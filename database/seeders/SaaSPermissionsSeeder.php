<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SaaSPermissionsSeeder extends Seeder
{
    public function run()
    {
        // SaaS-specific permissions
        $saasPermissions = [
            // Company/Tenant Management
            'company-manage',
            'company-create',
            'company-edit',
            'company-delete',
            'company-view',

            // Subscription Management
            'subscription-plan-manage',
            'subscription-plan-create',
            'subscription-plan-edit',
            'subscription-plan-delete',
            'subscription-plan-view',

            // Tenant Operations
            'tenant-manage',
            'tenant-activate',
            'tenant-deactivate',
            'tenant-data-export',
            'tenant-statistics-view',

            // Billing & Payments
            'billing-manage',
            'billing-view',
            'payment-approve',
            'invoice-manage',
            'invoice-view',

            // Usage & Analytics
            'usage-view',
            'analytics-view',
            'report-tenant-usage',
            'report-billing',

            // System Administration (SaaS level)
            'system-configure',
            'webhook-manage',
            'api-key-manage',
        ];

        // Create permissions if they don't exist
        foreach ($saasPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Assign SaaS permissions to Super Admin and Admin roles
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin = Role::where('name', 'Admin')->first();

        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }

        if ($admin) {
            // Get existing admin permissions and add SaaS permissions
            $existingPermissions = $admin->permissions->pluck('name')->toArray();
            $allAdminPermissions = array_merge($existingPermissions, $saasPermissions);

            $admin->syncPermissions($allAdminPermissions);
        }

        $this->command->info('SaaS permissions created and assigned successfully');
        $this->command->info('Super Admin: All permissions including SaaS');
        $this->command->info('Admin: Core permissions + SaaS permissions');
    }
}