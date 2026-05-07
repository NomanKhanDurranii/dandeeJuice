<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $juices   = Category::where('slug', 'fresh-juices')->first();
        $shakes   = Category::where('slug', 'shakes-smoothies')->first();
        $cold     = Category::where('slug', 'cold-drinks')->first();
        $seasonal = Category::where('slug', 'seasonal-specials')->first();

        $products = [
            // ── Fresh Juices ──────────────────────────────────────
            [
                'category_id'  => $juices?->id,
                'name'         => 'Orange Juice',
                'description'  => 'Freshly squeezed pure orange juice — no sugar, no water. Packed with Vitamin C.',
                'price'        => 180,
                'order_column' => 1,
            ],
            [
                'category_id'  => $juices?->id,
                'name'         => 'Mango Juice',
                'description'  => 'Made from hand-picked Chaunsa mangoes. Thick, sweet and irresistible.',
                'price'        => 200,
                'order_column' => 2,
            ],
            [
                'category_id'  => $juices?->id,
                'name'         => 'Apple Juice',
                'description'  => 'Cold-pressed fresh apple juice. Crisp, clean and naturally sweet.',
                'price'        => 160,
                'order_column' => 3,
            ],
            [
                'category_id'  => $juices?->id,
                'name'         => 'Mixed Fruit Juice',
                'description'  => 'A refreshing blend of seasonal fruits — orange, apple, pineapple and more.',
                'price'        => 220,
                'order_column' => 4,
            ],
            [
                'category_id'  => $juices?->id,
                'name'         => 'Watermelon Juice',
                'description'  => 'Pure, ice-cold watermelon juice. The ultimate summer cooler.',
                'price'        => 150,
                'order_column' => 5,
            ],
            [
                'category_id'  => $juices?->id,
                'name'         => 'Pomegranate Juice',
                'description'  => 'Rich in antioxidants. Freshly pressed pomegranate — no concentrate ever.',
                'price'        => 260,
                'order_column' => 6,
            ],

            // ── Shakes & Smoothies ────────────────────────────────
            [
                'category_id'  => $shakes?->id,
                'name'         => 'Mango Shake',
                'description'  => 'Creamy mango blended with fresh milk and a hint of cardamom. A crowd favourite.',
                'price'        => 220,
                'order_column' => 1,
            ],
            [
                'category_id'  => $shakes?->id,
                'name'         => 'Banana Shake',
                'description'  => 'Thick and filling banana shake made with fresh bananas and full-fat milk.',
                'price'        => 200,
                'order_column' => 2,
            ],
            [
                'category_id'  => $shakes?->id,
                'name'         => 'Strawberry Shake',
                'description'  => 'Fresh strawberries blended with milk and a scoop of vanilla. Perfectly pink.',
                'price'        => 240,
                'order_column' => 3,
            ],
            [
                'category_id'  => $shakes?->id,
                'name'         => 'Oreo Shake',
                'description'  => 'Crushed Oreos, vanilla ice cream and chilled milk. Pure indulgence.',
                'price'        => 280,
                'order_column' => 4,
            ],
            [
                'category_id'  => $shakes?->id,
                'name'         => 'Nutella Shake',
                'description'  => 'A rich Nutella shake topped with whipped cream and chocolate drizzle.',
                'price'        => 300,
                'order_column' => 5,
            ],
            [
                'category_id'  => $shakes?->id,
                'name'         => 'Avocado Smoothie',
                'description'  => 'Creamy avocado blended with banana, honey and almond milk. Nutritious and delicious.',
                'price'        => 320,
                'order_column' => 6,
            ],

            // ── Cold Drinks ───────────────────────────────────────
            [
                'category_id'  => $cold?->id,
                'name'         => 'Mint Lemonade',
                'description'  => 'Fresh lemon juice with mint, chilled water and a touch of sugar. Super refreshing.',
                'price'        => 180,
                'order_column' => 1,
            ],
            [
                'category_id'  => $cold?->id,
                'name'         => 'Rose Milk',
                'description'  => 'Chilled milk infused with rose syrup. A Pakistani classic.',
                'price'        => 160,
                'order_column' => 2,
            ],
            [
                'category_id'  => $cold?->id,
                'name'         => 'Iced Lemon Tea',
                'description'  => 'Brewed black tea chilled over ice with fresh lemon slices.',
                'price'        => 150,
                'order_column' => 3,
            ],
            [
                'category_id'  => $cold?->id,
                'name'         => 'Virgin Mojito',
                'description'  => 'Lime, mint, soda water and crushed ice. Fresh and fizzy.',
                'price'        => 200,
                'order_column' => 4,
            ],

            // ── Seasonal Specials ──────────────────────────────────
            [
                'category_id'  => $seasonal?->id,
                'name'         => 'Sugarcane Juice',
                'description'  => 'Freshly pressed sugarcane with ginger and lemon. Only available in season.',
                'price'        => 120,
                'order_column' => 1,
            ],
            [
                'category_id'  => $seasonal?->id,
                'name'         => 'Falsa Drink',
                'description'  => 'Tart and sweet falsa (grewia) blended with chilled water and sugar.',
                'price'        => 140,
                'order_column' => 2,
            ],
            [
                'category_id'  => $seasonal?->id,
                'name'         => 'Coconut Water',
                'description'  => 'Pure, natural coconut water served straight from the shell.',
                'price'        => 180,
                'order_column' => 3,
            ],
            [
                'category_id'  => $seasonal?->id,
                'name'         => 'Seasonal Fruit Punch',
                'description'  => 'Our chef\'s rotating blend of whatever is freshest today. Ask us what\'s in it!',
                'price'        => 220,
                'order_column' => 4,
            ],
        ];

        foreach ($products as $product) {
            if (! $product['category_id']) {
                continue;
            }

            Product::firstOrCreate(
                ['name' => $product['name'], 'category_id' => $product['category_id']],
                [...$product, 'is_active' => true]
            );
        }
    }
}
