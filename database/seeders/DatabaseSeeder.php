<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Gieo dữ liệu vào cơ sở dữ liệu của ứng dụng.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // Gieo dữ liệu cho bảng roles
            UserSeeder::class, // Gieo dữ liệu cho bảng users
        ]);
    }
}
