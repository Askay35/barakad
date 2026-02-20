<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Первые блюда', 'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=400&fit=crop'],
            ['name' => 'Вторые блюда', 'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=400&fit=crop'],
            ['name' => 'Гарниры', 'image' => 'https://images.unsplash.com/photo-1536304929831-ee1ca9d44906?w=400&h=400&fit=crop'],
            ['name' => 'Салаты', 'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=400&fit=crop'],
            ['name' => 'Выпечка', 'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=400&fit=crop'],
            ['name' => 'Напитки', 'image' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=400&h=400&fit=crop'],
            ['name' => 'Десерты', 'image' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400&h=400&fit=crop'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
