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
        Schema::table('notifications', function (Blueprint $table) {
            // Make old custom notification columns nullable for Laravel DatabaseNotification
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->text('message')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('link')->nullable()->change();
            $table->boolean('is_read')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('message')->change();
            $table->string('type')->change();
            $table->string('link')->change();
            $table->boolean('is_read')->change();
        });
    }
};
