<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Company reference
            $table->foreignId('company_id')
                  ->constrained()
                  ->cascadeOnDelete()->nullable();

            // User reference
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Subscription reference
            $table->foreignId('subscription_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Payment details
            $table->string('method');          // manual, stripe, etc
            $table->decimal('amount', 10, 2);  // amount
              // Plan reference
            $table->foreignId('plan_id')
                  ->constrained('subscription_plans') // ✅ points to subscription_plans
                  ->cascadeOnDelete();
            $table->string('currency')->default('BDT');
            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();

            // Payment status
            $table->enum('status', ['pending', 'paid', 'rejected'])->default('pending');

            // Who created the record (admin or user)
            $table->unsignedBigInteger('created_by')->nullable();

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
         Schema::dropIfExists('payments');
    }
}
