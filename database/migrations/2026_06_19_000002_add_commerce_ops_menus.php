<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $permissions = [
        'commerce-ops-manage',
        'commerce-payment-methods',
        'commerce-payment-reconciliation',
        'commerce-digital-access',
        'commerce-fraud-risk',
        'commerce-vat-tax',
        'commerce-affiliate-manage',
        'commerce-abandoned-checkout',
        'commerce-channel-sales',
    ];

    private array $menuSlugs = [
        'commerce-ops',
        'commerce-payment-methods',
        'commerce-payment-reconciliation',
        'commerce-digital-access',
        'commerce-fraud-risk',
        'commerce-vat-tax',
        'commerce-affiliates-resellers',
        'commerce-abandoned-checkouts',
        'commerce-marketplace-channels',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $now = Carbon::now();

        if (Schema::hasTable('permissions')) {
            foreach ($this->permissions as $permission) {
                DB::table('permissions')->updateOrInsert(
                    ['name' => $permission, 'guard_name' => 'web'],
                    ['created_at' => $now, 'updated_at' => $now]
                );
            }
        }

        DB::table('menus')->updateOrInsert(
            ['menu_slug' => 'commerce-ops'],
            [
                'menu_name' => 'Commerce Ops',
                'menu_icon' => 'fa-briefcase',
                'menu_url' => null,
                'menu_permission' => 'commerce-ops-manage',
                'menu_order' => 5,
                'menu_parent' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $parentId = DB::table('menus')->where('menu_slug', 'commerce-ops')->value('id');

        $children = [
            ['Payment Methods', 'commerce-payment-methods', 'fa-wallet', 'admin.commerce-ops.payment-methods', 'commerce-payment-methods'],
            ['Payment Reconciliation', 'commerce-payment-reconciliation', 'fa-receipt', 'admin.commerce-ops.payment-reconciliation', 'commerce-payment-reconciliation'],
            ['Digital Access & Licenses', 'commerce-digital-access', 'fa-key', 'admin.commerce-ops.digital-access', 'commerce-digital-access'],
            ['Fraud & Risk Review', 'commerce-fraud-risk', 'fa-shield-alt', 'admin.commerce-ops.fraud-risk', 'commerce-fraud-risk'],
            ['VAT & Tax', 'commerce-vat-tax', 'fa-file-invoice-dollar', 'admin.commerce-ops.vat-tax', 'commerce-vat-tax'],
            ['Affiliates & Resellers', 'commerce-affiliates-resellers', 'fa-handshake', 'admin.commerce-ops.affiliates-resellers', 'commerce-affiliate-manage'],
            ['Abandoned Checkouts', 'commerce-abandoned-checkouts', 'fa-cart-arrow-down', 'admin.commerce-ops.abandoned-checkouts', 'commerce-abandoned-checkout'],
            ['Marketplace Channels', 'commerce-marketplace-channels', 'fa-store', 'admin.commerce-ops.marketplace-channels', 'commerce-channel-sales'],
        ];

        foreach ($children as $index => [$name, $slug, $icon, $route, $permission]) {
            DB::table('menus')->updateOrInsert(
                ['menu_slug' => $slug],
                [
                    'menu_name' => $name,
                    'menu_icon' => $icon,
                    'menu_url' => $route,
                    'menu_permission' => $permission,
                    'menu_order' => $index + 1,
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
            DB::table('menus')->whereIn('menu_slug', $this->menuSlugs)->delete();
        }

        if (Schema::hasTable('permissions')) {
            DB::table('permissions')->whereIn('name', $this->permissions)->delete();
        }
    }
};
