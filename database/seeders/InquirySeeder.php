<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $inquiries = [
            [
                'name'    => 'Sara Khan',
                'email'   => 'sara.khan@example.com',
                'phone'   => '03012222222',
                'subject' => 'Bulk order for office event',
                'message' => 'Hi! We are hosting an office party for around 40 people next Friday. Can you provide bulk juices and shakes at a discounted rate? We are looking for around 50 glasses total. Please share your corporate pricing.',
                'status'  => 'new',
            ],
            [
                'name'    => 'Ahmad Ali',
                'email'   => 'ahmad.ali@example.com',
                'phone'   => '03001111111',
                'subject' => 'Order was delivered late',
                'message' => 'My order #0003 was supposed to arrive in 45 minutes but it took over 90 minutes. The shakes were melted by the time they arrived. I would like a refund or at least a discount on my next order.',
                'status'  => 'in_progress',
            ],
            [
                'name'    => 'Mariam Tariq',
                'email'   => 'mariam.tariq@example.com',
                'phone'   => '03078888888',
                'subject' => 'Do you have sugar-free options?',
                'message' => 'I am diabetic and looking for sugar-free juice options. Do you use natural sweeteners? Can I customize my order to have no added sugar? Please let me know.',
                'status'  => 'resolved',
            ],
            [
                'name'    => 'Bilal Sheikh',
                'email'   => 'bilal.sheikh@example.com',
                'phone'   => '03067777777',
                'subject' => 'Wrong item delivered',
                'message' => 'I ordered an Oreo Shake but received a Banana Shake instead. I am allergic to bananas and this was very concerning. Please ensure quality checks are done before delivery.',
                'status'  => 'resolved',
            ],
            [
                'name'    => 'Zainab Hussain',
                'email'   => 'zainab.h@example.com',
                'phone'   => '03089999999',
                'subject' => 'Catering inquiry for wedding',
                'message' => 'We are planning a wedding in next month and are looking for a juice bar setup for approximately 200 guests. Do you provide catering services? What would the pricing look like for fresh juices and shakes on-site?',
                'status'  => 'new',
            ],
        ];

        foreach ($inquiries as $inquiry) {
            Inquiry::firstOrCreate(
                ['email' => $inquiry['email'], 'subject' => $inquiry['subject']],
                $inquiry
            );
        }
    }
}
