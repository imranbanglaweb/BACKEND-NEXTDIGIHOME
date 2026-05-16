<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ================= ROLES =================
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin = Role::where('name', 'Admin')->first();
        $transport = Role::where('name', 'Transport')->first();
        $employee = Role::where('name', 'Employee')->first();
        $deptHead = Role::where('name', 'Department Head')->first();
        $manager = Role::where('name', 'Manager')->first();
        $driver = Role::where('name', 'Driver')->first();

        // ================= SUPER ADMIN =================
        $superAdmin?->syncPermissions(Permission::all());

        // ================= ADMIN =================
        $adminPermissions = [

            'dashboard',

            // Marketplace
            'product-manage',
            'product-view',
            'product-create',
            'product-edit',
            'order-manage',
            'order-view',
            'customer-manage',
            'customer-view',
            'content-manage',
            'analytics-dashboard',

            // Requisitions
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-delete',
            'requisition-export',
            'requisition-download',
            'requisition-approve',
            'requisition-pending-view',
            'requisition-approved-view',
            'my-requisitions',

            // Department Approval
            'department-approve',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',

            // Transport Approval
            'transport-approve',
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',
            'trip-fuel-log',
            'trip-fuel-own',
            'trip-fuel-view',

            // GPS Tracking
            'gps-tracking',
            'gps-tracking-view',

            // Drivers
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-view',
            'driver-export',
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
            'driver-access',
            'driver-list-view',
            'driver-list-department',
            'driver-vehicle',

            // Employees
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

            // Department / Unit
            'department-manage',
            'department-create',
            'department-edit',
            'department-delete',
            'department-head-manage',
            'unit-manage',
            'unit-create',
            'unit-edit',
            'unit-delete',

            // Location
            'location-manage',
            'location-create',
            'location-edit',
            'location-delete',

            // Company
            'company-manage',
            'company-create',
            'company-edit',
            'company-delete',

            // Maintenance
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

            // Reports
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

            // Fuel Management
            'fuel-manage',
            'fuel-log-entry',
            'fuel-history-view',

            // Documents
            'document-manage',
            'document-create',
            'document-edit',
            'document-delete',
            'document-view',
            'document-approve',
            'document-reject',
            'document-history',
            'document-export',
            'my-documents',

            // Support / Helpdesk
            'support-manage',
            'support-create',
            'support-edit',
            'support-view',
            'support-delete',
            'support-emergency',

            // Settings & Notifications
            'settings-notification',
            'settings-manage',
            'settings-language',
            'email-setting',
            'notification-manage',
            'notification-view',

            // Users / Roles
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

            // Menu & Settings
            'menu-manage',
            'menu-create',
            'menu-edit',
            'menu-delete',
            'menu-list',
            'menu-reorder',
            'translation-manage',
            'translation-create',
            'translation-update',
            'translation-auto',

            // Payments
            'payment-approve',
            'payment-view',
            'payment-reject',
            'payment-invoice',

            // Subscription
            'subscription-plan-manage',
            'subscription-plan-create',
            'subscription-plan-edit',
            'subscription-plan-delete',
            'subscription-plan-view',

            // SaaS / Company Management
            'tenant-manage',
            'tenant-activate',
            'tenant-deactivate',
            'tenant-data-export',
            'tenant-statistics-view',
            'tenant-manage',
            'tenant-activate',
            'tenant-deactivate',
            'tenant-data-export',
            'tenant-statistics-view',

            // Billing
            'billing-manage',
            'billing-view',
            'invoice-manage',
            'invoice-view',

            // Usage & Analytics
            'usage-view',
            'analytics-view',
            'report-tenant-usage',
            'report-billing',

            // Maintenance Schedule
            'maintenance-schedule-manage',

            // Driver Availability Own
            'driver-availability-own',

            // Trip Fuel View
            'trip-fuel-view',

            // Department Approval
            'department-approve',
            'transport-approve',
        ];

        $admin?->syncPermissions($adminPermissions);

        // ================= TRANSPORT =================
        $transportPermissions = [

            'dashboard',

            // Requisition View Only
            'requisition-view',
            'requisition-export',
            'requisition-download',

            // Transport Approval Stage
            'transport-approve',
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',
            'transport-approval-reject',

            // Trips / Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',
            'trip-fuel-log',
            'trip-fuel-own',
            'trip-fuel-view',

            // Vehicle & Driver View/Manage
            'vehicle-manage',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-view',
            'vehicle-export',
            'vehicle-type-manage',
            'driver-manage',
            'driver-create',
            'driver-edit',
            'driver-view',
            'driver-export',

            // GPS Tracking
            'gps-tracking',
            'gps-tracking-view',

            // Driver Schedule
            'driver-schedule-manage',
            'driver-schedule-view',
            'driver-schedule-assign',
            'driver-schedule-own',

            // Driver Performance
            'driver-performance-view',
            'driver-performance-report',

            // Driver Availability
            'driver-availability-manage',
            'driver-availability-view',
            'driver-availability-update',
            'driver-availability-own',
            'driver-access',
            'driver-list-view',
            'driver-vehicle',

            // Maintenance
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-edit',
            'maintenance-approval-view',
            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-category-manage',

            // Reports
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-requisition',
            'report-maintenance',
            'report-export',

            // Fuel Management
            'fuel-manage',
            'fuel-log-entry',
            'fuel-history-view',

            // Documents
            'document-manage',
            'document-create',
            'document-view',
            'document-history',

            // Notifications
            'notification-view',
            'notification-manage',

            // Profile
            'profile-view',
            'profile-edit',
            'employee-view-own',
            'employee-edit-own',
        ];

        $transport?->syncPermissions($transportPermissions);

        // ================= EMPLOYEE =================
        $employeePermissions = [

            'dashboard',

            // Requisitions - Create, View, Edit (No Delete)
            'requisition-create',
            'requisition-view',
            'requisition-edit',
            'requisition-pending-view',
            'requisition-approved-view',
            'my-requisitions',

            // Driver - List View Only
            'driver-list-view',

            // Vehicle - List View Only
            'vehicle-list-view',

            // Trip Sheets - Own Trips
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-create',
            'trip-manage',

            // Maintenance - Create and View Own
            'maintenance-create',
            'maintenance-view',

            // Reports - Own Requisitions Only
            'report-requisition-own',
            'report-maintenance-own',

            // Employee - View and Edit Own Profile
            'employee-view-own',
            'employee-edit-own',

            // Documents
            'document-manage',
            'document-create',
            'document-view',
            'document-history',
            'document-export',
            'my-documents',

            // Notifications
            'notification-view',

            // Support / Helpdesk
            'support-create',
            'support-edit',
            'support-view',

            // Profile & Settings
            'profile-view',
            'profile-edit',

            // Trip Sheets
            'trip-sheet-view',

            // GPS Tracking
            'gps-tracking-view',
        ];

        $employee?->syncPermissions($employeePermissions);

        // ================= DEPARTMENT HEAD =================
        $deptHeadPermissions = [
            'dashboard',

            // Requisitions
            'requisition-view',
            'requisition-create',
            'requisition-edit',
            'requisition-export',
            'requisition-download',
            'requisition-pending-view',
            'requisition-approved-view',
            'my-requisitions',

            // Department Approval
            'department-approve',
            'department-approval-view',
            'department-approval-approve',
            'department-approval-reject',
            'requisition-approval-department',

            // Transport Approval
            'transport-approval-view',
            'transport-approval-assign',

            // Trip Sheets
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-manage',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',

            // Employee Management (Department specific)
            'employee-list-department',
            'employee-create-department',
            'employee-edit-department',
            'employee-delete-department',
            'employee-view-own',
            'employee-edit-own',
            'employee-manage',
            'employee-create',
            'employee-edit',
            'employee-export',

            // Department / Unit
            'department-manage',
            'department-create',
            'department-edit',
            'unit-manage',
            'unit-create',
            'unit-edit',

            // Vehicle (View for department)
            'vehicle-list-department',
            'vehicle-view',
            'vehicle-export',

            // Driver (View for department)
            'driver-list-department',
            'driver-view',

            // Maintenance
            'maintenance-view',
            'maintenance-create',
            'maintenance-approval-view',
            'maintenance-approval-department',
            'maintenance-manage',

            // Reports (Department specific)
            'report-requisition-department',
            'report-maintenance-department',
            'report-requisition',
            'report-maintenance',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-export',

            // Profile
            'profile-view',
            'profile-edit',

            // Notifications
            'notification-view',

            // Documents
            'document-manage',
            'document-view',
            'document-history',
            'document-create',
            'my-documents',

            // GPS Tracking
            'gps-tracking-view',

            // Trip Sheets
            'trip-sheet-view',
            'trip-sheet-own',
        ];

        $deptHead?->syncPermissions($deptHeadPermissions);

        // ================= MANAGER =================
        $managerPermissions = [
            // 'dashboard',

            // Requisitions
            'requisition-view',
            'requisition-create',
            'requisition-edit',
            'requisition-export',
            'requisition-download',
            'requisition-pending-view',
            'requisition-approved-view',
            'my-requisitions',

            // Department Approval
            'department-approval-view',
            'department-approval-approve',

            // Transport Approval
            'transport-approval-view',
            'transport-approval-assign',
            'transport-approval-approve',

            // Trip Sheets
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-manage',
            'trip-create',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-export',
            'trip-fuel-log',
            'trip-fuel-own',
            'trip-fuel-view',

            // Driver Performance
            'driver-view',
            'driver-list-view',
            'driver-performance-view',
            'driver-performance-report',
            'driver-schedule-view',
            'driver-schedule-own',
            'driver-availability-view',
            'driver-availability-update',
            'driver-access',
            'driver-vehicle',

            // Maintenance
            'maintenance-view',
            'maintenance-create',
            'maintenance-approval-view',
            'maintenance-manage',
            'maintenance-type-manage',
            'maintenance-vendor-manage',

            // Reports
            'report-requisition',
            'report-requisition-own',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-maintenance',
            'report-maintenance-own',
            'report-export',

            // Fuel Management
            'fuel-manage',
            'fuel-log-entry',
            'fuel-history-view',

            // Employee
            'employee-view-own',
            'employee-edit-own',
            'employee-list-department',

            // Department / Unit
            'department-manage',
            'department-create',
            'department-edit',
            'unit-manage',

            // Profile & Settings
            'profile-view',
            'profile-edit',

            // GPS Tracking
            'gps-tracking',
            'gps-tracking-view',

            // Documents
            'document-manage',
            'document-view',
            'document-history',
            'document-create',
            'my-documents',

            // Notifications
            'notification-view',
        ];

        $manager?->syncPermissions($managerPermissions);

        // ================= DRIVER =================
        $driverPermissions = [
            // 'dashboard',

            // Driver Access - Required for driver personal module menus
            'driver-access',

            // Driver Schedule
            'driver-schedule-view',
            'driver-schedule-own',
            'driver-availability-view',
            'driver-availability-update',

            // Trip Sheets - Own trips only
            // 'trip-sheet-view',
            // 'trip-sheet-own',
            // 'trip-start',
            // 'trip-finish',
            // 'trip-end',

            // Fuel & Expense Logging
            'trip-fuel-log',
            'trip-fuel-own',
            'trip-fuel-view',

            // Driver Documents - View own documents
            'driver-document-view',
            'driver-document-upload',

            // Driver Vehicle - View assigned vehicle
            'driver-vehicle',

            // Driver Performance - View own performance
            'driver-performance-view',

            // Notifications
            'notification-view',

            // GPS Tracking
            'gps-tracking-view',
        ];

        $driver?->syncPermissions($driverPermissions);

        $this->command->info('RolePermissionSeeder completed successfully!');
    }
}
