<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            ['location_name' => 'Headquarters', 'address' => 'Main Office Building'],
            ['location_name' => 'Branch Office', 'address' => 'Branch Location'],
            ['location_name' => 'Warehouse', 'address' => 'Storage Facility'],
            ['location_name' => 'Factory', 'address' => 'Manufacturing Unit'],
            ['location_name' => 'Distribution Center', 'address' => 'Distribution Hub'],
            ['location_name' => 'Regional Office', 'address' => 'Regional Branch'],
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate(
                ['location_name' => $loc['location_name']],
                [
                    'address' => $loc['address'] ?? null,
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            );
        }
    }
}
