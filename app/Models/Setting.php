<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;


     protected $table = 'settings';

        protected $fillable = [
        'id',
        'site_title',
        'site_description',
        'admin_title',
        'admin_description',
        'site_logo',
        'site_copyright_text',
        'admin_logo',
        'favicon',
        'status',
        'created_by',
        'default_language',
        'available_languages',
        'auto_translate',
        'translation_cache_duration',
        // Email Settings
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        // Email Templates
        'welcome_email_template',
        'order_confirmation_template',
        'password_reset_template',
        // SEO Settings
        'seo_enabled',
        'seo_meta_title',
        'seo_meta_description',
        'seo_meta_keywords',
        'seo_focus_keyword',
        'seo_secondary_keywords',
        'seo_readability_target',
        'seo_content_score_target',
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
    ];
}
