<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceRequisition;
use App\Models\MaintenanceRequisitionItem;
use App\Models\Company;
use Faker\Factory as Faker;

class MaintenanceRequisitionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Get first company
        $company = Company::first();
        $companyId = $company ? $company->id : 1;

        // Generate 100 dummy maintenance requisitions with items
        $this->generateDummyRequisitions($faker, $companyId);
    }

    private function generateDummyRequisitions($faker, $companyId = 1)
    {
        $requisitionTypes = ['scheduled', 'emergency', 'routine', 'insurance','maintenance','breakdown','inspection'];
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];
        $statuses = ['Pending', 'Pending Approval', 'Approved', 'Completed', 'Rejected'];
        $chargeBearers = ['Company', 'Employee', 'Department'];

        $serviceTitles = [
            'Full Engine Service',
            'Oil Change',
            'Brake System Repair',
            'Monthly Inspection',
            'Body Repair',
            'Tire Replacement',
            'Tire Rotation',
            'Battery Replacement',
            'AC Repair',
            'Suspension Work',
            'Engine Tune-up',
            'Wheel Alignment',
            'Transmission Service',
            'General Inspection',
            'Brake Pad Replacement',
            'Air Filter Replacement',
            'Coolant Flush',
            'Spark Plug Replacement',
            'Wiper Blade Replacement',
            'Headlight Bulb Replacement',
        ];

        $itemNames = [
            'Engine Oil',
            'Oil Filter',
            'Air Filter',
            'Brake Pads',
            'Brake Disc',
            'Brake Caliper',
            'Brake Fluid',
            'Battery',
            'Tire (MRF)',
            'Tire (Apollo)',
            'Wheel Rim',
            'Spark Plug',
            'Wiper Blade',
            'Headlight Bulb',
            'Coolant',
            'Transmission Fluid',
            'Fuel Filter',
            'Cabin Filter',
            'Door Panel',
            'Bumper',
            'Paint Job',
            'Diagnostic Check',
        ];

        for ($i = 0; $i < 100; $i++) {
            $status = $faker->randomElement($statuses);
            
            $requisitionData = [
                'company_id' => $companyId,
                'requisition_no' => $faker->unique()->bothify('MMR-#####'),
                'requisition_type' => $faker->randomElement($requisitionTypes),
                'priority' => $faker->randomElement($priorities),
                'employee_id' => $faker->numberBetween(1, 10),
                'vehicle_id' => $faker->numberBetween(1, 20),
                'maintenance_type_id' => $faker->numberBetween(1, 12),
                'maintenance_date' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'service_title' => $faker->randomElement($serviceTitles),
                'charge_bear_by' => $faker->randomElement($chargeBearers),
                'charge_amount' => $faker->randomFloat(2, 0, 5000),
                'remarks' => $faker->sentence(3),
                'total_parts_cost' => $faker->randomFloat(2, 100, 10000),
                'total_cost' => $faker->randomFloat(2, 500, 20000),
                'status' => $status,
                'created_by' => 1,
            ];
            
            // Add approval fields if status is Approved or Rejected
            if (in_array($status, ['Approved', 'Rejected', 'Pending Approval'])) {
                $requisitionData['approved_by'] = 1;
                $requisitionData['approved_at'] = now();
            }
            
            if ($status === 'Rejected') {
                $requisitionData['approval_remarks'] = $faker->sentence(3);
            }
            
            $requisition = MaintenanceRequisition::create($requisitionData);

            // Create 1-4 items for each requisition
            $numItems = $faker->numberBetween(1, 4);
            for ($j = 0; $j < $numItems; $j++) {
                $qty = $faker->numberBetween(1, 5);
                $unitPrice = $faker->randomFloat(2, 100, 2000);
                $itemName = $faker->randomElement($itemNames);
                $categoryId = $faker->numberBetween(1, 15);
                
                MaintenanceRequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'category_id' => $categoryId,
                    'item_name' => $itemName,
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'total_price' => $qty * $unitPrice,
                    'created_by' => 1,
                ]);
            }
        }

        $this->command->info('100 dummy maintenance requisitions with items created successfully!');
    }
}
