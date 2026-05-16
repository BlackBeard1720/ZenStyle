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
        $services = [];
        $staff = [];

        return view('frontend.booking.index', compact('services', 'staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],

            'customer_count' => ['required', 'integer', 'min:1'],

            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],

            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['exists:services,id'],

            'staff_id' => ['nullable', 'exists:staff,id'],

            'coupon_code' => ['nullable', 'string', 'max:50'],

            'notes' => ['nullable', 'string'],
        ]);

        if ($this->hasStaffConflict($data)) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => 'Nhân viên này đã có lịch hẹn vào khung giờ đã chọn.',
                ]);
        }

        $services = Service::whereIn('id', $data['service_ids'])->get();

        $subtotal = $services->sum('price');
        $discount = 0;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', $data['coupon_code'])->first();

            if ($coupon) {
                $discount = $coupon->discount_amount ?? 0;
            }
        }

        $totalAmount = max($subtotal - $discount, 0);

        $appointment = DB::transaction(function () use ($data, $services, $totalAmount) {
            $client = Client::firstOrCreate(
                [
                    'phone' => $data['phone'],
                ],
                [
                    'full_name' => $data['full_name'],
                    'status' => 'active',
                ]
            );

            $appointment = Appointment::create([
                'client_id' => $client->id,
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'customer_count' => $data['customer_count'],
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
