<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('project_inquiries')) {
            Schema::create('project_inquiries', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->string('company')->nullable();
                $table->string('service');
                $table->string('budget')->nullable();
                $table->string('timeline')->nullable();
                $table->text('message');
                $table->string('status')->default('new'); // new, in_review, contacted, closed
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_inquiries');
    }
};
