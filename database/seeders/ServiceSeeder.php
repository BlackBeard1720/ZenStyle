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
            ['category' => 'Hair Services', 'service_name' => 'Hair Cut', 'description' => 'Basic salon haircut.', 'price' => 150000, 'duration_minutes' => 45],
            ['category' => 'Hair Services', 'service_name' => 'Hair Wash', 'description' => 'Wash and scalp massage.', 'price' => 120000, 'duration_minutes' => 30],
            ['category' => 'Hair Services', 'service_name' => 'Hair Coloring', 'description' => 'Basic coloring service.', 'price' => 650000, 'duration_minutes' => 120],
            ['category' => 'Hair Services', 'service_name' => 'Hair Treatment', 'description' => 'Recovery treatment.', 'price' => 320000, 'duration_minutes' => 60],
            ['category' => 'Nail Services', 'service_name' => 'Nail Care', 'description' => 'Basic nail cleaning and care.', 'price' => 220000, 'duration_minutes' => 60],
            ['category' => 'Nail Services', 'service_name' => 'Manicure', 'description' => 'Basic hand nail care and polish.', 'price' => 180000, 'duration_minutes' => 45],
            ['category' => 'Nail Services', 'service_name' => 'Pedicure', 'description' => 'Basic foot nail care and polish.', 'price' => 200000, 'duration_minutes' => 45],
            ['category' => 'Spa & Massage', 'service_name' => 'Relaxing Massage', 'description' => 'Full body relaxing massage to reduce stress and muscle tension.', 'price' => 450000, 'duration_minutes' => 90],
            ['category' => 'Spa & Massage', 'service_name' => 'Foot Massage', 'description' => 'Relaxing foot massage to improve blood circulation.', 'price' => 250000, 'duration_minutes' => 45],
            ['category' => 'Spa & Massage', 'service_name' => 'Head Massage', 'description' => 'Relaxing head and shoulder massage.', 'price' => 200000, 'duration_minutes' => 30],
            ['category' => 'Spa & Massage', 'service_name' => 'Aromatherapy Massage', 'description' => 'Relaxing massage using essential oils.', 'price' => 550000, 'duration_minutes' => 90],
            ['category' => 'Spa & Massage', 'service_name' => 'Hot Stone Massage', 'description' => 'Massage therapy using warm stones for deep relaxation.', 'price' => 600000, 'duration_minutes' => 90],
            ['category' => 'Spa & Massage', 'service_name' => 'Facial Treatment', 'description' => 'Basic facial cleansing and skin treatment.', 'price' => 350000, 'duration_minutes' => 60],
            ['category' => 'Spa & Massage', 'service_name' => 'Body Scrub', 'description' => 'Body exfoliation treatment for smoother skin.', 'price' => 480000, 'duration_minutes' => 75],
            ['category' => 'Combo Packages', 'service_name' => 'Weekend Relax Combo', 'description' => 'Hair wash, head massage, and facial treatment combo.', 'price' => 790000, 'duration_minutes' => 120],
            ['category' => 'Combo Packages', 'service_name' => 'Hair Refresh Combo', 'description' => 'Hair cut, wash, and treatment package.', 'price' => 520000, 'duration_minutes' => 105],
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
