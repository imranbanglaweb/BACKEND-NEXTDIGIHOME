<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyMenuSeeder extends Seeder
{
    public function run()
    {
        // Check if Company Management parent menu exists
        $parentMenu = DB::table('menus')->where('menu_name', 'Company Management')->first();

        if (!$parentMenu) {
            // Create the parent menu
            $parentId = DB::table('menus')->insertGetId([
                'menu_name' => 'Company Management',
                'menu_slug' => 'company-management',
                'menu_icon' => 'fa-building',
                'menu_url' => null,
                'menu_permission' => 'company-manage',
                'menu_order' => 6,
                'menu_parent' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create child menus
            $childMenus = [
                [
                    'menu_name' => 'All Companies',
                    'menu_slug' => 'all-companies',
                    'menu_icon' => 'fa-list',
                    'menu_url' => 'company.index',
                    'menu_permission' => 'company-manage',
                    'menu_order' => 1,
                    'menu_parent' => $parentId,
                ],
                [
                    'menu_name' => 'Add Company',
                    'menu_slug' => 'add-company',
                    'menu_icon' => 'fa-plus-circle',
                    'menu_url' => 'company.create',
                    'menu_permission' => 'company-manage',
                    'menu_order' => 2,
                    'menu_parent' => $parentId,
                ],
                [
                    'menu_name' => 'Subscription Plans',
                    'menu_slug' => 'subscription-plans',
                    'menu_icon' => 'fa-credit-card',
                    'menu_url' => 'admin.dashboard.plans.index',
                    'menu_permission' => 'subscription-plan-manage',
                    'menu_order' => 3,
                    'menu_parent' => $parentId,
                ],
            ];

            foreach ($childMenus as $child) {
                DB::table('menus')->insert(array_merge($child, [
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            $this->command->info('Company Management menu created successfully');
        } else {
            $this->command->info('Company Management menu already exists');
        }
    }
}