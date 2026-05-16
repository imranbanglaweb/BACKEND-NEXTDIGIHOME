<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        // database/migrations/xxxx_add_role_to_users_table.php
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('employee')->after('password'); // employee, transport, admin
            });
        }

        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

}
