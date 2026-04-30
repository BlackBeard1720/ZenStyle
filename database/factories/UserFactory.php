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
    /**
     * Mật khẩu hiện tại được sử dụng bởi factory.
     */
    protected static ?string $password = null;

    /**
     * Định nghĩa trạng thái mặc định của model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (static::$password === null) {
            static::$password = Hash::make('123456'); // Tạo mật khẩu mặc định
        }
        return [
            "username" => fake()->name(), // Tên đăng nhập giả lập
            "email" => fake()->unique()->safeEmail(), // Email giả lập
            "phone" => fake()->phoneNumber(), // Số điện thoại giả lập
            "password" => static::$password, // Mật khẩu được tạo bởi factory
            'role_id' => fake()->numberBetween(1, 3), // ID vai trò giả lập
            'status' => fake()->boolean(), // Trạng thái hoạt động giả lập
            'email_verified_at' => now(), // Thời gian xác minh email
        ];
    }

    /**
     * Chỉ định rằng địa chỉ email của model không được xác minh.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
