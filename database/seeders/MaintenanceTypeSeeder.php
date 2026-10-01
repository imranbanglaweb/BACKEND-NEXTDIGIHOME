<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceType;

class MaintenanceTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'name' => 'Scheduled Maintenance',
                'description' => 'Planned maintenance activities as per service schedule',
                'created_by' => 1,
            ],
            [
                'name' => 'Emergency Repair',
                'description' => 'Urgent repairs required due to sudden breakdown or failure',
                'created_by' => 1,
            ],
            [
                'name' => 'Routine Inspection',
                'description' => 'Regular safety and performance inspections',
                'created_by' => 1,
            ],
            [
                'name' => 'Body Work',
                'description' => 'Collision damage repair and body painting',
                'created_by' => 1,
            ],
            [
                'name' => 'Tire & Wheel',
                'description' => 'Tire replacement, rotation, and wheel alignment',
                'created_by' => 1,
            ],
            [
                'name' => 'Engine & Transmission',
                'description' => 'Engine repairs, transmission service, and diagnostics',
                'created_by' => 1,
            ],
            [
                'name' => 'Electrical System',
                'description' => 'Battery, lighting, wiring, and electrical component repairs',
                'created_by' => 1,
            ],
            [
                'name' => 'AC & Heating',
                'description' => 'Air conditioning and heating system service',
                'created_by' => 1,
            ],
            [
                'name' => 'Brake System',
                'description' => 'Brake pads, discs, and brake system repairs',
                'created_by' => 1,
            ],
            [
                'name' => 'Suspension',
                'description' => 'Shock absorbers, struts, and suspension repairs',
                'created_by' => 1,
            ],
            [
                'name' => 'Oil & Fluids',
                'description' => 'Oil change, fluid top-up, and filter replacement',
                'created_by' => 1,
            ],
            [
                'name' => 'Glass & Mirrors',
                'description' => 'Windshield, window, and mirror replacement',
                'created_by' => 1,
            ],
        ];

        foreach ($types as $type) {
            MaintenanceType::create($type);
        }

        $this->command->info('Maintenance types seeded successfully!');
    }
}
