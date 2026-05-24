<?php

// routes/api.php
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\PublicApiController;
use App\Http\Controllers\DepartmentHeadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NotificationChannels\WebPush\PushSubscription;

// ============================================================================
// PUBLIC API ROUTES (For External Subscription System)
// ============================================================================

Route::middleware(['api'])->group(function () {
    Route::post('/register', [PublicApiController::class, 'register']);
    Route::post('/login', [PublicApiController::class, 'login']);

    // Social Login Routes
    Route::get('/auth/google', [PublicApiController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [PublicApiController::class, 'handleGoogleCallback']);
    Route::get('/auth/facebook', [PublicApiController::class, 'redirectToFacebook']);
    Route::get('/auth/facebook/callback', [PublicApiController::class, 'handleFacebookCallback']);
    Route::post('/subscribe', [PublicApiController::class, 'subscribe']);
    Route::post('/submit-payment', [PublicApiController::class, 'submitPayment']);
    Route::get('/packages', [PublicApiController::class, 'packages']);
    Route::get('/packages/{id}', [PublicApiController::class, 'packageById']);
});

// Product API Routes (public, accessible from frontend)
Route::middleware(['api'])->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('categories', [ProductController::class, 'categories']);
});

// Cart API Routes (session-based for guests)
Route::middleware(['web'])->group(function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::put('cart/{itemId}', [CartController::class, 'update']);
    Route::delete('cart/{itemId}', [CartController::class, 'destroy']);
    Route::delete('cart', [CartController::class, 'clear']);
});

// Authenticated User Routes
Route::middleware(['auth:api'])->group(function () {
    Route::get('user', function () {
        return response()->json([
            'user' => auth('api')->user(),
        ]);
    });
});

// Checkout & Purchases API Routes (require auth via token)
Route::middleware(['auth:api'])->group(function () {
    Route::post('checkout', [CheckoutController::class, 'store']);
    Route::post('checkout/verify', [CheckoutController::class, 'verify']);
    Route::get('checkout/purchases', [CheckoutController::class, 'myPurchases']);
});

// Checkout API Routes with auth (admin only)
Route::middleware(['api', 'auth'])->group(function () {
    Route::post('checkout/{id}/approve', [CheckoutController::class, 'approve']);
    Route::get('my-purchases', [CheckoutController::class, 'myPurchases']);
});

// Delivery API Routes
Route::middleware(['api'])->group(function () {
    Route::get('download', [DeliveryController::class, 'download']);
    Route::post('verify-token', [DeliveryController::class, 'verifyToken']);
});

// Content Management API Routes
Route::middleware(['api'])->group(function () {
    // Hero Sliders
    Route::apiResource('hero-sliders', App\Http\Controllers\Api\HeroSliderController::class, ['names' => [
        'index' => 'api.hero-sliders.index',
        'store' => 'api.hero-sliders.store',
        'show' => 'api.hero-sliders.show',
        'update' => 'api.hero-sliders.update',
        'destroy' => 'api.hero-sliders.destroy',
    ]]);

    // Page Content
    Route::apiResource('page-content', App\Http\Controllers\Api\PageContentController::class, ['names' => [
        'index' => 'api.page-content.index',
        'store' => 'api.page-content.store',
        'show' => 'api.page-content.show',
        'update' => 'api.page-content.update',
        'destroy' => 'api.page-content.destroy',
    ]]);
    Route::get('page-content/page/{page}', [App\Http\Controllers\Api\PageContentController::class, 'getByPage']);
    Route::get('page-content/page/{page}/{section}', [App\Http\Controllers\Api\PageContentController::class, 'getBySection']);

    // Stats
    Route::apiResource('stats', App\Http\Controllers\Api\StatsController::class, ['names' => [
        'index' => 'api.stats.index',
        'store' => 'api.stats.store',
        'show' => 'api.stats.show',
        'update' => 'api.stats.update',
        'destroy' => 'api.stats.destroy',
    ]]);

    // Testimonials
    Route::apiResource('testimonials', App\Http\Controllers\Api\TestimonialsController::class, ['names' => [
        'index' => 'api.testimonials.index',
        'store' => 'api.testimonials.store',
        'show' => 'api.testimonials.show',
        'update' => 'api.testimonials.update',
        'destroy' => 'api.testimonials.destroy',
    ]]);

    // Team Members
    Route::apiResource('team-members', App\Http\Controllers\Api\TeamController::class, ['names' => [
        'index' => 'api.team-members.index',
        'store' => 'api.team-members.store',
        'show' => 'api.team-members.show',
        'update' => 'api.team-members.update',
        'destroy' => 'api.team-members.destroy',
    ]]);

    // Contact Info
    Route::apiResource('contact-info', App\Http\Controllers\Api\ContactInfoController::class, ['names' => [
        'index' => 'api.contact-info.index',
        'store' => 'api.contact-info.store',
        'show' => 'api.contact-info.show',
        'update' => 'api.contact-info.update',
        'destroy' => 'api.contact-info.destroy',
    ]]);
    Route::get('contact-info/type/{type}', [App\Http\Controllers\Api\ContactInfoController::class, 'getByType']);

    // Content Management (for frontend)
    Route::get('content/home', [App\Http\Controllers\Api\ContentManagementController::class, 'getHomeContent']);
    Route::get('content/about', [App\Http\Controllers\Api\ContentManagementController::class, 'getAboutContent']);
    Route::get('content/contact', [App\Http\Controllers\Api\ContentManagementController::class, 'getContactContent']);
    Route::get('content/privacy', [App\Http\Controllers\Api\ContentManagementController::class, 'getPrivacyContent']);
    Route::get('content/terms', [App\Http\Controllers\Api\ContentManagementController::class, 'getTermsContent']);
    Route::get('content/all', [App\Http\Controllers\Api\ContentManagementController::class, 'getAllContent']);
});

// ============================================================================
// GPS TRACKING API ROUTES (For Mobile App)
// ============================================================================

// Test route to verify API is working
Route::get('/test', function () {
    return response()->json(['status' => 'ok', 'message' => 'API is working']);
});

Route::prefix('gps')->group(function () {
    // Device registration
    Route::post('/device/register', 'GpsTrackingController@registerDevice');

    // Single GPS point upload
    Route::post('/track', 'GpsTrackingController@storeGpsData');

    // Batch GPS data upload
    Route::post('/batch', 'GpsTrackingController@storeBatchGpsData');

    // Get live tracking for all vehicles
    Route::get('/live', 'GpsTrackingController@getLiveTracking');

    // Get active trips with live tracking
    Route::get('/active-trips', 'GpsTrackingController@getActiveTrips');

    // Get GPS status
    Route::get('/status', 'GpsTrackingController@getStatus');
});

Route::middleware('web')->group(function () {
    Route::post('/switch-language', function (Request $request) {
        $request->validate([
            'language' => 'required|string|in:en,bn,ar,hi',
        ]);

        session(['locale' => $request->language]);

        // Update user preference if logged in
        if (Auth::check()) {
            Auth::user()->update(['preferred_language' => $request->language]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Language switched successfully',
            'language' => $request->language,
        ]);
    });

    // Get all translations for current language
    Route::get('/translations/{group?}', function ($group = 'frontend') {
        $translationService = app(App\Services\TranslationService::class);

        return response()->json([
            'translations' => $translationService->getAll($group),
        ]);
    });

    // Get employees by department (for department head assignment)
    Route::get('/employees-by-department/{departmentId}', [DepartmentHeadController::class, 'getEmployeesByDepartment'])->name('api.employees-by-department');

    // Web Push Subscription Routes
    Route::post('/push/subscribe', function (Request $request) {
        if (! Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'subscription' => 'required|array',
        ]);

        $user = Auth::user();

        // Find existing subscription or create new one
        $subscription = $user->pushSubscriptions()->where('endpoint', $request->subscription['endpoint'])->first();

        if (! $subscription) {
            $subscription = new PushSubscription;
            $subscription->user_id = $user->id;
            $subscription->endpoint = $request->subscription['endpoint'];
            $subscription->public_key = $request->subscription['keys']['p256dh'] ?? null;
            $subscription->auth_token = $request->subscription['keys']['auth'] ?? null;
            $subscription->save();
        }

        return response()->json(['success' => true]);
    });

    Route::post('/push/unsubscribe', function (Request $request) {
        if (! Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'endpoint' => 'required|string',
        ]);

        $user = Auth::user();
        $user->pushSubscriptions()->where('endpoint', $request->endpoint)->delete();

        return response()->json(['success' => true]);
    });
});

// ============================================================================
// DRIVER MOBILE APP API ROUTES
// ============================================================================

Route::prefix('driver')->middleware('auth:api')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DriverController::class, 'driverDashboard']);

    // Trips
    Route::get('/trips', [App\Http\Controllers\DriverController::class, 'driverTrips']);
    Route::get('/trips/{id}', [App\Http\Controllers\DriverController::class, 'driverTripStatus']);
    Route::post('/trips/{id}/start', [App\Http\Controllers\DriverController::class, 'startTrip']);
    Route::post('/trips/{id}/finish', [App\Http\Controllers\DriverController::class, 'finishTrip']);
    Route::post('/trips/{id}/end', [App\Http\Controllers\DriverController::class, 'endTrip']);

    // Schedule
    Route::get('/schedule', [App\Http\Controllers\DriverController::class, 'driverSchedule']);

    // Fuel Log
    Route::get('/fuel-log', [App\Http\Controllers\DriverController::class, 'driverFuelLog']);
    Route::post('/fuel-log', [App\Http\Controllers\DriverController::class, 'storeFuelLog']);

    // Availability
    Route::get('/availability', [App\Http\Controllers\DriverController::class, 'driverAvailability']);
    Route::post('/availability', [App\Http\Controllers\DriverController::class, 'updateAvailability']);

    // Profile
    Route::get('/profile', [App\Http\Controllers\DriverController::class, 'driverProfile']);
});

// ============================================================================
// AUTHENTICATION ROUTES FOR MOBILE APP AND FRONTEND
// ============================================================================

Route::middleware(['auth:api'])->get('/user', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'user' => [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone' => $request->user()->cell_phone,
        ]
    ]);
});

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'apiLogin']);

// ============================================================================
// PUBLIC SETTINGS ROUTES (For Mobile App)
// ============================================================================

Route::get('/settings', function () {
    $settings = DB::table('settings')->where('id', 1)->first();

    return response()->json([
        'site_logo' => $settings->site_logo ?? null,
        'admin_logo' => $settings->admin_logo ?? null,
        'site_title' => $settings->site_title ?? 'Next Digi Home',
        'admin_title' => $settings->admin_title ?? 'Admin Panel',
        'site_description' => $settings->site_description ?? 'Premium Digital Products',
        'admin_description' => $settings->admin_description ?? 'Admin Panel',
        // SEO for frontend
        'seo_enabled' => (bool) ($settings->seo_enabled ?? true),
        'seo_meta_title' => $settings->seo_meta_title ?? $settings->site_title ?? 'Next Digi Home',
        'seo_meta_description' => $settings->seo_meta_description ?? $settings->site_description ?? '',
        'seo_meta_keywords' => $settings->seo_meta_keywords ?? '',
        'seo_og_image' => $settings->seo_og_image ? asset('public/admin_resource/assets/images/' . $settings->seo_og_image) : null,
        'google_analytics_id' => $settings->google_analytics_id ?? null,
    ]);
});

// Authenticated settings endpoints
Route::middleware(['auth'])->group(function () {
    // Get current settings
    Route::get('/admin/settings', function () {
        $settings = DB::table('settings')->where('id', 1)->first();
        
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    });

    // Update settings with logo upload
    Route::post('/admin/settings', function (\Illuminate\Http\Request $request) {
        try {
            $setting = \App\Models\Setting::find(1);
            if (!$setting) {
                $setting = new \App\Models\Setting();
                $setting->id = 1;
            }

            // Define the image directory path
            $imageDirectory = public_path('admin_resource/assets/images');
            
            // Create directory if it doesn't exist
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }

            // Handle site logo upload
            if ($request->file('site_logo')) {
                $request->validate([
                    'site_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                ]);
                $siteLogo = time() . '_site.' . $request->site_logo->extension();
                $request->site_logo->move($imageDirectory, $siteLogo);
                $setting->site_logo = $siteLogo;
            }

            // Handle admin logo upload
            if ($request->file('admin_logo')) {
                $request->validate([
                    'admin_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                ]);
                $adminLogo = time() . '_admin.' . $request->admin_logo->extension();
                $request->admin_logo->move($imageDirectory, $adminLogo);
                $setting->admin_logo = $adminLogo;
            }

            // Update text fields
            if ($request->has('site_title')) {
                $setting->site_title = $request->site_title;
            }
            if ($request->has('site_description')) {
                $setting->site_description = $request->site_description;
            }
            if ($request->has('admin_title')) {
                $setting->admin_title = $request->admin_title;
            }
            if ($request->has('admin_description')) {
                $setting->admin_description = $request->admin_description;
            }

            $setting->created_by = auth()->id();
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => $setting
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    });
});

// Logo endpoint with CORS support
Route::middleware(['cors'])->group(function () {
    Route::get('/logo/{filename}', function ($filename) {
        // Whitelist check - only allow alphanumeric, dots, underscores and dashes
        if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
            return response()->json(['error' => 'Invalid filename'], 400);
        }
        
        $path = public_path('admin_resource/assets/images/'.$filename);

        if (! file_exists($path)) {
            return response()->json(['error' => 'Logo not found'], 404);
        }

        $mime = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    })->where('filename', '.*');
});
