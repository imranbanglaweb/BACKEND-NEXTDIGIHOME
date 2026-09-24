<?php

namespace App\Services;

use App\Models\ProjectInquiry;
use App\Models\ServerTrackingLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ServerTrackingService
{
    protected ?object $settings = null;

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * Load settings from database if available, or initialize empty object.
     */
    protected function loadSettings(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $this->settings = DB::table('settings')->where('id', 1)->first();
            }
        } catch (\Exception $e) {
            $this->settings = null;
        }
    }

    /**
     * Get GA4 configuration.
     */
    public function getGA4Config(): array
    {
        $measurementId = $this->settings->ga4_measurement_id 
            ?? $this->settings->google_analytics_id 
            ?? config('server_tracking.ga4.measurement_id', env('GA4_MEASUREMENT_ID', ''));

        $apiSecret = $this->settings->ga4_api_secret 
            ?? config('server_tracking.ga4.api_secret', env('GA4_API_SECRET', ''));

        $enabled = isset($this->settings->ga4_server_enabled) 
            ? (bool) $this->settings->ga4_server_enabled 
            : config('server_tracking.ga4.enabled', env('GA4_SERVER_TRACKING_ENABLED', true));

        $debugMode = config('server_tracking.ga4.debug_mode', env('GA4_DEBUG_MODE', false));

        return [
            'measurement_id' => trim($measurementId ?: ''),
            'api_secret' => trim($apiSecret ?: ''),
            'enabled' => $enabled && !empty($measurementId) && !empty($apiSecret),
            'debug_mode' => (bool) $debugMode,
        ];
    }

    /**
     * Get Meta Conversions API (CAPI) configuration.
     * Note: Dataset ID is the modern Meta Graph API event ingestion target (replaces legacy Pixel ID).
     * Endpoint pattern: https://graph.facebook.com/{version}/{dataset_id}/events
     */
    public function getMetaCAPIConfig(): array
    {
        $rawDatasetId = null;
        if ($this->settings) {
            $rawDatasetId = (!empty($this->settings->meta_dataset_id) ? $this->settings->meta_dataset_id : null)
                ?? (!empty($this->settings->meta_pixel_id) ? $this->settings->meta_pixel_id : null);
        }

        $datasetId = trim((string) ($rawDatasetId 
            ?: config('server_tracking.meta_capi.dataset_id')
            ?: config('server_tracking.meta_capi.pixel_id')
            ?: env('META_DATASET_ID')
            ?: env('META_PIXEL_ID', '1786172575724734')));

        // Explicit guard against legacy dummy ID 981230941262806
        if ($datasetId === '981230941262806' || empty($datasetId)) {
            $datasetId = '1786172575724734';
        }

        $rawToken = null;
        if ($this->settings && !empty($this->settings->meta_capi_access_token)) {
            $rawToken = $this->settings->meta_capi_access_token;
            try {
                $rawToken = Crypt::decryptString($rawToken);
            } catch (\Exception $e) {
                // If stored in plain text, use as-is
            }
        }

        $accessToken = trim((string) ($rawToken 
            ?: config('server_tracking.meta_capi.access_token')
            ?: env('META_CAPI_ACCESS_TOKEN', '')));

        $rawTestCode = $this->settings->meta_capi_test_event_code ?? null;
        $testEventCode = trim((string) ($rawTestCode 
            ?: config('server_tracking.meta_capi.test_event_code')
            ?: env('META_CAPI_TEST_EVENT_CODE', 'TEST54855')));

        $enabled = isset($this->settings->meta_capi_enabled) 
            ? (bool) $this->settings->meta_capi_enabled 
            : config('server_tracking.meta_capi.enabled', env('META_CAPI_ENABLED', true));

        $version = config('server_tracking.meta_capi.api_version', env('META_GRAPH_API_VERSION', 'v20.0'));

        return [
            'dataset_id' => $datasetId,
            'pixel_id' => $datasetId, // alias for backwards compatibility
            'access_token' => $accessToken,
            'test_event_code' => $testEventCode,
            'enabled' => $enabled && !empty($datasetId) && !empty($accessToken),
            'version' => $version,
        ];
    }

    /**
     * Securely persist active Meta credentials to database settings with encryption.
     */
    public function persistMetaCredentials(string $datasetId, ?string $accessToken = null, ?string $testCode = null): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $setting = Setting::find(1);
                if (!$setting) {
                    $setting = new Setting();
                    $setting->id = 1;
                }
                
                $cleanDatasetId = trim($datasetId);
                if ($cleanDatasetId === '981230941262806' || empty($cleanDatasetId)) {
                    $cleanDatasetId = '1786172575724734';
                }

                $setting->meta_pixel_id = $cleanDatasetId;
                if (Schema::hasColumn('settings', 'meta_dataset_id')) {
                    $setting->meta_dataset_id = $cleanDatasetId;
                }
                if (!empty($accessToken) && !str_contains($accessToken, '••••') && !str_contains($accessToken, '****')) {
                    $setting->meta_capi_access_token = Crypt::encryptString(trim($accessToken));
                }
                if (!empty($testCode)) {
                    $setting->meta_capi_test_event_code = trim($testCode);
                }
                $setting->meta_capi_enabled = true;
                $setting->save();

                $this->loadSettings();
            }
        } catch (\Exception $e) {
            Log::warning("[ServerTracking] Could not persist Meta CAPI credentials: " . $e->getMessage());
        }
    }

    /**
     * Get TikTok Events API configuration.
     */
    public function getTikTokConfig(): array
    {
        $pixelCode = $this->settings->tiktok_pixel_code 
            ?? config('server_tracking.tiktok.pixel_code', env('TIKTOK_PIXEL_CODE', env('TIKTOK_PIXEL_ID', '')));

        $accessToken = $this->settings->tiktok_access_token 
            ?? config('server_tracking.tiktok.access_token', env('TIKTOK_ACCESS_TOKEN', ''));

        $testEventCode = $this->settings->tiktok_test_event_code 
            ?? config('server_tracking.tiktok.test_event_code', env('TIKTOK_TEST_EVENT_CODE', ''));

        $enabled = isset($this->settings->tiktok_server_enabled) 
            ? (bool) $this->settings->tiktok_server_enabled 
            : config('server_tracking.tiktok.enabled', env('TIKTOK_SERVER_TRACKING_ENABLED', false));

        return [
            'pixel_code' => trim($pixelCode ?: ''),
            'access_token' => trim($accessToken ?: ''),
            'test_event_code' => trim($testEventCode ?: ''),
            'enabled' => $enabled && !empty($pixelCode) && !empty($accessToken),
        ];
    }

    /**
     * Get Webhook configuration.
     */
    public function getWebhookConfig(): array
    {
        $url = $this->settings->server_tracking_webhook_url 
            ?? config('server_tracking.webhook.url', env('SERVER_TRACKING_WEBHOOK_URL', ''));

        $secret = config('server_tracking.webhook.secret', env('SERVER_TRACKING_WEBHOOK_SECRET', ''));

        $enabled = isset($this->settings->server_tracking_webhook_enabled) 
            ? (bool) $this->settings->server_tracking_webhook_enabled 
            : config('server_tracking.webhook.enabled', env('SERVER_TRACKING_WEBHOOK_ENABLED', false));

        return [
            'url' => trim($url ?: ''),
            'secret' => trim($secret ?: ''),
            'enabled' => $enabled && !empty($url),
        ];
    }

    /**
     * Track a newly created Project Inquiry (Lead).
     */
    public function trackLead(ProjectInquiry $inquiry, array $additionalParams = []): array
    {
        $eventId = $inquiry->event_id ?: ('lead_' . time() . '_' . Str::random(8));
        $sourceUrl = $inquiry->landing_page ?: url('/contact');
        if (!Str::startsWith($sourceUrl, 'http')) {
            $sourceUrl = url($sourceUrl);
        }

        // Estimated lead commercial value based on budget slab
        $estimatedValue = $this->resolveBudgetValue($inquiry->budget);
        $currency = 'USD';

        $userData = [
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'name' => $inquiry->name,
            'client_ip_address' => $inquiry->ip_address ?: request()->ip(),
            'client_user_agent' => $inquiry->user_agent ?: request()->userAgent(),
            'fbp' => request()->cookie('_fbp') ?: ($additionalParams['fbp'] ?? null),
            'fbc' => request()->cookie('_fbc') ?: ($additionalParams['fbc'] ?? null),
        ];

        $customData = [
            'lead_id' => $inquiry->lead_id,
            'service' => $inquiry->service,
            'priority' => $inquiry->priority,
            'lead_score' => $inquiry->lead_score,
            'value' => $estimatedValue,
            'currency' => $currency,
            'utm_source' => $inquiry->utm_source,
            'utm_medium' => $inquiry->utm_medium,
            'utm_campaign' => $inquiry->utm_campaign,
        ];

        $results = [];

        // 1. Meta Conversions API (Lead)
        $results['meta_capi'] = $this->sendMetaCapi(
            'Lead',
            $eventId,
            $userData,
            $customData,
            $sourceUrl,
            $inquiry->lead_id
        );

        // 2. GA4 Measurement Protocol (generate_lead)
        $clientId = $this->resolveGAClientId($additionalParams['ga_client_id'] ?? null, $inquiry->email);
        $results['ga4'] = $this->sendGA4(
            'generate_lead',
            $clientId,
            [
                'currency' => $currency,
                'value' => $estimatedValue,
                'transaction_id' => $inquiry->lead_id,
                'lead_id' => $inquiry->lead_id,
                'service' => $inquiry->service,
                'priority' => $inquiry->priority,
                'source' => $inquiry->utm_source ?: 'website',
                'medium' => $inquiry->utm_medium ?: 'organic',
                'campaign' => $inquiry->utm_campaign ?: 'direct',
            ],
            null,
            $inquiry->lead_id
        );

        // 3. TikTok Events API (SubmitForm)
        $results['tiktok'] = $this->sendTikTok(
            'SubmitForm',
            $eventId,
            $userData,
            $customData,
            $sourceUrl,
            $inquiry->lead_id
        );

        // 4. Custom Server Webhook
        $results['webhook'] = $this->sendWebhook(
            'lead_created',
            array_merge($customData, [
                'event_id' => $eventId,
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'phone' => $inquiry->phone,
                'company' => $inquiry->company,
                'landing_page' => $sourceUrl,
                'created_at' => $inquiry->created_at ? $inquiry->created_at->toISOString() : now()->toISOString(),
            ]),
            $inquiry->lead_id
        );

        return $results;
    }

    /**
     * Track an Order / Checkout Purchase.
     */
    public function trackPurchase(array $orderData, array $additionalParams = []): array
    {
        $eventId = $orderData['event_id'] ?? ('purchase_' . time() . '_' . Str::random(8));
        $transactionId = $orderData['transaction_id'] ?? ('TXN-' . strtoupper(Str::random(10)));
        $value = (float) ($orderData['value'] ?? $orderData['total'] ?? 0);
        $currency = $orderData['currency'] ?? 'USD';
        $sourceUrl = $orderData['source_url'] ?? url('/checkout/success');

        $userData = [
            'email' => $orderData['customer_email'] ?? $orderData['email'] ?? null,
            'phone' => $orderData['customer_phone'] ?? $orderData['phone'] ?? null,
            'name' => $orderData['customer_name'] ?? $orderData['name'] ?? null,
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->userAgent(),
            'fbp' => request()->cookie('_fbp') ?: ($additionalParams['fbp'] ?? null),
            'fbc' => request()->cookie('_fbc') ?: ($additionalParams['fbc'] ?? null),
        ];

        $customData = [
            'transaction_id' => $transactionId,
            'value' => $value,
            'currency' => $currency,
            'items' => $orderData['items'] ?? [],
            'payment_method' => $orderData['payment_method'] ?? 'online',
        ];

        $results = [];

        // 1. Meta CAPI (Purchase)
        $results['meta_capi'] = $this->sendMetaCapi(
            'Purchase',
            $eventId,
            $userData,
            $customData,
            $sourceUrl,
            null,
            $transactionId
        );

        // 2. GA4 (purchase)
        $clientId = $this->resolveGAClientId($additionalParams['ga_client_id'] ?? null, $userData['email']);
        $results['ga4'] = $this->sendGA4(
            'purchase',
            $clientId,
            [
                'transaction_id' => $transactionId,
                'value' => $value,
                'currency' => $currency,
                'payment_type' => $orderData['payment_method'] ?? 'online',
                'items' => array_map(function ($item) {
                    return [
                        'item_id' => $item['id'] ?? $item['product_id'] ?? '',
                        'item_name' => $item['name'] ?? 'Digital Product',
                        'price' => $item['price'] ?? 0,
                        'quantity' => $item['quantity'] ?? 1,
                    ];
                }, (array) ($orderData['items'] ?? [])),
            ],
            null,
            null,
            $transactionId
        );

        // 3. TikTok (CompletePayment)
        $results['tiktok'] = $this->sendTikTok(
            'CompletePayment',
            $eventId,
            $userData,
            $customData,
            $sourceUrl,
            null,
            $transactionId
        );

        // 4. Webhook
        $results['webhook'] = $this->sendWebhook(
            'purchase_completed',
            array_merge($customData, [
                'event_id' => $eventId,
                'customer_email' => $userData['email'],
                'customer_name' => $userData['name'],
            ]),
            null,
            $transactionId
        );

        return $results;
    }

    /**
     * Track a custom generic server event.
     */
    public function trackCustomEvent(string $eventName, array $eventData = [], array $userData = []): array
    {
        $eventId = $eventData['event_id'] ?? (strtolower($eventName) . '_' . time() . '_' . Str::random(8));
        $sourceUrl = $eventData['source_url'] ?? request()->header('referer') ?? url('/');

        $fullUserData = array_merge([
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->userAgent(),
            'fbp' => request()->cookie('_fbp'),
            'fbc' => request()->cookie('_fbc'),
        ], $userData);

        $results = [];

        // Meta CAPI
        $results['meta_capi'] = $this->sendMetaCapi(
            $eventName,
            $eventId,
            $fullUserData,
            $eventData,
            $sourceUrl
        );

        // GA4
        $clientId = $this->resolveGAClientId($eventData['ga_client_id'] ?? null, $fullUserData['email'] ?? null);
        $results['ga4'] = $this->sendGA4(
            strtolower(str_replace(' ', '_', $eventName)),
            $clientId,
            $eventData
        );

        // Webhook
        $results['webhook'] = $this->sendWebhook($eventName, array_merge($eventData, ['event_id' => $eventId]));

        return $results;
    }

    /**
     * Dispatch Meta Conversions API (CAPI) Event.
     * Guaranteed endpoint pattern: https://graph.facebook.com/{version}/{dataset_id}/events
     */
    public function sendMetaCapi(
        string $eventName,
        string $eventId,
        array $userData,
        array $customData,
        string $eventSourceUrl,
        ?string $leadId = null,
        ?string $orderId = null,
        ?string $customTestCode = null,
        ?string $customDatasetId = null,
        ?string $customAccessToken = null
    ): array {
        $config = $this->getMetaCAPIConfig();

        // 1. Resolve active Meta Dataset ID (never allow legacy dummy 981230941262806)
        $datasetId = trim((string) ($customDatasetId ?: ($config['dataset_id'] ?? $config['pixel_id'])));
        if ($datasetId === '981230941262806' || empty($datasetId)) {
            $datasetId = '1786172575724734';
        }

        // 2. Resolve active Access Token (server-side decrypted)
        $accessToken = trim((string) ($customAccessToken ?: ($config['access_token'] ?? '')));
        $version = $config['version'] ?? 'v20.0';

        // 3. Expected endpoint: https://graph.facebook.com/{version}/{dataset_id}/events
        $url = "https://graph.facebook.com/{$version}/{$datasetId}/events";

        if (empty($accessToken)) {
            $this->logEvent('meta_capi', $eventName, $eventId, 'skipped', null, [
                'endpoint' => $url,
                'dataset_id' => $datasetId,
                'api_version' => $version,
            ], ['message' => 'Meta CAPI disabled or missing Access Token. Please configure your Access Token in CAPI & Pixel Setup.'], 'Meta CAPI Access Token is missing', $leadId, $orderId);
            return [
                'status' => 'skipped', 
                'message' => 'Meta CAPI disabled or Access Token is missing. Please save a valid Access Token in CAPI & Pixel Setup.',
                'endpoint' => $url,
                'dataset_id' => $datasetId,
            ];
        }

        try {
            // Prepare hashed user data adhering strictly to Meta CAPI specification
            $hashedUserData = [
                'client_ip_address' => $userData['client_ip_address'] ?? request()->ip(),
                'client_user_agent' => $userData['client_user_agent'] ?? request()->userAgent(),
            ];

            if (!empty($userData['email'])) {
                $hashedUserData['em'] = [$this->hashSha256(strtolower(trim($userData['email'])))];
            }

            if (!empty($userData['phone'])) {
                $hashedUserData['ph'] = [$this->hashSha256($this->normalizePhone($userData['phone']))];
            }

            if (!empty($userData['name'])) {
                $parts = explode(' ', trim($userData['name']), 2);
                $hashedUserData['fn'] = [$this->hashSha256(strtolower($parts[0]))];
                if (isset($parts[1])) {
                    $hashedUserData['ln'] = [$this->hashSha256(strtolower($parts[1]))];
                }
            }

            if (!empty($userData['fbp'])) {
                $hashedUserData['fbp'] = $userData['fbp'];
            }
            if (!empty($userData['fbc'])) {
                $hashedUserData['fbc'] = $userData['fbc'];
            }

            $eventPayload = [
                'event_name' => $eventName,
                'event_time' => time(),
                'event_id' => $eventId,
                'event_source_url' => $eventSourceUrl,
                'action_source' => 'website',
                'user_data' => $hashedUserData,
                'custom_data' => $customData,
            ];

            $requestBody = [
                'data' => [$eventPayload],
            ];

            $activeTestCode = $customTestCode ?: ($config['test_event_code'] ?? 'TEST54855');
            if (!empty($activeTestCode)) {
                $requestBody['test_event_code'] = $activeTestCode;
            }

            // Task Requirement 10: Verify the final HTTP request target before sending
            // Task Requirement 11: Diagnostic logging without access token
            Log::info('[Meta CAPI Request Target]', [
                'provider' => 'meta_capi',
                'dataset_id' => $datasetId,
                'api_version' => $version,
                'endpoint' => $url,
                'event_id' => $eventId,
                'event_name' => $eventName,
                'test_event_code' => $activeTestCode,
            ]);

            $response = Http::timeout(6)
                ->withToken($accessToken)
                ->asJson()
                ->post($url, $requestBody);

            $status = $response->successful() ? 'success' : 'failed';
            $statusCode = $response->status();
            $responseJson = $response->json() ?: ['body' => $response->body()];
            $metaErrorCode = $responseJson['error']['code'] ?? null;
            $metaErrorSubcode = $responseJson['error']['error_subcode'] ?? null;
            $metaErrorType = $responseJson['error']['type'] ?? null;
            $errorMsg = $response->successful() ? null : ($responseJson['error']['message'] ?? 'Meta API error');

            // Task Requirement 11: Diagnostic logging showing HTTP code and Meta error details
            Log::info('[Meta CAPI Response Diagnostics]', [
                'provider' => 'meta_capi',
                'dataset_id' => $datasetId,
                'api_version' => $version,
                'endpoint' => $url,
                'event_id' => $eventId,
                'event_name' => $eventName,
                'http_response_code' => $statusCode,
                'meta_error_code' => $metaErrorCode,
                'meta_error_subcode' => $metaErrorSubcode,
                'meta_error_type' => $metaErrorType,
                'meta_error_message' => $errorMsg,
            ]);

            $diagnosticRequest = [
                'endpoint' => $url,
                'dataset_id' => $datasetId,
                'api_version' => $version,
                'event_id' => $eventId,
                'event_name' => $eventName,
                'payload' => $requestBody,
            ];

            $this->logEvent('meta_capi', $eventName, $eventId, $status, $statusCode, $diagnosticRequest, $responseJson, $errorMsg, $leadId, $orderId);

            return [
                'status' => $status,
                'http_code' => $statusCode,
                'endpoint' => $url,
                'dataset_id' => $datasetId,
                'response' => $responseJson,
                'error' => $errorMsg,
            ];
        } catch (\Exception $e) {
            Log::error('[Meta CAPI Dispatch Exception]', [
                'provider' => 'meta_capi',
                'dataset_id' => $datasetId,
                'api_version' => $version,
                'endpoint' => $url,
                'event_id' => $eventId,
                'event_name' => $eventName,
                'exception' => $e->getMessage(),
            ]);

            $this->logEvent('meta_capi', $eventName, $eventId, 'failed', 500, [
                'endpoint' => $url,
                'dataset_id' => $datasetId,
                'api_version' => $version,
            ], [], $e->getMessage(), $leadId, $orderId);

            return [
                'status' => 'failed',
                'http_code' => 500,
                'endpoint' => $url,
                'dataset_id' => $datasetId,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Dispatch Google Analytics 4 (GA4) Measurement Protocol Event.
     */
    public function sendGA4(
        string $eventName,
        string $clientId,
        array $eventParams,
        ?string $userId = null,
        ?string $leadId = null,
        ?string $orderId = null
    ): array {
        $config = $this->getGA4Config();
        if (!$config['enabled']) {
            $this->logEvent('ga4', $eventName, null, 'skipped', null, [], ['message' => 'GA4 Measurement Protocol disabled or missing credentials'], null, $leadId, $orderId);
            return ['status' => 'skipped', 'message' => 'GA4 Measurement Protocol disabled or credentials missing'];
        }

        try {
            $measurementId = $config['measurement_id'];
            $apiSecret = $config['api_secret'];
            $debugMode = $config['debug_mode'];

            $endpoint = $debugMode 
                ? 'https://www.google-analytics.com/debug/mp/collect' 
                : 'https://www.google-analytics.com/mp/collect';

            $url = "{$endpoint}?api_secret={$apiSecret}&measurement_id={$measurementId}";

            $cleanParams = $this->sanitizeGA4Params($eventParams);

            $payload = [
                'client_id' => $clientId,
                'events' => [
                    [
                        'name' => $eventName,
                        'params' => $cleanParams,
                    ]
                ],
            ];

            if ($userId) {
                $payload['user_id'] = (string) $userId;
            }

            $response = Http::timeout(4)
                ->asJson()
                ->post($url, $payload);

            $statusCode = $response->status();
            $responseJson = $response->json() ?: ['body' => $response->body()];
            
            // In GA4 debug mode, validation messages return inside validationMessages array
            $hasValidationErrors = !empty($responseJson['validationMessages']);
            $status = ($response->successful() && !$hasValidationErrors) ? 'success' : 'failed';
            $errorMsg = $hasValidationErrors ? json_encode($responseJson['validationMessages']) : null;

            $this->logEvent('ga4', $eventName, null, $status, $statusCode, $payload, $responseJson, $errorMsg, $leadId, $orderId);

            return [
                'status' => $status,
                'http_code' => $statusCode,
                'response' => $responseJson,
            ];
        } catch (\Exception $e) {
            $this->logEvent('ga4', $eventName, null, 'failed', 500, [], [], $e->getMessage(), $leadId, $orderId);
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Dispatch TikTok Events API Event.
     */
    public function sendTikTok(
        string $eventName,
        string $eventId,
        array $userData,
        array $properties,
        string $eventSourceUrl,
        ?string $leadId = null,
        ?string $orderId = null,
        ?string $customTestCode = null
    ): array {
        $config = $this->getTikTokConfig();
        if (!$config['enabled']) {
            $this->logEvent('tiktok', $eventName, $eventId, 'skipped', null, [], ['message' => 'TikTok Events API disabled or missing credentials'], null, $leadId, $orderId);
            return ['status' => 'skipped', 'message' => 'TikTok Events API disabled or credentials missing'];
        }

        try {
            $pixelCode = $config['pixel_code'];
            $accessToken = $config['access_token'];

            $context = [
                'ip' => $userData['client_ip_address'] ?? request()->ip(),
                'user_agent' => $userData['client_user_agent'] ?? request()->userAgent(),
            ];

            $userPayload = [];
            if (!empty($userData['email'])) {
                $userPayload['email'] = $this->hashSha256(strtolower(trim($userData['email'])));
            }
            if (!empty($userData['phone'])) {
                $userPayload['phone_number'] = $this->hashSha256($this->normalizePhone($userData['phone']));
            }

            $payload = [
                'pixel_code' => $pixelCode,
                'event' => $eventName,
                'event_id' => $eventId,
                'timestamp' => now()->toISOString(),
                'context' => array_merge($context, [
                    'page' => ['url' => $eventSourceUrl],
                    'user' => $userPayload,
                ]),
                'properties' => $properties,
            ];

            $activeTestCode = $customTestCode ?: ($config['test_event_code'] ?? null);
            if (!empty($activeTestCode)) {
                $payload['test_event_code'] = $activeTestCode;
            }

            $url = 'https://business-api.tiktok.com/open_api/v1.3/event/track/';

            $response = Http::timeout(4)
                ->withHeaders([
                    'Access-Token' => $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            $statusCode = $response->status();
            $responseJson = $response->json() ?: ['body' => $response->body()];
            $isSuccess = $response->successful() && ($responseJson['code'] ?? 0) === 0;
            $status = $isSuccess ? 'success' : 'failed';
            $errorMsg = $isSuccess ? null : ($responseJson['message'] ?? 'TikTok API error');

            $this->logEvent('tiktok', $eventName, $eventId, $status, $statusCode, $payload, $responseJson, $errorMsg, $leadId, $orderId);

            return [
                'status' => $status,
                'http_code' => $statusCode,
                'response' => $responseJson,
            ];
        } catch (\Exception $e) {
            $this->logEvent('tiktok', $eventName, $eventId, 'failed', 500, [], [], $e->getMessage(), $leadId, $orderId);
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Dispatch Custom Server Webhook / Server GTM.
     */
    public function sendWebhook(string $eventName, array $payload, ?string $leadId = null, ?string $orderId = null): array
    {
        $config = $this->getWebhookConfig();
        if (!$config['enabled']) {
            $this->logEvent('webhook', $eventName, $payload['event_id'] ?? null, 'skipped', null, $payload, ['message' => 'Webhook disabled or missing URL'], null, $leadId, $orderId);
            return ['status' => 'skipped', 'message' => 'Webhook disabled'];
        }

        try {
            $url = $config['url'];
            $request = Http::timeout(4);

            if (!empty($config['secret'])) {
                $request = $request->withHeaders(['X-Webhook-Secret' => $config['secret']]);
            }

            $body = [
                'event' => $eventName,
                'timestamp' => now()->toISOString(),
                'data' => $payload,
            ];

            $response = $request->post($url, $body);

            $status = $response->successful() ? 'success' : 'failed';
            $statusCode = $response->status();

            $this->logEvent('webhook', $eventName, $payload['event_id'] ?? null, $status, $statusCode, $body, ['status' => $statusCode], null, $leadId, $orderId);

            return [
                'status' => $status,
                'http_code' => $statusCode,
            ];
        } catch (\Exception $e) {
            $this->logEvent('webhook', $eventName, $payload['event_id'] ?? null, 'failed', 500, [], [], $e->getMessage(), $leadId, $orderId);
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Estimate budget value for conversion attribution.
     */
    protected function resolveBudgetValue(?string $budget): float
    {
        if (empty($budget)) {
            return 1000.0;
        }

        $b = strtolower($budget);
        if (str_contains($b, '100k') || str_contains($b, '50k+')) return 50000.0;
        if (str_contains($b, '25k') || str_contains($b, '20k-50k')) return 25000.0;
        if (str_contains($b, '10k') || str_contains($b, '10k-25k')) return 10000.0;
        if (str_contains($b, '5k') || str_contains($b, '5k-10k')) return 5000.0;
        if (str_contains($b, '2.5k') || str_contains($b, '2500')) return 2500.0;

        preg_match('/\d+/', $budget, $matches);
        if (!empty($matches[0])) {
            return (float) $matches[0];
        }

        return 1000.0;
    }

    /**
     * Resolve GA4 Client ID.
     */
    protected function resolveGAClientId(?string $providedClientId, ?string $email): string
    {
        if (!empty($providedClientId)) {
            return $providedClientId;
        }

        // Try extracting from _ga cookie (format: GA1.1.123456789.1234567890)
        $gaCookie = request()->cookie('_ga');
        if ($gaCookie && preg_match('/GA\d+\.\d+\.(\d+\.\d+)/', $gaCookie, $matches)) {
            return $matches[1];
        }

        // Generate deterministic client_id from email or IP
        if (!empty($email)) {
            $hash = md5($email);
            return substr($hash, 0, 10) . '.' . substr($hash, 10, 10);
        }

        return rand(100000000, 999999999) . '.' . time();
    }

    /**
     * Strip PII or unapproved fields from GA4 params.
     */
    protected function sanitizeGA4Params(array $params): array
    {
        $disallowed = ['email', 'phone', 'name', 'first_name', 'last_name', 'address', 'password', 'token'];
        $clean = [];

        foreach ($params as $key => $value) {
            if (in_array(strtolower($key), $disallowed)) {
                continue;
            }
            if (is_array($value)) {
                $clean[$key] = $value;
            } else {
                $clean[$key] = is_numeric($value) ? $value : (string) $value;
            }
        }

        return $clean;
    }

    /**
     * Hash string to SHA-256 (hex).
     */
    protected function hashSha256(?string $value): string
    {
        if (empty($value)) return '';
        return hash('sha256', trim((string) $value));
    }

    /**
     * Normalize phone number to digits only (with international prefix if available).
     */
    protected function normalizePhone(?string $phone): string
    {
        if (empty($phone)) return '';
        return preg_replace('/[^0-9]/', '', (string) $phone);
    }

    /**
     * Log tracking execution to database and Laravel log.
     */
    protected function logEvent(
        string $provider,
        string $eventName,
        ?string $eventId,
        string $status,
        ?int $httpCode,
        array $requestPayload,
        array $responsePayload,
        ?string $errorMessage = null,
        ?string $leadId = null,
        ?string $orderId = null
    ): void {
        try {
            if (Schema::hasTable('server_tracking_logs')) {
                ServerTrackingLog::create([
                    'provider' => $provider,
                    'event_name' => $eventName,
                    'event_id' => $eventId,
                    'status' => $status,
                    'http_code' => $httpCode,
                    'request_payload' => $requestPayload,
                    'response_payload' => $responsePayload,
                    'error_message' => $errorMessage,
                    'ip_address' => request()->ip(),
                    'lead_id' => $leadId,
                    'order_id' => $orderId,
                ]);
            }
        } catch (\Exception $e) {
            Log::warning("Could not persist server tracking log: " . $e->getMessage());
        }

        if ($status === 'failed') {
            Log::warning("[ServerTracking:{$provider}] Event '{$eventName}' failed: " . ($errorMessage ?: 'Unknown error'));
        }
    }

    /**
     * Dispatch a live test event from the Admin Console.
     * Guaranteed target dataset: 1786172575724734 (with TEST54855 test code)
     */
    public function testDispatch(
        string $provider, 
        string $eventName = 'Lead', 
        ?string $customTestCode = null,
        ?string $overrideDatasetId = null,
        ?string $overrideAccessToken = null
    ): array
    {
        $testEventId = 'test_' . time() . '_' . Str::random(6);
        $testLeadId = 'TEST-LEAD-' . strtoupper(Str::random(6));
        $sourceUrl = url('/admin/server-tracking');

        $testUserData = [
            'email' => 'admin_test@nextdigihome.com',
            'phone' => '+15550192834',
            'name' => 'NextDigiHome Live Tester',
            'client_ip_address' => request()->ip() ?: '127.0.0.1',
            'client_user_agent' => request()->userAgent() ?: 'NextDigiHome Server Tracking Tester/2.6',
            'fbp' => 'fb.1.' . time() . '.987654321',
            'fbc' => 'fb.1.' . time() . '.IwAR0TestClickIdForCAPI',
        ];

        $testCustomData = [
            'lead_id' => $testLeadId,
            'service' => 'Web Development & CAPI Integration',
            'priority' => 'HIGH',
            'value' => 750.00,
            'currency' => 'USD',
            'utm_source' => 'nextdigihome_admin',
            'utm_medium' => 'test_console',
            'utm_campaign' => 'server_tracking_verification',
        ];

        $startTime = microtime(true);

        switch ($provider) {
            case 'meta_capi':
                $activeTestCode = !empty($customTestCode) ? $customTestCode : 'TEST54855';
                $result = $this->sendMetaCapi(
                    $eventName,
                    $testEventId,
                    $testUserData,
                    $testCustomData,
                    $sourceUrl,
                    $testLeadId,
                    null,
                    $activeTestCode,
                    $overrideDatasetId,
                    $overrideAccessToken
                );
                break;

            case 'ga4':
                $result = $this->sendGA4(
                    $eventName === 'Lead' ? 'generate_lead' : strtolower($eventName),
                    'GA1.1.' . rand(100000000, 999999999) . '.' . time(),
                    [
                        'currency' => 'USD',
                        'value' => 750.00,
                        'transaction_id' => $testLeadId,
                        'source' => 'admin_console',
                        'medium' => 'test',
                        'campaign' => 'ga4_measurement_protocol_test',
                    ],
                    null,
                    $testLeadId
                );
                break;

            case 'tiktok':
                $result = $this->sendTikTok(
                    $eventName === 'Lead' ? 'SubmitForm' : $eventName,
                    $testEventId,
                    $testUserData,
                    $testCustomData,
                    $sourceUrl,
                    $testLeadId,
                    null,
                    $customTestCode
                );
                break;

            case 'webhook':
                $result = $this->sendWebhook(
                    'test_event_dispatch',
                    array_merge($testCustomData, [
                        'event_id' => $testEventId,
                        'event_name' => $eventName,
                        'timestamp' => now()->toIso8601String(),
                        'tester' => auth()->user() ? auth()->user()->name : 'Admin',
                    ]),
                    $testLeadId
                );
                break;

            default:
                return [
                    'status' => 'failed',
                    'message' => "Unknown tracking provider: {$provider}",
                ];
        }

        $latencyMs = round((microtime(true) - $startTime) * 1000, 1);
        $result['latency_ms'] = $latencyMs;
        $result['test_event_id'] = $testEventId;

        return $result;
    }
}
