<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

        // Define permissions for Next Digi Home digital marketplace
        $allPermissions = [
            // Core System
            'dashboard',
            'settings-manage',
            'settings-notification',
            'settings-language',
            'email-setting',

            // User Management
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

            // Products & Content
            'product-manage',
            'product-create',
            'product-edit',
            'product-delete',
            'product-view',
            'product-publish',
            'product-category-manage',
            'product-category-create',
            'product-category-edit',
            'product-category-delete',
            'content-manage',
            'content-create',
            'content-edit',
            'content-delete',

            // Orders & Sales
            'order-manage',
            'order-view',
            'order-create',
            'order-edit',
            'order-fulfill',
            'order-cancel',
            'order-refund',
            'sales-report',
            'order-export',

            // Customers
            'customer-manage',
            'customer-view',
            'customer-create',
            'customer-edit',
            'customer-delete',
            'customer-support',
            'customer-communication',

            // Analytics & Reports
            'analytics-view',
            'analytics-dashboard',
            'report-sales',
            'report-products',
            'report-customers',
            'report-export',

            // Marketing
            'marketing-manage',
            'marketing-campaign',
            'marketing-email',
            'marketing-promotion',
            'seo-manage',

            // Subscription & Billing
            'subscription-plan-manage',
            'subscription-plan-create',
            'subscription-plan-edit',
            'subscription-plan-delete',
            'subscription-plan-view',
            'billing-manage',
            'billing-view',
            'payment-view',
            'payment-approve',
            'payment-refund',
            'invoice-manage',
            'invoice-view',

            // Support & Helpdesk
            'support-manage',
            'support-create',
            'support-edit',
            'support-view',
            'support-delete',
            'support-ticket',
            'support-response',

            // Profile & Self-service
            'profile-view',
            'profile-edit',
            'my-orders',
            'my-products',
            'my-support',

            // System Administration
            'system-configure',
            'system-maintenance',
            'system-backup',
            'system-logs',

            // Translations & Localization
            'translation-manage',
            'translation-create',
            'translation-update',
            'translation-auto',
        ];

        // Create permissions if they don't exist
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        // Define parent menus for Next Digi Home (Digital Products Marketplace)
        $parentMenus = [
            // 1. Dashboard
            [
                'menu_name' => 'Dashboard',
                'menu_slug' => 'dashboard',
                'menu_icon' => 'fa-gauge',
                'menu_url' => 'home',
                'menu_permission' => 'dashboard',
                'menu_order' => 1,
                'menu_parent' => 0,
            ],

            // 2. Products
            [
                'menu_name' => 'Products',
                'menu_slug' => 'products',
                'menu_icon' => 'fa-box',
                'menu_url' => null,
                'menu_permission' => 'product-manage',
                'menu_order' => 2,
                'menu_parent' => 0,
            ],

            // 3. Orders
            [
                'menu_name' => 'Orders',
                'menu_slug' => 'orders',
                'menu_icon' => 'fa-shopping-cart',
                'menu_url' => null,
                'menu_permission' => 'order-manage',
                'menu_order' => 3,
                'menu_parent' => 0,
            ],

            // 4. Customers
            [
                'menu_name' => 'Customers',
                'menu_slug' => 'customers',
                'menu_icon' => 'fa-users',
                'menu_url' => null,
                'menu_permission' => 'customer-manage',
                'menu_order' => 4,
                'menu_parent' => 0,
            ],

            // 5. Subscriptions
            [
                'menu_name' => 'Subscriptions',
                'menu_slug' => 'subscriptions',
                'menu_icon' => 'fa-crown',
                'menu_url' => null,
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 5,
                'menu_parent' => 0,
            ],

            // 6. Content Management
            [
                'menu_name' => 'Content',
                'menu_slug' => 'content',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => null,
                'menu_permission' => 'content-manage',
                'menu_order' => 6,
                'menu_parent' => 0,
            ],

            // 7. Reports & Analytics
            [
                'menu_name' => 'Reports',
                'menu_slug' => 'reports',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'admin.reports.index',
                'menu_permission' => 'analytics-view',
                'menu_order' => 7,
                'menu_parent' => 0,
            ],

            // 8. Marketing
            [
                'menu_name' => 'Marketing',
                'menu_slug' => 'marketing',
                'menu_icon' => 'fa-bullhorn',
                'menu_url' => null,
                'menu_permission' => 'marketing-manage',
                'menu_order' => 8,
                'menu_parent' => 0,
            ],

            // 9. Support
            [
                'menu_name' => 'Support',
                'menu_slug' => 'support',
                'menu_icon' => 'fa-headset',
                'menu_url' => null,
                'menu_permission' => 'support-manage',
                'menu_order' => 9,
                'menu_parent' => 0,
            ],

            // 10. User Management
            [
                'menu_name' => 'Users',
                'menu_slug' => 'user-management',
                'menu_icon' => 'fa-user-circle',
                'menu_url' => null,
                'menu_permission' => 'user-manage',
                'menu_order' => 10,
                'menu_parent' => 0,
            ],

            // 11. System
            [
                'menu_name' => 'System',
                'menu_slug' => 'system',
                'menu_icon' => 'fa-server',
                'menu_url' => null,
                'menu_permission' => 'system-configure',
                'menu_order' => 11,
                'menu_parent' => 0,
            ],

            // 12. Settings
            [
                'menu_name' => 'Settings',
                'menu_slug' => 'settings',
                'menu_icon' => 'fa-cogs',
                'menu_url' => 'admin.settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 12,
                'menu_parent' => 0,
            ],

            // 13. My Profile
            [
                'menu_name' => 'My Profile',
                'menu_slug' => 'my-profile',
                'menu_icon' => 'fa-user',
                'menu_url' => 'admin.profile.edit',
                'menu_permission' => 'profile-view',
                'menu_order' => 13,
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
            // ===== Products Children =====
            [
                'menu_name' => 'All Products',
                'menu_slug' => 'products-all',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.products.index',
                'menu_permission' => 'product-view',
                'menu_order' => 1,
                'parent_name' => 'Products',
            ],
            [
                'menu_name' => 'Add Product',
                'menu_slug' => 'products-add',
                'menu_icon' => 'fa-plus-circle',
                'menu_url' => 'admin.products.create',
                'menu_permission' => 'product-create',
                'menu_order' => 2,
                'parent_name' => 'Products',
            ],
            [
                'menu_name' => 'Categories',
                'menu_slug' => 'products-categories',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'admin.categories.index',
                'menu_permission' => 'product-category-manage',
                'menu_order' => 3,
                'parent_name' => 'Products',
            ],
            [
                'menu_name' => 'Digital Downloads',
                'menu_slug' => 'products-downloads',
                'menu_icon' => 'fa-download',
                'menu_url' => 'admin.products.downloads',
                'menu_permission' => 'product-manage',
                'menu_order' => 4,
                'parent_name' => 'Products',
            ],
            [
                'menu_name' => 'Product Reviews',
                'menu_slug' => 'products-reviews',
                'menu_icon' => 'fa-star',
                'menu_url' => 'admin.products.reviews',
                'menu_permission' => 'product-manage',
                'menu_order' => 5,
                'parent_name' => 'Products',
            ],

            // ===== Orders Children =====
            [
                'menu_name' => 'All Orders',
                'menu_slug' => 'orders-all',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.orders.index',
                'menu_permission' => 'order-view',
                'menu_order' => 1,
                'parent_name' => 'Orders',
            ],
            [
                'menu_name' => 'Pending Orders',
                'menu_slug' => 'orders-pending',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'admin.orders.pending',
                'menu_permission' => 'order-manage',
                'menu_order' => 2,
                'parent_name' => 'Orders',
            ],
            [
                'menu_name' => 'Processing',
                'menu_slug' => 'orders-processing',
                'menu_icon' => 'fa-cog',
                'menu_url' => 'admin.orders.processing',
                'menu_permission' => 'order-fulfill',
                'menu_order' => 3,
                'parent_name' => 'Orders',
            ],
            [
                'menu_name' => 'Shipped',
                'menu_slug' => 'orders-shipped',
                'menu_icon' => 'fa-truck',
                'menu_url' => 'admin.orders.shipped',
                'menu_permission' => 'order-manage',
                'menu_order' => 4,
                'parent_name' => 'Orders',
            ],
            [
                'menu_name' => 'Delivered',
                'menu_slug' => 'orders-delivered',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => 'admin.orders.delivered',
                'menu_permission' => 'order-manage',
                'menu_order' => 5,
                'parent_name' => 'Orders',
            ],
            [
                'menu_name' => 'Refunds',
                'menu_slug' => 'orders-refunds',
                'menu_icon' => 'fa-undo',
                'menu_url' => 'admin.orders.refunds',
                'menu_permission' => 'order-refund',
                'menu_order' => 6,
                'parent_name' => 'Orders',
            ],
            [
                'menu_name' => 'Order Exports',
                'menu_slug' => 'orders-exports',
                'menu_icon' => 'fa-file-export',
                'menu_url' => 'admin.orders.exports',
                'menu_permission' => 'order-export',
                'menu_order' => 7,
                'parent_name' => 'Orders',
            ],

            // ===== Customers Children =====
            [
                'menu_name' => 'All Customers',
                'menu_slug' => 'customers-all',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.customers.index',
                'menu_permission' => 'customer-view',
                'menu_order' => 1,
                'parent_name' => 'Customers',
            ],
            [
                'menu_name' => 'Add Customer',
                'menu_slug' => 'customers-add',
                'menu_icon' => 'fa-user-plus',
                'menu_url' => 'admin.customers.create',
                'menu_permission' => 'customer-create',
                'menu_order' => 2,
                'parent_name' => 'Customers',
            ],
            [
                'menu_name' => 'Customer Groups',
                'menu_slug' => 'customers-groups',
                'menu_icon' => 'fa-users-cog',
                'menu_url' => 'admin.customer-groups.index',
                'menu_permission' => 'customer-manage',
                'menu_order' => 3,
                'parent_name' => 'Customers',
            ],
            [
                'menu_name' => 'Support Tickets',
                'menu_slug' => 'customers-support',
                'menu_icon' => 'fa-headset',
                'menu_url' => 'admin.support.tickets',
                'menu_permission' => 'customer-support',
                'menu_order' => 4,
                'parent_name' => 'Customers',
            ],
            [
                'menu_name' => 'Customer Reviews',
                'menu_slug' => 'customers-reviews',
                'menu_icon' => 'fa-star',
                'menu_url' => 'admin.customers.reviews',
                'menu_permission' => 'customer-view',
                'menu_order' => 5,
                'parent_name' => 'Customers',
            ],

            // ===== Subscriptions Children =====
            [
                'menu_name' => 'Subscription Plans',
                'menu_slug' => 'subscriptions-plans',
                'menu_icon' => 'fa-crown',
                'menu_url' => 'admin.subscription-plans.index',
                'menu_permission' => 'subscription-plan-view',
                'menu_order' => 1,
                'parent_name' => 'Subscriptions',
            ],
            [
                'menu_name' => 'Active Subscriptions',
                'menu_slug' => 'subscriptions-active',
                'menu_icon' => 'fa-check-circle',
                'menu_url' => 'admin.subscriptions.active',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 2,
                'parent_name' => 'Subscriptions',
            ],
            [
                'menu_name' => 'Expired Subscriptions',
                'menu_slug' => 'subscriptions-expired',
                'menu_icon' => 'fa-times-circle',
                'menu_url' => 'admin.subscriptions.expired',
                'menu_permission' => 'subscription-plan-manage',
                'menu_order' => 3,
                'parent_name' => 'Subscriptions',
            ],
            [
                'menu_name' => 'Billing History',
                'menu_slug' => 'subscriptions-billing',
                'menu_icon' => 'fa-credit-card',
                'menu_url' => 'admin.subscriptions.billing',
                'menu_permission' => 'billing-view',
                'menu_order' => 4,
                'parent_name' => 'Subscriptions',
            ],

            // ===== Content Children =====
            [
                'menu_name' => 'Pages',
                'menu_slug' => 'content-pages',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => 'admin.pages.index',
                'menu_permission' => 'content-manage',
                'menu_order' => 1,
                'parent_name' => 'Content',
            ],
            [
                'menu_name' => 'Hero Sliders',
                'menu_slug' => 'content-hero',
                'menu_icon' => 'fa-images',
                'menu_url' => 'admin.hero-sliders.index',
                'menu_permission' => 'content-manage',
                'menu_order' => 2,
                'parent_name' => 'Content',
            ],
            [
                'menu_name' => 'Testimonials',
                'menu_slug' => 'content-testimonials',
                'menu_icon' => 'fa-comments',
                'menu_url' => 'admin.testimonials.index',
                'menu_permission' => 'content-manage',
                'menu_order' => 3,
                'parent_name' => 'Content',
            ],
            [
                'menu_name' => 'Team Members',
                'menu_slug' => 'content-team',
                'menu_icon' => 'fa-users',
                'menu_url' => 'admin.team-members.index',
                'menu_permission' => 'content-manage',
                'menu_order' => 4,
                'parent_name' => 'Content',
            ],
            [
                'menu_name' => 'Contact Info',
                'menu_slug' => 'content-contact',
                'menu_icon' => 'fa-address-book',
                'menu_url' => 'admin.contact-info.index',
                'menu_permission' => 'content-manage',
                'menu_order' => 5,
                'parent_name' => 'Content',
            ],

            // ===== Reports Children =====
            [
                'menu_name' => 'Sales Reports',
                'menu_slug' => 'reports-sales',
                'menu_icon' => 'fa-chart-line',
                'menu_url' => 'admin.reports.sales',
                'menu_permission' => 'report-sales',
                'menu_order' => 1,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Product Reports',
                'menu_slug' => 'reports-products',
                'menu_icon' => 'fa-box',
                'menu_url' => 'admin.reports.products',
                'menu_permission' => 'report-products',
                'menu_order' => 2,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Customer Reports',
                'menu_slug' => 'reports-customers',
                'menu_icon' => 'fa-users',
                'menu_url' => 'admin.reports.customers',
                'menu_permission' => 'report-customers',
                'menu_order' => 3,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Order Reports',
                'menu_slug' => 'reports-orders',
                'menu_icon' => 'fa-shopping-cart',
                'menu_url' => 'admin.reports.orders',
                'menu_permission' => 'sales-report',
                'menu_order' => 4,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Revenue Reports',
                'menu_slug' => 'reports-revenue',
                'menu_icon' => 'fa-dollar-sign',
                'menu_url' => 'admin.reports.revenue',
                'menu_permission' => 'analytics-view',
                'menu_order' => 5,
                'parent_name' => 'Reports',
            ],
            [
                'menu_name' => 'Export Data',
                'menu_slug' => 'reports-export',
                'menu_icon' => 'fa-file-export',
                'menu_url' => 'admin.reports.export',
                'menu_permission' => 'report-export',
                'menu_order' => 6,
                'parent_name' => 'Reports',
            ],

            // ===== Marketing Children =====
            [
                'menu_name' => 'Email Templates',
                'menu_slug' => 'marketing-email-templates',
                'menu_icon' => 'fa-envelope',
                'menu_url' => 'admin.email-templates.index',
                'menu_permission' => 'marketing-email',
                'menu_order' => 1,
                'parent_name' => 'Marketing',
            ],
            [
                'menu_name' => 'Email Campaigns',
                'menu_slug' => 'marketing-email-campaigns',
                'menu_icon' => 'fa-mail-bulk',
                'menu_url' => 'admin.marketing.email-campaigns',
                'menu_permission' => 'marketing-email',
                'menu_order' => 2,
                'parent_name' => 'Marketing',
            ],
            [
                'menu_name' => 'Promotions',
                'menu_slug' => 'marketing-promotions',
                'menu_icon' => 'fa-percent',
                'menu_url' => 'admin.marketing.promotions',
                'menu_permission' => 'marketing-promotion',
                'menu_order' => 3,
                'parent_name' => 'Marketing',
            ],
            [
                'menu_name' => 'Coupons',
                'menu_slug' => 'marketing-coupons',
                'menu_icon' => 'fa-ticket-alt',
                'menu_url' => 'admin.marketing.coupons',
                'menu_permission' => 'marketing-promotion',
                'menu_order' => 4,
                'parent_name' => 'Marketing',
            ],
            [
                'menu_name' => 'SEO Settings',
                'menu_slug' => 'marketing-seo',
                'menu_icon' => 'fa-search',
                'menu_url' => 'admin.marketing.seo',
                'menu_permission' => 'seo-manage',
                'menu_order' => 5,
                'parent_name' => 'Marketing',
            ],

            // ===== Support Children =====
            [
                'menu_name' => 'All Tickets',
                'menu_slug' => 'support-tickets',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.support.tickets.index',
                'menu_permission' => 'support-view',
                'menu_order' => 1,
                'parent_name' => 'Support',
            ],
            [
                'menu_name' => 'Open Tickets',
                'menu_slug' => 'support-open',
                'menu_icon' => 'fa-envelope-open',
                'menu_url' => 'admin.support.tickets.open',
                'menu_permission' => 'support-manage',
                'menu_order' => 2,
                'parent_name' => 'Support',
            ],
            [
                'menu_name' => 'Pending Tickets',
                'menu_slug' => 'support-pending',
                'menu_icon' => 'fa-clock',
                'menu_url' => 'admin.support.tickets.pending',
                'menu_permission' => 'support-manage',
                'menu_order' => 3,
                'parent_name' => 'Support',
            ],
            [
                'menu_name' => 'Closed Tickets',
                'menu_slug' => 'support-closed',
                'menu_icon' => 'fa-envelope',
                'menu_url' => 'admin.support.tickets.closed',
                'menu_permission' => 'support-view',
                'menu_order' => 4,
                'parent_name' => 'Support',
            ],
            [
                'menu_name' => 'Knowledge Base',
                'menu_slug' => 'support-knowledge',
                'menu_icon' => 'fa-book',
                'menu_url' => 'admin.support.knowledge-base.index',
                'menu_permission' => 'support-manage',
                'menu_order' => 5,
                'parent_name' => 'Support',
            ],
            [
                'menu_name' => 'Support Categories',
                'menu_slug' => 'support-categories',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'admin.support.categories.index',
                'menu_permission' => 'support-manage',
                'menu_order' => 6,
                'parent_name' => 'Support',
            ],

            // ===== System Children =====
            [
                'menu_name' => 'Menu Management',
                'menu_slug' => 'system-menus',
                'menu_icon' => 'fa-bars',
                'menu_url' => 'admin.menus.index',
                'menu_permission' => 'system-configure',
                'menu_order' => 1,
                'parent_name' => 'System',
            ],
            [
                'menu_name' => 'System Info',
                'menu_slug' => 'system-info',
                'menu_icon' => 'fa-info-circle',
                'menu_url' => 'admin.system.info',
                'menu_permission' => 'system-configure',
                'menu_order' => 3,
                'parent_name' => 'System',
            ],
            [
                'menu_name' => 'System Logs',
                'menu_slug' => 'system-logs',
                'menu_icon' => 'fa-file-alt',
                'menu_url' => 'admin.system.logs',
                'menu_permission' => 'system-logs',
                'menu_order' => 4,
                'parent_name' => 'System',
            ],
            [
                'menu_name' => 'Cache Management',
                'menu_slug' => 'system-cache',
                'menu_icon' => 'fa-memory',
                'menu_url' => 'admin.system.cache',
                'menu_permission' => 'system-maintenance',
                'menu_order' => 5,
                'parent_name' => 'System',
            ],
            [
                'menu_name' => 'Backup & Restore',
                'menu_slug' => 'system-backup',
                'menu_icon' => 'fa-save',
                'menu_url' => 'admin.system.backup',
                'menu_permission' => 'system-backup',
                'menu_order' => 6,
                'parent_name' => 'System',
            ],
            [
                'menu_name' => 'API Settings',
                'menu_slug' => 'system-api',
                'menu_icon' => 'fa-plug',
                'menu_url' => 'admin.system.api',
                'menu_permission' => 'system-configure',
                'menu_order' => 7,
                'parent_name' => 'System',
            ],

            // ===== User Management Children =====
            [
                'menu_name' => 'All Users',
                'menu_slug' => 'users-all',
                'menu_icon' => 'fa-list',
                'menu_url' => 'admin.users.index',
                'menu_permission' => 'user-manage',
                'menu_order' => 1,
                'parent_name' => 'Users',
            ],
            [
                'menu_name' => 'Add User',
                'menu_slug' => 'users-add',
                'menu_icon' => 'fa-user-plus',
                'menu_url' => 'admin.users.create',
                'menu_permission' => 'user-create',
                'menu_order' => 2,
                'parent_name' => 'Users',
            ],
            [
                'menu_name' => 'Roles & Permissions',
                'menu_slug' => 'users-roles',
                'menu_icon' => 'fa-shield-halved',
                'menu_url' => 'admin.roles.index',
                'menu_permission' => 'role-manage',
                'menu_order' => 3,
                'parent_name' => 'Users',
            ],
            [
                'menu_name' => 'User Activity',
                'menu_slug' => 'users-activity',
                'menu_icon' => 'fa-history',
                'menu_url' => 'admin.users.activity',
                'menu_permission' => 'user-manage',
                'menu_order' => 4,
                'parent_name' => 'Users',
            ],

            // ===== Settings Children =====
            [
                'menu_name' => 'General Settings',
                'menu_slug' => 'settings-general',
                'menu_icon' => 'fa-cog',
                'menu_url' => 'settings.index',
                'menu_permission' => 'settings-manage',
                'menu_order' => 1,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Email Settings',
                'menu_slug' => 'settings-email',
                'menu_icon' => 'fa-envelope',
                'menu_url' => 'admin.settings.email',
                'menu_permission' => 'email-setting',
                'menu_order' => 2,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Payment Settings',
                'menu_slug' => 'settings-payment',
                'menu_icon' => 'fa-credit-card',
                'menu_url' => 'admin.settings.payments',
                'menu_permission' => 'billing-manage',
                'menu_order' => 3,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Languages',
                'menu_slug' => 'settings-languages',
                'menu_icon' => 'fa-language',
                'menu_url' => 'admin.settings.languages',
                'menu_permission' => 'settings-language',
                'menu_order' => 4,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Notifications',
                'menu_slug' => 'settings-notifications',
                'menu_icon' => 'fa-bell',
                'menu_url' => 'admin.settings.notifications',
                'menu_permission' => 'settings-notification',
                'menu_order' => 5,
                'parent_name' => 'Settings',
            ],
            [
                'menu_name' => 'Security',
                'menu_slug' => 'settings-security',
                'menu_icon' => 'fa-shield-alt',
                'menu_url' => 'admin.settings.security',
                'menu_permission' => 'settings-manage',
                'menu_order' => 6,
                'parent_name' => 'Settings',
            ],
        ];

        // Insert child menus with correct parent IDs
        foreach ($childMenus as $menu) {
            if (isset($parentIdMap[$menu['parent_name']])) {
                DB::table('menus')->insert([
                    'menu_name' => $menu['menu_name'],
                    'menu_slug' => $menu['menu_slug'],
                    'menu_icon' => $menu['menu_icon'],
                    'menu_url' => $menu['menu_url'],
                    'menu_permission' => $menu['menu_permission'],
                    'menu_order' => $menu['menu_order'],
                    'menu_parent' => $parentIdMap[$menu['parent_name']],
                    'created_by' => $adminId,
                    'updated_by' => $adminId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->command->info('MenuSeeder completed successfully for Next Digi Home!');
        $this->command->info('Created menus for digital products marketplace.');
    }
}