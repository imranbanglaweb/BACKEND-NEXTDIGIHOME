<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderNumberToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('sender_number')->nullable()->after('transaction_id');
            $table->timestamp('paid_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('sender_number');
            $table->dropColumn('paid_at');
        });
    }
}