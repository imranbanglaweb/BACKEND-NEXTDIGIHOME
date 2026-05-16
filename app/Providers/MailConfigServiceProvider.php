<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureMail();
    }

    /**
     * Configure mail settings from database if available
     */
    protected function configureMail()
    {
        // Try to get mail config from cache first
        $mailConfig = Cache::get('mail_config');

        if (!$mailConfig) {
            // Try to get from database
            try {
                $settings = DB::table('settings')->where('id', 1)->first();

                if ($settings && !empty($settings->mail_host) && !empty($settings->mail_username)) {
                    $mailConfig = [
                        'default' => $settings->mail_mailer ?? 'smtp',
                        'mailers' => [
                            'smtp' => [
                                'transport' => 'smtp',
                                'host' => $settings->mail_host,
                                'port' => $settings->mail_port ?? 587,
                                'encryption' => $settings->mail_encryption ?? 'tls',
                                'username' => $settings->mail_username,
                                'password' => $settings->mail_password ?? '',
                                'timeout' => null,
                                'auth_mode' => null,
                            ],
                            'log' => [
                                'transport' => 'log',
                                'channel' => env('MAIL_LOG_CHANNEL'),
                            ],
                        ],
                        'from' => [
                            'address' => $settings->mail_from_address ?? 'noreply@example.com',
                            'name' => $settings->mail_from_name ?? 'System',
                        ],
                    ];

                    // Cache the config
                    Cache::put('mail_config', $mailConfig, 3600); // Cache for 1 hour
                }
            } catch (\Exception $e) {
                // Database not available or table doesn't exist, use default config
                return;
            }
        }

        // Apply the mail configuration
        if ($mailConfig) {
            Config::set('mail', $mailConfig);
        }
    }
}
