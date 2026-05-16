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
                'description' => 'We respond within 24 hours',
                'icon' => 'envelope',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'phone',
                'title' => 'Call Us',
                'value' => '01918329829',
                'description' => 'Mon-Fri 9AM-6PM EST',
                'icon' => 'phone',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'address',
                'title' => 'Visit Us',
                'value' => '123 Digital Street, Tech City, TC 12345, United States',
                'icon' => 'map-pin',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'type' => 'hours',
                'title' => 'Business Hours',
                'value' => 'Monday - Friday: 9:00 AM - 6:00 PM EST',
                'description' => 'Saturday: 10:00 AM - 4:00 PM EST, Sunday: Closed',
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