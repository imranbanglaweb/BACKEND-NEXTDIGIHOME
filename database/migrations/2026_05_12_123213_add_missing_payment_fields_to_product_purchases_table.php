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
        Schema::table('product_purchases', function (Blueprint $table) {
            // Check each column individually to avoid conflicts
            $columns = Schema::getColumnListing('product_purchases');

            if (! in_array('sender_number', $columns)) {
                $table->string('sender_number')->nullable()->after('customer_phone');
            }
            if (! in_array('transaction_id', $columns)) {
                $table->string('transaction_id')->nullable()->after('sender_number');
            }
            if (! in_array('payment_proof', $columns)) {
                $table->string('payment_proof')->nullable()->after('notes');
            }
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $columns = Schema::getColumnListing('product_purchases');

            if (in_array('sender_number', $columns)) {
                $table->dropColumn('sender_number');
            }
            if (in_array('transaction_id', $columns)) {
                $table->dropColumn('transaction_id');
            }
            if (in_array('payment_proof', $columns)) {
                $table->dropColumn('payment_proof');
            }
        });
    }
};
