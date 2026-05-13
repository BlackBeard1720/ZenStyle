<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Chạy các seed cho bảng roles.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();

        Role::insert([
            ['role_name' => 'admin'],
            ['role_name' => 'receptionist'],
            ['role_name' => 'stylist'],
            ['role_name' => 'client'],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
