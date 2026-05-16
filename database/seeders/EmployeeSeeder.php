<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Location;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $firstLocation = Location::first();

        $employees = [
            [
                'name' => 'Demo Employee',
                'employee_code' => 'EMP101',
                'email' => 'employee.extra@garibondhu360.com',
                'department_id' => 1,
                'unit_id' => 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'designation' => 'Officer',
                'phone' => '01800000001',
                'employee_type' => 'Permanent',
                'status' => 'Active',
            ],
            [
                'name' => 'John Doe',
                'employee_code' => 'EMP102',
                'email' => 'john.doe@garibondhu360.com',
                'department_id' => 2,
                'unit_id' => 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'designation' => 'Manager',
                'phone' => '01800000002',
                'employee_type' => 'Permanent',
                'status' => 'Active',
            ],
            [
                'name' => 'Jane Smith',
                'employee_code' => 'EMP103',
                'email' => 'jane.smith@garibondhu360.com',
                'department_id' => 3,
                'unit_id' => 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'designation' => 'Accountant',
                'phone' => '01800000003',
                'employee_type' => 'Permanent',
                'status' => 'Active',
            ],
            [
                'name' => 'Mike Johnson',
                'employee_code' => 'EMP104',
                'email' => 'mike.johnson@garibondhu360.com',
                'department_id' => 4,
                'unit_id' => 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'designation' => 'Supervisor',
                'phone' => '01800000004',
                'employee_type' => 'Contract',
                'status' => 'Active',
            ],
            [
                'name' => 'Sarah Williams',
                'employee_code' => 'EMP105',
                'email' => 'sarah.williams@garibondhu360.com',
                'department_id' => 1,
                'unit_id' => 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'designation' => 'HR Executive',
                'phone' => '01800000005',
                'employee_type' => 'Permanent',
                'status' => 'Active',
            ],
            [
                'name' => 'Alex Brown',
                'employee_code' => 'EMP200',
                'email' => 'alex.brown@garibondhu360.com',
                'department_id' => 2,
                'unit_id' => 1,
                'location_id' => $firstLocation ? $firstLocation->id : 1,
                'designation' => 'Senior Developer',
                'phone' => '01800000006',
                'employee_type' => 'Permanent',
                'status' => 'Active',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['email' => $employee['email']],
                [
                    'name' => $employee['name'],
                    'employee_code' => $employee['employee_code'],
                    'company_id' => 1,
                    'department_id' => $employee['department_id'],
                    'unit_id' => $employee['unit_id'],
                    'location_id' => $employee['location_id'],
                    'designation' => $employee['designation'],
                    'phone' => $employee['phone'] ?? null,
                    'employee_type' => $employee['employee_type'] ?? 'Permanent',
                    'status' => $employee['status'] ?? 'Active',
                ]
            );
        }

        // Generate 100 dummy employees
        for ($i = 0; $i < 100; $i++) {
            Employee::updateOrCreate(
                ['employee_code' => 'EMP'.str_pad($i + 200, 4, '0', STR_PAD_LEFT)],
                [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'company_id' => 1,
                    'department_id' => $faker->numberBetween(1, 10),
                    'unit_id' => $faker->numberBetween(1, 6),
                    'location_id' => $faker->numberBetween(1, 5),
                    'designation' => $faker->jobTitle,
                    'phone' => $faker->phoneNumber,
                    'employee_type' => $faker->randomElement(['Permanent', 'Contract', 'Intern']),
                    'status' => 'Active',
                ]
            );
        }
    }
}
