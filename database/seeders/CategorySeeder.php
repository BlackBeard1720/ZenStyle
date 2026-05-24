<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hair Services'],
            ['name' => 'Nail Services'],
            ['name' => 'Spa & Massage'],
            ['name' => 'Combo Packages'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category + ['status' => 'active']
            );
        }
    }
}
