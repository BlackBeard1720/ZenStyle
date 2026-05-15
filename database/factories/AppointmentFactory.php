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
        return [
            'client_id' => null,
            'coupon_id' => null,
            'appointment_date' => fake()->dateTimeBetween('-10 days', '+20 days')->format('Y-m-d'),
            'appointment_time' => fake()->time('H:i:s'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
            'total_amount' => 0,
        ];
    }
}
