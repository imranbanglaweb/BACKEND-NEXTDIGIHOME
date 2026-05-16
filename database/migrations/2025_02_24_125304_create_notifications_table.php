<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
        {
            Schema::create('notifications', function (Blueprint $table) {
                // $table->id();
                $table->unsignedBigInteger('user_id'); // who will receive
                $table->unsignedBigInteger('from_user_id')->nullable(); // who triggered event
                $table->string('title');
                $table->text('message')->nullable();
                $table->string('type')->default('info'); // success, warning, danger
                $table->string('link')->nullable(); // clickable link in UI
                $table->boolean('is_read')->default(0);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
            });
        }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
