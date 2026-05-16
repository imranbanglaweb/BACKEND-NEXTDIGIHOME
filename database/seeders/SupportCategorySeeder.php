<?php

namespace Database\Seeders;

use App\Models\SupportCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminId = 1;
        $now = Carbon::now();

        $categories = [
            [
                'name' => 'General Questions',
                'slug' => 'general-questions',
                'description' => 'General inquiries and questions about our services',
                'icon' => 'fa-question-circle',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Technical Support',
                'slug' => 'technical-support',
                'description' => 'Technical issues and troubleshooting assistance',
                'icon' => 'fa-cogs',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Billing & Payments',
                'slug' => 'billing-payments',
                'description' => 'Questions about billing, payments, and subscriptions',
                'icon' => 'fa-credit-card',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Account Issues',
                'slug' => 'account-issues',
                'description' => 'Login problems, password resets, and account management',
                'icon' => 'fa-user-circle',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Feature Requests',
                'slug' => 'feature-requests',
                'description' => 'Suggestions for new features and improvements',
                'icon' => 'fa-lightbulb',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Bug Reports',
                'slug' => 'bug-reports',
                'description' => 'Report bugs and technical issues you encounter',
                'icon' => 'fa-bug',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            SupportCategory::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'icon' => $category['icon'],
                'is_active' => $category['is_active'],
                'sort_order' => $category['sort_order'],
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('SupportCategorySeeder completed successfully!');
        $this->command->info('Created ' . count($categories) . ' default support categories.');
    }
}
