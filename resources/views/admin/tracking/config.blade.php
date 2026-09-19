@extends('admin.dashboard.master')

@section('title', 'Server Tracking Configuration - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header mb-4">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon" style="background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%); color: #070b14; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-sliders-h"></i>
        </div>
        <div class="dashboard-header-content ml-3">
            <h1 class="h3 font-weight-bold mb-1" style="color: #ffffff;">Server Tracking Configuration</h1>
            <p class="text-muted small mb-0">Manage API keys, access tokens, and server-side tracking pipelines</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-light btn-sm">
            <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center mb-4" style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #10b981;">
    <i class="fa fa-check-circle mr-2"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

<form method="POST" action="{{ route('admin.server-tracking.config.update') }}">
    @csrf

    <div class="row">
        <!-- Meta Conversions API (CAPI) -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100" style="background: #0f1523; border: 1px solid rgba(0,212,170,0.25); border-radius: 16px;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-facebook text-primary mr-2" style="font-size: 20px;"></i>
                        <h5 class="card-title text-white font-weight-bold mb-0">Meta Conversions API (CAPI)</h5>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="meta_capi_enabled" name="meta_capi_enabled" value="1" {{ ($settings->meta_capi_enabled ?? $metaConfig['enabled']) ? 'checked' : '' }}>
                        <label class="custom-control-label text-white small" for="meta_capi_enabled">Enabled</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">Meta Pixel / Dataset ID</label>
                        <input type="text" class="form-control" name="meta_pixel_id" value="{{ old('meta_pixel_id', $settings->meta_pixel_id ?? $metaConfig['pixel_id']) }}" placeholder="e.g. 981230941262806" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                        <small class="form-text text-muted">Found in Meta Events Manager &gt; Data Sources &gt; Settings.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">Conversions API Access Token</label>
                        <textarea class="form-control font-mono" name="meta_capi_access_token" rows="3" placeholder="EAAB... (Long-lived System User or CAPI Access Token)" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff; font-size: 11px;">{{ old('meta_capi_access_token', $settings->meta_capi_access_token ?? $metaConfig['access_token']) }}</textarea>
                        <small class="form-text text-muted">Generated under Meta Events Manager &gt; Settings &gt; Conversions API &gt; Generate access token.</small>
                    </div>

                    <div class="form-group mb-0">
                        <label class="text-white small font-weight-bold">Test Event Code (Optional)</label>
                        <input type="text" class="form-control font-mono" name="meta_capi_test_event_code" value="{{ old('meta_capi_test_event_code', $settings->meta_capi_test_event_code ?? $metaConfig['test_event_code']) }}" placeholder="e.g. TEST12345" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                        <small class="form-text text-muted">Enter code from the "Test events" tab in Events Manager to verify server events live.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Analytics 4 (GA4) -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100" style="background: #0f1523; border: 1px solid rgba(56,189,248,0.25); border-radius: 16px;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-google text-warning mr-2" style="font-size: 20px;"></i>
                        <h5 class="card-title text-white font-weight-bold mb-0">GA4 Measurement Protocol</h5>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="ga4_server_enabled" name="ga4_server_enabled" value="1" {{ ($settings->ga4_server_enabled ?? $ga4Config['enabled']) ? 'checked' : '' }}>
                        <label class="custom-control-label text-white small" for="ga4_server_enabled">Enabled</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">GA4 Measurement ID</label>
                        <input type="text" class="form-control" name="ga4_measurement_id" value="{{ old('ga4_measurement_id', $settings->ga4_measurement_id ?? $settings->google_analytics_id ?? $ga4Config['measurement_id']) }}" placeholder="e.g. G-XXXXXXXXXX" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                        <small class="form-text text-muted">Found in Google Analytics &gt; Admin &gt; Data Streams &gt; Stream ID.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">Measurement Protocol API Secret</label>
                        <input type="password" class="form-control font-mono" name="ga4_api_secret" value="{{ old('ga4_api_secret', $settings->ga4_api_secret ?? $ga4Config['api_secret']) }}" placeholder="Enter GA4 API Secret" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                        <small class="form-text text-muted">Generated in GA4 Admin &gt; Data Streams &gt; Measurement Protocol API secrets.</small>
                    </div>

                    <div class="alert alert-dark p-3 mb-0" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: #94a3b8;">
                        <i class="fa fa-info-circle text-info mr-1"></i> GA4 dispatches send server-side <code>generate_lead</code> and <code>purchase</code> hits with client-side deduplication.
                    </div>
                </div>
            </div>
        </div>

        <!-- TikTok Events API -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100" style="background: #0f1523; border: 1px solid rgba(244,63,94,0.25); border-radius: 16px;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-tiktok text-light mr-2" style="font-size: 18px;"></i>
                        <h5 class="card-title text-white font-weight-bold mb-0">TikTok Events API</h5>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="tiktok_server_enabled" name="tiktok_server_enabled" value="1" {{ ($settings->tiktok_server_enabled ?? $tiktokConfig['enabled']) ? 'checked' : '' }}>
                        <label class="custom-control-label text-white small" for="tiktok_server_enabled">Enabled</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">TikTok Pixel Code / ID</label>
                        <input type="text" class="form-control" name="tiktok_pixel_code" value="{{ old('tiktok_pixel_code', $settings->tiktok_pixel_code ?? $tiktokConfig['pixel_code']) }}" placeholder="e.g. CXXXXXXXXXX" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">TikTok Long-Term Access Token</label>
                        <textarea class="form-control font-mono" name="tiktok_access_token" rows="2" placeholder="Enter TikTok Events API Access Token" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff; font-size: 11px;">{{ old('tiktok_access_token', $settings->tiktok_access_token ?? $tiktokConfig['access_token']) }}</textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label class="text-white small font-weight-bold">Test Event Code (Optional)</label>
                        <input type="text" class="form-control font-mono" name="tiktok_test_event_code" value="{{ old('tiktok_test_event_code', $settings->tiktok_test_event_code ?? $tiktokConfig['test_event_code']) }}" placeholder="e.g. TEST12345" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Webhook / Server GTM -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100" style="background: #0f1523; border: 1px solid rgba(139,92,246,0.25); border-radius: 16px;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-network-wired text-info mr-2" style="font-size: 18px;"></i>
                        <h5 class="card-title text-white font-weight-bold mb-0">Server Webhook / sGTM Container</h5>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="server_tracking_webhook_enabled" name="server_tracking_webhook_enabled" value="1" {{ ($settings->server_tracking_webhook_enabled ?? $webhookConfig['enabled']) ? 'checked' : '' }}>
                        <label class="custom-control-label text-white small" for="server_tracking_webhook_enabled">Enabled</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">Server Webhook Endpoint URL</label>
                        <input type="url" class="form-control" name="server_tracking_webhook_url" value="{{ old('server_tracking_webhook_url', $settings->server_tracking_webhook_url ?? $webhookConfig['url']) }}" placeholder="https://sgtm.yourdomain.com/data" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                        <small class="form-text text-muted">Supports Server-Side Google Tag Manager (sGTM), Stape, Make, or Zapier webhooks.</small>
                    </div>

                    <div class="alert alert-dark p-3 mb-0" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: #94a3b8;">
                        <i class="fa fa-shield-alt text-primary mr-1"></i> Dispatches include normalized user metadata, attribution UTMs, event IDs, and payload parameters.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Save Action Bar -->
    <div class="card p-3 d-flex flex-row justify-content-between align-items-center" style="background: #0f1523; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
        <span class="text-muted small">
            <i class="fa fa-lock mr-1 text-success"></i> Credentials are encrypted in transit and hashed using SHA-256 for ad platform transmissions.
        </span>
        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
            <i class="fa fa-save mr-1"></i> Save Tracking Credentials
        </button>
    </div>
</form>
@endsection
