<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_kind')->default('digital_download')->after('digital');
            $table->string('purchase_type')->default('one_time')->after('product_kind');
            $table->unsignedInteger('validity_days')->nullable()->after('purchase_type');
            $table->string('validity_label')->nullable()->after('validity_days');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'product_kind',
                'purchase_type',
                'validity_days',
                'validity_label',
            ]);
        });
    }
};
