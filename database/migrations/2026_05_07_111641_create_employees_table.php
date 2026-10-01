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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('employee_code')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->string('employee_type')->default('Permanent'); // Permanent, Contract, etc.
            $table->string('status')->default('Active'); // Active, Inactive
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('photo')->nullable();
            $table->integer('employee_order')->default(0);

            // Foreign keys
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            // $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');

            // Indexes
            $table->index(['status', 'employee_type']);
            $table->index('employee_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
