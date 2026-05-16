<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        DB::table('menus')->truncate();
        Schema::enableForeignKeyConstraints();

        $adminId = 1;
        $now = Carbon::now();

        // Define all permissions used in menus
        $allPermissions = [
            // Dashboard
            'dashboard',

            // Settings
            'settings-manage',
            'settings-notification',
            'settings-language',

            // Roles & Permissions
            'role-manage',

            // Users
            'user-manage',
            'user-create',

            // Menu Management
            'menu-manage',

            // Employees
            'employee-manage',
            'employee-view-own',
            'employee-edit-own',
            'i',
            'employee-create-department',
            'employee-edit-department',
            'employee-delete-department',
            'unit-manage',
            'company-manage',
            'location-manage',
            'department-manage',
            'department-head-manage',
            'license-type-manage',

            // Drivers
            'driver-manage',
            'driver-create',
            'driver-view',
            'driver-export',
            'driver-document-manage',
            'driver-document-upload',
            'driver-document-view',
            'driver-schedule-view',
            'driver-schedule-own',
            'driver-performance-view',
            'driver-access',
            'driver-access',
            'driver-list-view',
            'driver-list-department',
            'driver-vehicle',
            'driver-availability-view',
            'driver-availability-update',
            'driver-availability-manage',

            // Vehicles
            'vehicle-manage',
            'vehicle-create',
            'vehicle-view',
            'vehicle-type-manage',
            'vehicle-list-view',
            'vehicle-list-department',

            // Maintenance
            'maintenance-manage',
            'maintenance-view',
            'maintenance-create',
            'maintenance-type-manage',
            'maintenance-vendor-manage',
            'maintenance-category-manage',
            'maintenance-approval-view',
            'maintenance-approval-department',

            // Requisitions
            'requisition-create',
            'requisition-view',

            // Department Approval
            'department-approval-view',
            'requisition-approval-department',

            // Transport Approval
            'transport-approval-view',

            // Trip Sheets
            'trip-manage',
            'trip-sheet-view',
            'trip-sheet-own',
            'trip-start',
            'trip-finish',
            'trip-end',
            'trip-fuel-log',
            'trip-fuel-own',

            // Profile & Employee
            'profile-view',
            'profile-edit',

            // Payments
            'payment-approve',
            'payment-view',

            // Reports
            'report-requisition',
            'report-requisition-own',
            'report-requisition-department',
            'report-trip-fuel',
            'report-vehicle-utilization',
            'report-driver-performance',
            'report-maintenance',
            'report-maintenance-own',
            'report-maintenance-department',

            // Notifications
            'notification-manage',

            // Email Templates
            'email-template-manage',
            'emaillog-manage',

             // GPS Tracking
             'gps-tracking',
             'gps-tracking-view',

              // Tenant Management
              'tenant-manage',

              // Subscription Plans
              'subscription-plan-manage',

              // Translations
              'translation-manage',
        ];

        // Create permissions if they don't exist
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // Define parent menus first with their structure (ordered as specified)
        $parentMenus = [
            // Dashboard at the top
            [
                'menu_name' => 'Dashboard',
                'menu_slug' => 'menu.dashboard',
                'menu_icon' => 'fa-gauge',
                'menu_url' => 'home',
                'menu_permission' => 'dashboard',
                'menu_order' => 1,
                'menu_parent' => 0,
            ],
            // Management menus
            [
                'menu_name' => 'Settings',
                'menu_slug' => 'menu.settings',
                'menu_icon' => 'fa-cogs',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 2,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'User Manage',
                'menu_slug' => 'User-Manage',
                'menu_icon' => 'fa-user-circle',
                'menu_url' => null,
                'menu_permission' => 'user-manage',
                'menu_order' => 3,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Menu Manage',
                'menu_slug' => 'menu-Manage',
                'menu_icon' => 'fa-sitemap',
                'menu_url' => null,
                'menu_permission' => 'menu-manage',
                'menu_order' => 4,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Roles & Permissions',
                'menu_slug' => 'Role-Permission-Manage',
                'menu_icon' => 'fa-shield-halved',
                'menu_url' => 'admin.roles.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 5,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Company Management',
                'menu_slug' => 'company-management',
                'menu_icon' => 'fa-building',
                'menu_url' => null,
                'menu_permission' => 'company-manage',
                'menu_order' => 6,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Employee Manage',
                'menu_slug' => 'menu.employee',
                'menu_icon' => 'fa-users',
                'menu_url' => null,
                'menu_permission' => 'employee-manage',
                'menu_order' => 7,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'My Profile',
                'menu_slug' => 'my-profile',
                'menu_icon' => 'fa-user',
                'menu_url' => 'user-profile',
                'menu_permission' => 'employee-view-own',
                'menu_order' => 16,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'My Team',
                'menu_slug' => 'my-team',
                'menu_icon' => 'fa-users',
                'menu_url' => 'admin.employees.department.index',
                'menu_permission' => 'employee-list-department',
                'menu_order' => 17,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'My Approvals',
                'menu_slug' => 'my-approvals',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => null,
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 18,
                'menu_parent' => 0,
            ],
            // Core operational menus
            [
                'menu_name' => 'Driver Management',
                'menu_slug' => 'driver-manage',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'drivers.index',
                'menu_permission' => null,
                'menu_order' => 7,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicle Management',
                'menu_slug' => 'vehicle-managemant',
                'menu_icon' => 'fa-truck',
                'menu_url' => null,
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 8,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'GPS Tracking',
                'menu_slug' => 'gps-tracking',
                'menu_icon' => 'fa-map-marker-alt',
                'menu_url' => null,
                'menu_permission' => 'gps-tracking',
                'menu_order' => 8.5,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicle Maintenance',
                'menu_slug' => 'menu.maintenance',
                'menu_icon' => 'fa-wrench',
                'menu_url' => null,
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 9,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Maintenance Requisition',
                'menu_slug' => 'maintenance-requisition',
                'menu_icon' => 'fa-clipboard-list',
                'menu_url' => null,
                'menu_permission' => null,
                'menu_order' => 15,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Vehicle Requisition',
                'menu_slug' => 'vehicle-requisition',
                'menu_icon' => 'fa-file-lines',
                'menu_url' => null,
                'menu_permission' => null,
                'menu_order' => 10,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Approvals',
                'menu_slug' => 'approvals',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => null,
                'menu_permission' => 'department-approval-view',
                'menu_order' => 11,
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Trip Sheets',
                'menu_slug' => 'trip-sheets',
                'menu_icon' => 'fa-road',
                'menu_url' => null,
                'menu_permission' => 'trip-manage',
                'menu_order' => 12,
                'menu_parent' => 0,
            ],
            // Fuel Management
            [
                'menu_name' => 'Fuel Management',
                'menu_slug' => 'fuel-management',
                'menu_icon' => 'fa-gas-pump',
                'menu_url' => null,
                'menu_permission' => null,
                'menu_order' => 13,
                'menu_parent' => 0,
            ],
            // Reports at the bottom
            [
                'menu_name' => 'Reports',
                'menu_slug' => 'menu.reports',
                'menu_icon' => 'fa-chart-simple',
                'menu_url' => null,
                'menu_permission' => 'report-requisition',
                'menu_order' => 14,
                'menu_parent' => 0,
            ],
            // Additional settings menus
            [
                'menu_name' => 'Email & Notification',
                'menu_slug' => 'email-notification',
                'menu_icon' => 'fa-bell',
                'menu_url' => null,
                'menu_permission' => 'settings-notification',
                'menu_order' => 14,
                'menu_parent' => 0,
            ],
             [
                 'menu_name' => 'AI Features',
                 'menu_slug' => 'ai-features',
                 'menu_icon' => 'fa-brain',
                 'menu_url' => null,
                 'menu_permission' => null,
                 'menu_order' => 15,
                 'menu_parent' => 0,
                ],
            [
                'menu_name' => 'Translations',
                'menu_slug' => 'translations-manage',
                'menu_icon' => 'fa-language',
                'menu_url' => null,
                'menu_permission' => 'translation-manage',
                'menu_order' => 16,
                'menu_parent' => 0,
            ],
        ];

        // Insert parent menus and create parent ID map
        $parentIdMap = [];
        foreach ($parentMenus as $menu) {
            $id = DB::table('menus')->insertGetId([
                'menu_name' => $menu['menu_name'],
                'menu_slug' => $menu['menu_slug'],
                'menu_icon' => $menu['menu_icon'],
                'menu_url' => $menu['menu_url'],
                'menu_permission' => $menu['menu_permission'],
                'menu_order' => $menu['menu_order'],
                'menu_parent' => $menu['menu_parent'],
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $parentIdMap[$menu['menu_name']] = $id;
        }

        // Now insert child menus with correct parent IDs
        $childMenus = [
            // Settings children
            [
                'menu_name' => 'General Settings',
                'menu_slug' => 'general-settings',
                'menu_icon' => 'fa-sliders-h',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 1,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Language Settings',
                'menu_slug' => 'language-settings',
                'menu_icon' => 'fa-language',
                'menu_url' => 'settings.language',
                'menu_permission' => 'settings-language',
                'menu_order' => 2,
                'parent_name' => 'Settings',
            ],

            // Roles & Permissions children
            [
                'menu_name' => 'All Roles',
                'menu_slug' => 'all-roles',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.roles.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 1,
                'parent_name' => 'Roles & Permissions',
            ],
            [
                'menu_name' => 'Create Role',
                'menu_slug' => 'create-role',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.roles.create',
                'menu_permission' => 'role-manage',
                'menu_order' => 2,
                'parent_name' => 'Roles & Permissions',
            ],
            [
                'menu_name' => 'All Permissions',
                'menu_slug' => 'all-permissions',
                'menu_icon' => 'fa-key',
                'menu_url' => 'admin.permissions.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 3,
                'parent_name' => 'Roles & Permissions',
            ],

            // My Profile children
            [
                'menu_name' => 'Profile Information',
                'menu_slug' => 'profile-info',
                'menu_icon' => 'fa-user-circle',
                'menu_url' => 'profile.show',
                'menu_permission' => 'profile-view',
                'menu_order' => 1,
                'parent_name' => 'My Profile',
            ],
            [
                'menu_name' => 'Edit Profile',
                'menu_slug' => 'edit-profile',
                'menu_icon' => 'fa-edit',
                'menu_url' => 'profile.edit',
                'menu_permission' => 'profile-edit',
                'menu_order' => 2,
                'parent_name' => 'My Profile',
            ],
            [
                'menu_name' => 'Change Password',
                'menu_slug' => 'change-password',
                'menu_icon' => 'fa-lock',
                'menu_url' => 'password.change',
                'menu_permission' => 'profile-edit',
                'menu_order' => 3,
                'parent_name' => 'My Profile',
            ],

            // My Team children
            [
                'menu_name' => 'Team Members',
                'menu_slug' => 'team-members',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.employees.department.index',
                'menu_permission' => 'employee-list-department',
                'menu_order' => 1,
                'parent_name' => 'My Team',
            ],
            [
                'menu_name' => 'Team Statistics',
                'menu_slug' => 'team-statistics',
                'menu_icon' => 'fa-chart-pie',
                'menu_url' => 'admin.team.statistics',
                'menu_permission' => 'employee-list-department',
                'menu_order' => 2,
                'parent_name' => 'My Team',
            ],

            // Company Management children
            [
                'menu_name' => 'All Companies',
                'menu_slug' => 'all-companies',
                'menu_icon' => 'fa-list',
                'menu_url' => 'company.index',
                'menu_permission' => 'company-manage',
                'menu_order' => 1,
                'parent_name' => 'Company Management',
            ],
            [
                'menu_name' => 'Add Company',
                'menu_slug' => 'add-company',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'company.create',
                'menu_permission' => 'company-manage',
                'menu_order' => 2,
                'parent_name' => 'Company Management',
            ],
            [
                'menu_name' => 'Subscription Plans',
                'menu_slug' => 'subscription-plans',
                'menu_icon' => 'fa-credit-card',
                'menu_url' => 'admin.dashboard.plans.index',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 3,
                'parent_name' => 'Company Management',
            ],

            // Driver Management children
            [
                'menu_name' => 'Driver List',
                'menu_slug' => 'driver-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'drivers.index',
                'menu_permission' => 'driver-manage',
                'menu_order' => 1,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Driver List (View Only)',
                'menu_slug' => 'driver-list-view',
                'menu_icon' => 'fa-users',
                'menu_url' => 'drivers.index',
                'menu_permission' => 'driver-list-view',
                'menu_order' => 13,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Add Driver',
                'menu_slug' => 'add-driver',
                'menu_icon' => 'fa-circle-plus',
                'menu_url' => 'drivers.create',
                'menu_permission' => 'driver-create',
                'menu_order' => 2,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Driver Documents',
                'menu_slug' => 'driver-documents',
                'menu_icon' => 'fa-file',
                'menu_url' => 'driver-documents.index',
                'menu_permission' => 'driver-document-manage',
                'menu_order' => 3,
                'parent_name' => 'Driver Management',
            ],

            [
                'menu_name' => 'Driver Performance',
                'menu_slug' => 'driver-performance',
                'menu_icon' => 'fa-chart-simple',
                'menu_url' => 'driver_performance',
                'menu_permission' => 'driver-performance-view',
                'menu_order' => 4,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'License Type',
                'menu_slug' => 'license-type-manage',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'license-types.index',
                'menu_permission' => 'license-type-manage',
                'menu_order' => 5,
                'parent_name' => 'Driver Management',
            ],

            // Driver Personal Module (for drivers accessing their own data)
            [
                'menu_name' => 'My Dashboard',
                'menu_slug' => 'driver-dashboard',
                'menu_icon' => 'fa-tachometer-alt',
                'menu_url' => 'driver.dashboard',
                'menu_permission' => 'driver-access',
                'menu_order' => 6,
                'parent_name' => 'Driver Management',
            ],

            [
                'menu_name' => 'My Schedule',
                'menu_slug' => 'driver-schedule',
                'menu_icon' => 'fa-calendar',
                'menu_url' => 'driver.schedule',
                'menu_permission' => 'driver-access',
                'menu_order' => 7,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Trips',
                'menu_slug' => 'driver-trips',
                'menu_icon' => 'fa-road',
                'menu_url' => 'driver.trips',
                'menu_permission' => 'driver-access',
                'menu_order' => 8,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'Trip Status',
                'menu_slug' => 'driver-trip-status',
                'menu_icon' => 'fa-exchange-alt',
                'menu_url' => 'driver.trip.status',
                'menu_permission' => 'driver-access',
                'menu_order' => 9,
                'parent_name' => 'Driver Management',
            ],

            [
                'menu_name' => 'My Availability',
                'menu_slug' => 'driver-availability',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'driver.availability',
                'menu_permission' => 'driver-access',
                'menu_order' => 11,
                'parent_name' => 'Driver Management',
            ],
            [
                'menu_name' => 'My Vehicle',
                'menu_slug' => 'driver-vehicle',
                'menu_icon' => 'fa-truck',
                'menu_url' => 'driver.vehicle',
                'menu_permission' => 'driver-access',
                'menu_order' => 12,
                'parent_name' => 'Driver Management',
            ],

            // Vehicle Management children
            [
                'menu_name' => 'Vehicle List',
                'menu_slug' => 'vehicle-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vehicles.index',
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vehicle List (View Only)',
                'menu_slug' => 'vehicle-list-view',
                'menu_icon' => 'fa-car',
                'menu_url' => 'vehicles.index',
                'menu_permission' => 'vehicle-list-view',
                'menu_order' => 7,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vehicle',
                'menu_slug' => 'add-vehicle',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vehicles.create',
                'menu_permission' => 'vehicle-create',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vendor List',
                'menu_slug' => 'vendor-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 3,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vendor',
                'menu_slug' => 'add-vendor',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vendors.create',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 4,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Vehicle Type List',
                'menu_slug' => 'vehicle-type-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'vehicle-type.index',
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 5,
                'parent_name' => 'Vehicle Management',
            ],
            [
                'menu_name' => 'Add Vehicle Type',
                'menu_slug' => 'add-vehicle-type',
                'menu_icon' => 'fa-plus',
                'menu_url' => 'vehicle-type.create',
                'menu_permission' => 'vehicle-manage',
                'menu_order' => 6,
                'parent_name' => 'Vehicle Management',
            ],

            // GPS Tracking children
            [
                'menu_name' => 'Live Tracking',
                'menu_slug' => 'gps-tracking-live',
                'menu_icon' => 'fa-satellite-dish',
                'menu_url' => 'admin.gps-tracking.index',
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 1,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Vehicle Tracking',
                'menu_slug' => 'gps-tracking-vehicle',
                'menu_icon' => 'fa-car',
                'menu_url' => 'admin.gps-tracking.vehicle',
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 2,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Trip Tracking',
                'menu_slug' => 'gps-tracking-trip',
                'menu_icon' => 'fa-route',
                'menu_url' => 'admin.gps-tracking.trip',
                'menu_permission' => 'gps-tracking-view',
                'menu_order' => 3,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Device Management',
                'menu_slug' => 'gps-devices',
                'menu_icon' => 'fa-microchip',
                'menu_url' => 'admin.gps-devices.index',
                'menu_permission' => 'gps-tracking',
                'menu_order' => 4,
                'parent_name' => 'GPS Tracking',
            ],
            [
                'menu_name' => 'Add Device',
                'menu_slug' => 'gps-device-create',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.gps-devices.create',
                'menu_permission' => 'gps-tracking',
                'menu_order' => 5,
                'parent_name' => 'GPS Tracking',
            ],

            // Vehicle Maintenance children
            [
                'menu_name' => 'Maintenance Requests',
                'menu_slug' => 'maintenance-requests',
                'menu_icon' => 'fa-inbox',
                'menu_url' => 'maintenance.index',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Type',
                'menu_slug' => 'menu.maintenance-type',
                'menu_icon' => 'fa-tag',
                'menu_url' => 'maintenance-types.index',
                'menu_permission' => 'maintenance-type-manage',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Vendor',
                'menu_slug' => 'menu.maintenance-vendor',
                'menu_icon' => 'fa-building',
                'menu_url' => 'maintenance-vendors.index',
                'menu_permission' => 'maintenance-vendor-manage',
                'menu_order' => 3,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance Category',
                'menu_slug' => 'menu.maintenance-category',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'maintenance-categories.index',
                'menu_permission' => 'maintenance-category-manage',
                'menu_order' => 4,
                'parent_name' => 'Vehicle Maintenance',
            ],
            [
                'menu_name' => 'Maintenance History',
                'menu_slug' => 'maintenance-history',
                'menu_icon' => 'fa-clock-rotate-left',
                'menu_url' => 'admin-maintenance.history',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 5,
                'parent_name' => 'Vehicle Maintenance',
            ],

            // User Manage children
            [
                'menu_name' => 'User List',
                'menu_slug' => 'user-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'users.index',
                'menu_permission' => 'user-manage',
                'menu_order' => 1,
                'parent_name' => 'User Manage',
            ],
            [
                'menu_name' => 'Add User',
                'menu_slug' => 'add-user',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'users.create',
                'menu_permission' => 'user-create',
                'menu_order' => 2,
                'parent_name' => 'User Manage',
            ],

            // Menu Manage children
            [
                'menu_name' => 'All Menus',
                'menu_slug' => 'all-menus',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.menus.index',
                'menu_permission' => 'menu-manage',
                'menu_order' => 1,
                'parent_name' => 'Menu Manage',
            ],
            [
                'menu_name' => 'Add Menu',
                'menu_slug' => 'add-menu',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.menus.create',
                'menu_permission' => 'menu-manage',
                'menu_order' => 2,
                'parent_name' => 'Menu Manage',
            ],

            // Employee Manage children
            [
                'menu_name' => 'All Employees',
                'menu_slug' => 'all-employees',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.employees.index',
                'menu_permission' => 'employee-manage',
                'menu_order' => 1,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Add Employee',
                'menu_slug' => 'add-employee',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.employees.create',
                'menu_permission' => 'employee-manage',
                'menu_order' => 2,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Departments',
                'menu_slug' => 'departments',
                'menu_icon' => 'fa-sitemap',
                'menu_url' => 'departments.index',
                'menu_permission' => 'department-manage',
                'menu_order' => 3,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Designations',
                'menu_slug' => 'designations',
                'menu_icon' => 'fa-briefcase',
                'menu_url' => 'designations.index',
                'menu_permission' => 'department-manage',
                'menu_order' => 4,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Employee Profiles',
                'menu_slug' => 'employee-profiles',
                'menu_icon' => 'fa-id-badge',
                'menu_url' => 'admin.employees.profiles',
                'menu_permission' => 'employee-manage',
                'menu_order' => 5,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Employee Approvals',
                'menu_slug' => 'employee-approvals',
                'menu_icon' => 'fa-check-double',
                'menu_url' => 'admin.employees.approvals',
                'menu_permission' => 'employee-manage',
                'menu_order' => 6,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Units',
                'menu_slug' => 'units-manage',
                'menu_icon' => 'fa-layer-group',
                'menu_url' => 'admin.units.index',
                'menu_permission' => 'unit-manage',
                'menu_order' => 7,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Locations',
                'menu_slug' => 'locations-manage',
                'menu_icon' => 'fa-map-pin',
                'menu_url' => 'admin.locations.index',
                'menu_permission' => 'location-manage',
                'menu_order' => 8,
                'parent_name' => 'Employee Manage',
            ],
            [
                'menu_name' => 'Department Heads',
                'menu_slug' => 'department-heads-manage',
                'menu_icon' => 'fa-crown',
                'menu_url' => 'admin.department-heads.index',
                'menu_permission' => 'department-head-manage',
                'menu_order' => 9,
                'parent_name' => 'Employee Manage',
            ],

            // My Approvals children
            [
                'menu_name' => 'Pending Approvals',
                'menu_slug' => 'pending-approvals',
                'menu_icon' => 'fa-inbox',
                'menu_url' => 'admin.approvals.pending',
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 1,
                'parent_name' => 'My Approvals',
            ],
            [
                'menu_name' => 'Approved',
                'menu_slug' => 'approved-requisitions',
                'menu_icon' => 'fa-check',
                'menu_url' => 'admin.approvals.approved',
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 2,
                'parent_name' => 'My Approvals',
            ],
            [
                'menu_name' => 'Rejected',
                'menu_slug' => 'rejected-requisitions',
                'menu_icon' => 'fa-times',
                'menu_url' => 'admin.approvals.rejected',
                'menu_permission' => 'requisition-approval-department',
                'menu_order' => 3,
                'parent_name' => 'My Approvals',
            ],

            // Vehicle Requisition children
            [
                'menu_name' => 'Requisition List',
                'menu_slug' => 'vehicle-req-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'requisitions.index',
                'menu_permission' => 'requisition-view',
                'menu_order' => 1,
                'parent_name' => 'Vehicle Requisition',
            ],
            [
                'menu_name' => 'New Requisition',
                'menu_slug' => 'new-req',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'requisitions.create',
                'menu_permission' => 'requisition-create',
                'menu_order' => 2,
                'parent_name' => 'Vehicle Requisition',
            ],

            // Approvals children (Department)
            [
                'menu_name' => 'Pending Requisitions',
                'menu_slug' => 'pending-requisitions',
                'menu_icon' => 'fa-inbox',
                'menu_url' => 'admin.requisition-approvals.pending',
                'menu_permission' => 'department-approval-view',
                'menu_order' => 1,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Transport Approvals',
                'menu_slug' => 'transport-approvals',
                'menu_icon' => 'fa-check',
                'menu_url' => 'admin.transport-approvals.index',
                'menu_permission' => 'transport-approval-view',
                'menu_order' => 2,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Approvals',
                'menu_slug' => 'maintenance-approvals',
                'menu_icon' => 'fa-tools',
                'menu_url' => 'maintenance_approvals.index',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 3,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Maintenance Transport Approvals',
                'menu_slug' => 'maintenance-transport-approvals',
                'menu_icon' => 'fa-gears',
                'menu_url' => 'maintenance_transport_approvals.index',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 4,
                'parent_name' => 'Approvals',
            ],
            [
                'menu_name' => 'Approved Maintenance',
                'menu_slug' => 'approved-maintenance',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => 'maintenance_approvals.approved',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 5,
                'parent_name' => 'Approvals',
            ],

            // Trip Sheets children
            [
                'menu_name' => 'All Trip Sheets',
                'menu_slug' => 'all-trips',
                'menu_icon' => 'fa-list',
                'menu_url' => 'trip-sheets.index',
                'menu_permission' => 'trip-manage',
                'menu_order' => 1,
                'parent_name' => 'Trip Sheets',
            ],
            [
                'menu_name' => 'Create Trip',
                'menu_slug' => 'create-trip',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'trip-sheets.create',
                'menu_permission' => 'trip-manage',
                'menu_order' => 2,
                'parent_name' => 'Trip Sheets',
            ],

            // Fuel Management children
            [
                'menu_name' => 'Fuel Logs',
                'menu_slug' => 'fuel-logs',
                'menu_icon' => 'fa-list',
                'menu_url' => 'driver.fuel.log',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 1,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel Purchase Log',
                'menu_slug' => 'fuel-purchase-log',
                'menu_icon' => 'fa-shopping-cart',
                'menu_url' => 'driver.fuel.purchase.log',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 2,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel History',
                'menu_slug' => 'fuel-history',
                'menu_icon' => 'fa-history',
                'menu_url' => 'driver.fuel.history',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 3,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel Monthly Summary',
                'menu_slug' => 'fuel-monthly-summary',
                'menu_icon' => 'fa-calendar',
                'menu_url' => 'driver.fuel.monthly.summary',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 4,
                'parent_name' => 'Fuel Management',
            ],
            [
                'menu_name' => 'Fuel Efficiency',
                'menu_slug' => 'fuel-efficiency',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'driver.fuel.efficiency',
                'menu_permission' => 'trip-fuel-log',
                'menu_order' => 5,
                'parent_name' => 'Fuel Management',
            ],

            // Maintenance Requisition children
            [
                'menu_name' => 'Maintenance Req List',
                'menu_slug' => 'maintenance-req-list',
                'menu_icon' => 'fa-list',
                'menu_url' => 'maintenance.index',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 1,
                'parent_name' => 'Maintenance Requisition',
            ],
            [
                'menu_name' => 'New Maintenance Req',
                'menu_slug' => 'new-maintenance-req',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.maintenance-requisitions.create',
                'menu_permission' => 'maintenance-manage',
                'menu_order' => 2,
                'parent_name' => 'Maintenance Requisition',
            ],

            // Reports children
            [
                'menu_name' => 'Requisition Report',
                'menu_slug' => 'reports-dashboard',
                'menu_icon' => 'fa-dashboard',
                'menu_url' => 'reports.requisitions',
                'menu_permission' => 'report-requisition',
                'menu_order' => 0,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Requisition Report',
                'menu_slug' => 'report-requisition',
                'menu_icon' => 'fa-chart-bar',
                'menu_url' => 'reports.vehicle-requisitions',
                'menu_permission' => 'report-requisition',
                'menu_order' => 1,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Trip & Fuel Report',
                'menu_slug' => 'report-trip-fuel',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'reports.trips_fuel',
                'menu_permission' => 'report-trip-fuel',
                'menu_order' => 2,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Vehicle Utilization',
                'menu_slug' => 'report-vehicle-util',
                'menu_icon' => 'fa-car',
                'menu_url' => 'reports.vehicle_utilization',
                'menu_permission' => 'report-vehicle-utilization',
                'menu_order' => 3,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Driver Performance',
                'menu_slug' => 'report-driver-perf',
                'menu_icon' => 'fa-id-card',
                'menu_url' => 'reports.driver_performance',
                'menu_permission' => 'report-driver-performance',
                'menu_order' => 4,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Maintenance Report',
                'menu_slug' => 'report-maintenance',
                'menu_icon' => 'fa-tools',
                'menu_url' => 'reports.maintenance',
                'menu_permission' => 'report-maintenance',
                'menu_order' => 5,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Custom Reports',
                'menu_slug' => 'custom-reports',
                'menu_icon' => 'fa-file-export',
                'menu_url' => 'reports.custom',
                'menu_permission' => 'report-requisition',
                'menu_order' => 6,
                'parent_name' => 'Reports',
            ],

            // Email & Notification children
            [
                'menu_name' => 'Email Templates',
                'menu_slug' => 'email-templates',
                'menu_icon' => 'fa-envelope',
                'menu_url' => 'email-templates.index',
                'menu_permission' => 'email-template-manage',
                'menu_order' => 1,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Email Logs',
                'menu_slug' => 'email-logs',
                'menu_icon' => 'fa-history',
                'menu_url' => 'emaillogs.index',
                'menu_permission' => 'emaillog-manage',
                'menu_order' => 2,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Notification Settings',
                'menu_slug' => 'notification-settings',
                'menu_icon' => 'fa-bell',
                'menu_url' => 'settings.notifications',
                'menu_permission' => 'settings-notification',
                'menu_order' => 3,
                'parent_name' => 'Email & Notification',
            ],
            [
                'menu_name' => 'Push Subscribers',
                'menu_slug' => 'push-subscribers',
                'menu_icon' => 'fa-bell',
                'menu_url' => 'admin.push.subscribers',
                'menu_permission' => 'settings-notification',
                'menu_order' => 4,
                'parent_name' => 'Email & Notification',
            ],

            // AI Features children
            [
                'menu_name' => 'AI Maintenance Alerts',
                'menu_slug' => 'ai-maintenance-alerts',
                'menu_icon' => 'fa-lightbulb',
                'menu_url' => 'ai-maintenance-alerts.index',
                'menu_permission' => null,
                'menu_order' => 1,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'Generate New Alert',
                'menu_slug' => 'generate-ai-alert',
                'menu_icon' => 'fa-magic',
                'menu_url' => 'ai-maintenance-alerts.generate',
                'menu_permission' => null,
                'menu_order' => 2,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'AI Reports',
                'menu_slug' => 'ai-reports',
                'menu_icon' => 'fa-robot',
                'menu_url' => 'ai-reports.index',
                'menu_permission' => null,
                'menu_order' => 3,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'Create Report',
                'menu_slug' => 'create-ai-report',
                'menu_icon' => 'fa-file-excel',
                'menu_url' => 'ai-reports.create',
                'menu_permission' => null,
                'menu_order' => 4,
                'parent_name' => 'AI Features',
            ],
            [
                'menu_name' => 'Reports Dashboard',
                'menu_slug' => 'ai-reports-dashboard',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'ai-reports.dashboard',
                'menu_permission' => null,
                'menu_order' => 5,
                'parent_name' => 'AI Features',
            ],

            // Translations children
            [
                'menu_name' => 'Manage Translations',
                'menu_slug' => 'manage-translations',
                'menu_icon' => 'fa-edit',
                'menu_url' => 'admin.translations',
                'menu_permission' => 'translation-manage',
                'menu_order' => 1,
                'parent_name' => 'Translations',
            ],
            [
                'menu_name' => 'Languages',
                'menu_slug' => 'manage-languages',
                'menu_icon' => 'fa-globe',
                'menu_url' => 'admin.languages.index',
                'menu_permission' => 'translation-manage',
                'menu_order' => 2,
                'parent_name' => 'Translations',
            ],
        ];

        // Insert child menus with correct parent_id and sequential ordering
        $childOrderCounters = [];

        foreach ($childMenus as $child) {
            $parentName = $child['parent_name'];
            
            // Initialize counter for this parent if not exists
            if (!isset($childOrderCounters[$parentName])) {
                $childOrderCounters[$parentName] = 1;
            }
            
            $parentId = $parentIdMap[$parentName] ?? 0;
            DB::table('menus')->insert([
                'menu_name' => $child['menu_name'],
                'menu_slug' => $child['menu_slug'],
                'menu_icon' => $child['menu_icon'],
                'menu_url' => $child['menu_url'],
                'menu_permission' => $child['menu_permission'],
                'menu_order' => $childOrderCounters[$parentName]++,
                'menu_parent' => $parentId,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Menu seeder completed successfully!');
        $this->command->info('Total parent menus: ' . count($parentMenus));
        $this->command->info('Total child menus: ' . count($childMenus));
    }
}
