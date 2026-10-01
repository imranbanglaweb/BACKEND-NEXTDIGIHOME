<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceCategory;

class MaintenanceCategorySeeder extends Seeder
{
    public function run()
    {
        // Parent Categories
        $oilCategory = MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Engine Oil & Fluids',
            'category_slug' => 'engine-oil-fluids',
            'category_type' => 'parts',
            'category_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $oilCategory->id,
            'category_name' => 'Engine Oil',
            'category_slug' => 'engine-oil',
            'category_type' => 'parts',
            'category_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $oilCategory->id,
            'category_name' => 'Oil Filter',
            'category_slug' => 'oil-filter',
            'category_type' => 'parts',
            'category_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $oilCategory->id,
            'category_name' => 'Transmission Oil',
            'category_slug' => 'transmission-oil',
            'category_type' => 'parts',
            'category_order' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $oilCategory->id,
            'category_name' => 'Coolant',
            'category_slug' => 'coolant',
            'category_type' => 'parts',
            'category_order' => 4,
            'status' => 1,
            'created_by' => 1,
        ]);

        // Brake Category
        $brakeCategory = MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Brake System',
            'category_slug' => 'brake-system',
            'category_type' => 'parts',
            'category_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $brakeCategory->id,
            'category_name' => 'Brake Pads',
            'category_slug' => 'brake-pads',
            'category_type' => 'parts',
            'category_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $brakeCategory->id,
            'category_name' => 'Brake Disc',
            'category_slug' => 'brake-disc',
            'category_type' => 'parts',
            'category_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $brakeCategory->id,
            'category_name' => 'Brake Caliper',
            'category_slug' => 'brake-caliper',
            'category_type' => 'parts',
            'category_order' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $brakeCategory->id,
            'category_name' => 'Brake Fluid',
            'category_slug' => 'brake-fluid',
            'category_type' => 'parts',
            'category_order' => 4,
            'status' => 1,
            'created_by' => 1,
        ]);

        // Filter Category
        $filterCategory = MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Filters',
            'category_slug' => 'filters',
            'category_type' => 'parts',
            'category_order' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $filterCategory->id,
            'category_name' => 'Air Filter',
            'category_slug' => 'air-filter',
            'category_type' => 'parts',
            'category_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $filterCategory->id,
            'category_name' => 'Cabin Filter',
            'category_slug' => 'cabin-filter',
            'category_type' => 'parts',
            'category_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $filterCategory->id,
            'category_name' => 'Fuel Filter',
            'category_slug' => 'fuel-filter',
            'category_type' => 'parts',
            'category_order' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        // Body Parts Category
        $bodyCategory = MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Body Parts',
            'category_slug' => 'body-parts',
            'category_type' => 'parts',
            'category_order' => 4,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $bodyCategory->id,
            'category_name' => 'Door Panel',
            'category_slug' => 'door-panel',
            'category_type' => 'parts',
            'category_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $bodyCategory->id,
            'category_name' => 'Bumper',
            'category_slug' => 'bumper',
            'category_type' => 'parts',
            'category_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $bodyCategory->id,
            'category_name' => 'Headlight',
            'category_slug' => 'headlight',
            'category_type' => 'parts',
            'category_order' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $bodyCategory->id,
            'category_name' => 'Tail Light',
            'category_slug' => 'tail-light',
            'category_type' => 'parts',
            'category_order' => 4,
            'status' => 1,
            'created_by' => 1,
        ]);

        // Tire Category
        $tireCategory = MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Tires & Wheels',
            'category_slug' => 'tires-wheels',
            'category_type' => 'parts',
            'category_order' => 5,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $tireCategory->id,
            'category_name' => 'Tire (MRF)',
            'category_slug' => 'tire-mrf',
            'category_type' => 'parts',
            'category_order' => 1,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $tireCategory->id,
            'category_name' => 'Tire (Apollo)',
            'category_slug' => 'tire-apollo',
            'category_type' => 'parts',
            'category_order' => 2,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $tireCategory->id,
            'category_name' => 'Wheel Rim',
            'category_slug' => 'wheel-rim',
            'category_type' => 'parts',
            'category_order' => 3,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => $tireCategory->id,
            'category_name' => 'Tire Valve',
            'category_slug' => 'tire-valve',
            'category_type' => 'parts',
            'category_order' => 4,
            'status' => 1,
            'created_by' => 1,
        ]);

        // Battery Category
        MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Battery & Electrical',
            'category_slug' => 'battery-electrical',
            'category_type' => 'parts',
            'category_order' => 6,
            'status' => 1,
            'created_by' => 1,
        ]);

        // Service Category
        MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Labor Services',
            'category_slug' => 'labor-services',
            'category_type' => 'service',
            'category_order' => 7,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Diagnostics',
            'category_slug' => 'diagnostics',
            'category_type' => 'service',
            'category_order' => 8,
            'status' => 1,
            'created_by' => 1,
        ]);

        MaintenanceCategory::create([
            'parent_id' => 0,
            'category_name' => 'Paint Work',
            'category_slug' => 'paint-work',
            'category_type' => 'service',
            'category_order' => 9,
            'status' => 1,
            'created_by' => 1,
        ]);

        $this->command->info('Maintenance categories seeded successfully!');
    }
}
