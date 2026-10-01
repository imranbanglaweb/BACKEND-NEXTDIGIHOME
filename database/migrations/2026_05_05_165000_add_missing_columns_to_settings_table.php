<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Language & Translation Settings
            if (!Schema::hasColumn('settings', 'default_language')) {
                $table->string('default_language', 10)->default('en')->after('updated_by');
            }
            if (!Schema::hasColumn('settings', 'available_languages')) {
                $table->text('available_languages')->nullable()->comment('JSON array of available language codes')->after('default_language');
            }
            if (!Schema::hasColumn('settings', 'auto_translate')) {
                $table->boolean('auto_translate')->default(false)->after('available_languages');
            }
            if (!Schema::hasColumn('settings', 'translation_cache_duration')) {
                $table->integer('translation_cache_duration')->default(3600)->comment('Cache duration in seconds')->after('auto_translate');
            }

            // Email Configuration
            if (!Schema::hasColumn('settings', 'mail_mailer')) {
                $table->string('mail_mailer', 50)->default('smtp')->after('translation_cache_duration');
            }
            if (!Schema::hasColumn('settings', 'mail_host')) {
                $table->string('mail_host', 100)->nullable()->after('mail_mailer');
            }
            if (!Schema::hasColumn('settings', 'mail_port')) {
                $table->integer('mail_port')->nullable()->after('mail_host');
            }
            if (!Schema::hasColumn('settings', 'mail_username')) {
                $table->string('mail_username', 100)->nullable()->after('mail_port');
            }
            if (!Schema::hasColumn('settings', 'mail_password')) {
                $table->text('mail_password')->nullable()->after('mail_username');
            }
            if (!Schema::hasColumn('settings', 'mail_encryption')) {
                $table->string('mail_encryption', 20)->nullable()->after('mail_password');
            }
            if (!Schema::hasColumn('settings', 'mail_from_address')) {
                $table->string('mail_from_address', 100)->nullable()->after('mail_encryption');
            }
            if (!Schema::hasColumn('settings', 'mail_from_name')) {
                $table->string('mail_from_name', 100)->nullable()->after('mail_from_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'default_language',
                'available_languages',
                'auto_translate',
                'translation_cache_duration',
                'mail_mailer',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name',
                'favicon',
            ]);
        });
    }
};
