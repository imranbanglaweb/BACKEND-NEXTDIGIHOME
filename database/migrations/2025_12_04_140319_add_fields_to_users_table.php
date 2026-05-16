<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_image')->nullable()->after('email');
            $table->string('role_id')->nullable()->after('user_image');
            $table->string('user_type')->nullable()->after('role_id');
            $table->string('user_name')->nullable()->after('user_type');
            $table->string('employee_id')->nullable()->after('user_name');
            $table->string('cell_phone')->nullable()->after('employee_id');
            $table->unsignedBigInteger('unit_id')->nullable()->after('cell_phone');
            $table->unsignedBigInteger('company_id')->nullable()->after('unit_id');
            $table->unsignedBigInteger('department_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('location_id')->nullable()->after('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
