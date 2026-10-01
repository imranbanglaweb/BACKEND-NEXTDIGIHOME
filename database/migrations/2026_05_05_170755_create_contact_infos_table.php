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
         Schema::create('contact_infos', function (Blueprint $table) {
             $table->id();
             $table->string('type');
             $table->string('title');
             $table->text('value');
             $table->text('description')->nullable();
             $table->string('icon')->nullable();
             $table->integer('sort_order')->default(0);
             $table->boolean('is_active')->default(true);
             $table->timestamps();
         });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_infos');
    }
};
