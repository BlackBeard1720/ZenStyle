<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::query()
            ->whereIn('role_name', ['admin', 'receptionist', 'stylist'])
            ->pluck('id', 'role_name');

        $users = [
            [
                'username' => 'minhpham',
                'email' => 'minhpham@gmail.com',
                'password' => 'minh123456',
                'role' => 'admin',
            ],
            [
                'username' => 'linhvn',
                'email' => 'linhvn@gmail.com',
                'password' => 'linh123456',
                'role' => 'receptionist',
            ],
            [
                'username' => 'maipt',
                'email' => 'maipt@gmail.com',
                'password' => 'mai123456',
                'role' => 'receptionist',
            ],
            [
                'username' => 'huyphg',
                'email' => 'huyphg@gmail.com',
                'password' => 'huy123456',
                'role' => 'stylist',
            ],
            [
                'username' => 'thaoha',
                'email' => 'thaoha@gmail.com',
                'password' => 'thao123456',
                'role' => 'stylist',
            ],
            [
                'username' => 'namle',
                'email' => 'namle@gmail.com',
                'password' => 'nam123456',
                'role' => 'stylist',
            ],
            [
                'username' => 'ngocanh',
                'email' => 'ngocanh@gmail.com',
                'password' => 'ngoc123456',
                'role' => 'stylist',
            ],
            [
                'username' => 'tuanvo',
                'email' => 'tuanvo@gmail.com',
                'password' => 'tuan123456',
                'role' => 'stylist',
            ],
            [
                'username' => 'hanhdo',
                'email' => 'hanhdo@gmail.com',
                'password' => 'hanh123456',
                'role' => 'stylist',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'username' => $user['username'],
                    'password' => Hash::make($user['password']),
                    'role_id' => $roles[$user['role']],
                    'status' => 'active',
                ]
            );
        }
    }
}
