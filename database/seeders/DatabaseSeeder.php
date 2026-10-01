<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for Next Digi Home (Digital Products Marketplace).
     */
    public function run(): void
    {
        $this->call([
            // ============================================================================
            // BASIC SETUP - Essential for any Laravel app
            // ============================================================================

            // Language and localization
            LanguageSeeder::class,

            // Settings and configurations
            SettingSeeder::class,
            EmailSettingSeeder::class,

            // ============================================================================
            // ROLES, PERMISSIONS & USERS - Core system for admin access
            // ============================================================================

            // Roles and permissions (must come before users)
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            SaaSPermissionsSeeder::class,

            // Users - Next Digi Home admin accounts
            UserSeeder::class,

            // ============================================================================
            // SUBSCRIPTIONS & PLANS - For Next Digi Home SaaS features
            // ============================================================================

            // Subscription plans for marketplace tiers
            SubscriptionPlanSeeder::class,
            SaaSSubscriptionPlansSeeder::class,

            // ============================================================================
            // MENUS & NAVIGATION - For admin panel
            // ============================================================================

            MenuSeeder::class,

            // ============================================================================
            // PRODUCTS & CATEGORIES - For the marketplace
            // ============================================================================

            CategorySeeder::class,
            ProductSeeder::class,
            PurchaseSeeder::class,

            // ============================================================================
            // EMAIL TEMPLATES - For marketplace communications
            // ============================================================================

            EmailTemplateSeeder::class,

            // ============================================================================
            // FRONTEND CONTENT - For Next Digi Home landing pages
            // ============================================================================

            // Hero slider and content
            HeroSliderSeeder::class,
            PageContentSeeder::class,
            ContentSeeder::class,

            // Stats and testimonials
            StatsSeeder::class,
            TestimonialsSeeder::class,
            TeamMembersSeeder::class,

            // Contact information
            ContactInfoSeeder::class,

            // ============================================================================
            // VEHICLE MANAGEMENT SYSTEM SEEDERS - SKIPPED (Not needed for Next Digi Home)
            // ============================================================================
            /*
            CompanySeeder::class,
            UnitSeeder::class,
            DepartmentSeeder::class,
            LocationSeeder::class,
            EmployeeSeeder::class,
            DriverSeeder::class,
            DepartmentHeadSeeder::class,

            LicenseTypeSeeder::class,
            MaintenanceTypeSeeder::class,
            MaintenanceCategorySeeder::class,
            MaintenanceVendorSeeder::class,
            RequisitionSeeder::class,
            RequisitionPassengerSeeder::class,
            MaintenanceRequisitionSeeder::class,
            GpsDeviceSeeder::class,
            GpsTrackSeeder::class,
            VendorSeeder::class,
            CompanyMenuSeeder::class,
            TripSheetSeeder::class,
            */
        ]);
    }
}
