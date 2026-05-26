<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmedMail;
use App\Models\Attendance;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use App\Services\FcmService;
use App\Services\TelegramOtpService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerBookController extends Controller
{
    public function create(): View
    {
        return view('frontend.booking.index', [
            'staff' => Staff::query()
                ->where('status', 'active')
                ->orderBy('full_name')
                ->get(),
            'services' => Service::query()
                ->with('category')
                ->where('status', 'active')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function availableStaff(Request $request): JsonResponse
    {
        $data = $request->validate([
            'appointment_date' => ['nullable', 'date'],
            'appointment_time' => ['nullable', 'date_format:H:i'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', Rule::exists('services', 'id')->where(fn ($query) => $query->where('status', 'active'))],
        ]);

        $staff = $this->availableStaffFor(
            $data['appointment_date'] ?? null,
            $data['appointment_time'] ?? null,
            $data['service_ids'] ?? []
        );

        return response()->json([
            'staff' => $staff->values()->map(fn (Staff $staffMember, int $index) => $this->staffOptionPayload($staffMember, $index)),
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
            'staff_id' => ['nullable', 'integer', Rule::exists('staff', 'id')->where(fn ($query) => $query->where('status', 'active'))],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $staff = $this->resolveStaff($data['staff_id'] ?? null);

        if ($this->isStaffUnavailable($data, $staff)) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => 'Nhân viên này đã có lịch trong khung giờ đã chọn. Vui lòng chọn nhân viên hoặc thời gian khác.',
                ]);
        }

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

    public function sendTelegramOtp(TelegramOtpService $telegramOtpService): RedirectResponse
    {
        // Lay du lieu booking dang cho xac thuc
        $data = session('booking_data');

        if (! $data || empty($data['phone'])) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Vui lòng hoàn tất thông tin đặt lịch trước.']);
        }

        // Gui OTP qua Telegram
        $result = $telegramOtpService->sendOtp($data['phone']);

        if (! $result['ok']) {
            return back()
                ->withInput()
                ->withErrors(['otp' => $result['message']])
                ->with('otp_pending', true);
        }

        return back()
            ->withInput()
            ->with('otp_pending', true)
            ->with('telegram_otp_sent', true)
            ->with('success', $result['message']);
    }

    public function verifyOtp(Request $request, TelegramOtpService $telegramOtpService): RedirectResponse
    {
        $lockedUntil = (int) session('booking_otp_locked_until', 0);

        if ($lockedUntil > now()->timestamp) {
            return back()
                ->withErrors(['otp' => 'Ban da nhap sai OTP qua nhieu lan. Vui long doi het thoi gian dem nguoc.'])
                ->withInput()
                ->with('otp_pending', true);
        }

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
                ->with('otp_pending', true);
        }

        // lấy booking_data
        $data = session('booking_data');

        if (! $data) {
            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Vui lòng hoàn tất đặt lịch trước.']);
        }

        // check trùng lịch trước
        $staff = $this->resolveStaff($data['staff_id'] ?? null);
        if ($this->isStaffUnavailable($data, $staff)) {
            return redirect()
                ->route('booking')
                ->withInput($data)
                ->withErrors([
                    'appointment_time' => 'Nhân viên này đã có lịch trong khung giờ đã chọn. Vui lòng chọn nhân viên hoặc thời gian khác.',
                ]);
        }

        // sau đó mới verify OTP
        $result = $telegramOtpService->verifyOtp($data['phone'], $request->input('otp'));
        if (! $result['ok']) {
            // Khoa OTP neu sai 2 lan
            $failedAttempts = (int) session('booking_otp_failed_attempts', 0) + 1;
            session(['booking_otp_failed_attempts' => $failedAttempts]);

            if ($failedAttempts >= 2) {
                session([
                    'booking_otp_locked_until' => now()->addSeconds(60)->timestamp,
                    'booking_otp_failed_attempts' => 0,
                ]);
            }

            return back()
                ->withErrors(['otp' => $result['message']])
                ->withInput()
                ->with('otp_pending', true);
        }

        $services = $this->resolveSelectedServices($data['service_ids'] ?? []);
        $totalAmount = $services->sum('price');

        $appointment = DB::transaction(function () use ($data, $services, $staff, $totalAmount): Appointment {
            $client = Client::firstOrCreate(
                ['phone' => $data['phone']],
                [
                    'full_name' => $data['full_name'],
                    'email' => $data['email'] ?? null,
                ]
            );

            $clientUpdateData = [];

            if ($client->full_name !== $data['full_name']) {
                $clientUpdateData['full_name'] = $data['full_name'];
            }

            if (! empty($data['email']) && $client->email !== $data['email']) {
                $clientUpdateData['email'] = $data['email'];
            }

            if (! empty($clientUpdateData)) {
                $client->update($clientUpdateData);
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

        // Gui mail xac nhan dat lich thanh cong
        $appointment->load([
            'client',
            'appointmentServices.service',
            'appointmentServices.staff',
        ]);

        if ($appointment->client?->email) {
            Mail::to($appointment->client->email)->queue(new BookingConfirmedMail($appointment));
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
                    'New appointment booked',
                    "{$data['full_name']} booked an appointment at {$data['appointment_time']} on {$data['appointment_date']}.",
                    [
                        'type' => 'appointment_created',
                        'appointment_id' => (string) $appointment->id,
                        'url' => route('staff.appointments.show', $appointment),
                    ]
                );
            });

        session()->forget(['booking_data']);
        session()->forget(['booking_otp_failed_attempts', 'booking_otp_locked_until']);
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

        return Staff::query()
            ->where('status', 'active')
            ->find((int) $staffId);
    }

    private function isStaffUnavailable(array $data, ?Staff $staff = null): bool
    {
        if (! $staff || empty($data['appointment_date']) || empty($data['appointment_time'])) {
            return false;
        }

        return ! $this->availableStaffFor(
            $data['appointment_date'],
            $data['appointment_time'],
            $data['service_ids'] ?? []
        )->contains('id', $staff->id);
    }

    private function availableStaffFor(?string $date, ?string $time, array $serviceIds)
    {
        $staff = Staff::query()
            ->where('status', 'active')
            ->orderBy('full_name')
            ->get();

        if (! $date || ! $time) {
            return $staff;
        }

        $unavailableIds = $this->attendanceUnavailableStaffIds($date)
            ->merge($this->busyStaffIds($date, $time, $serviceIds))
            ->unique();

        return $staff
            ->reject(fn (Staff $staffMember) => $unavailableIds->contains($staffMember->id))
            ->values();
    }

    private function attendanceUnavailableStaffIds(string $date)
    {
        return Attendance::query()
            ->whereDate('work_date', $date)
            ->whereIn('status', [
                Attendance::STATUS_ABSENT,
                Attendance::STATUS_LEAVE,
            ])
            ->pluck('staff_id');
    }

    private function busyStaffIds(string $date, string $time, array $serviceIds)
    {
        [$requestedStart, $requestedEnd] = $this->appointmentPeriod($date, $time, $serviceIds);

        return Appointment::query()
            ->with('appointmentServices.service')
            ->whereDate('appointment_date', $date)
            ->whereIn('status', $this->holdingAppointmentStatuses())
            ->whereHas('appointmentServices', fn ($query) => $query->whereNotNull('staff_id'))
            ->get()
            ->filter(function (Appointment $appointment) use ($requestedStart, $requestedEnd) {
                $existingStart = Carbon::parse($appointment->appointment_date->toDateString() . ' ' . Carbon::parse($appointment->appointment_time)->format('H:i'));
                $existingDuration = max(1, (int) $appointment->appointmentServices->sum(
                    fn (AppointmentService $appointmentService) => (int) ($appointmentService->service?->duration ?? 60)
                ));
                $existingEnd = $existingStart->copy()->addMinutes($existingDuration);

                return $existingStart->lt($requestedEnd) && $existingEnd->gt($requestedStart);
            })
            ->flatMap(fn (Appointment $appointment) => $appointment->appointmentServices->pluck('staff_id'))
            ->filter()
            ->unique()
            ->values();
    }

    private function appointmentPeriod(string $date, string $time, array $serviceIds): array
    {
        $duration = $this->requestedDuration($serviceIds);
        $start = Carbon::parse($date . ' ' . $time);

        return [$start, $start->copy()->addMinutes($duration)];
    }

    private function requestedDuration(array $serviceIds): int
    {
        $ids = collect($serviceIds)
            ->filter()
            ->map(fn ($serviceId) => (int) $serviceId)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return 60;
        }

        return max(1, (int) Service::query()
            ->whereIn('id', $ids)
            ->where('status', 'active')
            ->sum('duration'));
    }

    private function holdingAppointmentStatuses(): array
    {
        return ['pending', 'confirmed', 'booked', 'scheduled'];
    }

    private function staffOptionPayload(Staff $staff, int $index): array
    {
        $years = $staff->hire_date
            ? max(0, (int) Carbon::parse($staff->hire_date)->diffInYears(now()))
            : null;

        return [
            'id' => $staff->id,
            'name' => $staff->full_name,
            'role' => $staff->specialization ?? 'Nhân viên',
            'experience' => $years !== null
                ? ($years >= 1 ? $years . ' năm kinh nghiệm' : 'Dưới 1 năm kinh nghiệm')
                : null,
            'image' => asset('images/tailadmin/user/user-0' . (($index % 3) + 1) . '.jpg'),
        ];
    }
}
