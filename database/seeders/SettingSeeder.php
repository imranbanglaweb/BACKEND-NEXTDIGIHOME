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
                'site_title' => 'NextDigiHome',
                'site_description' => 'Technology, AI, custom software engineering and digital growth solutions for modern businesses.',
                'admin_title' => 'NextDigiHome Admin',
                'admin_description' => 'NextDigiHome Technology Ecosystem & Multi-Division Management Console',
                'site_logo' => 'logo.png',
                'site_copyright_text' => '© 2026 NextDigiHome. All rights reserved.',
                'admin_logo' => 'logo.png',
                'status' => 1,
                'created_by' => 1,
                'default_language' => 'en',
                'available_languages' => '["en"]',
                'auto_translate' => 0,
                'translation_cache_duration' => 3600,
                'mail_mailer' => 'smtp',
                'mail_host' => 'smtp.mailtrap.io',
                'mail_port' => 2525,
                'mail_username' => null,
                'mail_password' => null,
                'mail_encryption' => 'tls',
                'mail_from_address' => 'info@nextdigihome.com',
                'mail_from_name' => 'NextDigiHome',
                'seo_enabled' => 1,
                'seo_meta_title' => 'NextDigiHome - Build • Launch • Automate • Grow',
                'seo_meta_description' => 'Modern digital ecosystem providing full-stack web & software solutions, autonomous AI agents, performance marketing growth, and SaaS platforms.',
                'seo_meta_keywords' => 'NextDigiHome, AI agents, software development, web development, digital growth, SaaS, ecommerce',
                'robots_meta' => 'index, follow',
                'canonical_url' => 'https://nextdigihome.com',
            ]
        );
    }
}
