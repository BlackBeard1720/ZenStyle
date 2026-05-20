<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerBookController extends Controller
{
    private const DEMO_SERVICES = [
        'cut' => [
            'service_name' => 'Hair Cut',
            'description' => 'Cắt tóc nam cao cấp',
            'price' => 150000,
            'duration_minutes' => 45,
        ],
        'wash' => [
            'service_name' => 'Hair Wash',
            'description' => 'Gội + massage da đầu',
            'price' => 120000,
            'duration_minutes' => 30,
        ],
        'perm' => [
            'service_name' => 'Hair Coloring',
            'description' => 'Uốn / nhuộm cơ bản',
            'price' => 650000,
            'duration_minutes' => 120,
        ],
        'treatment' => [
            'service_name' => 'Hair Treatment',
            'description' => 'Treatment phục hồi',
            'price' => 320000,
            'duration_minutes' => 60,
        ],
    ];

    private const DEMO_STYLISTS = [
        'quach-tung-duong' => 'Quách Tùng Dương',
        'dinh-van-hai' => 'Đinh Văn Hải',
        'le-hoang-nam' => 'Lê Hoàng Nam',
    ];

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
            'service_ids.*' => ['nullable', 'string'],
            'staff_id' => ['nullable'],
            'staff_name' => ['nullable', 'string', 'max:255'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['staff_name'] = ($data['staff_name'] ?? null) ?: $this->displayStaffName($data['staff_id'] ?? null);

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

        $staff = $this->resolveStaff($data['staff_id'] ?? null, $data['staff_name'] ?? null);

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

        session()->forget(['booking_otp', 'booking_data']);
        session()->flash('booking_success', [
            'appointment_id' => $appointment->id,
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'staff_name' => $data['staff_name'] ?? $this->displayStaffName($data['staff_id'] ?? null),
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
        return collect($serviceIds)
            ->filter()
            ->unique()
            ->map(function ($serviceId) {
                $serviceId = (string) $serviceId;

                if (ctype_digit($serviceId)) {
                    return Service::find((int) $serviceId);
                }

                $demoService = self::DEMO_SERVICES[$serviceId] ?? null;

                if (! $demoService) {
                    return null;
                }

                return Service::firstOrCreate(
                    ['service_name' => $demoService['service_name']],
                    [
                        'description' => $demoService['description'],
                        'price' => $demoService['price'],
                        'duration_minutes' => $demoService['duration_minutes'],
                        'status' => 'active',
                    ]
                );
            })
            ->filter()
            ->values();
    }

    private function resolveStaff(mixed $staffId, ?string $staffName): ?Staff
    {
        if ($staffId && ctype_digit((string) $staffId)) {
            return Staff::find((int) $staffId);
        }

        if ($staffName) {
            return Staff::where('full_name', $staffName)->first();
        }

        if ($staffId && isset(self::DEMO_STYLISTS[$staffId])) {
            return Staff::where('full_name', self::DEMO_STYLISTS[$staffId])->first();
        }

        return null;
    }

    private function displayStaffName(mixed $staffId): string
    {
        if ($staffId && ctype_digit((string) $staffId)) {
            return Staff::find((int) $staffId)?->full_name ?? 'Bất kỳ nhân viên';
        }

        return self::DEMO_STYLISTS[$staffId] ?? 'Bất kỳ nhân viên';
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
