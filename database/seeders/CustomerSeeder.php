<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'Ahmad Ali',     'email' => 'ahmad.ali@example.com',     'phone' => '03001111111'],
            ['name' => 'Sara Khan',     'email' => 'sara.khan@example.com',     'phone' => '03012222222'],
            ['name' => 'Usman Malik',   'email' => 'usman.malik@example.com',   'phone' => '03023333333'],
            ['name' => 'Fatima Ahmed',  'email' => 'fatima.ahmed@example.com',  'phone' => '03034444444'],
            ['name' => 'Hassan Raza',   'email' => 'hassan.raza@example.com',   'phone' => '03045555555'],
            ['name' => 'Ayesha Siddiqui', 'email' => 'ayesha.s@example.com',   'phone' => '03056666666'],
            ['name' => 'Bilal Sheikh',  'email' => 'bilal.sheikh@example.com',  'phone' => '03067777777'],
            ['name' => 'Mariam Tariq',  'email' => 'mariam.tariq@example.com',  'phone' => '03078888888'],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    ...$customer,
                    'password' => Hash::make('password'),
                    'role'     => 'customer',
                ]
            );
        }
    }
}
