<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PublicApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cell_phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->cell_phone,
                ]
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token
            ]
        ]);
    }

    public function packages()
    {
        $packages = SubscriptionPlan::where('is_active', true)
            ->orderBy('display_order')
            ->get(['id', 'name', 'price', 'billing_cycle', 'vehicle_limit', 'user_limit', 'driver_limit']);

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    public function packageById($id)
    {
        $package = SubscriptionPlan::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:subscription_plans,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $plan = SubscriptionPlan::find($request->package_id);
        
        $user = User::where('email', $request->customer_email)->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'cell_phone' => $request->customer_phone,
                'password' => Hash::make(Str::random(10)),
            ]);
        }

        $company = Company::create([
            'name' => $request->customer_name . ' Company',
            'email' => $request->customer_email,
            'phone' => $request->customer_phone,
        ]);

        $user->company_id = $company->id;
        $user->save();

        $subscription = Subscription::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'plan_id' => $request->package_id,
            'starts_at' => now(),
            'ends_at' => $plan->is_trial 
                ? now()->addDays($plan->trial_days ?? 7) 
                : now()->addDays(30),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data' => [
                'subscription_id' => $subscription->id,
                'plan' => $plan->name,
                'amount' => $plan->price,
                'status' => $subscription->status
            ]
        ], 201);
    }

    public function submitPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscription_id' => 'required|exists:subscriptions,id',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
            'sender_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $subscription = Subscription::with(['company', 'plan'])->find($request->subscription_id);
        
        $payment = Payment::create([
            'company_id' => $subscription->company_id,
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'plan_id' => $subscription->plan_id,
            'method' => $request->payment_method,
            'amount' => $request->amount,
            'currency' => 'BDT',
            'transaction_id' => $request->transaction_id,
            'sender_number' => $request->sender_number,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted successfully',
            'data' => [
                'payment_id' => $payment->id,
                'subscription_id' => $subscription->id,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'transaction_id' => $payment->transaction_id
            ]
        ], 201);
    }

    // Google OAuth
    public function redirectToGoogle()
    {
        $clientId = env('GOOGLE_CLIENT_ID');
        $redirectUri = env('GOOGLE_REDIRECT_URI', url('/api/auth/google/callback'));

        if (!$clientId) {
            return response()->json([
                'success' => false,
                'message' => 'Google OAuth not configured. Please add GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET to your .env file.'
            ], 500);
        }

        $googleAuthUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'openid profile email',
            'response_type' => 'code',
            'state' => csrf_token(),
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => $googleAuthUrl
        ]);
    }

    public function handleGoogleCallback(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/signin?error=google_auth_failed');
        }

        try {
            $clientId = env('GOOGLE_CLIENT_ID');
            $clientSecret = env('GOOGLE_CLIENT_SECRET');
            $redirectUri = env('GOOGLE_REDIRECT_URI', url('/api/auth/google/callback'));

            // Exchange code for access token
            $tokenResponse = Http::post('https://oauth2.googleapis.com/token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
            ]);

            if (!$tokenResponse->successful()) {
                throw new \Exception('Failed to get access token');
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'];

            // Get user info
            $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v2/userinfo');

            if (!$userResponse->successful()) {
                throw new \Exception('Failed to get user info');
            }

            $googleUser = $userResponse->json();

            // Find or create user
            $user = User::where('email', $googleUser['email'])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser['name'],
                    'email' => $googleUser['email'],
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                    'social_provider' => 'google',
                    'social_id' => $googleUser['id'],
                ]);
            } else {
                // Update social info if not set
                if (!$user->social_provider) {
                    $user->update([
                        'social_provider' => 'google',
                        'social_id' => $googleUser['id'],
                    ]);
                }
            }

            $token = $user->createToken('api-token')->plainTextToken;

            // Redirect to frontend with success
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect($frontendUrl . '/signin?success=google_login&token=' . $token . '&user=' . urlencode(json_encode([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ])));

        } catch (\Exception $e) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect($frontendUrl . '/signin?error=google_auth_failed');
        }
    }

    // Facebook OAuth
    public function redirectToFacebook()
    {
        $appId = env('FACEBOOK_APP_ID');
        $redirectUri = env('FACEBOOK_REDIRECT_URI', url('/api/auth/facebook/callback'));

        if (!$appId) {
            return response()->json([
                'success' => false,
                'message' => 'Facebook OAuth not configured. Please add FACEBOOK_APP_ID and FACEBOOK_APP_SECRET to your .env file.'
            ], 500);
        }

        $facebookAuthUrl = 'https://www.facebook.com/v18.0/dialog/oauth?' . http_build_query([
            'client_id' => $appId,
            'redirect_uri' => $redirectUri,
            'scope' => 'email,public_profile',
            'response_type' => 'code',
            'state' => csrf_token(),
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => $facebookAuthUrl
        ]);
    }

    public function handleFacebookCallback(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/signin?error=facebook_auth_failed');
        }

        try {
            $appId = env('FACEBOOK_APP_ID');
            $appSecret = env('FACEBOOK_APP_SECRET');
            $redirectUri = env('FACEBOOK_REDIRECT_URI', url('/api/auth/facebook/callback'));

            // Exchange code for access token
            $tokenResponse = Http::get('https://graph.facebook.com/v18.0/oauth/access_token', [
                'client_id' => $appId,
                'client_secret' => $appSecret,
                'code' => $code,
                'redirect_uri' => $redirectUri,
            ]);

            if (!$tokenResponse->successful()) {
                throw new \Exception('Failed to get access token');
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'];

            // Get user info
            $userResponse = Http::get('https://graph.facebook.com/me', [
                'fields' => 'id,name,email,picture',
                'access_token' => $accessToken,
            ]);

            if (!$userResponse->successful()) {
                throw new \Exception('Failed to get user info');
            }

            $facebookUser = $userResponse->json();

            // Find or create user
            $user = User::where('email', $facebookUser['email'])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $facebookUser['name'],
                    'email' => $facebookUser['email'],
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                    'social_provider' => 'facebook',
                    'social_id' => $facebookUser['id'],
                ]);
            } else {
                // Update social info if not set
                if (!$user->social_provider) {
                    $user->update([
                        'social_provider' => 'facebook',
                        'social_id' => $facebookUser['id'],
                    ]);
                }
            }

            $token = $user->createToken('api-token')->plainTextToken;

            // Redirect to frontend with success
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect($frontendUrl . '/signin?success=facebook_login&token=' . $token . '&user=' . urlencode(json_encode([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ])));

        } catch (\Exception $e) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect($frontendUrl . '/signin?error=facebook_auth_failed');
        }
    }
}