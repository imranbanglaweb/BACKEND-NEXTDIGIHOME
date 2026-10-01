<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->integer('parent_id')->default(0);
            $table->string('category_name',150)->index();
            $table->string('category_slug',100)->index();
            $table->string('category_type',100)->nullable();
            $table->string('remarks',250)->nullable();
            $table->string('category_url',250)->nullable();
            $table->integer('category_oder')->nullable();
            $table->integer('menu_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
}
