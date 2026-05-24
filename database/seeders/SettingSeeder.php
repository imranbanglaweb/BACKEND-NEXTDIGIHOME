<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_title' => 'Next Digi Home',
                'site_description' => 'Next Digi Home',
                'admin_title' => 'Next Digi Home',
                'admin_description' => 'Bangladesh Largest Digital Products Marketplace for Sale Premium Products',    
                'site_logo' => 'logo.png',
                'site_copyright_text' => '© 2026 Next Digi Home. All rights reserved.',
                'admin_logo' => 'logo.png',
                'status' => 1,
                'created_by' => 1,
                'default_language' => 'en',
                'available_languages' => '["en"]',
                'auto_translate' => 0,
                'translation_cache_duration' => 3600,
                // Email Settings (default values)
                'mail_mailer' => 'smtp',
                'mail_host' => 'smtp.mailtrap.io',
                'mail_port' => 2525,
                'mail_username' => null,
                'mail_password' => null,
                'mail_encryption' => 'tls',
                'mail_from_address' => 'noreply@nextdigihome.com',
                'mail_from_name' => 'Next Digi Home',
                // SEO Defaults
                'seo_enabled' => 1,
                'seo_meta_title' => 'Next Digi Home - Premium Digital Products Marketplace',
                'seo_meta_description' => 'Discover and buy premium digital products, software, templates, and courses. High-quality downloads from trusted creators.',
                'seo_meta_keywords' => 'digital products, premium software, templates, online courses, marketplace',
                'robots_meta' => 'index, follow',
                'canonical_url' => 'https://nextdigihome.com',
            ]
        );
    }
}
