<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'supplier_id' => 1,
                'product_name' => 'Keratin Shampoo',
                'sku' => 'SP001',
                'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780201488/ChatGPT_Image_11_19_00_31_thg_5_2026_1_idltjy.png',
                'description' => 'Keratin Shampoo',
                'price' => 25,
                'stock_quantity' => 50,
                'min_threshold' => 10,
                'status' => 'active',
            ],
            [
                'supplier_id' => 1,
                'product_name' => 'Hair Dye Premium',
                'sku' => 'SP002',
                'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780201488/ChatGPT_Image_11_19_01_31_thg_5_2026_3_w6efqf.png',
                'description' => 'Hair Dye Premium',
                'price' => 18,
                'stock_quantity' => 20,
                'min_threshold' => 5,
                'status' => 'active',
            ],
            [
                'supplier_id' => 1,
                'product_name' => 'Spa Face Cream',
                'sku' => 'SP003',
                'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780201489/ChatGPT_Image_20_28_56_30_thg_5_2026_1_dtrwty.png',
                'description' => 'Spa Face Cream',
                'price' => 32,
                'stock_quantity' => 30,
                'min_threshold' => 8,
                'status' => 'active',
            ],
            [
                'supplier_id' => 1,
                'product_name' => 'Hair Serum',
                'sku' => 'SP004',
                'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780201488/ChatGPT_Image_11_19_00_31_thg_5_2026_2_u91y5b.png',
                'description' => 'Hair Serum',
                'price' => 28,
                'stock_quantity' => 15,
                'min_threshold' => 5,
                'status' => 'active',
            ],
            [
                'supplier_id' => 1,
                'product_name' => 'Hair Mask',
                'sku' => 'SP005',
                'image' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1780201489/ChatGPT_Image_20_28_56_30_thg_5_2026_2_kaecvr.png',
                'description' => 'Hair Mask',
                'price' => 35,
                'stock_quantity' => 12,
                'min_threshold' => 5,
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }
    }
}
