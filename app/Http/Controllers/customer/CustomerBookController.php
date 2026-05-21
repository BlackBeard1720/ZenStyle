<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use App\Services\FcmService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                ->where('status', 'active')
                ->orderBy('service_name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'staff_id' => ['nullable', 'integer', 'exists:staff,id'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $otp = rand(100000, 999999);

        session([
            'booking_otp' => $otp,
            'booking_data' => $data,
        ]);

        return back()
            ->withInput()
            ->with('otp_pending', true)
            ->with('otp_demo', $otp);
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Vui lòng nhập OTP.',
            'otp.digits' => 'OTP phải gồm 6 số.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('otp_pending', true)
                ->with('otp_demo', session('booking_otp'));
        }

        $expectedOtp = session('booking_otp');
        $data = session('booking_data');

        if (! $expectedOtp || ! $data) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Vui lòng hoàn tất đặt lịch trước.']);
        }

        if (! hash_equals((string) $expectedOtp, (string) $request->input('otp'))) {
            return back()
                ->withErrors(['otp' => 'OTP không đúng'])
                ->withInput()
                ->with('otp_pending', true)
                ->with('otp_demo', $expectedOtp);
        }

        $staff = $this->resolveStaff($data['staff_id'] ?? null);

        if ($this->hasStaffConflict($data, $staff?->id)) {
            return redirect()
                ->route('booking')
                ->withInput($data)
                ->withErrors([
                    'appointment_time' => 'Nhân viên này đã có lịch hẹn vào khung giờ đã chọn.',
                ]);
        }

        $services = $this->resolveSelectedServices($data['service_ids'] ?? []);
        $totalAmount = $services->sum('price');

        $appointment = DB::transaction(function () use ($data, $services, $staff, $totalAmount): Appointment {
            $client = Client::firstOrCreate(
                ['phone' => $data['phone']],
                ['full_name' => $data['full_name']]
            );

            if ($client->full_name !== $data['full_name']) {
                $client->update(['full_name' => $data['full_name']]);
            }

            $appointment = Appointment::create([
                'client_id' => $client->id,
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            foreach ($services as $service) {
                AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'staff_id' => $staff?->id,
                    'price_at_booking' => $service->price,
                ]);
            }

            return $appointment;
        });

        $admins = User::where('status', 'active')
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', ['admin', 'receptionist']);
            })
            ->get();

        foreach ($admins as $admin) {
            app(FcmService::class)->sendToUser(
                $admin,
                'Có lịch hẹn mới',
                "{$data['full_name']} vừa đặt lịch lúc {$data['appointment_time']} ngày {$data['appointment_date']}.",
                [
                    'type' => 'appointment_created',
                    'appointment_id' => $appointment->id,
                    'url' => route('staff.appointments.show', $appointment),
                ]
            );
        }

        User::query()
            ->where('status', 'active')
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', ['admin', 'receptionist']);
            })
            ->get()
            ->each(function (User $user) use ($appointment, $data) {
                app(FcmService::class)->sendToUser(
                    $user,
                    'Có lịch hẹn mới',
                    sprintf(
                        '%s - %s %s',
                        $data['full_name'],
                        $data['appointment_date'],
                        $data['appointment_time']
                    ),
                    [
                        'type' => 'appointment_created',
                        'appointment_id' => (string) $appointment->id,
                        'url' => route('staff.appointments.show', $appointment),
                    ]
                );
            });

        session()->forget(['booking_otp', 'booking_data']);
        session()->flash('booking_success', [
            'appointment_id' => $appointment->id,
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'staff_name' => $staff?->full_name ?? 'Bất kỳ nhân viên',
            'coupon_code' => $data['coupon_code'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('booking.success');
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

        return Service::whereIn('id', $ids)->get();
    }

    private function resolveStaff(mixed $staffId): ?Staff
    {
        if (! $staffId) {
            return null;
        }

        return Staff::find((int) $staffId);
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
            })
            ->exists();
    }
}
