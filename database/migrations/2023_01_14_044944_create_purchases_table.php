<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->string('requisition_title')->nullable();
            $table->text('requisition_date')->nullable();
            $table->text('requisition_receive_date')->nullable();
            $table->string('requisition_raised_by')->nullable();
            $table->integer('unit_id')->index();
            $table->integer('company_id')->nullable();
            $table->integer('pproject_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('requisition_status_id')->nullable();
            $table->integer('requisition_oder')->default(1);
            $table->string('status_date',250)->nullable();
            $table->string('remarks',250)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('ip_address')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
