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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('subject');
            $table->text('description');
            $table->enum('status', ['open', 'pending', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('customer_id'); // Customer who created the ticket
            $table->unsignedBigInteger('assigned_to')->nullable(); // Admin/Support staff assigned
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamp('last_reply_at')->nullable();
            $table->json('tags')->nullable(); // For tagging/categorization
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('support_categories');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->index(['status', 'priority']);
            $table->index('ticket_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
};
