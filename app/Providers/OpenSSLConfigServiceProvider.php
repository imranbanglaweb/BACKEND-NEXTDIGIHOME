<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OpenSSLConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Set OpenSSL config path for Windows XAMPP
        // This must be done early before any OpenSSL operations
        if (PHP_OS === 'WINNT') {
            $opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
            if (file_exists($opensslPath)) {
                // Set for current process
                putenv('OPENSSL_CONF=' . $opensslPath);
                $_ENV['OPENSSL_CONF'] = $opensslPath;
                
                // Also set in $_SERVER for wider compatibility
                $_SERVER['OPENSSL_CONF'] = $opensslPath;
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
