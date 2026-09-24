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
        if (Schema::hasTable('settings') && !Schema::hasColumn('settings', 'meta_dataset_id')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('meta_dataset_id', 100)->nullable()->after('meta_pixel_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings') && Schema::hasColumn('settings', 'meta_dataset_id')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('meta_dataset_id');
            });
        }
    }
};
