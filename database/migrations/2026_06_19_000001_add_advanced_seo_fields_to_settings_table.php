<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'seo_focus_keyword')) {
                $table->string('seo_focus_keyword')->nullable()->after('seo_meta_keywords');
            }
            if (!Schema::hasColumn('settings', 'seo_secondary_keywords')) {
                $table->text('seo_secondary_keywords')->nullable()->after('seo_focus_keyword');
            }
            if (!Schema::hasColumn('settings', 'seo_readability_target')) {
                $table->string('seo_readability_target')->nullable()->after('seo_secondary_keywords');
            }
            if (!Schema::hasColumn('settings', 'seo_content_score_target')) {
                $table->unsignedTinyInteger('seo_content_score_target')->nullable()->after('seo_readability_target');
            }
            if (!Schema::hasColumn('settings', 'schema_type')) {
                $table->string('schema_type')->nullable()->after('custom_head_scripts');
            }
            if (!Schema::hasColumn('settings', 'organization_name')) {
                $table->string('organization_name')->nullable()->after('schema_type');
            }
            if (!Schema::hasColumn('settings', 'organization_phone')) {
                $table->string('organization_phone')->nullable()->after('organization_name');
            }
            if (!Schema::hasColumn('settings', 'organization_address')) {
                $table->text('organization_address')->nullable()->after('organization_phone');
            }
            if (!Schema::hasColumn('settings', 'sitemap_url')) {
                $table->string('sitemap_url')->nullable()->after('organization_address');
            }
            if (!Schema::hasColumn('settings', 'robots_txt_rules')) {
                $table->text('robots_txt_rules')->nullable()->after('sitemap_url');
            }
            if (!Schema::hasColumn('settings', 'semrush_project_url')) {
                $table->string('semrush_project_url')->nullable()->after('robots_txt_rules');
            }
            if (!Schema::hasColumn('settings', 'semrush_api_key')) {
                $table->string('semrush_api_key')->nullable()->after('semrush_project_url');
            }
            if (!Schema::hasColumn('settings', 'ahrefs_site_audit_url')) {
                $table->string('ahrefs_site_audit_url')->nullable()->after('semrush_api_key');
            }
            if (!Schema::hasColumn('settings', 'facebook_domain_verification')) {
                $table->string('facebook_domain_verification')->nullable()->after('ahrefs_site_audit_url');
            }
            if (!Schema::hasColumn('settings', 'pinterest_domain_verification')) {
                $table->string('pinterest_domain_verification')->nullable()->after('facebook_domain_verification');
            }
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_focus_keyword',
                'seo_secondary_keywords',
                'seo_readability_target',
                'seo_content_score_target',
                'schema_type',
                'organization_name',
                'organization_phone',
                'organization_address',
                'sitemap_url',
                'robots_txt_rules',
                'semrush_project_url',
                'semrush_api_key',
                'ahrefs_site_audit_url',
                'facebook_domain_verification',
                'pinterest_domain_verification',
            ]);
        });
    }
};
