<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->string('customer_email')->nullable()->after('notes');
            $table->string('customer_name')->nullable()->after('customer_email');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->string('download_token')->nullable()->after('customer_phone');
            $table->timestamp('delivered_at')->nullable()->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->dropColumn(['customer_email', 'customer_name', 'customer_phone', 'download_token', 'delivered_at']);
        });
    }
};
