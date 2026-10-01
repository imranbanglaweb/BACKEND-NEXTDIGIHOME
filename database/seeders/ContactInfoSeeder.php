<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'type' => 'email',
                'title' => 'Email Us',
                'value' => 'info@nextdigihome.com',
                'description' => 'Technical proposals & commercial requests',
                'icon' => 'envelope',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'phone',
                'title' => 'Call / WhatsApp',
                'value' => '+880 1918 329829',
                'description' => 'Saturday – Thursday: 10:00 AM – 7:00 PM BST',
                'icon' => 'phone',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'address',
                'title' => 'Headquarters',
                'value' => 'Dhaka, Bangladesh',
                'description' => 'Global digital operations & engineering',
                'icon' => 'map-pin',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'type' => 'hours',
                'title' => 'Business Hours',
                'value' => 'Saturday - Thursday: 10:00 AM - 7:00 PM BST',
                'description' => '24/7 SLA emergency support for ongoing platforms',
                'icon' => 'clock',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($contacts as $contact) {
            ContactInfo::updateOrCreate(
                ['type' => $contact['type']],
                $contact
            );
        }
    }
}
