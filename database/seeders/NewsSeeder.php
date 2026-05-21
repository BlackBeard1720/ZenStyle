<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $title = $faker->sentence(6, true);
            News::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . time() . $i,
                'summary' => $faker->paragraph(),
                'body' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>',
                'image' => null,
                'status' => 'active',
            ]);
        }
    }
}
