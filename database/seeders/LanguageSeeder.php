<?php

// database/seeders/LanguageSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use Illuminate\Support\Facades\DB;
class LanguageSeeder extends Seeder
{
    
public function run()
        {
            $languages = [
                [
                    'code' => 'en',
                    'name' => 'English',
                    'native_name' => 'English',
                    'direction' => 'ltr',
                    'is_default' => true,
                    'is_active' => true,
                    'flag_icon' => 'us',
                    'sort_order' => 1
                ],
                [
                    'code' => 'bn',
                    'name' => 'Bengali',
                    'native_name' => 'বাংলা',
                    'direction' => 'ltr',
                    'is_default' => false,
                    'is_active' => true,
                    'flag_icon' => 'bd',
                    'sort_order' => 2
                ],
                [
                    'code' => 'ar',
                    'native_name' => 'العربية',
                    'name' => 'Arabic',
                    'direction' => 'rtl',
                    'is_default' => false,
                    'is_active' => true,
                    'flag_icon' => 'sa',
                    'sort_order' => 3
                ],
                [
                    'code' => 'hi',
                    'name' => 'Hindi',
                    'native_name' => 'हिन्दी',
                    'direction' => 'ltr',
                    'is_default' => false,
                    'is_active' => true,
                    'flag_icon' => 'in',
                    'sort_order' => 4
                ]
            ];

            foreach ($languages as $language) {
                DB::table('languages')->updateOrInsert(
                    ['code' => $language['code']],
                    $language
                );
            }

            // Seed default translations
            $translations = [
                ['group' => 'frontend', 'key' => 'welcome_message', 'text' => 'Welcome to our application'],
                ['group' => 'frontend', 'key' => 'login_button', 'text' => 'Login'],
                ['group' => 'frontend', 'key' => 'register_button', 'text' => 'Register'],
                ['group' => 'frontend', 'key' => 'home_menu', 'text' => 'Home'],
                ['group' => 'frontend', 'key' => 'about_menu', 'text' => 'About Us'],
                ['group' => 'frontend', 'key' => 'contact_menu', 'text' => 'Contact'],
                ['group' => 'frontend', 'key' => 'dashboard', 'text' => 'Dashboard'],
                ['group' => 'frontend', 'key' => 'profile', 'text' => 'Profile'],
                ['group' => 'frontend', 'key' => 'logout', 'text' => 'Logout'],
                ['group' => 'frontend', 'key' => 'search_placeholder', 'text' => 'Search...'],
                ['group' => 'frontend', 'key' => 'copyright', 'text' => 'All rights reserved'],
            ];
            
            foreach($translations as $trans) {
                DB::table('translations')->updateOrInsert(
                    ['group' => $trans['group'], 'key' => $trans['key']],
                    $trans
                );
            }
        }
}
