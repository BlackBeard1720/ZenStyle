<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'full_name' => fake()->name(),
            'phone' => fake()->numerify('09########'),
            'email' => fake()->unique()->safeEmail(),
            'dob' => fake()->optional()->dateTimeBetween('-50 years', '-18 years')?->format('Y-m-d'),
            'preferences' => fake()->optional()->sentence(),
            'loyalty_points' => fake()->numberBetween(0, 500),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'full_name' => $user->username,
            'phone' => $user->phone ?: fake()->numerify('09########'),
            'email' => $user->email,
            'status' => in_array($user->status, ['active', 'inactive'], true)
                ? $user->status
                : fake()->randomElement(['active', 'inactive']),
        ]);
    }
}
