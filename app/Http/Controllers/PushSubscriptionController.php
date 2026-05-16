<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\WebPush\PushSubscription;

class PushSubscriptionController extends Controller
{
    /**
     * Store a new push subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription' => 'required|array',
            'subscription.endpoint' => 'required|string',
            'subscription.keys' => 'required|array',
            'subscription.keys.p256dh' => 'required|string',
            'subscription.keys.auth' => 'required|string',
        ]);

        $endpoint = $request->subscription['endpoint'];
        $publicKey = $request->subscription['keys']['p256dh'];
        $authToken = $request->subscription['keys']['auth'];

        $user = Auth::check() ? Auth::user() : null;

        $subscription = PushSubscription::where('endpoint', $endpoint)->first();

        if ($subscription) {
            // Update existing subscription
            $subscription->public_key = $publicKey;
            $subscription->auth_token = $authToken;
            $subscription->user_id = $user ? $user->id : null;
            $subscription->save();
        } else {
            // Create new subscription
            $subscription = new PushSubscription();
            $subscription->endpoint = $endpoint;
            $subscription->public_key = $publicKey;
            $subscription->auth_token = $authToken;
            $subscription->user_id = $user ? $user->id : null;
            $subscription->save();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified push subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
        ]);

        $query = PushSubscription::where('endpoint', $request->endpoint);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        $query->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Clear all push subscriptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAll(Request $request)
    {
        // Only admin should be able to clear all (middleware already restricts to auth)
        // Optionally add additional authorization check here
        PushSubscription::query()->delete();

        return redirect()->back()->with('success', 'All push subscriptions have been cleared.');
    }

    /**
     * Display a listing of push subscribers.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $subscriptions = PushSubscription::with('user')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.push-subscribers.index', compact('subscriptions'));
    }
}
