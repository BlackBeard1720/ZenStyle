<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->randomElement(['Hair Cut', 'Hair Wash', 'Hair Coloring', 'Hair Treatment', 'Skin Care']),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(100000, 800000),
            'duration' => fake()->randomElement([30, 45, 60, 75, 90, 120]),
            'status' => 'active',
        ];
    }
}
