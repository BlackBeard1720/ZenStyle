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

        $clientUsers = User::factory(10)->create([
            'role_id' => $clientRole->id,
        ]);

        $clientUsers->each(function (User $user) {
            Client::factory()
                ->forUser($user)
                ->create();
        });
    }
}
