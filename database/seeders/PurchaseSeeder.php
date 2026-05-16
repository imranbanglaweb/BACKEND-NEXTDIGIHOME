<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder data disabled as requested - orders should be created through actual purchases
        $this->command->info('PurchaseSeeder skipped - no sample data inserted.');
        $this->command->info('Orders will be created through actual purchase flow.');
    }
}
