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
        Schema::create('languages', function (Blueprint $table) {
            $table->string('code', 10)->primary();
            $table->string('name', 50);
            $table->string('native_name', 50);
            $table->string('direction', 5)->default('ltr');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('flag_icon', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
