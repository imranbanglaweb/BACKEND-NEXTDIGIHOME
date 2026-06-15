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
        Schema::table('products', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('published_at');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->text('seo_keywords')->nullable()->after('seo_description');
            $table->string('canonical_url')->nullable()->after('seo_keywords');
            $table->string('og_title')->nullable()->after('canonical_url');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->boolean('robots_index')->default(true)->after('og_image');
            $table->boolean('robots_follow')->default(true)->after('robots_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title',
                'seo_description',
                'seo_keywords',
                'canonical_url',
                'og_title',
                'og_description',
                'og_image',
                'robots_index',
                'robots_follow',
            ]);
        });
    }
};
