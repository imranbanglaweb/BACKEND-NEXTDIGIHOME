<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('billing_cycle')->default('monthly');
            $table->integer('vehicle_limit')->nullable()->comment('0 means unlimited');
            $table->integer('user_limit')->nullable()->comment('0 means unlimited');
            $table->integer('driver_limit')->nullable()->comment('0 means unlimited');
            $table->integer('monthly_reports')->nullable()->comment('Number of reports per month');
            $table->integer('monthly_alerts')->nullable()->comment('Number of alerts per month');
            $table->json('features')->nullable()->comment('Array of plan features');
            $table->boolean('is_trial')->default(false);
            $table->integer('trial_days')->default(0);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('recommended_for')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
