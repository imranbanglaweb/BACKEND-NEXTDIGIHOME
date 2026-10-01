<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            [
                'key' => 'experience',
                'value' => '8+ Years',
                'label' => 'Combined Engineering Experience',
                'icon' => 'code-bracket',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'platforms',
                'value' => 'Multiple',
                'label' => 'SaaS Platforms in Active Production',
                'icon' => 'cpu-chip',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'ip_ownership',
                'value' => '100%',
                'label' => 'Code & IP Ownership',
                'icon' => 'shield-check',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'sla_support',
                'value' => '24/7',
                'label' => 'Monitoring & SLA-Backed Support',
                'icon' => 'clock',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::updateOrCreate(
                ['key' => $stat['key']],
                $stat
            );
        }
    }
}
