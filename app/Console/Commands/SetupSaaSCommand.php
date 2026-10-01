<?php

namespace App\Console\Commands;

use Database\Seeders\SaaSSubscriptionPlansSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupSaaSCommand extends Command
{
    protected $signature = 'saas:setup';
    protected $description = 'Set up the application for SaaS multi-tenancy';

    public function handle()
    {
        $this->info('🚀 Setting up SaaS Multi-Tenancy...');

        // Run migrations
        $this->info('📦 Running migrations...');
        Artisan::call('migrate', [], $this->getOutput());

        // Seed subscription plans
        $this->info('📋 Seeding subscription plans...');
        $seeder = new SaaSSubscriptionPlansSeeder();
        $seeder->run();

        // Seed menus
        $this->info('🍔 Seeding menus...');
        Artisan::call('db:seed', ['--class' => 'MenuSeeder'], $this->getOutput());

        // Clear cache
        $this->info('🧹 Clearing cache...');
        Artisan::call('cache:clear', [], $this->getOutput());
        Artisan::call('config:clear', [], $this->getOutput());

        $this->newLine();
        $this->info('✅ SaaS setup completed successfully!');
        $this->newLine();

        $this->comment('Next steps:');
        $this->line('1. Configure Stripe keys in .env:');
        $this->line('   STRIPE_KEY=pk_test_...');
        $this->line('   STRIPE_SECRET=sk_test_...');
        $this->line('   STRIPE_WEBHOOK_SECRET=whsec_...');
        $this->newLine();

        $this->line('2. Set up Stripe webhook endpoint:');
        $this->line('   URL: ' . config('app.url') . '/stripe/webhook');
        $this->line('   Events: invoice.payment_succeeded, invoice.payment_failed, customer.subscription.*');
        $this->newLine();

        $this->line('3. Access company management (admin):');
        $this->line('   URL: ' . config('app.url') . '/admin/company');
        $this->newLine();

        $this->line('4. Access subscription plans (admin):');
        $this->line('   URL: ' . config('app.url') . '/admin/dashboard/plans');

        return 0;
    }
}