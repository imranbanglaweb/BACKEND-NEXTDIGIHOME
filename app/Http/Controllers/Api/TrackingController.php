<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServerTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackingController extends Controller
{
    protected ServerTrackingService $trackingService;

    public function __construct(ServerTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Dispatch custom server-side event (GA4, Meta CAPI, Webhook).
     */
    public function trackEvent(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:100',
            'event_data' => 'nullable|array',
            'user_data' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $eventName = $request->input('event_name');
        $eventData = (array) $request->input('event_data', []);
        $userData = (array) $request->input('user_data', []);

        // Automatically attach request IP, user agent, and cookies
        $userData['client_ip_address'] = $userData['client_ip_address'] ?? $request->ip();
        $userData['client_user_agent'] = $userData['client_user_agent'] ?? $request->userAgent();
        if ($request->cookie('_fbp') && empty($userData['fbp'])) {
            $userData['fbp'] = $request->cookie('_fbp');
        }
        if ($request->cookie('_fbc') && empty($userData['fbc'])) {
            $userData['fbc'] = $request->cookie('_fbc');
        }

        $results = $this->trackingService->trackCustomEvent($eventName, $eventData, $userData);

        return response()->json([
            'success' => true,
            'message' => "Server tracking event '{$eventName}' processed",
            'dispatches' => $results,
        ]);
    }
}
