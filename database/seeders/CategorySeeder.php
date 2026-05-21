<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hair Services', 'description' => 'Hair cutting, styling, coloring, and treatment services.'],
            ['name' => 'Nail Services', 'description' => 'Manicure, pedicure, polish, and nail care services.'],
            ['name' => 'Spa & Massage', 'description' => 'Relaxing massage, skincare, and body care services.'],
            ['name' => 'Combo Packages', 'description' => 'Bundled services offered as normal services in this category.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category + ['status' => 'active']
            );
        }
    }
}
