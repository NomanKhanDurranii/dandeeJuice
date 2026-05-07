<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fresh Juices',       'order_column' => 1],
            ['name' => 'Shakes & Smoothies', 'order_column' => 2],
            ['name' => 'Cold Drinks',        'order_column' => 3],
            ['name' => 'Seasonal Specials',  'order_column' => 4],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [...$cat, 'slug' => Str::slug($cat['name']), 'is_active' => true]
            );
        }
    }
}
