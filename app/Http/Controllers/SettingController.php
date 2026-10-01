<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settings-manage')->only(['index', 'store']);
        $this->middleware('permission:settings-notification')->only(['notification']);
    }

    public function index()
    {
           // $menus = Menu::orderBy('menu_oder','ASC')->paginate(100);

        $settings = DB::table('settings')->where('id',1)->first();
        $languages = DB::table('languages')->orderBy('name')->get();
        return view('admin.dashboard.settings.index', compact('settings', 'languages'));
    }

    public function notification()
    {
        return view('admin.dashboard.settings.notifications');
    }


    public function loadLanguages()
    {
        // Logic to load languages for settings dropdown
        if (class_exists(\App\Models\Language::class)) {
            return \App\Models\Language::all();
        }
        return [];
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'admin_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'favicon'    => 'nullable|file|mimes:ico,png,jpg,jpeg,svg,webp,gif|max:5120',
            ]);

            // Try to find the setting with ID 1, or create a new one if it doesn't exist.
            $setting = Setting::find(1);
            if (!$setting) {
                $setting = new Setting();
                $setting->id = 1; // Explicitly set ID for the first record
            }

            // Define the image directory path
            $imageDirectory = public_path('admin_resource/assets/images');
            
            // Create directory if it doesn't exist
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }

            // Process Admin Logo upload
            if ($request->hasFile('admin_logo')) {
                $file = $request->file('admin_logo');
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $admin_logo = 'logo_' . time() . '.' . strtolower($extension);
                $file->move($imageDirectory, $admin_logo);
                $setting->admin_logo = $admin_logo;
            }

            // Process Favicon upload (supports PNG, ICO, SVG, WEBP, JPG)
            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                $extension = $file->getClientOriginalExtension() ?: 'ico';
                $favicon = 'favicon_' . time() . '.' . strtolower($extension);
                $file->move($imageDirectory, $favicon);
                $setting->favicon = $favicon;
            }

            // Only update text fields if provided
            if ($request->filled('admin_title')) {
                $setting->admin_title = $request->admin_title;
            }
            if ($request->filled('admin_description')) {
                $setting->admin_description = $request->admin_description;
            }

            // Language Settings
            if ($request->has('default_language')) {
                $setting->default_language = $request->default_language ?? 'en';
            }
            if ($request->has('available_languages')) {
                $setting->available_languages = $request->available_languages ? json_encode($request->available_languages) : json_encode(['en']);
            }
            if ($request->has('auto_translate')) {
                $setting->auto_translate = $request->auto_translate ? 1 : 0;
            }
            if ($request->has('translation_cache_duration')) {
                $setting->translation_cache_duration = $request->translation_cache_duration ?? 60;
            }

            // Email Settings
            if ($request->has('mail_mailer')) {
                $setting->mail_mailer = $request->mail_mailer ?? 'smtp';
            }
            if ($request->has('mail_host')) {
                $setting->mail_host = $request->mail_host ?? 'smtp.gmail.com';
            }
            if ($request->has('mail_port')) {
                $setting->mail_port = $request->mail_port ?? 587;
            }
            if ($request->has('mail_username')) {
                $setting->mail_username = $request->mail_username ?? '';
            }
            if ($request->has('mail_password')) {
                $setting->mail_password = $request->mail_password ?? '';
            }
            if ($request->has('mail_encryption')) {
                $mailEncryption = $request->input('mail_encryption');
                $setting->mail_encryption = $mailEncryption === 'none' ? null : $mailEncryption;
            }
            if ($request->has('mail_from_address')) {
                $setting->mail_from_address = $request->mail_from_address ?? '';
            }
            if ($request->has('mail_from_name')) {
                $setting->mail_from_name = $request->mail_from_name ?? '';
            }

            $setting->created_by = Auth::id() ?: 1;
            $setting->save();

            // Clear all relevant caches
            Cache::forget('site_settings');
            Cache::forget('admin_settings');
            Cache::forget('mail_config');

            return response()->json([
                'success' => true,
                'message' => 'Settings Updated Successfully',
                'favicon_url' => app_favicon_url(),
                'logo_url' => admin_logo_url(),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            \Log::error('Settings update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear translation cache
     */
    public function clearTranslationCache()
    {
        try {
            Cache::forget('translations');
            Cache::forget('translation_keys');
            
            // Also clear any language-specific caches
            $languages = ['en', 'ar', 'fr', 'es', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko'];
            foreach ($languages as $lang) {
                Cache::forget("translations_{$lang}");
            }
            
            return response()->json(['success' => true, 'message' => 'Translation cache cleared successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to clear translation cache: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to clear translation cache'], 500);
        }
    }

        public function syncLanguages()
        {
        try {
            // Get available languages from settings
            $settings = DB::table('settings')->where('id', 1)->first();
            $availableLanguages = json_decode($settings->available_languages ?? '["en"]', true);
            
            // Ensure all available languages exist in languages table
            foreach ($availableLanguages as $langCode) {
                DB::table('languages')->updateOrInsert(
                    ['code' => $langCode],
                    [
                        'name' => $this->getLanguageName($langCode),
                        'is_active' => 1,
                        'is_default' => ($langCode === ($settings->default_language ?? 'en')),
                        'updated_at' => now()
                    ]
                );
            }
            
            // Clear translation cache to force reload
            $this->clearTranslationCache();
            
            return response()->json(['success' => true, 'message' => 'Languages synchronized successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to sync languages: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to sync languages'], 500);
        }
    }

    /**
     * Get language name from code
     */
    private function getLanguageName($code)
    {
        $languages = [
            'en' => 'English',
            'ar' => 'العربية',
            'fr' => 'Français',
            'es' => 'Español',
            'de' => 'Deutsch',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ru' => 'Русский',
            'zh' => '中文',
            'ja' => '日本語',
            'ko' => '한국어'
        ];
        
        return $languages[$code] ?? ucfirst($code);
    }

    /**
     * Clear mail configuration cache
     */
    public function clearMailConfigCache()
    {
        try {
            Cache::forget('mail_config');
            
            return response()->json(['success' => true, 'message' => 'Mail configuration cache cleared successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to clear mail config cache: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to clear cache'], 500);
        }
    }

    /**
     * Get current mail configuration
     */
    public function getMailConfig()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        
        return [
            'mailer' => $settings->mail_mailer ?? config('mail.default'),
            'host' => $settings->mail_host ?? config('mail.mailers.smtp.host'),
            'port' => $settings->mail_port ?? config('mail.mailers.smtp.port'),
            'username' => $settings->mail_username ?? config('mail.mailers.smtp.username'),
            'encryption' => in_array($settings->mail_encryption, ['tls', 'ssl'], true) ? $settings->mail_encryption : null,
            'from_address' => $settings->mail_from_address ?? config('mail.from.address'),
            'from_name' => $settings->mail_from_name ?? config('mail.from.name'),
        ];
    }

    /**
     * Get logo URL and title for email templates
     */
    public function getLogo()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        //  dd($settings);
        $logoUrl = null;
        if ($settings && $settings->admin_logo) {
            $logoUrl = asset('public/admin_resource/assets/images/' . $settings->admin_logo);
            // dd($logoUrl);
        }
        
        $adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
        
        return response()->json([
            'logo_url' => $logoUrl,
            'admin_title' => $adminTitle
        ]);
    }
}
