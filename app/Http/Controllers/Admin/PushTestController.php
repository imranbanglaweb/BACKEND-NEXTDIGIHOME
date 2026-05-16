<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\WebPush\PushSubscription;
use App\Notifications\TestPushNotification;

class PushTestController extends Controller
{
    /**
     * Send a test push notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $user = Auth::user();
        $user->notify(new TestPushNotification());

        return response()->json([
            'success' => true,
            'message' => 'Test push notification sent successfully.',
        ]);
    }

    /**
     * Clear all push subscriptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAllSubscriptions(Request $request)
    {
        PushSubscription::query()->delete();

        return response()->json([
            'success' => true,
            'message' => 'All push subscriptions have been cleared.',
        ]);
    }
}
