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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('menu_slug')->unique();
            $table->string('menu_icon')->nullable();
            $table->string('menu_url')->nullable();
            $table->string('menu_permission')->nullable()->index();
            $table->integer('menu_order')->default(0);
            $table->unsignedBigInteger('menu_parent')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Optional: foreign keys (disabled because menu_parent uses 0 for root, not NULL)
            // Uncomment if you change menu_parent to use NULL for root menus
            // $table->foreign('menu_parent')
            //     ->references('id')->on('menus')
            //     ->onDelete('cascade');

            // $table->foreign('created_by')
            //     ->references('id')->on('users')
            //     ->onDelete('set null');

            // $table->foreign('updated_by')
            //     ->references('id')->on('users')
            //     ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
