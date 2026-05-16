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
