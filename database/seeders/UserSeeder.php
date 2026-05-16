<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();

        User::create([
            'username' => 'minhpham',
            'email' => 'minhpham@gmail.com',
            'password' => Hash::make('123456'),
            'role_id' => 1,
            'status' => 'active',
        ]);

        User::create([
            'username' => 'huyphg',
            'email' => 'huyphg@gmail.com',
            'password' => Hash::make('123456'),
            'role_id' => 2,
            'status' => 'active',
        ]);

        User::create([
            'username' => 'linhvn',
            'email' => 'linhvn@gmail.com',
            'password' => Hash::make('123456'),
            'role_id' => 3,
            'status' => 'active',
        ]);

        User::factory(20)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
