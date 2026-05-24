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
        Schema::table('settings', function (Blueprint $table) {
            // Global Frontend SEO Settings
            $table->boolean('seo_enabled')->default(true)->after('status');
            $table->string('seo_meta_title')->nullable()->after('seo_enabled');
            $table->text('seo_meta_description')->nullable()->after('seo_meta_title');
            $table->string('seo_meta_keywords')->nullable()->after('seo_meta_description');
            
            // Open Graph
            $table->string('seo_og_title')->nullable()->after('seo_meta_keywords');
            $table->text('seo_og_description')->nullable()->after('seo_og_title');
            $table->string('seo_og_image')->nullable()->after('seo_og_description');
            
            // Twitter Cards
            $table->string('seo_twitter_title')->nullable()->after('seo_og_image');
            $table->text('seo_twitter_description')->nullable()->after('seo_twitter_title');
            $table->string('seo_twitter_image')->nullable()->after('seo_twitter_description');
            
            // Analytics & Verification
            $table->string('google_analytics_id')->nullable()->after('seo_twitter_image');
            $table->string('google_search_console_verification')->nullable()->after('google_analytics_id');
            $table->string('bing_webmaster_verification')->nullable()->after('google_search_console_verification');
            
            // Other SEO
            $table->string('robots_meta')->default('index, follow')->after('bing_webmaster_verification');
            $table->string('canonical_url')->nullable()->after('robots_meta');
            $table->text('custom_head_scripts')->nullable()->after('canonical_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_enabled',
                'seo_meta_title',
                'seo_meta_description',
                'seo_meta_keywords',
                'seo_og_title',
                'seo_og_description',
                'seo_og_image',
                'seo_twitter_title',
                'seo_twitter_description',
                'seo_twitter_image',
                'google_analytics_id',
                'google_search_console_verification',
                'bing_webmaster_verification',
                'robots_meta',
                'canonical_url',
                'custom_head_scripts',
            ]);
        });
    }
};
