<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $roleIds = Role::whereIn('role_name', ['admin', 'receptionist', 'stylist'])
            ->pluck('id', 'role_name');

        $staffData = [
            'minhpham@gmail.com' => [
                'full_name' => 'Minh Pham',
                'specialization' => 'Manager',
                'salary' => 18000000,
            ],
            'linhvn@gmail.com' => [
                'full_name' => 'Linh Nguyen',
                'specialization' => 'Receptionist',
                'salary' => 10000000,
            ],
            'maipt@gmail.com' => [
                'full_name' => 'Mai Pham',
                'specialization' => 'Receptionist',
                'salary' => 9500000,
            ],
            'huyphg@gmail.com' => [
                'full_name' => 'Huy Phan',
                'specialization' => 'Hair stylist',
                'salary' => 14000000,
            ],
            'thaoha@gmail.com' => [
                'full_name' => 'Thao Ha',
                'specialization' => 'Hair coloring',
                'salary' => 13000000,
            ],
            'namle@gmail.com' => [
                'full_name' => 'Nam Le',
                'specialization' => 'Hair stylist',
                'salary' => 12500000,
            ],
            'ngocanh@gmail.com' => [
                'full_name' => 'Ngoc Anh',
                'specialization' => 'Skin care',
                'salary' => 12000000,
            ],
            'tuanvo@gmail.com' => [
                'full_name' => 'Tuan Vo',
                'specialization' => 'Nail care',
                'salary' => 11500000,
            ],
            'hanhdo@gmail.com' => [
                'full_name' => 'Hanh Do',
                'specialization' => 'Hair stylist',
                'salary' => 11000000,
            ],
        ];

        $users = User::query()
            ->whereIn('email', array_keys($staffData))
            ->whereIn('role_id', $roleIds->values())
            ->get();

        foreach ($users as $user) {
            Staff::updateOrCreate(
                ['user_id' => $user->id],
                [
                    ...$staffData[$user->email],
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'hire_date' => now()->subMonths(6)->toDateString(),
                    'status' => 'active',
                ]
            );
        }
    }
}
