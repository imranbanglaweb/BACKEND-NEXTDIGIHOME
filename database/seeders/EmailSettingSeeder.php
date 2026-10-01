<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class EmailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default SMTP settings (Mailtrap for development)
        $this->createEmailSetting('mailtrap', [
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => 2525,
            'mail_username' => null,
            'mail_password' => null,
            'mail_encryption' => 'tls',
            'mail_from_address' => 'noreply@example.com',
            'mail_from_name' => 'TMS',
        ]);
    }

    /**
     * Create or update email settings
     *
     * @param string $type
     * @param array $settings
     * @return void
     */
    protected function createEmailSetting(string $type, array $settings)
    {
        Setting::updateOrCreate(
            ['id' => 1],
            array_merge([
                'site_title' => 'next Digi Home',
                'site_description' => 'Next Digi Home Bd',
                'admin_title' => 'Next Digi Home Bd',
                'admin_description' => 'All-in-One Fleet & Transport Automation System',
                'site_logo' => null,
                'site_copyright_text' => '© 2026 Next Digi Home. All rights reserved.',
                'admin_logo' => null,
                'status' => 1,
                'created_by' => 1,
                'default_language' => 'en',
                'available_languages' => '["en"]',
                'auto_translate' => 0,
                'translation_cache_duration' => 3600,
            ], $settings)
        );

        $this->command->info("Email settings seeded with {$type} configuration.");
    }
}
