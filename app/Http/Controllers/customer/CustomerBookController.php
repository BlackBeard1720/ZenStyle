<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\JsonResponse;
use App\Models\TelegramUser;
use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmedMail;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use App\Services\FcmService;
use App\Services\TelegramOtpService;
use Illuminate\Contracts\View\View;
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

    public function sendTelegramOtp(Request $request, TelegramOtpService $telegramOtpService): RedirectResponse|JsonResponse
    {
        // Lay du lieu booking dang cho xac thuc
        $data = session('booking_data');

        if (! $data || empty($data['phone'])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Please complete the booking information first.',
                ], 422);
            }

            return redirect()
                ->route('booking')
                ->withErrors(['booking' => 'Please complete the booking information first.']);
        }

        // Gui OTP qua Telegram
        $normalizedPhone = $this->normalizePhone($data['phone'] ?? '');

        if (! $normalizedPhone) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid phone number format.',
            ], 422);
        }

        $result = $telegramOtpService->sendOtp($normalizedPhone);

        if (! $result['ok']) {
            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => $result['message'],
                ], 422);
            }

            return back()
                ->withInput()
                ->withErrors(['otp' => $result['message']])
                ->with('otp_pending', true);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => $result['message'],
            ]);
        }

        return back()
            ->withInput()
            ->with('otp_pending', true)
            ->with('telegram_otp_sent', true)
            ->with('success', $result['message']);
    }

    public function checkTelegramLink(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $normalizedPhone = $this->normalizePhone($data['phone']);

        if (! $normalizedPhone) {
            return response()->json([
                'linked' => false,
                'phone' => null,
                'message' => 'Invalid phone number format.',
            ], 422);
        }

        $linked = TelegramUser::query()
            ->where('phone', $normalizedPhone)
            ->exists();

        return response()->json([
            'linked' => $linked,
            'phone' => $normalizedPhone,
            'message' => $linked ? 'Telegram is linked.' : 'Telegram is not linked yet.',
        ]);
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
        if ($this->hasStaffConflict($data, $staff?->id)) {
            return redirect()
                ->route('booking')
                ->withInput($data)
                ->withErrors([
                    'appointment_time' => 'Nhân viên này đã có lịch hẹn vào khung giờ đã chọn.',
                ]);
        }

        // sau đó mới verify OTP
        $normalizedPhone = $this->normalizePhone($data['phone'] ?? '');

        if (! $normalizedPhone) {
            return back()
                ->withErrors(['otp' => 'Invalid phone number format.'])
                ->withInput()
                ->with('otp_pending', true);
        }

        $result = $telegramOtpService->verifyOtp($normalizedPhone, $request->input('otp'));
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
