<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

if (!function_exists('routeBase')) {
    function routeBase($route)
    {
        $segments = explode('.', $route);
        if (count($segments) > 1) {
            array_pop($segments);
            return implode('.', $segments);
        }
        return $route;
    }
}

if (!function_exists('isActiveUrl')) {
    function isActiveUrl($routeName)
    {
        if (!$routeName) return '';

        return request()->routeIs($routeName)
            ? 'nav-active active'
            : '';
    }
}

if (!function_exists('isMenuOpen')) {
    function isMenuOpen($menus)
    {
        $current = Route::currentRouteName();

        foreach ($menus as $menu) {

            if ($menu->menu_url &&
                routeBase($menu->menu_url) === routeBase($current)) {
                return 'nav-expanded nav-active';
            }

            $children = DB::table('menus')
                ->where('menu_parent', $menu->id)
                ->get();

            foreach ($children as $child) {
                if ($child->menu_url &&
                    routeBase($child->menu_url) === routeBase($current)) {
                    return 'nav-expanded nav-active';
                }
            }
        }

        return '';
    }
}

if (!function_exists('admin_logo_url')) {
    /**
     * Get admin logo URL dynamically from settings or brand assets
     */
    function admin_logo_url()
    {
        try {
            $settings = DB::table('settings')->where('id', 1)->first();

            // 1. Direct admin_logo from settings
            if ($settings && !empty($settings->admin_logo)) {
                $candidate = 'public/admin_resource/assets/images/' . $settings->admin_logo;
                if (file_exists(public_path('admin_resource/assets/images/' . $settings->admin_logo)) || file_exists(base_path($candidate))) {
                    return asset($candidate);
                }
            }

            // 2. Direct site_logo from settings
            if ($settings && !empty($settings->site_logo)) {
                $candidate = 'public/admin_resource/assets/images/' . $settings->site_logo;
                if (file_exists(public_path('admin_resource/assets/images/' . $settings->site_logo)) || file_exists(base_path($candidate))) {
                    return asset($candidate);
                }
            }

            // 3. Generic logo in uploads/logo
            if ($settings && !empty($settings->logo)) {
                $candidate = 'public/uploads/logo/' . $settings->logo;
                if (file_exists(public_path('uploads/logo/' . $settings->logo)) || file_exists(base_path($candidate))) {
                    return asset($candidate);
                }
            }

            // 4. Default brand logo fallbacks
            if (file_exists(public_path('admin_resource/assets/images/logo.png'))) {
                return asset('public/admin_resource/assets/images/logo.png');
            }

            if (file_exists(public_path('admin_resource/assets/images/vault-logo.webp'))) {
                return asset('public/admin_resource/assets/images/vault-logo.webp');
            }

            if (file_exists(public_path('images/vault-logo.webp'))) {
                return asset('public/images/vault-logo.webp');
            }
        } catch (\Throwable $e) {
            // Silently fallback
        }

        return null;
    }
}

if (!function_exists('app_favicon_url')) {
    /**
     * Get active favicon URL dynamically (uses uploaded favicon, or falls back to brand logo)
     */
    function app_favicon_url()
    {
        try {
            $settings = DB::table('settings')->where('id', 1)->first();

            // 1. Direct favicon from settings
            if ($settings && !empty($settings->favicon)) {
                $candidate = 'public/admin_resource/assets/images/' . $settings->favicon;
                if (file_exists(public_path('admin_resource/assets/images/' . $settings->favicon)) || file_exists(base_path($candidate))) {
                    return asset($candidate);
                }
            }

            // 2. Fallback: Use brand logo as favicon in admin & frontend!
            $logoUrl = admin_logo_url();
            if (!empty($logoUrl)) {
                return $logoUrl;
            }

            // 3. Fallback to favicon.ico in root if exists
            if (file_exists(public_path('favicon.ico'))) {
                return asset('favicon.ico');
            }

            // 4. Default fallback to logo.png
            if (file_exists(public_path('admin_resource/assets/images/logo.png'))) {
                return asset('public/admin_resource/assets/images/logo.png');
            }
        } catch (\Throwable $e) {
            // Silently fallback
        }

        return null;
    }
}

