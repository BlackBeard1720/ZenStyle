<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        $products = [
            [
                'name' => 'Keratin Shampoo',
                'sku' => 'SP001',
                'url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=800',
                'price' => 25,
                'stock' => 50,
                'min' => 10,
            ],
            [
                'name' => 'Hair Dye Premium',
                'sku' => 'SP002',
                'url' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=800',
                'price' => 18,
                'stock' => 20,
                'min' => 5,
            ],
            [
                'name' => 'Spa Face Cream',
                'sku' => 'SP003',
                'url' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800',
                'price' => 32,
                'stock' => 30,
                'min' => 8,
            ],
            [
                'name' => 'Hair Serum',
                'sku' => 'SP004',
                'url' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800',
                'price' => 28,
                'stock' => 15,
                'min' => 5,
            ],
            [
                'name' => 'Hair Mask',
                'sku' => 'SP005',
                'url' => 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?w=800',
                'price' => 35,
                'stock' => 12,
                'min' => 5,
            ],
        ];

        foreach ($products as $index => $item) {

            $imagePath = null;

            try {

                $imageName = strtolower($item['sku']) . '.jpg';

                $imageContent = Http::timeout(20)
                    ->get($item['url'])
                    ->body();

                Storage::disk('public')->put(
                    'products/' . $imageName,
                    $imageContent
                );

                $imagePath = 'products/' . $imageName;

            } catch (\Exception $e) {

                $imagePath = null;

            }

            Product::create([
                'supplier_id' => ($index % 2) + 1,
                'product_name' => $item['name'],
                'sku' => $item['sku'],
                'image' => $imagePath,
                'description' => $item['name'],
                'price' => $item['price'],
                'stock_quantity' => $item['stock'],
                'min_threshold' => $item['min'],
                'status' => 'active',
            ]);
        }
    }
}
