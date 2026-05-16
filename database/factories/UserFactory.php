<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = null;
    public function definition(): array
    {
        if (static::$password === null) {
            static::$password = Hash::make('123456');
        }
        return [
            "username" => fake()->userName(),
            "email" => fake()->unique()->safeEmail(),
            "phone" => fake()->phoneNumber(),
            "password" => static::$password,
            'role_id' => fake()->numberBetween(1, 3),
            'status' => fake()->randomElement(['active', 'inactive']),
            'email_verified_at' => now(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
