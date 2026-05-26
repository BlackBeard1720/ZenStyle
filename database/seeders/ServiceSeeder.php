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
            [
                'category' => 'Hair Services',
                'name' => 'Hair Cut',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604455/HairCut_i02zgw.png',
                'description' => 'Basic haircut and styling.',
                'price' => 35,
                'duration' => 45,
            ],
            [
                'category' => 'Hair Services',
                'name' => 'Hair Wash',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604455/HairWash_yrs6v2.png',
                'description' => 'Hair wash with scalp massage.',
                'price' => 25,
                'duration' => 30,
            ],
            [
                'category' => 'Hair Services',
                'name' => 'Hair Coloring',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604455/HairColoring_kbzl0g.png',
                'description' => 'Basic hair coloring service.',
                'price' => 120,
                'duration' => 120,
            ],
            [
                'category' => 'Hair Services',
                'name' => 'Hair Treatment',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604455/HairTreatment_f5vab9.png',
                'description' => 'Hair recovery treatment.',
                'price' => 70,
                'duration' => 60,
            ],

            [
                'category' => 'Nail Services',
                'name' => 'Manicure',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604454/Manicure_bq9g3h.png',
                'description' => 'Hand nail care and polish.',
                'price' => 30,
                'duration' => 45,
            ],
            [
                'category' => 'Nail Services',
                'name' => 'Pedicure',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604454/Pedicure_zwk5qs.png',
                'description' => 'Foot nail care and polish.',
                'price' => 40,
                'duration' => 45,
            ],

            [
                'category' => 'Spa & Massage',
                'name' => 'Relaxing Massage',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604459/massage01_eadxlg.png',
                'description' => 'Full body relaxing massage.',
                'price' => 110,
                'duration' => 90,
            ],
            [
                'category' => 'Spa & Massage',
                'name' => 'Foot Massage',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604460/massage02_cddjhh.png',
                'description' => 'Relaxing foot massage.',
                'price' => 55,
                'duration' => 45,
            ],
            [
                'category' => 'Spa & Massage',
                'name' => 'Head Massage',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604458/massage03_goxvly.png',
                'description' => 'Head and shoulder massage.',
                'price' => 45,
                'duration' => 30,
            ],
            [
                'category' => 'Spa & Massage',
                'name' => 'Aromatherapy Massage',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604460/massage04_syzjmx.png',
                'description' => 'Massage using essential oils.',
                'price' => 135,
                'duration' => 90,
            ],
            [
                'category' => 'Spa & Massage',
                'name' => 'Hot Stone Massage',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604459/massage05_asohrk.png',
                'description' => 'Warm stone massage therapy.',
                'price' => 150,
                'duration' => 90,
            ],
            [
                'category' => 'Spa & Massage',
                'name' => 'Facial Treatment',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779604460/massage06_iegivw.png',
                'description' => 'Basic facial cleansing and skin care.',
                'price' => 85,
                'duration' => 60,
            ],

            [
                'category' => 'Combo Packages',
                'name' => 'Weekend Relax Combo',
                'thumbnail' => 'https://res.cloudinary.com/dg5hsfg4n/image/upload/q_auto/f_auto/v1779605690/combozenstyle_e6pfwl.png',
                'description' => 'Hair cut, wash and treatment, head massage, and facial treatment.',
                'price' => 260,
                'duration' => 120,
            ],
        ];

        foreach ($services as $service) {
            $categoryName = $service['category'];
            unset($service['category']);

            Service::updateOrCreate(
                [
                    'name' => $service['name'],
                    'category_id' => $categories[$categoryName],
                ],
                $service + [
                    'category_id' => $categories[$categoryName],
                    'status' => 'active',
                ]
            );
        }
    }
}
