<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            [
                'supplier_name' => 'Công ty Mỹ Phẩm ABC',
                'contact_name' => 'Nguyễn Văn A',
                'phone' => '0901234567',
                'email' => 'abc@gmail.com',
                'address' => 'Hà Nội',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_name' => 'Beauty Supplier',
                'contact_name' => 'Trần Thị B',
                'phone' => '0912345678',
                'email' => 'beauty@gmail.com',
                'address' => 'Hồ Chí Minh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
