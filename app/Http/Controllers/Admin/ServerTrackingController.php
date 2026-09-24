<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServerTrackingLog;
use App\Models\Setting;
use App\Services\ServerTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
     * Note: Access tokens are masked for security and never exposed in plain text.
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

        // Mask token for frontend display to protect server-side credentials
        if ($settings && !empty($metaConfig['access_token'])) {
            $rawToken = $metaConfig['access_token'];
            $settings = (object) ((array) $settings);
            $settings->meta_capi_access_token = strlen($rawToken) > 12 
                ? substr($rawToken, 0, 5) . '••••••••••••••••••••••••••••••••' . substr($rawToken, -4) 
                : '••••••••••••••••';
            // Also mask in metaConfig for view
            $metaConfig['access_token'] = $settings->meta_capi_access_token;
        }

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
     * Tokens are encrypted at rest; Dataset ID 1786172575724734 is enforced.
     */
    public function updateConfig(Request $request)
    {
        $validated = $request->validate([
            // GA4
            'ga4_measurement_id' => 'nullable|string|max:100',
            'ga4_api_secret' => 'nullable|string|max:255',
            'ga4_server_enabled' => 'nullable|boolean',

            // Meta CAPI / Dataset
            'meta_pixel_id' => 'nullable|string|max:100',
            'meta_dataset_id' => 'nullable|string|max:100',
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

            // Enforce clean Dataset ID (defaulting to 1786172575724734, avoiding legacy 981230941262806)
            $rawDatasetId = trim((string) ($request->input('meta_dataset_id') ?: $request->input('meta_pixel_id')));
            if ($rawDatasetId === '981230941262806' || empty($rawDatasetId)) {
                $rawDatasetId = '1786172575724734';
            }
            $setting->meta_pixel_id = $rawDatasetId;
            if (Schema::hasColumn('settings', 'meta_dataset_id')) {
                $setting->meta_dataset_id = $rawDatasetId;
            }

            // Only update access token if a non-masked new token was entered
            $rawToken = $request->input('meta_capi_access_token');
            if (!empty($rawToken) && !str_contains($rawToken, '••••') && !str_contains($rawToken, '****')) {
                $setting->meta_capi_access_token = Crypt::encryptString(trim($rawToken));
            }

            $testCode = trim((string) $request->input('meta_capi_test_event_code'));
            $setting->meta_capi_test_event_code = !empty($testCode) ? $testCode : 'TEST54855';
            $setting->meta_capi_enabled = $request->has('meta_capi_enabled');

            $setting->tiktok_pixel_code = $request->input('tiktok_pixel_code');
            if ($request->filled('tiktok_access_token') && !str_contains($request->input('tiktok_access_token'), '••••')) {
                $setting->tiktok_access_token = $request->input('tiktok_access_token');
            }
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
     * Guarantees Meta CAPI uses Dataset ID 1786172575724734 and Test Event Code TEST54855.
     */
    public function testDispatch(Request $request): JsonResponse
    {
        $request->validate([
            'provider' => 'required|string|in:meta_capi,ga4,tiktok,webhook',
            'event_name' => 'nullable|string|max:50',
            'test_event_code' => 'nullable|string|max:100',
            'dataset_id' => 'nullable|string|max:100',
            'pixel_id' => 'nullable|string|max:100',
            'access_token' => 'nullable|string',
        ]);

        $provider = $request->input('provider');
        $eventName = $request->input('event_name', 'Lead');
        $testEventCode = $request->input('test_event_code') ?: 'TEST54855';
        $datasetId = trim((string) ($request->input('dataset_id') ?: $request->input('pixel_id')));
        if ($datasetId === '981230941262806' || empty($datasetId)) {
            $datasetId = '1786172575724734';
        }

        $accessToken = $request->input('access_token');
        if (!empty($accessToken) && (str_contains($accessToken, '••••') || str_contains($accessToken, '****'))) {
            $accessToken = null; // Ignore masked placeholder
        }

        // If active credentials entered in form, auto-persist encrypted to database
        if ($provider === 'meta_capi' && !empty($accessToken)) {
            $this->trackingService->persistMetaCredentials($datasetId, $accessToken, $testEventCode);
        }

        $result = $this->trackingService->testDispatch(
            $provider, 
            $eventName, 
            $testEventCode, 
            $datasetId, 
            $accessToken
        );

        return response()->json([
            'success' => ($result['status'] ?? '') === 'success',
            'provider' => $provider,
            'event_name' => $eventName,
            'result' => $result,
        ]);
    }

    /**
     * Clear server tracking audit logs.
     */
    public function clearLogs(Request $request)
    {
        if (Schema::hasTable('server_tracking_logs')) {
            if ($request->filled('provider')) {
                ServerTrackingLog::where('provider', $request->input('provider'))->delete();
                $msg = 'Audit logs cleared for ' . strtoupper($request->input('provider')) . '.';
            } else {
                ServerTrackingLog::truncate();
                $msg = 'All server tracking audit logs cleared successfully.';
            }
            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Tracking logs table does not exist.');
    }
}
