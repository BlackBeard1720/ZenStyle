<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Xoa payment cu truoc de seeder chay lai khong bi trung du lieu
        Payment::query()->delete();

        $completedAppointments = Appointment::query()
            ->where('status', 'completed')
            ->whereDoesntHave('payments')
            ->get();

        if ($completedAppointments->isEmpty()) {
            throw new RuntimeException('PaymentSeeder requires completed appointments. Run AppointmentSeeder first.');
        }

        foreach ($completedAppointments as $appointment) {
            Payment::query()->create([
                'appointment_id' => $appointment->id,
                'amount' => $appointment->total_amount,
                'payment_method' => 'cash',
                'status' => 'paid',
                'transaction_code' => 'CASH-' . now()->format('YmdHis') . '-' . $appointment->id,
                'paypal_order_id' => null,
                'paypal_capture_id' => null,
                'note' => 'Seeded cash payment.',
                'paid_at' => now()->subDays(fake()->numberBetween(0, 10)),
            ]);
        }
    }
}
