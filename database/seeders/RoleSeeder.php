<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Super Admin role with ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        
        // Get all permissions and assign to Super Admin
        $allPermissions = Permission::all();
        if ($allPermissions->isNotEmpty()) {
            $superAdminRole->syncPermissions($allPermissions);
        }

        // Create other roles
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Transport', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Department Head', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Driver', 'guard_name' => 'web']);

        $this->command->info('Role seeder completed successfully!');
        $this->command->info('Created roles: Super Admin, Admin, Transport, Employee, Department Head, Manager');
    }
}
