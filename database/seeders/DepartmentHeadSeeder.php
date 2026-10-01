<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;

class DepartmentHeadSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('========================================');
        $this->command->info('Assigning Department Heads');
        $this->command->info('========================================');

        // Department head assignments - ONLY HR
        $departmentHeads = [
            'HR' => ['name' => 'Department Head User', 'email' => 'depthead@garibondhu360.com'],
        ];

        foreach ($departmentHeads as $deptName => $headInfo) {
            $department = Department::where('department_name', $deptName)->first();
            
            if ($department) {
                $head = Employee::where('email', $headInfo['email'])->first();
                
                if ($head) {
                    $department->update([
                        'head_employee_id' => $head->id,
                        'head_name' => $head->name,
                        'head_email' => $head->email,
                        'updated_by' => 1,
                    ]);
                    
                    // Check if user exists for this employee
                    $user = User::where('email', $head->email)->first();
                    $userStatus = $user ? 'User exists' : 'No user account';
                    
                    $this->command->info("✓ {$headInfo['name']} ({$headInfo['email']}) - Head of {$deptName} | {$userStatus}");
                } else {
                    $this->command->warn("✗ Employee {$headInfo['email']} not found for {$deptName}");
                }
            } else {
                $this->command->warn("✗ Department {$deptName} not found");
            }
        }

        // Leave these departments without heads
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('Departments WITHOUT Heads');
        $this->command->info('========================================');
        $departmentsWithoutHeads = ['IT', 'Accounts', 'Operations', 'Finance', 'Marketing', 'Sales', 'Administration', 'Transport', 'Logistics'];
        foreach ($departmentsWithoutHeads as $deptName) {
            $department = Department::where('department_name', $deptName)->first();
            if ($department) {
                $this->command->info("✗ {$deptName} - No head assigned yet");
            }
        }

        // ================= SHOW ALL EMPLOYEE USERS =================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('Employee User List');
        $this->command->info('========================================');
        
        $employeeUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'Employee');
        })->with('employee')->get();

        if ($employeeUsers->count() > 0) {
            foreach ($employeeUsers as $user) {
                $deptName = $user->employee && $user->employee->department ? $user->employee->department->department_name : 'N/A';
                $this->command->info("{$user->name} ({$user->email}) | Dept: {$deptName}");
            }
        } else {
            $this->command->info('No employee users found.');
        }

        $this->command->info('');
        $this->command->info('Department heads assigned successfully!');
    }
}
