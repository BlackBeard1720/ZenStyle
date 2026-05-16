<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\AppointmentService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $appointmentTime = fake()->numberBetween(8, 17) . ':' . fake()->randomElement(['00', '30']) . ':00';

        return [
            'client_id' => null,
            'coupon_id' => null,
            'appointment_date' => fake()->dateTimeBetween('now', '+20 days')->format('Y-m-d'),
            'appointment_time' => $appointmentTime,
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
            'total_amount' => 0,
        ];
    }

    public function withServices(Collection $services, Collection $staff): static
    {
        return $this->afterCreating(function (Appointment $appointment) use ($services, $staff) {
            $selectedServices = $services->random(fake()->numberBetween(1, min(3, $services->count())));

            foreach ($selectedServices as $service) {
                AppointmentService::create([
                    'appointment_id' => $appointment->id,
                    'service_id' => $service->id,
                    'staff_id' => $staff->random()->id,
                    'price_at_booking' => $service->price,
                ]);
            }

            $appointment->update([
                'total_amount' => $selectedServices->sum('price'),
            ]);
        });
    }
}
