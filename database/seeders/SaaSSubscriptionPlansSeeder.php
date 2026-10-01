<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SaaSSubscriptionPlansSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'price' => 29,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 10,
                'user_limit' => 5,
                'driver_limit' => 10,
                'monthly_reports' => 50,
                'monthly_alerts' => 100,
                'features' => [
                    'Basic vehicle tracking',
                    'Driver management',
                    'Trip logging',
                    'Basic reports',
                    'Email support'
                ],
                'is_trial' => false,
                'trial_days' => 0,
                'is_popular' => false,
                'is_active' => true,
                'recommended_for' => 'Small fleets with up to 10 vehicles',
                'display_order' => 1,
                'last_updated_at' => now(),
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'price' => 79,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 50,
                'user_limit' => 15,
                'driver_limit' => 50,
                'monthly_reports' => 200,
                'monthly_alerts' => 500,
                'features' => [
                    'Advanced vehicle tracking',
                    'GPS integration',
                    'Maintenance scheduling',
                    'Advanced analytics',
                    'Priority support',
                    'API access'
                ],
                'is_trial' => false,
                'trial_days' => 0,
                'is_popular' => true,
                'is_active' => true,
                'recommended_for' => 'Growing businesses with 10-50 vehicles',
                'display_order' => 2,
                'last_updated_at' => now(),
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 199,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 0,
                'user_limit' => 0,
                'driver_limit' => 0,
                'monthly_reports' => 0,
                'monthly_alerts' => 0,
                'features' => [
                    'Everything in Professional',
                    'AI-powered maintenance alerts',
                    'Advanced AI reporting',
                    'Custom integrations',
                    'Dedicated support',
                    'SLA guarantee',
                    'White-label option'
                ],
                'is_trial' => false,
                'trial_days' => 0,
                'is_popular' => false,
                'is_active' => true,
                'recommended_for' => 'Large organizations with 50+ vehicles',
                'display_order' => 3,
                'last_updated_at' => now(),
            ],
            [
                'name' => 'Free Trial',
                'slug' => 'trial',
                'price' => 0,
                'billing_cycle' => 'monthly',
                'vehicle_limit' => 3,
                'user_limit' => 2,
                'driver_limit' => 3,
                'monthly_reports' => 10,
                'monthly_alerts' => 25,
                'features' => [
                    'Basic features',
                    'Limited vehicle tracking',
                    'Trial period: 30 days'
                ],
                'is_trial' => true,
                'trial_days' => 30,
                'is_popular' => false,
                'is_active' => true,
                'recommended_for' => 'New users testing the platform',
                'display_order' => 0,
                'last_updated_at' => now(),
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}