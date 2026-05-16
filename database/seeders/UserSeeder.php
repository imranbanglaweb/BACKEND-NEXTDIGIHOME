<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ================= ROLES =================
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $adminRole = Role::where('name', 'Admin')->first();

        // ================= SUPER ADMIN =================
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@nextdigihome.com'],
            [
                'name' => 'Next Digi Home Super Admin',
                'user_name' => 'superadmin',
                'password' => Hash::make('admin123'),
                'status' => 1,
                'user_type' => 'super_admin',
                'user_image' => 'default.png',
                'cell_phone' => '01700000001',
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        $this->command->info('Created Super Admin: superadmin@nextdigihome.com / admin123');

        // ================= ADMIN =================
        $admin = User::firstOrCreate(
            ['email' => 'admin@nextdigihome.com'],
            [
                'name' => 'Next Digi Home Admin',
                'user_name' => 'admin',
                'password' => Hash::make('password'),
                'status' => 1,
                'user_type' => 'admin',
                'user_image' => 'default.png',
                'cell_phone' => '01700000002',
            ]
        );
        $admin->assignRole($adminRole);

        $this->command->info('Created Admin: admin@nextdigihome.com / password');

        // ================= SUMMARY =================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('Next Digi Home User Seeding Completed!');
        $this->command->info('========================================');
        $this->command->info('Admin Users:');
        $this->command->info('  1. superadmin@nextdigihome.com / admin123 (Super Admin)');
        $this->command->info('  2. admin@nextdigihome.com / password (Admin)');
        $this->command->info('========================================');
    }
}