<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerBookController extends Controller
{
    public function create(): View
    {
        return view('frontend.booking.index', [
            'staff' => Staff::query()
                ->orderByRaw("status = 'active' desc")
                ->orderBy('full_name')
                ->get(),
            'services' => Service::query()
                ->with('category')
                ->where('status', 'active')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', Rule::exists('services', 'id')->where(fn ($query) => $query->where('status', 'active'))],
            'staff_id' => ['nullable', 'integer', 'exists:staff,id'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $staff = $this->resolveStaff($data['staff_id'] ?? null);

        if ($this->hasStaffConflict($data, $staff?->id)) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => 'Nhân viên này đã có lịch hẹn vào khung giờ đã chọn.',
                ]);
        }

        $data['phone'] = $this->normalizePhone($data['phone']) ?? $data['phone'];

        session(['booking_data' => $data]);
        session()->forget(['booking_otp_failed_attempts', 'booking_otp_locked_until']);

        return back()
            ->withInput()
            ->with('otp_pending', true);
    }

    public function cancelOtp(): RedirectResponse
    {
        session()->forget([
            'booking_data',
            'booking_otp_failed_attempts',
            'booking_otp_locked_until',
        ]);

        return redirect()->route('booking');
    }


    public function verifyOtp(Request $request): RedirectResponse
    {
        $lockedUntil = (int) session('booking_otp_locked_until', 0);

        if ($lockedUntil > now()->timestamp) {
            return back()
                ->withErrors(['otp' => 'You have entered the wrong OTP too many times. Please wait for the countdown to finish.'])
                ->withInput()
                ->with('otp_pending', true);
        }

        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Please enter the OTP.',
            'otp.digits' => 'OTP must be 6 digits.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('otp_pending', true);
        }

        if (! session()->has('booking_data')) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Please complete booking information first.']);
        }

        $failedAttempts = (int) session('booking_otp_failed_attempts', 0) + 1;
        session(['booking_otp_failed_attempts' => $failedAttempts]);

        if ($failedAttempts >= 2) {
            session([
                'booking_otp_locked_until' => now()->addSeconds(60)->timestamp,
                'booking_otp_failed_attempts' => 0,
            ]);
        }

        return back()
            ->withErrors(['otp' => 'OTP verification is temporarily unavailable. Email OTP will be enabled soon.'])
            ->withInput()
            ->with('otp_pending', true);
    }

    public function successPage(): View|RedirectResponse
    {
        $booking = session('booking_success');

        if (! $booking) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Vui lòng hoàn tất đặt lịch trước.']);
        }

        return view('frontend.booking.success', [
            'booking' => $booking,
        ]);
    }

    public function success(Appointment $appointment): View
    {
        $appointment->load([
            'client',
            'appointmentServices.service',
            'appointmentServices.staff',
        ]);

        return view('frontend.booking.success', [
            'booking' => [
                'appointment_id' => $appointment->id,
                'full_name' => $appointment->client?->full_name,
                'phone' => $appointment->client?->phone,
                'appointment_date' => optional($appointment->appointment_date)->toDateString(),
                'appointment_time' => $appointment->appointment_time,
                'staff_name' => $appointment->appointmentServices->first()?->staff?->full_name ?? 'Bất kỳ nhân viên',
                'notes' => $appointment->notes,
            ],
        ]);
    }

    private function resolveSelectedServices(array $serviceIds)
    {
        $ids = collect($serviceIds)
            ->filter()
            ->unique()
            ->map(fn ($serviceId) => (int) $serviceId)
            ->values();

        if ($ids->isEmpty()) {
            return collect();
        }

        return Service::query()
            ->whereIn('id', $ids)
            ->where('status', 'active')
            ->get();
    }

    private function resolveStaff(mixed $staffId): ?Staff
    {
        if (! $staffId) {
            return null;
        }

        return Staff::query()->find((int) $staffId);
    }

    private function hasStaffConflict(array $data, ?int $staffId = null): bool
    {
        if (! $staffId || empty($data['appointment_date']) || empty($data['appointment_time'])) {
            return false;
        }

        return Appointment::query()
            ->whereDate('appointment_date', $data['appointment_date'])
            ->whereTime('appointment_time', $data['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->whereHas('appointmentServices', function ($query) use ($staffId) {
                $query->where('staff_id', $staffId);
            })->exists();
    }

    private function normalizePhone(string $phone): ?string
    {
        $normalized = preg_replace('/[\s.\-]+/', '', trim($phone));

        if (! is_string($normalized) || ! preg_match('/^0\d{9,10}$/', $normalized)) {
            return null;
        }

        return $normalized;
    }
}
