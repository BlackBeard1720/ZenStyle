<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

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
}
