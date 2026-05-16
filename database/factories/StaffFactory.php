<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Staff>
 */
class StaffFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'full_name' => fake()->name(),
            'phone' => fake()->numerify('09########'),
            'email' => fake()->unique()->safeEmail(),
            'specialization' => fake()->randomElement(['Hair stylist', 'Skin care', 'Nail care', 'Hair coloring']),
            'salary' => fake()->numberBetween(7000000, 18000000),
            'hire_date' => fake()->dateTimeBetween('-3 years', '-1 month')->format('Y-m-d'),
            'status' => 'active',
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'full_name' => $user->username,
            'phone' => $user->phone ?: fake()->numerify('09########'),
            'email' => $user->email,
            'status' => 'active',
        ]);
    }
}
