<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        PurchaseOrder::insert([
            [
                'supplier_id' => 1,
                'order_date' => now(),
                'total_cost' => 50,
                'status' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 2,
                'order_date' => now(),
                'total_cost' => 35,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
