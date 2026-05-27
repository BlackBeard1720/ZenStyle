<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Staff::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roleIds = Role::whereIn('role_name', [
            'admin',
            'receptionist',
            'stylist',
        ])->pluck('id', 'role_name');

        $staffData = [

            'minhpham@gmail.com' => [
                'full_name' => 'Minh Pham',
                'specialization' => 'Manager',
                'salary' => 1200,
            ],

            'linhvn@gmail.com' => [
                'full_name' => 'Linh Nguyen',
                'specialization' => 'Receptionist',
                'salary' => 700,
            ],

            'maipt@gmail.com' => [
                'full_name' => 'Mai Pham',
                'specialization' => 'Receptionist',
                'salary' => 650,
            ],

            'huyphg@gmail.com' => [
                'full_name' => 'Huy Phan',
                'specialization' => 'Hair Stylist',
                'salary' => 900,
            ],

            'thaoha@gmail.com' => [
                'full_name' => 'Thao Ha',
                'specialization' => 'Hair Coloring',
                'salary' => 850,
            ],

            'namle@gmail.com' => [
                'full_name' => 'Nam Le',
                'specialization' => 'Hair Stylist',
                'salary' => 800,
            ],

            'ngocanh@gmail.com' => [
                'full_name' => 'Ngoc Anh',
                'specialization' => 'Skin Care',
                'salary' => 780,
            ],

            'tuanvo@gmail.com' => [
                'full_name' => 'Tuan Vo',
                'specialization' => 'Nail Care',
                'salary' => 750,
            ],

            'hanhdo@gmail.com' => [
                'full_name' => 'Hanh Do',
                'specialization' => 'Hair Stylist',
                'salary' => 720,
            ],
        ];

        $users = User::query()

            ->whereIn(
                'email',
                array_keys($staffData)
            )

            ->whereIn(
                'role_id',
                $roleIds->values()
            )

            ->get();

        foreach ($users as $user) {

            Staff::create([

                'user_id' => $user->id,

                'full_name' =>
                    $staffData[$user->email]['full_name'],

                'specialization' =>
                    $staffData[$user->email]['specialization'],

                'salary' =>
                    $staffData[$user->email]['salary'],

                'phone' =>
                    $user->phone ?? '0123456789',

                'email' =>
                    $user->email,

                'hire_date' =>
                    now()
                        ->subMonths(rand(3, 24))
                        ->toDateString(),

                'status' => 'active',
            ]);
        }
    }
}
