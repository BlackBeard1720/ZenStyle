<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerBookController extends Controller
{
    public function create()
    {

        $staff = Staff::where('status', 'active')
            ->orderBy('full_name')
            ->get();

        $services = Service::where('status', 'active')
            ->orderBy('service_name')
            ->get();

        return view('frontend.booking.index', compact('staff', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10'],

            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],

            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['required', 'exists:services,id'],

            'staff_id' => ['nullable', 'exists:staff,id'],

            'coupon_code' => ['nullable', 'string', 'max:50'],

            'notes' => ['nullable', 'string'],
        ]);

        if ($this->hasStaffConflict($data)) {
            return back()->withInput()->withErrors([
                'staff_id' => 'Nhân viên đã có lịch vào thời điểm này. Vui lòng chọn nhân viên khác.',
            ]);
        }

        $otp = random_int(100000, 999999);

        session([
            'booking_data' => $data,
            'booking_otp'  => $otp,
            'otp_pending'  => true,
            'otp_demo'     => $otp,
        ]);

        return redirect()->route('booking');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        if ($request->otp != session('booking_otp')) {
            return back()->withErrors([
                'otp' => 'OTP không đúng',
            ]);
        }

        $data = session('booking_data');

        if (!$data) {
            return redirect()
                ->route('booking')
                ->withErrors([
                    'otp' => 'Phiên đặt lịch đã hết hạn. Vui lòng đặt lịch lại.',
                ]);
        }

        $services = Service::whereIn('id', $data['service_ids'])->get();

        $subtotal = $services->sum('price');
        $discount = 0;
        $coupon = null;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', $data['coupon_code'])->first();

            if ($coupon) {
                $discount = $coupon->discount_amount ?? 0;
            }
        }

        $totalAmount = max($subtotal - $discount, 0);

        $appointment = DB::transaction(function () use ($data, $services, $coupon, $totalAmount) {
            $client = Client::updateOrCreate(
                [
                    'phone' => $data['phone'],
                ],
                [
                    'full_name' => $data['full_name'],
                ]
            );

            $appointment = Appointment::create([
                'client_id' => $client->id,
                'coupon_id' => $coupon?->id,
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
                    'staff_id' => $data['staff_id'] ?? null,
                    'price_at_booking' => $service->price,
                ]);
            }

            return $appointment;
        });

        session()->forget([
            'booking_otp',
            'booking_data',
            'otp_pending',
            'otp_demo',
        ]);

        return redirect()
            ->route('customer.booking.success', $appointment)
            ->with('success', 'Đặt lịch thành công. Vui lòng chờ salon xác nhận.');
    }

    public function success(Appointment $appointment)
    {
        $appointment->load([
            'client',
            'appointmentServices.service',
            'appointmentServices.staff',
        ]);

        return view('booking-success', compact('appointment'));
    }

    private function hasStaffConflict(array $data): bool
    {
        $staffId = $data['staff_id'] ?? null;

        if (!$staffId) {
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
