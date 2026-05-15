<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clientRole = Role::where('role_name', 'client')->firstOrFail();

        User::factory(10)
            ->create([
                'role_id' => $clientRole->id,
                'status' => 'active',
            ])
            ->each(function (User $user) {
                Client::factory()->create([
                    'user_id' => $user->id,
                    'full_name' => $user->username,
                    'phone' => $user->phone ?: fake()->numerify('09########'),
                    'email' => $user->email,
                    'status' => 'active',
                ]);
            });
    }
}
