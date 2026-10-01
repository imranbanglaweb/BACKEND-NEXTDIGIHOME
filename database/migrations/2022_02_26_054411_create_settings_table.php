<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->string('site_title', 250)->nullable();
            $table->text('site_description')->nullable();
            $table->string('admin_title', 250)->nullable();
            $table->text('admin_description')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_copyright_text')->nullable();
            $table->string('admin_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();

            // Language & Translation Settings
            $table->string('default_language', 10)->default('en');
            $table->text('available_languages')->nullable()->comment('JSON array of available language codes');
            $table->boolean('auto_translate')->default(false);
            $table->integer('translation_cache_duration')->default(3600)->comment('Cache duration in seconds');

            // Email Configuration
            $table->string('mail_mailer', 50)->default('smtp');
            $table->string('mail_host', 100)->nullable();
            $table->integer('mail_port')->nullable();
            $table->string('mail_username', 100)->nullable();
            $table->text('mail_password')->nullable();
            $table->string('mail_encryption', 20)->nullable();
            $table->string('mail_from_address', 100)->nullable();
            $table->string('mail_from_name', 100)->nullable();

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
        Schema::dropIfExists('settings');
    }
}
