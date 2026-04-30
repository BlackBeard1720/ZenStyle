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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Tắt kiểm tra khóa ngoại
        DB::table('roles')->truncate(); // Xóa toàn bộ dữ liệu trong bảng roles

        Role::insert([
            ['role_name' => 'admin'], // Vai trò quản trị viên
            ['role_name' => 'receptionist'], // Vai trò lễ tân
            ['role_name' => 'stylist'], // Vai trò nhà tạo mẫu
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Bật lại kiểm tra khóa ngoại
    }
}
