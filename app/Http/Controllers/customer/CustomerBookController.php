<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use App\Services\EmailOtpService;
use App\Services\FcmService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    public function busyStaff(Request $request): JsonResponse
    {
        $data = $request->validate([
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ]);

        $busyStaffIds = AppointmentService::query()
            ->whereNotNull('staff_id')
            ->whereHas('appointment', function ($query) use ($data) {
                $query->whereDate('appointment_date', $data['appointment_date'])
                    ->whereTime('appointment_time', $data['appointment_time'])
                    ->where('status', 'pending');
            })
            ->distinct()
            ->pluck('staff_id')
            ->map(fn ($staffId) => (int) $staffId)
            ->values();

        return response()->json([
            'busy_staff_ids' => $busyStaffIds,
        ]);
    }

    public function store(Request $request, EmailOtpService $emailOtpService): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', Rule::exists('services', 'id')->where(fn ($query) => $query->where('status', 'active'))],
            'staff_id' => ['nullable', 'integer', 'exists:staff,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $staff = $this->resolveStaff($data['staff_id'] ?? null);

        if ($this->hasStaffConflict($data, $staff?->id)) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => 'This staff member already has an appointment at the selected time.',
                ]);
        }

        $data['phone'] = $this->normalizePhone($data['phone']) ?? $data['phone'];

        $data['email'] = strtolower(trim((string) $data['email']));

        session(['booking_data' => $data]);
        session()->forget(['booking_otp_failed_attempts', 'booking_otp_locked_until']);

        $otpResult = $emailOtpService->sendOtp($data['email']);

        return back()
            ->withInput()
            ->with('otp_pending', true)
            ->with($otpResult['ok'] ? 'success' : 'error', $otpResult['message']);
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


    public function verifyOtp(Request $request, EmailOtpService $emailOtpService, FcmService $fcmService): RedirectResponse
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

        $data = session('booking_data');

        if (! is_array($data) || empty($data['email'])) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Please complete booking information first.']);
        }

        $otpResult = $emailOtpService->verifyOtp($data['email'], (string) $request->input('otp'));

        if (! $otpResult['ok']) {
            $failedAttempts = (int) session('booking_otp_failed_attempts', 0) + 1;
            session(['booking_otp_failed_attempts' => $failedAttempts]);

            if ($failedAttempts >= 2) {
                session([
                    'booking_otp_locked_until' => now()->addSeconds(60)->timestamp,
                    'booking_otp_failed_attempts' => 0,
                ]);
            }

            return back()
                ->withErrors(['otp' => $otpResult['message']])
                ->withInput()
                ->with('otp_pending', true);
        }

        // Check trung lich lan 2 sau khi OTP thanh cong, tranh race condition trong luc khach nhap OTP
        $staff = $this->resolveStaff($data['staff_id'] ?? null);

        if ($this->hasStaffConflict($data, $staff?->id)) {
            session()->forget([
                'booking_data',
                'booking_otp_failed_attempts',
                'booking_otp_locked_until',
            ]);

            return redirect()
                ->route('booking')
                ->withInput($data)
                ->withErrors([
                    'appointment_time' => 'This staff member already has an appointment at the selected time.',
                ]);
        }

        $services = $this->resolveSelectedServices($data['service_ids'] ?? [])->values();
        $totalAmount = $services->sum('price');

        $appointment = DB::transaction(function () use ($data, $services, $totalAmount) {
            $client = Client::query()->updateOrCreate(
                ['phone' => $data['phone']],
                ['full_name' => $data['full_name'], 'email' => $data['email']]
            );

            $appointment = Appointment::query()->create([
                'client_id' => $client->id,
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            foreach ($services as $service) {
                AppointmentService::query()->create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'staff_id' => $data['staff_id'] ?? null,
                    'price_at_booking' => $service->price,
                ]);
            }

            return $appointment;
        });

        $appointment->load(['client', 'appointmentServices.staff', 'appointmentServices.service']);

        $notifyUsers = User::query()
            ->where('status', 'active')
            ->whereHas('role', fn ($query) => $query->whereIn('role_name', ['admin', 'receptionist']))
            ->get();

        foreach ($notifyUsers as $user) {
            $fcmService->sendToUser(
                $user,
                'New Booking Received',
                'A new appointment has been booked by '.$appointment->client?->full_name.'.',
                ['type' => 'booking', 'appointment_id' => $appointment->id]
            );
        }

        session([
            'booking_success' => [
                'appointment_id' => $appointment->id,
                'full_name' => $appointment->client?->full_name,
                'phone' => $appointment->client?->phone,
                'appointment_date' => optional($appointment->appointment_date)->toDateString(),
                'appointment_time' => $appointment->appointment_time,
                'staff_name' => $appointment->appointmentServices->first()?->staff?->full_name ?? 'Any staff member',
                'notes' => $appointment->notes,
            ],
        ]);

        session()->forget([
            'booking_data',
            'booking_otp_failed_attempts',
            'booking_otp_locked_until',
        ]);

        return redirect()->route('booking.success');
    }

    public function successPage(): View|RedirectResponse
    {
        $booking = session('booking_success');

        if (! $booking) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Please complete booking information first.']);
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
                'staff_name' => $appointment->appointmentServices->first()?->staff?->full_name ?? 'Any staff member',
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
            ->where('status', 'pending')
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
