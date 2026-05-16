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

        $staffUsers = User::where('role_id', $staffRole->id)
            ->whereDoesntHave('staff')
            ->get();

        $staffUsers->each(function (User $user) {
            Staff::factory()
                ->forUser($user)
                ->create();
        });

        $neededStaff = max(0, 5 - Staff::where('status', 'active')->count());

        if ($neededStaff > 0) {
            $staffUsers = User::factory($neededStaff)->create([
                'role_id' => $staffRole->id,
                'status' => 'active',
            ]);

            $staffUsers->each(function (User $user) {
                Staff::factory()
                    ->forUser($user)
                    ->create();
            });
        }
    }
}
