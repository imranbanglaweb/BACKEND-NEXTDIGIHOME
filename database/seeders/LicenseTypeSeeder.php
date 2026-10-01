<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Licnese_type;

class LicenseTypeSeeder extends Seeder
{
    public function run()
    {
        $licenseTypes = [
            [
                'type_name' => 'Professional License (Non-Transport)',
                'description' => 'For private vehicles not used for commercial transport',
                'status' => 1,
            ],
            [
                'type_name' => 'Professional License (Transport)',
                'description' => 'For commercial vehicles used for public transport',
                'status' => 1,
            ],
            [
                'type_name' => 'Heavy Vehicle License',
                'description' => 'For heavy vehicles like buses, trucks, trailers',
                'status' => 1,
            ],
            [
                'type_name' => 'Motorcycle License',
                'description' => 'For motorcycles and scooters',
                'status' => 1,
            ],
            [
                'type_name' => 'Learner License',
                'description' => 'Temporary license for learning drivers',
                'status' => 1,
            ],
        ];

        foreach ($licenseTypes as $type) {
            Licnese_type::updateOrCreate(
                ['type_name' => $type['type_name']],
                [
                    'description' => $type['description'],
                    'status' => $type['status'],
                    'created_by' => 1,
                ]
            );
        }

        $this->command->info('License types seeded successfully.');
    }
}
