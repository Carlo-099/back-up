<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_type' => 'home'],
            ['category_type' => 'school'],
            ['category_type' => 'outdoors']
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'user_id' => 2, // Using the existing user_id
                'category_type' => $category['category_type'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
