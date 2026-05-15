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
        $staffRole = Role::where('role_name', 'stylist')->firstOrFail();

        User::where('role_id', $staffRole->id)
            ->whereDoesntHave('staff')
            ->get()
            ->each(function (User $user) {
                Staff::factory()->create([
                    'user_id' => $user->id,
                    'full_name' => $user->username,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'status' => 'active',
                ]);
            });

        $neededStaff = max(0, 5 - Staff::where('status', 'active')->count());

        User::factory($neededStaff)
            ->create([
                'role_id' => $staffRole->id,
                'status' => 'active',
            ])
            ->each(function (User $user) {
                Staff::factory()->create([
                    'user_id' => $user->id,
                    'full_name' => $user->username,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'status' => 'active',
                ]);
            });
    }
}
