<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            // ================= DASHBOARD =================
            'dashboard',

            // ================= MENU =================
            'menu-manage',
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-reorder',
            'menu-list',

            // ================= MARKETPLACE (NEXT DIGI HOME) =================
            'product-manage',
            'product-create',
            'product-edit',
            'product-delete',
            'product-view',
            'product-publish',
            'product-category-manage',
            'content-manage',
            'content-create',
            'content-edit',
            'content-delete',
            'order-manage',
            'order-view',
            'order-create',
            'order-edit',
            'order-fulfill',
            'order-cancel',
            'order-refund',
            'customer-manage',
            'customer-view',
            'customer-create',
            'customer-edit',
            'customer-delete',
            'customer-support',
            'analytics-dashboard',
            'marketing-manage',
            'marketing-email',
            'marketing-promotion',
            'seo-manage',
            'my-orders',
            'my-products',
            'my-support',

            // ================= REQUISITIONS =================
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-delete',
            'requisition-export',
            'requisition-download',
            'requisition-approve',
            'requisition-pending-view',
            'requisition-approved-view',

            // ================= DEPARTMENT APPROVAL WORKFLOW =================
            'department-approve',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
            'requisition-approval-department',

            // ================= TRANSPORT APPROVAL WORKFLOW =================
            'transport-approve',
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // ================= VEHICLE MANAGEMENT =================
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-type-manage',
            'vehicle-view',
            'vehicle-export',
            'vehicle-list-view',
            'vehicle-list-department',

            // ================= GPS TRACKING =================
            'gps-tracking',
            'gps-tracking-view',

            // ================= DRIVER MANAGEMENT =================
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-view',
            'driver-export',
            'driver-access',
            'driver-vehicle',
            'driver-list-view',
            'driver-list-department',
            'license-type-manage',
            
            // Driver Documents
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-document-delete',
            'driver-document-approve',
            
            // Driver Schedule
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-schedule-assign',
            'driver-schedule-edit',
            'driver-schedule-own',
            
            // Driver Performance
            'driver-performance-manage',
            'driver-performance-view',
            'driver-performance-report',
            
            // Driver Availability
            'driver-availability-manage',
            'driver-availability-view',
            'driver-availability-update',
            'driver-availability-own',
            
            // Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',
            
            // Trip Fuel
            'trip-fuel-log',
            'trip-fuel-own',
            'trip-fuel-view',

            // ================= EMPLOYEE MANAGEMENT =================
            'employee-manage',
            'employee-create',
            'employee-edit',
            'employee-delete',
            'employee-import',
            'employee-export',
            'employee-view-own',
            'employee-edit-own',
            'employee-list-department',
            'employee-create-department',
            'employee-edit-department',
            'employee-delete-department',

            // ================= DEPARTMENT =================
            'department-manage',
            'department-create',
            'department-edit',
            'department-delete',
            'department-head-manage',

            // ================= UNIT / LOCATION =================
            'unit-manage',
            'unit-create',
            'unit-edit',
            'unit-delete',

            'location-manage',
            'location-create',
            'location-edit',
            'location-delete',

            // ================= COMPANY =================
            'company-manage',
            'company-create',
            'company-edit',
            'company-delete',

            // ================= MAINTENANCE =================
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'maintenance-delete',
            'maintenance-approve',
            'maintenance-approval-view',
            'maintenance-approval-department',
            'maintenance-history',

            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-schedule-manage',
            'maintenance-category-manage',

            // ================= TRIP SHEETS =================
            'trip-manage',
            'trip-sheet-view',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',

            // ================= FUEL MANAGEMENT =================
            'fuel-manage',
            'fuel-log-entry',
            'fuel-history-view',

            // ================= REPORTS =================
            'report-requisition',
            'report-requisition-own',
            'report-requisition-department',
            'report-maintenance',
            'report-maintenance-own',
            'report-maintenance-department',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-export',

            // ================= DOCUMENT MANAGEMENT =================
            'document-manage',
            'document-create',
            'document-edit',
            'document-delete',
            'document-view',
            'document-approve',
            'document-reject',
            'document-history',
            'document-export',

            // ================= PROFILE & SETTINGS =================
            'profile-view',
            'profile-edit',

            // ================= EMPLOYEE SELF-SERVICE =================
            'my-requisitions',
            'my-documents',

            // ================= SUBSCRIPTION & PAYMENTS =================
            'subscription-plan-manage',
            'subscription-plan-create',
            'subscription-plan-edit',
            'subscription-plan-delete',
            'subscription-plan-view',
            'subscription-purchase',
            'subscription-approve',
            'subscription-view',

            'payment-view',
            'payment-approve',
            'payment-reject',
            'payment-invoice',

            // ================= SAAS / TENANT MANAGEMENT =================
            'tenant-manage',
            'tenant-activate',
            'tenant-deactivate',
            'tenant-data-export',
            'tenant-statistics-view',

            // ================= BILLING =================
            'billing-manage',
            'billing-view',
            'invoice-manage',
            'invoice-view',

            // ================= USAGE & ANALYTICS =================
            'usage-view',
            'analytics-view',
            'system-configure',
            'report-tenant-usage',
            'report-billing',

            // ================= SUPPORT =================
            'support-manage',
            'support-create',
            'support-edit',
            'support-view',
            'support-delete',
            'support-emergency',

            // ================= USER & ROLE MANAGEMENT =================
            'user-manage',
            'user-create',
            'user-edit',
            'user-delete',

            'role-manage',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'permission-manage',
            'permission-create',
            'permission-edit',
            'permission-delete',

            // ================= SETTINGS =================
            'settings-manage',
            'settings-language',
            'settings-notification',
            'email-setting',

            // ================= TRANSLATION =================
            'translation-manage',
            'translation-create',
            'translation-update',
            'translation-auto',

            // ================= NOTIFICATION =================
            'notification-view',
            'notification-manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |----------------------------------------------------------
        | Default Roles
        |----------------------------------------------------------
        */
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $transport  = Role::firstOrCreate(['name' => 'Transport', 'guard_name' => 'web']);
        $employee   = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        $deptHead   = Role::firstOrCreate(['name' => 'Department Head', 'guard_name' => 'web']);
        $manager    = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $driver     = Role::firstOrCreate(['name' => 'Driver', 'guard_name' => 'web']);

        // Super Admin gets everything
        $superAdmin->syncPermissions(Permission::all());

        // Admin permissions
        $admin->syncPermissions([
            'dashboard',
            'requisition-view',
            'department-approval-view',
            'transport-approval-view',
            'trip-sheet-view',
            'company-manage',
            'employee-manage',
            'department-manage',
            'unit-manage',
            'location-manage',
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-view',
            'driver-export',
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-performance-manage',
            'driver-performance-view',
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-view',
            'vehicle-export',
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-export',
        ]);

        // Transport role permissions
        $transport->syncPermissions([
            'dashboard',
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',
            'trip-manage',
            'trip-sheet-view',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'driver-manage',
            'driver-view',
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-schedule-assign',
            'driver-availability-manage',
            'driver-availability-view',
            'driver-availability-update',
            'vehicle-manage',
            'vehicle-view',
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'settings-manage',
            'settings-notification',
        ]);

        // Employee permissions
        $employee->syncPermissions([
            'dashboard',
            // Requisitions - Create, View, Edit (No Delete)
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-pending-view',
            'requisition-approved-view',
            // Driver - List View Only
            'driver-list-view',
            // Maintenance - Create and View Own
            'maintenance-create',
            'maintenance-view',
            // Reports - Own Requisitions Only
            'report-requisition-own',
            // Documents
            'document-create',
            'document-view',
            'document-history',
            // Notifications
            'notification-view',
            // Support
            'support-create',
            'support-edit',
            // Profile & Self-service
            'profile-view',
            'profile-edit',
            'my-requisitions',
            'my-documents',
        ]);

        // Department Head permissions
        $deptHead->syncPermissions([
            'dashboard',
            'requisition-view',
            'requisition-create',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
        ]);

        // Manager permissions
        $manager->syncPermissions([
            'dashboard',
            'requisition-view',
            'requisition-create',
            'requisition-approve',
            'department-approval-view',
            'department-approval-approve',
            'transport-approval-view',
            'trip-sheet-view',
            'trip-manage',
            'driver-view',
            'driver-performance-view',
            'driver-performance-report',
            'vehicle-view',
            'report-requisition',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
        ]);

        // Driver permissions
        $driver->syncPermissions([
            'driver-access',
            'driver-schedule-view',
            'driver-schedule-own',
            'driver-availability-view',
            'driver-availability-update',
            'driver-availability-own',
            'driver-vehicle',
            'driver-performance-view',
            'driver-document-view',
            'driver-document-upload',
            'trip-fuel-log',
            'trip-fuel-own',
            'trip-fuel-view',
            'notification-view',
            'gps-tracking-view',
        ]);

        $this->command->info('Permission seeder completed successfully!');
        $this->command->info('Total permissions: ' . count($permissions));
    }
}
