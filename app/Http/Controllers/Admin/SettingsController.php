<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || (!$user->can('settings-manage') && !$user->can('seo-manage'))) {
                abort(403, 'You do not have permission to manage settings or SEO.');
            }
            return $next($request);
        });
    }

    /**
     * Display general settings.
     */
    public function general()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('admin.settings.general', compact('settings'));
    }

    /**
     * Display email settings.
     */
    public function email()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Display payment settings.
     */
    public function payments()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('admin.settings.payments', compact('settings'));
    }

    /**
     * Display languages settings.
     */
    public function languages()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        $languages = DB::table('languages')->orderBy('name')->get();
        return view('admin.settings.languages', compact('settings', 'languages'));
    }

    /**
     * Display notifications settings.
     */
    public function notifications()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('admin.settings.notifications', compact('settings'));
    }

    /**
     * Display security settings.
     */
    public function security()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('admin.settings.security', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_title' => 'required|string|max:255',
            'admin_description' => 'nullable|string|max:500',
            'admin_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        try {
            $setting = DB::table('settings')->where('id', 1)->first();

            $data = [
                'admin_title' => $request->admin_title,
                'admin_description' => $request->admin_description,
                'updated_at' => now(),
            ];

            // Handle logo upload
            if ($request->hasFile('admin_logo')) {
                $imageDirectory = public_path('admin_resource/assets/images');
                if (!file_exists($imageDirectory)) {
                    mkdir($imageDirectory, 0755, true);
                }

                $imageName = time() . '.' . $request->admin_logo->extension();
                $request->admin_logo->move($imageDirectory, $imageName);
                $data['admin_logo'] = $imageName;
            }

            if ($setting) {
                DB::table('settings')->where('id', 1)->update($data);
            } else {
                $data['id'] = 1;
                $data['created_at'] = now();
                DB::table('settings')->insert($data);
            }

            // Clear relevant caches
            Cache::forget('site_settings');
            Cache::forget('admin_settings');

            return response()->json(['success' => true, 'message' => 'General settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update general settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update settings'], 500);
        }
    }

    /**
     * Update email settings.
     */
    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|in:tls,ssl,none',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        try {
            $data = [
                'mail_mailer' => $request->mail_mailer,
                'mail_host' => $request->mail_host,
                'mail_port' => $request->mail_port,
                'mail_username' => $request->mail_username,
                'mail_password' => $request->mail_password,
                'mail_encryption' => $request->mail_encryption === 'none' ? null : $request->mail_encryption,
                'mail_from_address' => $request->mail_from_address,
                'mail_from_name' => $request->mail_from_name,
                'updated_at' => now(),
            ];

            DB::table('settings')->where('id', 1)->update($data);

            // Clear mail config cache
            Cache::forget('mail_config');
            Artisan::call('config:clear');

            return response()->json(['success' => true, 'message' => 'Email settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update email settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update email settings'], 500);
        }
    }

    /**
     * Send a test email using the saved mail settings.
     */
    public function sendTestEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        try {
            $settings = DB::table('settings')->where('id', 1)->first();

            if ($settings) {
                Config::set('mail.default', $settings->mail_mailer ?? config('mail.default', 'smtp'));
                Config::set('mail.from.address', $settings->mail_from_address ?: config('mail.from.address'));
                Config::set('mail.from.name', $settings->mail_from_name ?: config('mail.from.name'));

                if (($settings->mail_mailer ?? 'smtp') === 'smtp') {
                    Config::set('mail.mailers.smtp.host', $settings->mail_host);
                    Config::set('mail.mailers.smtp.port', $settings->mail_port ?? 587);
                    Config::set('mail.mailers.smtp.encryption', $settings->mail_encryption);
                    Config::set('mail.mailers.smtp.username', $settings->mail_username);
                    Config::set('mail.mailers.smtp.password', $settings->mail_password);
                }
            }

            Mail::raw('This is a test email from your application email settings page.', function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Test Email');
            });

            return response()->json(['success' => true, 'message' => 'Test email sent successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to send test email: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update payment settings.
     */
    public function updatePayments(Request $request)
    {
        try {
            $data = [
                'stripe_publishable_key' => $request->stripe_publishable_key,
                'stripe_secret_key' => $request->stripe_secret_key,
                'paypal_client_id' => $request->paypal_client_id,
                'paypal_client_secret' => $request->paypal_client_secret,
                'payment_currency' => $request->payment_currency ?? 'USD',
                'payment_mode' => $request->payment_mode ?? 'sandbox',
                'updated_at' => now(),
            ];

            DB::table('settings')->where('id', 1)->update($data);

            // Clear payment config cache
            Cache::forget('payment_config');

            return response()->json(['success' => true, 'message' => 'Payment settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update payment settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update payment settings'], 500);
        }
    }

    /**
     * Update language settings.
     */
    public function updateLanguages(Request $request)
    {
        try {
            $data = [
                'default_language' => $request->default_language ?? 'en',
                'available_languages' => $request->available_languages ? json_encode($request->available_languages) : json_encode(['en']),
                'auto_translate' => $request->auto_translate ? 1 : 0,
                'translation_cache_duration' => $request->translation_cache_duration ?? 60,
                'updated_at' => now(),
            ];

            DB::table('settings')->where('id', 1)->update($data);

            // Clear translation cache
            Cache::forget('translations');
            Cache::forget('translation_keys');

            return response()->json(['success' => true, 'message' => 'Language settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update language settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update language settings'], 500);
        }
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        try {
            $data = [
                'email_notifications' => $request->email_notifications ? 1 : 0,
                'push_notifications' => $request->push_notifications ? 1 : 0,
                'sms_notifications' => $request->sms_notifications ? 1 : 0,
                'notification_email' => $request->notification_email,
                'updated_at' => now(),
            ];

            DB::table('settings')->where('id', 1)->update($data);

            return response()->json(['success' => true, 'message' => 'Notification settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update notification settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update notification settings'], 500);
        }
    }

    /**
     * Update security settings.
     */
    public function updateSecurity(Request $request)
    {
        try {
            $data = [
                'password_min_length' => $request->password_min_length ?? 8,
                'password_require_uppercase' => $request->password_require_uppercase ? 1 : 0,
                'password_require_lowercase' => $request->password_require_lowercase ? 1 : 0,
                'password_require_numbers' => $request->password_require_numbers ? 1 : 0,
                'password_require_symbols' => $request->password_require_symbols ? 1 : 0,
                'session_timeout' => $request->session_timeout ?? 7200,
                'max_login_attempts' => $request->max_login_attempts ?? 5,
                'lockout_duration' => $request->lockout_duration ?? 900,
                'two_factor_auth' => $request->two_factor_auth ? 1 : 0,
                'updated_at' => now(),
            ];

            DB::table('settings')->where('id', 1)->update($data);

            return response()->json(['success' => true, 'message' => 'Security settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update security settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update security settings'], 500);
        }
    }

    /**
     * Display SEO settings.
     */
    public function seo()
    {
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('admin.marketing.seo', compact('settings'));
    }

    /**
     * Update SEO settings for frontend site.
     */
    public function updateSeo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seo_meta_title' => 'nullable|string|max:70',
            'seo_meta_description' => 'nullable|string|max:180',
            'seo_meta_keywords' => 'nullable|string|max:500',
            'seo_og_title' => 'nullable|string|max:95',
            'seo_og_description' => 'nullable|string|max:220',
            'seo_og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'seo_twitter_title' => 'nullable|string|max:95',
            'seo_twitter_description' => 'nullable|string|max:220',
            'seo_twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'google_analytics_id' => 'nullable|string|max:50',
            'google_search_console_verification' => 'nullable|string|max:255',
            'bing_webmaster_verification' => 'nullable|string|max:255',
            'robots_meta' => 'nullable|in:index, follow,noindex, follow,index, nofollow,noindex, nofollow',
            'canonical_url' => 'nullable|url|max:255',
            'custom_head_scripts' => 'nullable|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fix the highlighted SEO fields.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = [
                'seo_enabled' => $request->seo_enabled ? 1 : 0,
                'seo_meta_title' => $request->input('seo_meta_title'),
                'seo_meta_description' => $request->input('seo_meta_description'),
                'seo_meta_keywords' => $request->input('seo_meta_keywords'),
                'seo_og_title' => $request->input('seo_og_title'),
                'seo_og_description' => $request->input('seo_og_description'),
                'seo_twitter_title' => $request->input('seo_twitter_title'),
                'seo_twitter_description' => $request->input('seo_twitter_description'),
                'google_analytics_id' => $request->input('google_analytics_id'),
                'google_search_console_verification' => $request->input('google_search_console_verification'),
                'bing_webmaster_verification' => $request->input('bing_webmaster_verification'),
                'robots_meta' => $request->robots_meta ?? 'index, follow',
                'canonical_url' => $request->input('canonical_url'),
                'custom_head_scripts' => $request->input('custom_head_scripts'),
                'updated_at' => now(),
            ];

            // Handle OG image upload
            if ($request->hasFile('seo_og_image')) {
                $imageDirectory = public_path('admin_resource/assets/images');
                if (!file_exists($imageDirectory)) {
                    mkdir($imageDirectory, 0755, true);
                }

                $imageName = 'og_' . time() . '.' . $request->seo_og_image->extension();
                $request->seo_og_image->move($imageDirectory, $imageName);
                $data['seo_og_image'] = $imageName;
            }

            // Handle Twitter image upload
            if ($request->hasFile('seo_twitter_image')) {
                $imageDirectory = public_path('admin_resource/assets/images');
                if (!file_exists($imageDirectory)) {
                    mkdir($imageDirectory, 0755, true);
                }

                $imageName = 'twitter_' . time() . '.' . $request->seo_twitter_image->extension();
                $request->seo_twitter_image->move($imageDirectory, $imageName);
                $data['seo_twitter_image'] = $imageName;
            }

            $setting = DB::table('settings')->where('id', 1)->first();
            if ($setting) {
                DB::table('settings')->where('id', 1)->update($data);
            } else {
                $data['id'] = 1;
                $data['created_at'] = now();
                DB::table('settings')->insert($data);
            }

            // Clear settings cache
            Cache::forget('site_settings');

            return response()->json(['success' => true, 'message' => 'SEO settings updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update SEO settings: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update SEO settings: ' . $e->getMessage()], 500);
        }
    }
}
