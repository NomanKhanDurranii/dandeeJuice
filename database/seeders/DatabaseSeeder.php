<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Super Admin ────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@dandeejuice.com'],
            [
                'name'     => 'Super Admin',
                'email'    => 'admin@dandeejuice.com',
                'phone'    => '03000000000',
                'password' => Hash::make('password'),
                'role'     => 'super_admin',
            ]
        );

        // ── 2. Delivery Zones ──────────────────────────────────────
        $zones = [
            ['name' => 'DHA Phase 1–4',       'delivery_fee' => 100, 'order_column' => 1],
            ['name' => 'DHA Phase 5–6',        'delivery_fee' => 120, 'order_column' => 2],
            ['name' => 'Gulberg',              'delivery_fee' => 80,  'order_column' => 3],
            ['name' => 'Model Town',           'delivery_fee' => 90,  'order_column' => 4],
            ['name' => 'Johar Town',           'delivery_fee' => 110, 'order_column' => 5],
            ['name' => 'Bahria Town',          'delivery_fee' => 150, 'order_column' => 6],
            ['name' => 'Cantt / Sarwar Road',  'delivery_fee' => 100, 'order_column' => 7],
        ];

        foreach ($zones as $zone) {
            DeliveryZone::firstOrCreate(['name' => $zone['name']], [...$zone, 'is_active' => true]);
        }

        // ── 3. Site Settings ───────────────────────────────────────
        $settings = [
            ['key' => 'easypaisa_enabled', 'value' => '0',            'group' => 'payments'],
            ['key' => 'jazzcash_enabled',  'value' => '0',            'group' => 'payments'],
            ['key' => 'whatsapp_number',   'value' => '923001234567', 'group' => 'contact'],
            ['key' => 'store_name',        'value' => 'DandeeJuice',  'group' => 'general'],
            ['key' => 'store_address',     'value' => '12-C Main Boulevard, Gulberg III, Lahore', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }

        // ── 4. FAQs ────────────────────────────────────────────────
        $faqs = [
            ['question' => 'What areas do you deliver to?',           'answer' => 'We currently deliver to DHA, Gulberg, Model Town, Johar Town, Bahria Town, and Cantt. Select your area at the start of your order to see the exact delivery fee.',                                   'order_column' => 1],
            ['question' => 'How long does delivery take?',            'answer' => 'Most orders are delivered within 30–45 minutes depending on your location and how busy we are. We will call/WhatsApp you if there is any delay.',                                                     'order_column' => 2],
            ['question' => 'Can I place a bulk or corporate order?',  'answer' => 'Absolutely! Contact us on WhatsApp for bulk orders, office events, or corporate packages and we will arrange a custom deal.',                                                                         'order_column' => 3],
            ['question' => 'Are your juices freshly made?',           'answer' => 'Yes — every juice and shake is made fresh to order. We never use concentrates, preservatives, or artificial flavors.',                                                                                'order_column' => 4],
            ['question' => 'What payment methods do you accept?',     'answer' => 'We currently accept Cash on Delivery for all orders. Digital payments (EasyPaisa / JazzCash) are coming soon.',                                                                                      'order_column' => 5],
            ['question' => 'Can I customize my order?',               'answer' => 'Yes! Use the order notes field at checkout to request less sugar, extra ice, a specific size, or any other customization. We do our best to accommodate.',                                            'order_column' => 6],
            ['question' => 'Do you have sugar-free options?',         'answer' => 'Yes! All our fresh juices can be made without added sugar. Simply mention "no sugar" in your order notes. We also have naturally low-sugar options like Apple Juice and Pomegranate Juice.',         'order_column' => 7],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], [...$faq, 'is_active' => true]);
        }

        // ── 5. Demo data ───────────────────────────────────────────
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
            InquirySeeder::class,
        ]);
    }
}
