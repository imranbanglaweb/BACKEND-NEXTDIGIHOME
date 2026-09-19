<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServerTrackingLog;
use App\Models\Setting;
use App\Services\ServerTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServerTrackingController extends Controller
{
    protected ServerTrackingService $trackingService;

    public function __construct(ServerTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Display Server Tracking & CAPI Dashboard.
     */
    public function dashboard()
    {
        $hasLogsTable = Schema::hasTable('server_tracking_logs');

        $totalEvents = $hasLogsTable ? ServerTrackingLog::count() : 0;
        $totalSuccess = $hasLogsTable ? ServerTrackingLog::where('status', 'success')->count() : 0;
        $totalFailed = $hasLogsTable ? ServerTrackingLog::where('status', 'failed')->count() : 0;

        $metaCount = $hasLogsTable ? ServerTrackingLog::where('provider', 'meta_capi')->count() : 0;
        $metaSuccess = $hasLogsTable ? ServerTrackingLog::where('provider', 'meta_capi')->where('status', 'success')->count() : 0;

        $ga4Count = $hasLogsTable ? ServerTrackingLog::where('provider', 'ga4')->count() : 0;
        $ga4Success = $hasLogsTable ? ServerTrackingLog::where('provider', 'ga4')->where('status', 'success')->count() : 0;

        $tiktokCount = $hasLogsTable ? ServerTrackingLog::where('provider', 'tiktok')->count() : 0;
        $webhookCount = $hasLogsTable ? ServerTrackingLog::where('provider', 'webhook')->count() : 0;

        $recentLogs = $hasLogsTable 
            ? ServerTrackingLog::orderBy('id', 'desc')->limit(15)->get() 
            : collect();

        $ga4Config = $this->trackingService->getGA4Config();
        $metaConfig = $this->trackingService->getMetaCAPIConfig();
        $tiktokConfig = $this->trackingService->getTikTokConfig();
        $webhookConfig = $this->trackingService->getWebhookConfig();

        return view('admin.tracking.dashboard', compact(
            'totalEvents',
            'totalSuccess',
            'totalFailed',
            'metaCount',
            'metaSuccess',
            'ga4Count',
            'ga4Success',
            'tiktokCount',
            'webhookCount',
            'recentLogs',
            'ga4Config',
            'metaConfig',
            'tiktokConfig',
            'webhookConfig'
        ));
    }

    /**
     * Display configuration form.
     */
    public function config()
    {
        $settings = null;
        if (Schema::hasTable('settings')) {
            $settings = DB::table('settings')->where('id', 1)->first();
        }

        $ga4Config = $this->trackingService->getGA4Config();
        $metaConfig = $this->trackingService->getMetaCAPIConfig();
        $tiktokConfig = $this->trackingService->getTikTokConfig();
        $webhookConfig = $this->trackingService->getWebhookConfig();

        return view('admin.tracking.config', compact(
            'settings',
            'ga4Config',
            'metaConfig',
            'tiktokConfig',
            'webhookConfig'
        ));
    }

    /**
     * Save updated server tracking configuration.
     */
    public function updateConfig(Request $request)
    {
        $validated = $request->validate([
            // GA4
            'ga4_measurement_id' => 'nullable|string|max:100',
            'ga4_api_secret' => 'nullable|string|max:255',
            'ga4_server_enabled' => 'nullable|boolean',

            // Meta CAPI
            'meta_pixel_id' => 'nullable|string|max:100',
            'meta_capi_access_token' => 'nullable|string',
            'meta_capi_test_event_code' => 'nullable|string|max:100',
            'meta_capi_enabled' => 'nullable|boolean',

            // TikTok
            'tiktok_pixel_code' => 'nullable|string|max:100',
            'tiktok_access_token' => 'nullable|string',
            'tiktok_test_event_code' => 'nullable|string|max:100',
            'tiktok_server_enabled' => 'nullable|boolean',

            // Webhook
            'server_tracking_webhook_url' => 'nullable|url|max:255',
            'server_tracking_webhook_enabled' => 'nullable|boolean',
        ]);

        if (Schema::hasTable('settings')) {
            $setting = Setting::find(1);
            if (!$setting) {
                $setting = new Setting();
                $setting->id = 1;
            }

            $setting->ga4_measurement_id = $request->input('ga4_measurement_id');
            $setting->ga4_api_secret = $request->input('ga4_api_secret');
            $setting->ga4_server_enabled = $request->has('ga4_server_enabled');

            $setting->meta_pixel_id = $request->input('meta_pixel_id');
            $setting->meta_capi_access_token = $request->input('meta_capi_access_token');
            $setting->meta_capi_test_event_code = $request->input('meta_capi_test_event_code');
            $setting->meta_capi_enabled = $request->has('meta_capi_enabled');

            $setting->tiktok_pixel_code = $request->input('tiktok_pixel_code');
            $setting->tiktok_access_token = $request->input('tiktok_access_token');
            $setting->tiktok_test_event_code = $request->input('tiktok_test_event_code');
            $setting->tiktok_server_enabled = $request->has('tiktok_server_enabled');

            $setting->server_tracking_webhook_url = $request->input('server_tracking_webhook_url');
            $setting->server_tracking_webhook_enabled = $request->has('server_tracking_webhook_enabled');

            $setting->save();
        }

        return redirect()->route('admin.server-tracking.config')
            ->with('success', 'Server tracking credentials updated successfully.');
    }

    /**
     * Display paginated audit logs.
     */
    public function logs(Request $request)
    {
        $hasLogsTable = Schema::hasTable('server_tracking_logs');
        if (!$hasLogsTable) {
            return view('admin.tracking.logs', ['logs' => collect()]);
        }

        $query = ServerTrackingLog::query();

        if ($request->filled('provider')) {
            $query->where('provider', $request->input('provider'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('event_name', 'like', "%{$search}%")
                  ->orWhere('event_id', 'like', "%{$search}%")
                  ->orWhere('lead_id', 'like', "%{$search}%")
                  ->orWhere('order_id', 'like', "%{$search}%");
            });
        }

        $logs = $query->orderBy('id', 'desc')->paginate(25)->withQueryString();

        return view('admin.tracking.logs', compact('logs'));
    }

    /**
     * Live test event dispatcher for admin console.
     */
    public function testDispatch(Request $request): JsonResponse
    {
        $request->validate([
            'provider' => 'required|string|in:meta_capi,ga4,tiktok,webhook',
            'event_name' => 'nullable|string|max:50',
        ]);

        $provider = $request->input('provider');
        $eventName = $request->input('event_name', 'Lead');

        $result = $this->trackingService->testDispatch($provider, $eventName);

        return response()->json([
            'success' => ($result['status'] ?? '') === 'success',
            'provider' => $provider,
            'result' => $result,
        ]);
    }
}
