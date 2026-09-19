@extends('admin.dashboard.master')

@section('title', 'Server Tracking & CAPI Configuration - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    .config-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .config-panel .card-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #edf0f4 !important;
        border-radius: 12px 12px 0 0 !important;
        padding: 18px 22px;
    }
    .config-panel .card-body {
        padding: 22px;
    }
    .config-panel-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .copy-pill-btn {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .copy-pill-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
</style>

<div class="premium-page">
    <div class="container-fluid">

        <!-- Hero Header -->
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">
                    <i class="fas fa-sliders-h mr-1"></i> Tracking Credentials &amp; Cloud Relays
                </div>
                <h2>Server Tracking &amp; CAPI Configuration</h2>
                <p>Manage API keys, access tokens, and server-side tracking pipelines</p>
            </div>
            <div class="premium-actions">
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-light">
                    <i class="fas fa-list"></i> Audit Logs
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px;">
                <i class="fas fa-check-circle mr-2" style="font-size: 16px;"></i>
                <div class="font-weight-500">{{ session('success') }}</div>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; border-radius: 10px;">
                <h6 class="font-weight-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i> Please correct the following errors:</h6>
                <ul class="mb-0 small pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Navigation Tabs Bar -->
        <div class="premium-nav">
            <a href="{{ route('admin.server-tracking.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard Overview
            </a>
            <a href="{{ route('admin.server-tracking.config') }}" class="active">
                <i class="fas fa-sliders-h"></i> Pipeline Credentials
            </a>
            <a href="{{ route('admin.server-tracking.logs') }}">
                <i class="fas fa-list-alt"></i> Audit Logs &amp; Inspector
            </a>
        </div>

        <!-- Privacy & Security Notice Banner -->
        <div class="alert p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap" style="background: #ecfdf5; border: 1px solid #a7f3d0; border-left: 4px solid #059669; border-radius: 8px;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <i class="fas fa-shield-alt text-success mr-3" style="font-size: 22px;"></i>
                <div>
                    <strong class="text-dark d-block" style="font-size: 13px;">Zero Signal Loss &bull; Privacy-Safe Edge Transmission</strong>
                    <span class="text-muted small">Customer emails and phone numbers are normalized and hashed using SHA-256 before transmission to comply with privacy regulations (GDPR/CCPA).</span>
                </div>
            </div>
            <div>
                <span class="badge badge-success px-3 py-1 font-mono" style="font-size: 11px; border-radius: 10px;">
                    <i class="fas fa-lock mr-1"></i> SHA-256 Hashing Active
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.server-tracking.config.update') }}">
            @csrf

            <div class="row">
                <!-- Meta Conversions API (CAPI) Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="config-panel">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="config-panel-icon mr-3" style="background: #eff6ff; color: #2563eb;">
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-dark font-weight-bold mb-0" style="font-size: 15px;">Meta Conversions API (CAPI)</h5>
                                    <small class="text-muted">Direct Server-to-Meta Graph API</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="meta_capi_enabled" name="meta_capi_enabled" value="1" {{ old('meta_capi_enabled', $settings->meta_capi_enabled ?? $metaConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-dark small font-weight-bold" for="meta_capi_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-dark small font-weight-bold">Meta Pixel / Dataset ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="meta_pixel_id" id="meta_pixel_id" value="{{ old('meta_pixel_id', $settings->meta_pixel_id ?? $metaConfig['pixel_id']) }}" placeholder="e.g. 981230941262806" style="border-color: #cbd5e1;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('meta_pixel_id')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Found in Meta Events Manager &gt; Data Sources &gt; Settings &gt; Dataset ID.</small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="text-dark small font-weight-bold mb-0">Conversions API Access Token</label>
                                    <button type="button" class="btn btn-link btn-xs text-primary p-0" onclick="toggleSecretMask('meta_token_field', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Token
                                    </button>
                                </div>
                                <textarea class="form-control font-mono" id="meta_token_field" name="meta_capi_access_token" rows="3" placeholder="EAAB... (Long-lived System User or CAPI Access Token)" style="border-color: #cbd5e1; font-size: 11px;">{{ old('meta_capi_access_token', $settings->meta_capi_access_token ?? $metaConfig['access_token']) }}</textarea>
                                <small class="form-text text-muted">Generate in Meta Events Manager &gt; Settings &gt; Conversions API &gt; Generate access token.</small>
                            </div>

                            <div class="form-group mb-0">
                                <label class="text-dark small font-weight-bold">Test Event Code (Optional)</label>
                                <input type="text" class="form-control font-mono" name="meta_capi_test_event_code" value="{{ old('meta_capi_test_event_code', $settings->meta_capi_test_event_code ?? $metaConfig['test_event_code']) }}" placeholder="e.g. TEST12345" style="border-color: #cbd5e1;">
                                <small class="form-text text-muted">From the "Test events" tab in Events Manager to route live events directly into your test feed.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Analytics 4 (GA4) Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="config-panel">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="config-panel-icon mr-3" style="background: #fffbeb; color: #d97706;">
                                    <i class="fab fa-google"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-dark font-weight-bold mb-0" style="font-size: 15px;">GA4 Measurement Protocol</h5>
                                    <small class="text-muted">Server-to-Google Analytics Engine</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ga4_server_enabled" name="ga4_server_enabled" value="1" {{ old('ga4_server_enabled', $settings->ga4_server_enabled ?? $ga4Config['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-dark small font-weight-bold" for="ga4_server_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-dark small font-weight-bold">GA4 Measurement ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="ga4_measurement_id" id="ga4_measurement_id" value="{{ old('ga4_measurement_id', $settings->ga4_measurement_id ?? $settings->google_analytics_id ?? $ga4Config['measurement_id']) }}" placeholder="e.g. G-XXXXXXXXXX" style="border-color: #cbd5e1;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('ga4_measurement_id')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Found in Google Analytics 4 &gt; Admin &gt; Data Streams &gt; Web Stream &gt; Measurement ID.</small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="text-dark small font-weight-bold mb-0">Measurement Protocol API Secret</label>
                                    <button type="button" class="btn btn-link btn-xs text-primary p-0" onclick="toggleSecretInput('ga4_api_secret', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Secret
                                    </button>
                                </div>
                                <input type="password" class="form-control font-mono" id="ga4_api_secret" name="ga4_api_secret" value="{{ old('ga4_api_secret', $settings->ga4_api_secret ?? $ga4Config['api_secret']) }}" placeholder="Enter GA4 API Secret" style="border-color: #cbd5e1;">
                                <small class="form-text text-muted">Generate in GA4 Admin &gt; Data Streams &gt; Measurement Protocol API secrets &gt; Create.</small>
                            </div>

                            <div class="p-3 rounded mb-0" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #475569;">
                                <i class="fas fa-info-circle text-primary mr-1"></i> Dispatches emit server-side <code>generate_lead</code>, <code>purchase</code>, and <code>view_item</code> hits with automatic client ID deduplication.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TikTok Events API Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="config-panel">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="config-panel-icon mr-3" style="background: #fff1f2; color: #be123c;">
                                    <i class="fab fa-tiktok"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-dark font-weight-bold mb-0" style="font-size: 15px;">TikTok Events API</h5>
                                    <small class="text-muted">Business API v1.3 Server Endpoint</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="tiktok_server_enabled" name="tiktok_server_enabled" value="1" {{ old('tiktok_server_enabled', $settings->tiktok_server_enabled ?? $tiktokConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-dark small font-weight-bold" for="tiktok_server_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-dark small font-weight-bold">TikTok Pixel Code / ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="tiktok_pixel_code" id="tiktok_pixel_code" value="{{ old('tiktok_pixel_code', $settings->tiktok_pixel_code ?? $tiktokConfig['pixel_code']) }}" placeholder="e.g. CXXXXXXXXXX" style="border-color: #cbd5e1;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('tiktok_pixel_code')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Found in TikTok Ads Manager &gt; Assets &gt; Events &gt; Web Events &gt; Pixel ID.</small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="text-dark small font-weight-bold mb-0">TikTok Long-Term Access Token</label>
                                    <button type="button" class="btn btn-link btn-xs text-primary p-0" onclick="toggleSecretMask('tiktok_token_field', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Token
                                    </button>
                                </div>
                                <textarea class="form-control font-mono" id="tiktok_token_field" name="tiktok_access_token" rows="2" placeholder="Enter TikTok Events API Access Token" style="border-color: #cbd5e1; font-size: 11px;">{{ old('tiktok_access_token', $settings->tiktok_access_token ?? $tiktokConfig['access_token']) }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label class="text-dark small font-weight-bold">Test Event Code (Optional)</label>
                                <input type="text" class="form-control font-mono" name="tiktok_test_event_code" value="{{ old('tiktok_test_event_code', $settings->tiktok_test_event_code ?? $tiktokConfig['test_event_code']) }}" placeholder="e.g. TEST12345" style="border-color: #cbd5e1;">
                                <small class="form-text text-muted">Obtained from the Test Events tab in TikTok Events Manager.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Webhook / sGTM Container Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="config-panel">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="config-panel-icon mr-3" style="background: #f5f3ff; color: #7c3aed;">
                                    <i class="fas fa-network-wired"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-dark font-weight-bold mb-0" style="font-size: 15px;">Server Webhook / sGTM Container</h5>
                                    <small class="text-muted">Cloud Tag Manager &amp; Custom Relays</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="server_tracking_webhook_enabled" name="server_tracking_webhook_enabled" value="1" {{ old('server_tracking_webhook_enabled', $settings->server_tracking_webhook_enabled ?? $webhookConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-dark small font-weight-bold" for="server_tracking_webhook_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-dark small font-weight-bold">Server Webhook Endpoint URL</label>
                                <div class="input-group">
                                    <input type="url" class="form-control font-mono" name="server_tracking_webhook_url" id="server_tracking_webhook_url" value="{{ old('server_tracking_webhook_url', $settings->server_tracking_webhook_url ?? $webhookConfig['url']) }}" placeholder="https://sgtm.yourdomain.com/data" style="border-color: #cbd5e1;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('server_tracking_webhook_url')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Supports Server-Side Google Tag Manager (sGTM), Stape, Make, or Zapier webhooks.</small>
                            </div>

                            <div class="p-3 rounded mb-0" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #475569;">
                                <i class="fas fa-code text-primary mr-1"></i> Webhooks deliver full conversion payloads as JSON POST requests, including event IDs, lead IDs, UTM attribution models, and timestamp headers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="card border-0 p-3 mb-4 d-flex flex-row justify-content-between align-items-center flex-wrap" style="background: #ffffff; border: 1px solid #e2e8f0 !important; border-radius: 12px; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <i class="fas fa-lock text-success mr-2" style="font-size: 18px;"></i>
                    <span class="text-muted small">
                        Tracking credentials are stored safely in database and accessed exclusively through secure backend services.
                    </span>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-sm btn-outline-secondary mr-2" style="border-radius: 8px;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-sm btn-primary px-4 font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-save mr-1"></i> Save Tracking Credentials
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
function copyInput(elementId) {
    const input = document.getElementById(elementId);
    if (!input || !input.value) {
        alert('Field is empty');
        return;
    }
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Copied to clipboard!');
    });
}

function toggleSecretInput(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<i class="fas fa-eye-slash mr-1"></i> Hide Secret';
    } else {
        input.type = 'password';
        btn.innerHTML = '<i class="fas fa-eye mr-1"></i> Show Secret';
    }
}

function toggleSecretMask(textareaId, btn) {
    const textarea = document.getElementById(textareaId);
    if (textarea.style.webkitTextSecurity === 'disc') {
        textarea.style.webkitTextSecurity = 'none';
        btn.innerHTML = '<i class="fas fa-eye-slash mr-1"></i> Hide Token';
    } else {
        textarea.style.webkitTextSecurity = 'disc';
        btn.innerHTML = '<i class="fas fa-eye mr-1"></i> Show Token';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    ['meta_token_field', 'tiktok_token_field'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.webkitTextSecurity = 'disc';
        }
    });
});
</script>
@endsection
