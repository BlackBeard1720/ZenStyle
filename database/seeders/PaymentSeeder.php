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
            $paymentMethod = fake()->randomElement(['cash', 'paypal']);

            Payment::query()->create([
                'appointment_id' => $appointment->id,
                'amount' => $appointment->total_amount,
                'payment_method' => $paymentMethod,
                'status' => 'paid',
                'transaction_code' => $paymentMethod === 'paypal'
                    ? 'PAYPAL-' . strtoupper(Str::random(12))
                    : 'CASH-' . now()->format('YmdHis') . '-' . $appointment->id,
                'paypal_order_id' => $paymentMethod === 'paypal'
                    ? 'ORDER-' . strtoupper(Str::random(12))
                    : null,
                'paypal_capture_id' => $paymentMethod === 'paypal'
                    ? 'CAPTURE-' . strtoupper(Str::random(12))
                    : null,
                'note' => $paymentMethod === 'paypal'
                    ? 'Seeded PayPal payment.'
                    : 'Seeded cash payment.',
                'paid_at' => now()->subDays(fake()->numberBetween(0, 10)),
            ]);
        }
    }
}
