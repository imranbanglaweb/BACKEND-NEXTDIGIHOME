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
            $table->timestamp('download_expires_at')->nullable()->after('download_token');
            $table->integer('download_count')->default(0)->after('download_expires_at');
            $table->timestamp('last_download_at')->nullable()->after('download_count');
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
            $table->dropColumn(['download_expires_at', 'download_count', 'last_download_at']);
        });
    }
};
