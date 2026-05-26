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
        $internalRoleIds = Role::whereIn('role_name', ['admin', 'receptionist', 'stylist'])
            ->pluck('id');

        $staffUsers = User::whereIn('role_id', $internalRoleIds)
            ->whereDoesntHave('staff')
            ->get();

        $staffUsers->each(function (User $user) {
            Staff::factory()
                ->forUser($user)
                ->create();
        });

        $neededStaff = max(0, 5 - Staff::where('status', 'active')->count());

        if ($neededStaff > 0) {
            $staffRole = Role::where('role_name', 'stylist')->firstOrFail();

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
