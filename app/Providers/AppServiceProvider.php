<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Requisition;
use App\Observers\RequisitionObserver;
use App\Services\CustomTranslationLoader;
use App\Services\MenuService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Admin Settings Helper Functions
 * These functions retrieve admin settings from the database for use in email templates and views
 */
if (! function_exists('admin_title')) {
    /**
     * Get admin title from settings
     */
    function admin_title()
    {
        // Try to get from config first (cached)
        if (config('admin_settings.admin_title')) {
            return config('admin_settings.admin_title');
        }
        // Fallback to database query
        $settings = DB::table('settings')->where('id', 1)->first();

        return $settings->admin_title ?? 'Transport Management System';
    }
}

if (! function_exists('admin_description')) {
    /**
     * Get admin description from settings
     */
    function admin_description()
    {
        // Try to get from config first (cached)
        if (config('admin_settings.admin_description')) {
            return config('admin_settings.admin_description');
        }
        // Fallback to database query
        $settings = DB::table('settings')->where('id', 1)->first();

        return $settings->admin_description ?? 'Fleet Management Solution';
    }
}

if (! function_exists('admin_logo_url')) {
    /**
     * Get admin logo URL from settings
     */
    function admin_logo_url()
    {
        // Try to get from config first (cached)
        if (config('admin_settings.admin_logo_url')) {
            return config('admin_settings.admin_logo_url');
        }
        // Fallback to database query
        $settings = DB::table('settings')->where('id', 1)->first();
        if (! empty($settings->admin_logo)) {
            return asset('public/admin_resource/assets/images/'.$settings->admin_logo);
        }

        // Return default logo
        return asset('public/admin_resource/assets/images/default.png');
    }
}

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Nothing related to translator here ✅
    }

    public function boot()
    {
        // Load admin settings into config
        $this->loadAdminSettings();

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        \URL::forceRootUrl(config('app.url'));

        // Custom translation loader
        $this->app->extend('translation.loader', function ($loader, $app) {
            return new CustomTranslationLoader($app['files'], $app['path.lang']);
        });

        /**
         * Load admin settings into config for caching
         */
        $this->loadAdminSettings();

        /**
         * Register Requisition Observer (disabled for performance)
         */
        // Requisition::observe(RequisitionObserver::class);

        /**
         * Sidebar menus
         */
        // view()->composer(
        //     ['admin.dashboard.dashboard', 'admin.dashboard.common.sidebar'],
        //     function ($view) {
        //         $sidebar_menus = Menu::orderBy('id', 'ASC')
        //             ->where('menu_parent', 0)
        //             ->get();

        //         $view->with('sidebar_menus', $sidebar_menus);
        //     }
        // );

        View::composer(
            'admin.dashboard.common.sidebar',
            function ($view) {
                $user = auth()->user();
                $isSuperAdmin = $user->hasRole('Super Admin');
                $isAdmin = $user->hasRole('Super Admin') || $user->hasRole('Admin');
                $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
                $isTransport = $user->hasRole('Transport');
                $isEmployee = $user->hasRole('Employee');

                // Get employee data if user has an employee profile
                $employee = null;
                if ($user->employee_id) {
                    $employee = \App\Models\Employee::with(['department', 'unit', 'location', 'company'])
                        ->where('id', $user->employee_id)
                        ->first();
                }

                $view->with([
                    'sidebar_menus' => MenuService::sidebar(),
                    'isSuperAdmin' => $isSuperAdmin,
                    'isAdmin' => $isAdmin,
                    'isManager' => $isManager,
                    'isTransport' => $isTransport,
                    'isEmployee' => $isEmployee,
                    'employee' => $employee,
                ]);
            }
        );

        View::composer('admin.dashboard.admin.dashboard',
            function ($view) {
                $user = auth()->user();
                $isSuperAdmin = $user->hasRole('Super Admin');
                $isAdmin = $user->hasRole('Super Admin') || $user->hasRole('Admin');
                $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
                $isTransport = $user->hasRole('Transport');
                $isEmployee = $user->hasRole('Employee');

                // Fallback to 'role' column if no Spatie role is assigned
                if (! $isAdmin && ! $isManager && ! $isTransport && ! $isEmployee) {
                    $userRole = $user->role ?? 'employee';
                    $isAdmin = ($userRole === 'admin');
                    $isManager = ($userRole === 'manager');
                    $isTransport = ($userRole === 'transport');
                    $isEmployee = ($userRole === 'employee');
                }

                // Force employee flag for regular users without specific roles
                if (! $isAdmin && ! $isManager && ! $isTransport) {
                    $isEmployee = true;
                }

                $view->with([
                    'sidebar_menus' => MenuService::sidebar(),
                    'isSuperAdmin' => $isSuperAdmin,
                    'isAdmin' => $isAdmin,
                    'isManager' => $isManager,
                    'isTransport' => $isTransport,
                    'isEmployee' => $isEmployee,
                ]);
            }
        );

        /**
         * Settings - for both auth and non-auth pages
         */
        view()->composer(
            ['admin.dashboard.common.header', 'admin.dashboard.common.sidebar', 'admin.dashboard.master', 'admin.dashboard.public.pricing'],
            function ($view) {
                $settings = DB::table('settings')->where('id', 1)->first();

                // For non-authenticated users, only pass settings
                if (! auth()->check()) {
                    $view->with('settings', $settings);

                    return;
                }

                $user = auth()->user();
                $isSuperAdmin = $user->hasRole('Super Admin');
                $isAdmin = $user->hasRole('Super Admin') || $user->hasRole('Admin');
                $isManager = $user->hasRole('Department Head') || $user->hasRole('Manager');
                $isTransport = $user->hasRole('Transport');
                $isEmployee = $user->hasRole('Employee');

                // Get employee data if user has an employee profile
                $employee = null;
                if ($user->employee_id) {
                    $employee = \App\Models\Employee::with(['department', 'unit', 'location', 'company'])
                        ->where('id', $user->employee_id)
                        ->first();
                }

                $view->with([
                    'settings' => $settings,
                    'isSuperAdmin' => $isSuperAdmin,
                    'isAdmin' => $isAdmin,
                    'isManager' => $isManager,
                    'isTransport' => $isTransport,
                    'isEmployee' => $isEmployee,
                    'employee' => $employee,
                ]);
            }
        );

        /**
         * Mail theme
         */
        Config::set('mail.markdown.theme', 'default');
        Config::set('mail.markdown.paths', [resource_path('views/vendor/mail')]);

        /**
         * RTL / LTR helpers
         */
        Blade::if('rtl', function () {
            return session('direction', 'ltr') === 'rtl';
        });

        Blade::if('ltr', function () {
            return session('direction', 'ltr') === 'rtl';
        });
    }

    /**
     * Load admin settings into config for caching/performance
     */
    private function loadAdminSettings()
    {
        try {
            $settings = DB::table('settings')->where('id', 1)->first();

            if ($settings) {
                // Set admin title
                $adminTitle = ! empty($settings->admin_title)
                    ? $settings->admin_title
                    : 'Transport Management System';

                // Set admin description
                $adminDescription = ! empty($settings->admin_description)
                    ? $settings->admin_description
                    : 'Fleet Management Solution';

                // Set admin logo URL
                $adminLogoUrl = ! empty($settings->admin_logo)
                    ? asset('public/admin_resource/assets/images/'.$settings->admin_logo)
                    : asset('public/admin_resource/assets/images/default.png');

                // Merge into config
                Config::set('admin_settings', [
                    'admin_title' => $adminTitle,
                    'admin_description' => $adminDescription,
                    'admin_logo_url' => $adminLogoUrl,
                    'admin_logo' => $settings->admin_logo ?? 'default.png',
                    'site_name' => $settings->site_name ?? $adminTitle,
                    'site_description' => $settings->site_description ?? $adminDescription,
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail if settings table doesn't exist or has issues
        }
    }
}
