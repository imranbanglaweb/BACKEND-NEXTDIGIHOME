<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Free Trial Plan
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'free-trial'],
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'price' => 0,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 5,
                'user_limit' => 3,
                'driver_limit' => 3,
                'monthly_reports' => 10,
                'monthly_alerts' => 20,
                'features' => [
                    '5 Vehicles',
                    '3 Users',
                    '3 Drivers',
                    'Fuel & Maintenance Management',
                    'Basic Reports',
                    'Vehicle Tracking',
                    'Driver Management',
                    'Requisition System',
                    'Email Support',
                    '7 Days Free Trial'
                ],
                'is_trial' => true,
                'trial_days' => 7,
                'is_popular' => false,
                'is_active' => true,
                'recommended_for' => 'New users testing the platform',
                'display_order' => 0,
                'last_updated_at' => now(),
            ]
        );

        // Starter Plan
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'starter'],
            [
                'name' => 'Starter',
                'price' => 2000,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 5,
                'user_limit' => 3,
                'driver_limit' => 3,
                'monthly_reports' => 25,
                'monthly_alerts' => 50,
                'features' => [
                    '5 Vehicles',
                    '3 Users',
                    '3 Drivers',
                    '25 Monthly Reports',
                    '50 Monthly Alerts',
                    'Fuel & Maintenance',
                    'Basic Reports',
                    'Limited Support',
                    'Vehicle Tracking',
                    'Driver Management',
                    'Requisition System',
                    'Trip Sheets'
                ],
                'is_popular' => false,
                'is_active' => true,
                'recommended_for' => 'Small fleets with up to 5 vehicles',
                'display_order' => 1,
                'last_updated_at' => now(),
            ]
        );

        // Business Plan
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'business'],
            [
                'name' => 'Business',
                'price' => 5000,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 25,
                'user_limit' => 10,
                'driver_limit' => 10,
                'monthly_reports' => 50,
                'monthly_alerts' => 100,
                'features' => [
                    '25 Vehicles',
                    '10 Users',
                    '10 Drivers',
                    'Unlimited Reports',
                    '100 Monthly Alerts',
                    'Advanced Reports',
                    'Priority Support',
                    'Fuel & Maintenance',
                    'API Access',
                    'GPS Tracking',
                    'Trip Sheets',
                    'Maintenance Alerts',
                    'Driver Performance Tracking',
                    'Vehicle Utilization Reports'
                ],
                'is_popular' => true,
                'is_active' => true,
                'recommended_for' => 'Growing businesses with 5-25 vehicles',
                'display_order' => 2,
                'last_updated_at' => now(),
            ]
        );

        // Enterprise Plan
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'enterprise'],
            [
                'name' => 'Enterprise',
                'price' => 0,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 0,
                'user_limit' => 0,
                'driver_limit' => 0,
                'monthly_reports' => 0,
                'monthly_alerts' => 0,
                'features' => [
                    'Unlimited Vehicles',
                    'Unlimited Users',
                    'Unlimited Drivers',
                    'Unlimited Reports & Alerts',
                    'API & Integrations',
                    'Custom Development',
                    '24/7 Priority Support',
                    'Dedicated Account Manager',
                    'White-label Solutions',
                    'Advanced Analytics Dashboard',
                    'Multi-location Support',
                    'SSO & Enterprise Security',
                    'Custom Workflow Automation',
                    'Real-time GPS Tracking',
                    'AI-powered Insights'
                ],
                'is_popular' => false,
                'is_active' => true,
                'recommended_for' => 'Large organizations with 25+ vehicles',
                'display_order' => 3,
                'last_updated_at' => now(),
            ]
        );
    }
}
