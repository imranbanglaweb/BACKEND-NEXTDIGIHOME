<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Server-Side Tracking Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration manages server-to-server tracking integrations,
    | including Google Analytics 4 Measurement Protocol, Meta Conversions API
    | (CAPI), TikTok Events API, and custom server webhooks.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Google Analytics 4 (GA4) Measurement Protocol
    |--------------------------------------------------------------------------
    */
    'ga4' => [
        'enabled' => env('GA4_SERVER_TRACKING_ENABLED', true),
        'measurement_id' => env('GA4_MEASUREMENT_ID', env('GOOGLE_ANALYTICS_ID', '')),
        'api_secret' => env('GA4_API_SECRET', ''),
        'debug_mode' => env('GA4_DEBUG_MODE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Meta Conversions API (CAPI) / Facebook Pixel Server-Side
    |--------------------------------------------------------------------------
    */
    'meta_capi' => [
        'enabled' => env('META_CAPI_ENABLED', true),
        'pixel_id' => env('META_PIXEL_ID', '981230941262806'),
        'access_token' => env('META_CAPI_ACCESS_TOKEN', ''),
        'test_event_code' => env('META_CAPI_TEST_EVENT_CODE', ''),
        'api_version' => env('META_GRAPH_API_VERSION', 'v20.0'),
    ],

    /*
    |--------------------------------------------------------------------------
    | TikTok Events API (Server-Side)
    |--------------------------------------------------------------------------
    */
    'tiktok' => [
        'enabled' => env('TIKTOK_SERVER_TRACKING_ENABLED', false),
        'pixel_code' => env('TIKTOK_PIXEL_CODE', env('TIKTOK_PIXEL_ID', '')),
        'access_token' => env('TIKTOK_ACCESS_TOKEN', ''),
        'test_event_code' => env('TIKTOK_TEST_EVENT_CODE', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Server Webhook / Server-Side GTM (sGTM)
    |--------------------------------------------------------------------------
    */
    'webhook' => [
        'enabled' => env('SERVER_TRACKING_WEBHOOK_ENABLED', false),
        'url' => env('SERVER_TRACKING_WEBHOOK_URL', ''),
        'secret' => env('SERVER_TRACKING_WEBHOOK_SECRET', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit & Health Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => env('SERVER_TRACKING_LOGGING_ENABLED', true),
        'retention_days' => 30,
    ],

];
