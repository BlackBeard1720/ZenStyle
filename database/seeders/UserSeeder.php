<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed tai khoan dang nhap noi bo co dinh.
     * Stylist se duoc seed trong StaffSeeder vi can co ho so staff rieng.
     */
    public function run(): void
    {
        $adminRole = Role::where('role_name', 'admin')->firstOrFail();
        $receptionistRole = Role::where('role_name', 'receptionist')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'minhpham@gmail.com'],
            [
                'username' => 'minhpham',
                'phone' => '0901000000',
                'password' => Hash::make('minh123456'),
                'role_id' => $adminRole->id,
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'linhvn@gmail.com'],
            [
                'username' => 'linhvn',
                'phone' => '0901000001',
                'password' => Hash::make('linh123456'),
                'role_id' => $receptionistRole->id,
                'status' => 'active',
            ]
        );
    }
}
