<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $services = [
            ['category' => 'Hair Services', 'name' => 'Hair Cut', 'description' => 'Basic salon haircut.', 'price' => 150000, 'duration' => 45],
            ['category' => 'Hair Services', 'name' => 'Hair Wash', 'description' => 'Wash and scalp massage.', 'price' => 120000, 'duration' => 30],
            ['category' => 'Hair Services', 'name' => 'Hair Coloring', 'description' => 'Basic coloring service.', 'price' => 650000, 'duration' => 120],
            ['category' => 'Hair Services', 'name' => 'Hair Treatment', 'description' => 'Recovery treatment.', 'price' => 320000, 'duration' => 60],
            ['category' => 'Nail Services', 'name' => 'Nail Care', 'description' => 'Basic nail cleaning and care.', 'price' => 220000, 'duration' => 60],
            ['category' => 'Nail Services', 'name' => 'Manicure', 'description' => 'Basic hand nail care and polish.', 'price' => 180000, 'duration' => 45],
            ['category' => 'Nail Services', 'name' => 'Pedicure', 'description' => 'Basic foot nail care and polish.', 'price' => 200000, 'duration' => 45],
            ['category' => 'Spa & Massage', 'name' => 'Relaxing Massage', 'description' => 'Full body relaxing massage to reduce stress and muscle tension.', 'price' => 450000, 'duration' => 90],
            ['category' => 'Spa & Massage', 'name' => 'Foot Massage', 'description' => 'Relaxing foot massage to improve blood circulation.', 'price' => 250000, 'duration' => 45],
            ['category' => 'Spa & Massage', 'name' => 'Head Massage', 'description' => 'Relaxing head and shoulder massage.', 'price' => 200000, 'duration' => 30],
            ['category' => 'Spa & Massage', 'name' => 'Aromatherapy Massage', 'description' => 'Relaxing massage using essential oils.', 'price' => 550000, 'duration' => 90],
            ['category' => 'Spa & Massage', 'name' => 'Hot Stone Massage', 'description' => 'Massage therapy using warm stones for deep relaxation.', 'price' => 600000, 'duration' => 90],
            ['category' => 'Spa & Massage', 'name' => 'Facial Treatment', 'description' => 'Basic facial cleansing and skin treatment.', 'price' => 350000, 'duration' => 60],
            ['category' => 'Spa & Massage', 'name' => 'Body Scrub', 'description' => 'Body exfoliation treatment for smoother skin.', 'price' => 480000, 'duration' => 75],
            ['category' => 'Combo Packages', 'name' => 'Weekend Relax Combo', 'description' => 'Hair wash, head massage, and facial treatment combo.', 'price' => 790000, 'duration' => 120],
            ['category' => 'Combo Packages', 'name' => 'Hair Refresh Combo', 'description' => 'Hair cut, wash, and treatment package.', 'price' => 520000, 'duration' => 105],
        ];

        foreach ($services as $service) {
            $categoryName = $service['category'];
            unset($service['category']);

            Service::create($service + [
                'category_id' => $categories[$categoryName],
                'status' => 'active',
            ]);
        }
    }
}
