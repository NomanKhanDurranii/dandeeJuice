<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products  = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        $zones = [
            ['name' => 'DHA Phase 1–4',       'fee' => 100],
            ['name' => 'DHA Phase 5–6',        'fee' => 120],
            ['name' => 'Gulberg',              'fee' => 80],
            ['name' => 'Model Town',           'fee' => 90],
            ['name' => 'Johar Town',           'fee' => 110],
            ['name' => 'Bahria Town',          'fee' => 150],
        ];

        $orderBlueprints = [
            // Today — pending (will trigger alert widget)
            ['status' => 'pending',   'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 0,  'items' => [['name' => 'Mango Shake', 'qty' => 2], ['name' => 'Orange Juice', 'qty' => 1]]],
            ['status' => 'pending',   'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 0,  'items' => [['name' => 'Oreo Shake', 'qty' => 1], ['name' => 'Mint Lemonade', 'qty' => 2]]],

            // Today — confirmed / preparing
            ['status' => 'confirmed', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 0,  'items' => [['name' => 'Nutella Shake', 'qty' => 1], ['name' => 'Banana Shake', 'qty' => 1]]],
            ['status' => 'preparing', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 0,  'items' => [['name' => 'Avocado Smoothie', 'qty' => 2]]],

            // Yesterday
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 1,  'items' => [['name' => 'Mango Juice', 'qty' => 3], ['name' => 'Rose Milk', 'qty' => 1]]],
            ['status' => 'delivered', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 1,  'items' => [['name' => 'Strawberry Shake', 'qty' => 2], ['name' => 'Oreo Shake', 'qty' => 1]]],
            ['status' => 'cancelled', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 1,  'items' => [['name' => 'Apple Juice', 'qty' => 2]]],

            // 3 days ago
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 3,  'items' => [['name' => 'Orange Juice', 'qty' => 2], ['name' => 'Mint Lemonade', 'qty' => 2]]],
            ['status' => 'delivered', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 3,  'items' => [['name' => 'Mango Shake', 'qty' => 4]]],

            // 5 days ago
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 5,  'items' => [['name' => 'Pomegranate Juice', 'qty' => 1], ['name' => 'Avocado Smoothie', 'qty' => 1], ['name' => 'Nutella Shake', 'qty' => 1]]],
            ['status' => 'delivered', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 5,  'items' => [['name' => 'Coconut Water', 'qty' => 3], ['name' => 'Falsa Drink', 'qty' => 2]]],

            // 1 week ago
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 7,  'items' => [['name' => 'Mango Shake', 'qty' => 2], ['name' => 'Banana Shake', 'qty' => 2]]],
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 7,  'items' => [['name' => 'Mixed Fruit Juice', 'qty' => 2], ['name' => 'Virgin Mojito', 'qty' => 1]]],
            ['status' => 'cancelled', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 8,  'items' => [['name' => 'Sugarcane Juice', 'qty' => 2]]],

            // 2 weeks ago
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 14, 'items' => [['name' => 'Oreo Shake', 'qty' => 1], ['name' => 'Strawberry Shake', 'qty' => 2], ['name' => 'Rose Milk', 'qty' => 1]]],
            ['status' => 'delivered', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 15, 'items' => [['name' => 'Watermelon Juice', 'qty' => 3]]],
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 18, 'items' => [['name' => 'Mango Juice', 'qty' => 2], ['name' => 'Mango Shake', 'qty' => 1]]],

            // 3 weeks ago
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 21, 'items' => [['name' => 'Apple Juice', 'qty' => 2], ['name' => 'Iced Lemon Tea', 'qty' => 3]]],
            ['status' => 'delivered', 'type' => 'pickup',   'payment' => 'cod',       'days_ago' => 25, 'items' => [['name' => 'Nutella Shake', 'qty' => 2], ['name' => 'Oreo Shake', 'qty' => 1]]],
            ['status' => 'delivered', 'type' => 'delivery', 'payment' => 'cod',       'days_ago' => 28, 'items' => [['name' => 'Seasonal Fruit Punch', 'qty' => 4]]],
        ];

        $productMap = $products->keyBy('name');
        $customerList = $customers->values();
        $zoneIndex = 0;

        foreach ($orderBlueprints as $index => $blueprint) {
            $customer = $customerList[$index % $customerList->count()];
            $zone = $blueprint['type'] === 'delivery' ? $zones[$zoneIndex % count($zones)] : null;
            $zoneIndex++;

            $subtotal = 0;
            $lineItems = [];

            foreach ($blueprint['items'] as $item) {
                $product = $productMap->get($item['name']);
                if (! $product) {
                    continue;
                }
                $lineSubtotal = $product->price * $item['qty'];
                $subtotal += $lineSubtotal;
                $lineItems[] = [
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_price' => $product->price,
                    'quantity'      => $item['qty'],
                    'subtotal'      => $lineSubtotal,
                ];
            }

            if (empty($lineItems)) {
                continue;
            }

            $deliveryFee = $zone ? $zone['fee'] : 0;
            $total       = $subtotal + $deliveryFee;

            $order = Order::create([
                'user_id'          => $customer->id,
                'type'             => $blueprint['type'],
                'status'           => $blueprint['status'],
                'payment_method'   => $blueprint['payment'],
                'subtotal'         => $subtotal,
                'delivery_fee'     => $deliveryFee,
                'total'            => $total,
                'delivery_address' => $zone ? $zone['name'] : null,
                'notes'            => null,
                'created_at'       => now()->subDays($blueprint['days_ago'])->subHours(rand(0, 10)),
                'updated_at'       => now()->subDays($blueprint['days_ago']),
            ]);

            foreach ($lineItems as $lineItem) {
                $order->items()->create($lineItem);
            }
        }
    }
}
