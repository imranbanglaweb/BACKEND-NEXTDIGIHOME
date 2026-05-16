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
                'key' => 'products_sold',
                'value' => '10K+',
                'label' => 'Products Sold',
                'icon' => 'shopping-bag',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'happy_customers',
                'value' => '50K+',
                'label' => 'Happy Customers',
                'icon' => 'users',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'countries_served',
                'value' => '150+',
                'label' => 'Countries Served',
                'icon' => 'globe',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'average_rating',
                'value' => '4.9★',
                'label' => 'Average Rating',
                'icon' => 'star',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::create($stat);
        }
    }
}