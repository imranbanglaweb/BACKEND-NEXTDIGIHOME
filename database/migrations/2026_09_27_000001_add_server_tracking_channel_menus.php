<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $menuSlugs = [
        'tracking-dashboard',
        'tracking-meta',
        'tracking-ga4',
        'tracking-gtm',
        'tracking-campaigns',
        'tracking-customer-journey',
        'tracking-config',
        'tracking-logs',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $now = Carbon::now();

        // 1. Ensure parent menu exists
        $parent = DB::table('menus')->where('menu_slug', 'server-tracking')->first();
        if (!$parent) {
            $parentId = DB::table('menus')->insertGetId([
                'menu_name' => 'Server Tracking',
                'menu_slug' => 'server-tracking',
                'menu_icon' => 'fa-satellite-dish',
                'menu_url' => 'admin.server-tracking.dashboard',
                'menu_permission' => 'analytics-view',
                'menu_order' => 7,
                'menu_parent' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $parentId = $parent->id;
            DB::table('menus')->where('id', $parentId)->update(['menu_name' => 'Server Tracking']);
        }

        // 2. Child menus definition
        $children = [
            [
                'menu_name' => 'Tracking Dashboard',
                'menu_slug' => 'tracking-dashboard',
                'menu_icon' => 'fa-chart-pie',
                'menu_url' => 'admin.server-tracking.dashboard',
                'menu_order' => 1,
            ],
            [
                'menu_name' => 'Meta Pixel & CAPI',
                'menu_slug' => 'tracking-meta',
                'menu_icon' => 'fa-brands fa-facebook',
                'menu_url' => 'admin.server-tracking.meta',
                'menu_order' => 2,
            ],
            [
                'menu_name' => 'Google Analytics 4',
                'menu_slug' => 'tracking-ga4',
                'menu_icon' => 'fa-chart-simple',
                'menu_url' => 'admin.server-tracking.ga4',
                'menu_order' => 3,
            ],
            [
                'menu_name' => 'Google Tag Manager',
                'menu_slug' => 'tracking-gtm',
                'menu_icon' => 'fa-tags',
                'menu_url' => 'admin.server-tracking.gtm',
                'menu_order' => 4,
            ],
            [
                'menu_name' => 'Campaigns & SEO',
                'menu_slug' => 'tracking-campaigns',
                'menu_icon' => 'fa-bullhorn',
                'menu_url' => 'admin.server-tracking.campaigns',
                'menu_order' => 5,
            ],
            [
                'menu_name' => 'Customer Journey',
                'menu_slug' => 'tracking-customer-journey',
                'menu_icon' => 'fa-route',
                'menu_url' => 'admin.server-tracking.customer-journey',
                'menu_order' => 6,
            ],
            [
                'menu_name' => 'CAPI & Pixel Setup',
                'menu_slug' => 'tracking-config',
                'menu_icon' => 'fa-sliders-h',
                'menu_url' => 'admin.server-tracking.config',
                'menu_order' => 7,
            ],
            [
                'menu_name' => 'Conversion Logs',
                'menu_slug' => 'tracking-logs',
                'menu_icon' => 'fa-clipboard-list',
                'menu_url' => 'admin.server-tracking.logs',
                'menu_order' => 8,
            ],
        ];

        foreach ($children as $child) {
            DB::table('menus')->updateOrInsert(
                ['menu_slug' => $child['menu_slug']],
                [
                    'menu_name' => $child['menu_name'],
                    'menu_icon' => $child['menu_icon'],
                    'menu_url' => $child['menu_url'],
                    'menu_permission' => 'analytics-view',
                    'menu_order' => $child['menu_order'],
                    'menu_parent' => $parentId,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('menus')) {
            DB::table('menus')->whereIn('menu_slug', ['tracking-meta', 'tracking-ga4', 'tracking-gtm'])->delete();
        }
    }
};
