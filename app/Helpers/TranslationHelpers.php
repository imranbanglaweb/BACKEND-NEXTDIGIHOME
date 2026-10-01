<?php

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

if (!function_exists('available_languages')) {
    function available_languages()
    {
        return Cache::remember('available_languages', 3600, function () {
            return Language::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }
}

if (!function_exists('current_locale')) {
    function current_locale()
    {
        return app()->getLocale();
    }
}

if (!function_exists('is_rtl')) {
    function is_rtl()
    {
        $locale = current_locale();
        return in_array($locale, ['ar', 'ur', 'fa', 'he']);
    }
}

if (!function_exists('language_direction')) {
    function language_direction()
    {
        return is_rtl() ? 'rtl' : 'ltr';
    }
}

if (!function_exists('ensure_menu_translation')) {
    function ensure_menu_translation($menuName)
    {
        $key = strtolower($menuName);
        $group = 'backend';
        
        // Check if translation exists
        $translation = \DB::table('translations')
            ->where('group', $group)
            ->where('key', $key)
            ->first();
            
        if (!$translation) {
            // Create translation for all active languages
            $languages = available_languages();
            $translationService = app(\App\Services\TranslationService::class);
            
            foreach ($languages as $language) {
                $translationService->set($key, $menuName, $group, $language->code);
            }
        }
        
        return 'backend.' . $key;
    }
}