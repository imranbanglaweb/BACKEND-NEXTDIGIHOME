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
            // Drop the existing foreign key constraint
            $table->dropForeign(['user_id']);

            // Make user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Re-add the foreign key constraint (nullable)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
            // Drop the nullable foreign key
            $table->dropForeign(['user_id']);

            // Make user_id not nullable again
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // Re-add the original foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
