@extends('admin.dashboard.master')

@section('title', 'Server Tracking & CAPI Configuration - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    .config-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .config-panel:hover {
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
    }
    .config-panel .card-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        border-radius: 14px 14px 0 0 !important;
        padding: 20px 24px;
    }
    .config-panel .card-body {
        padding: 24px;
    }
    .config-panel-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .config-panel .card-title {
        font-size: 18px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.01em;
    }
    .config-panel .card-subtitle {
        font-size: 13.5px !important;
        color: #64748b !important;
        font-weight: 500;
    }
    .config-panel label {
        font-size: 14.5px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        margin-bottom: 7px;
    }
    .config-panel .form-control {
        font-size: 14.5px !important;
        color: #0f172a !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px !important;
        min-height: 46px;
        padding: 10px 14px !important;
        font-weight: 500;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .config-panel .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18) !important;
    }
    .config-panel textarea.form-control {
        min-height: 100px;
        font-size: 13.5px !important;
        line-height: 1.6 !important;
    }
    .config-panel .form-text {
        font-size: 13.5px !important;
        color: #64748b !important;
        margin-top: 6px;
        line-height: 1.5;
    }
    .config-panel .custom-control-label {
        font-size: 14.5px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        cursor: pointer;
    }
    .copy-pill-btn {
        background: #f1f5f9;
        border: 1.5px solid #cbd5e1;
        color: #334155;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13.5px;
        font-weight: 600;
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
        <div class="alert p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap" style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-left: 5px solid #059669; border-radius: 12px;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 10px; background: #d1fae5; color: #059669; font-size: 22px; flex-shrink: 0;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <strong class="d-block text-dark font-weight-bold" style="font-size: 15.5px; letter-spacing: -0.01em;">Zero Signal Loss &bull; Privacy-Safe Edge Transmission</strong>
                    <span style="font-size: 14px; color: #065f46; line-height: 1.5;">Customer emails and phone numbers are normalized and hashed using SHA-256 before transmission to comply with privacy regulations (GDPR/CCPA).</span>
                </div>
            </div>
            <div>
                <span class="badge badge-success px-3 py-2 font-mono font-weight-bold" style="font-size: 13px; border-radius: 8px;">
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
                                    <h5 class="card-title mb-0">Meta Conversions API (CAPI)</h5>
                                    <div class="card-subtitle">Direct Server-to-Meta Graph API</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="meta_capi_enabled" name="meta_capi_enabled" value="1" {{ old('meta_capi_enabled', $settings->meta_capi_enabled ?? $metaConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="meta_capi_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="meta_pixel_id">Meta Pixel / Dataset ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="meta_pixel_id" id="meta_pixel_id" value="{{ old('meta_pixel_id', $settings->meta_pixel_id ?? $metaConfig['pixel_id']) }}" placeholder="e.g. 981230941262806">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('meta_pixel_id')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="form-text">Found in Meta Events Manager &gt; Data Sources &gt; Settings &gt; Dataset ID.</div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="meta_token_field" class="mb-0">Conversions API Access Token</label>
                                    <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretMask('meta_token_field', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Token
                                    </button>
                                </div>
                                <textarea class="form-control font-mono" id="meta_token_field" name="meta_capi_access_token" rows="3" placeholder="EAAB... (Long-lived System User or CAPI Access Token)">{{ old('meta_capi_access_token', $settings->meta_capi_access_token ?? $metaConfig['access_token']) }}</textarea>
                                <div class="form-text">Generate in Meta Events Manager &gt; Settings &gt; Conversions API &gt; Generate access token.</div>
                            </div>

                            <div class="form-group mb-0">
                                <label for="meta_capi_test_event_code">Test Event Code (Optional)</label>
                                <input type="text" class="form-control font-mono" id="meta_capi_test_event_code" name="meta_capi_test_event_code" value="{{ old('meta_capi_test_event_code', $settings->meta_capi_test_event_code ?? $metaConfig['test_event_code']) }}" placeholder="e.g. TEST12345">
                                <div class="form-text">From the "Test events" tab in Events Manager to route live events directly into your test feed.</div>
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
                                    <h5 class="card-title mb-0">GA4 Measurement Protocol</h5>
                                    <div class="card-subtitle">Server-to-Google Analytics Engine</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ga4_server_enabled" name="ga4_server_enabled" value="1" {{ old('ga4_server_enabled', $settings->ga4_server_enabled ?? $ga4Config['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="ga4_server_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="ga4_measurement_id">GA4 Measurement ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="ga4_measurement_id" id="ga4_measurement_id" value="{{ old('ga4_measurement_id', $settings->ga4_measurement_id ?? $settings->google_analytics_id ?? $ga4Config['measurement_id']) }}" placeholder="e.g. G-XXXXXXXXXX">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('ga4_measurement_id')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="form-text">Found in Google Analytics 4 &gt; Admin &gt; Data Streams &gt; Web Stream &gt; Measurement ID.</div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="ga4_api_secret" class="mb-0">Measurement Protocol API Secret</label>
                                    <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretInput('ga4_api_secret', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Secret
                                    </button>
                                </div>
                                <input type="password" class="form-control font-mono" id="ga4_api_secret" name="ga4_api_secret" value="{{ old('ga4_api_secret', $settings->ga4_api_secret ?? $ga4Config['api_secret']) }}" placeholder="Enter GA4 API Secret">
                                <div class="form-text">Generate in GA4 Admin &gt; Data Streams &gt; Measurement Protocol API secrets &gt; Create.</div>
                            </div>

                            <div class="p-3 mb-0" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13.5px; color: #334155; line-height: 1.6;">
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
                                    <h5 class="card-title mb-0">TikTok Events API</h5>
                                    <div class="card-subtitle">Business API v1.3 Server Endpoint</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="tiktok_server_enabled" name="tiktok_server_enabled" value="1" {{ old('tiktok_server_enabled', $settings->tiktok_server_enabled ?? $tiktokConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="tiktok_server_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="tiktok_pixel_code">TikTok Pixel Code / ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="tiktok_pixel_code" id="tiktok_pixel_code" value="{{ old('tiktok_pixel_code', $settings->tiktok_pixel_code ?? $tiktokConfig['pixel_code']) }}" placeholder="e.g. CXXXXXXXXXX">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('tiktok_pixel_code')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="form-text">Found in TikTok Ads Manager &gt; Assets &gt; Events &gt; Web Events &gt; Pixel ID.</div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="tiktok_token_field" class="mb-0">TikTok Long-Term Access Token</label>
                                    <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretMask('tiktok_token_field', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Token
                                    </button>
                                </div>
                                <textarea class="form-control font-mono" id="tiktok_token_field" name="tiktok_access_token" rows="2" placeholder="Enter TikTok Events API Access Token">{{ old('tiktok_access_token', $settings->tiktok_access_token ?? $tiktokConfig['access_token']) }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label for="tiktok_test_event_code">Test Event Code (Optional)</label>
                                <input type="text" class="form-control font-mono" id="tiktok_test_event_code" name="tiktok_test_event_code" value="{{ old('tiktok_test_event_code', $settings->tiktok_test_event_code ?? $tiktokConfig['test_event_code']) }}" placeholder="e.g. TEST12345">
                                <div class="form-text">Obtained from the Test Events tab in TikTok Events Manager.</div>
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
                                    <h5 class="card-title mb-0">Server Webhook / sGTM Container</h5>
                                    <div class="card-subtitle">Cloud Tag Manager &amp; Custom Relays</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="server_tracking_webhook_enabled" name="server_tracking_webhook_enabled" value="1" {{ old('server_tracking_webhook_enabled', $settings->server_tracking_webhook_enabled ?? $webhookConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="server_tracking_webhook_enabled">Enabled</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="server_tracking_webhook_url">Server Webhook Endpoint URL</label>
                                <div class="input-group">
                                    <input type="url" class="form-control font-mono" name="server_tracking_webhook_url" id="server_tracking_webhook_url" value="{{ old('server_tracking_webhook_url', $settings->server_tracking_webhook_url ?? $webhookConfig['url']) }}" placeholder="https://sgtm.yourdomain.com/data">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('server_tracking_webhook_url')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <div class="form-text">Supports Server-Side Google Tag Manager (sGTM), Stape, Make, or Zapier webhooks.</div>
                            </div>

                            <div class="p-3 mb-0" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13.5px; color: #334155; line-height: 1.6;">
                                <i class="fas fa-code text-primary mr-1"></i> Webhooks deliver full conversion payloads as JSON POST requests, including event IDs, lead IDs, UTM attribution models, and timestamp headers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="card border-0 p-3 mb-4 d-flex flex-row justify-content-between align-items-center flex-wrap" style="background: #ffffff; border: 1px solid #e2e8f0 !important; border-radius: 14px; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 8px; background: #ecfdf5; color: #059669; font-size: 18px; flex-shrink: 0;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <span style="font-size: 14px; color: #475569; font-weight: 500;">
                        Tracking credentials are stored safely in database and accessed exclusively through secure backend services.
                    </span>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-secondary px-3 py-2 mr-2 font-weight-bold" style="border-radius: 9px; font-size: 14.5px;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 9px; font-size: 15px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
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
