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

          $validator = Validator::make($request->all(), [
                    // "site_title" => "required",
                    // "site_description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

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

        if ($request->file('admin_logo')) {
            
            $imagePath = $request->file('admin_logo');
       $request->validate([
           'admin_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
       ]);
            $imageName = $imagePath->getClientOriginalName();

            // $path = $request->file('site_logo')->storeAs('admin_resource\assets\images', $imageName, 'public');
            // $path = public_path().'//images';
            //   $imagePath->move($path, $imageName);

 $admin_logo = time().'.'.$request->admin_logo->extension();  
      
   $request->admin_logo->move($imageDirectory, $admin_logo);
        }

        if ($request->file('favicon')) {
            $faviconPath = $request->file('favicon');
            $request->validate([
                'favicon' => 'required|image|mimes:png,ico|max:5048',
            ]);
            $favicon = time().'.'.$request->favicon->extension();
            $request->favicon->move($imageDirectory, $favicon);
        }

        $setting->admin_title = $request->admin_title;
        $setting->admin_description = $request->admin_description;

        // Language Settings
        $setting->default_language = $request->default_language ?? 'en';
        $setting->available_languages = $request->available_languages ? json_encode($request->available_languages) : json_encode(['en']);
        $setting->auto_translate = $request->auto_translate ? 1 : 0;
        $setting->translation_cache_duration = $request->translation_cache_duration ?? 60;

        // Email Settings
        $setting->mail_mailer = $request->mail_mailer ?? 'smtp';
        $setting->mail_host = $request->mail_host ?? 'smtp.gmail.com';
        $setting->mail_port = $request->mail_port ?? 587;
        $setting->mail_username = $request->mail_username ?? '';
        $setting->mail_password = $request->mail_password ?? '';
        $setting->mail_encryption = $request->mail_encryption ?? 'tls';
        $setting->mail_from_address = $request->mail_from_address ?? '';
        $setting->mail_from_name = $request->mail_from_name ?? '';

        if (!empty($admin_logo)) {
            
             $setting->admin_logo = $admin_logo;
        }

        if (!empty($favicon)) {
            $setting->favicon = $favicon;
        }

        $setting->created_by = Auth::id();
        // $setting->path = '/storage/'.$path;
        $setting->save();

        return response()->json('Settings Updated Successfully');
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
            'encryption' => $settings->mail_encryption ?? config('mail.mailers.smtp.encryption'),
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
