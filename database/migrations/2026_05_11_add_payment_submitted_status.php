<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add payment_submitted to the status enum using MySQL raw SQL
        // This avoids Doctrine DBAL issues with enum modifications
        DB::unprepared("ALTER TABLE product_purchases MODIFY COLUMN status ENUM('pending', 'payment_submitted', 'processing', 'completed', 'shipped', 'delivered', 'refunded', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove payment_submitted from the status enum
        DB::unprepared("ALTER TABLE product_purchases MODIFY COLUMN status ENUM('pending', 'processing', 'completed', 'shipped', 'delivered', 'refunded', 'cancelled') DEFAULT 'pending'");
    }
};
