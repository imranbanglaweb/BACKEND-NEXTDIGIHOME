@extends('admin.dashboard.master')

@section('title', 'Server Tracking & CAPI Configuration - ' . config('app.name'))

@section('main_content')
<section class="content-body py-4" style="background: linear-gradient(135deg, #0b0d14 0%, #111827 50%, #0d1322 100%); min-height: 100vh; color: #f1f5f9;">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.07) !important;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: #ffffff; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 0 24px rgba(59, 130, 246, 0.35);">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="ml-3">
                    <h3 class="font-weight-bold text-white mb-0" style="letter-spacing: -0.5px;">
                        Server Tracking &amp; CAPI Configuration
                    </h3>
                    <p class="text-muted small mb-0 mt-1">
                        Manage API tokens, measurement secrets, and direct cloud conversion channels
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-sm btn-outline-light mr-2" style="border-radius: 8px; padding: 7px 14px; border-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-info" style="border-radius: 8px; padding: 7px 14px; border-color: rgba(56, 189, 248, 0.4);">
                    <i class="fas fa-list mr-1"></i> Audit Logs
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; border-radius: 12px;">
                <i class="fas fa-check-circle mr-2" style="font-size: 18px;"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="close text-white ml-auto" data-dismiss="alert" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.35); color: #fb7185; border-radius: 12px;">
                <h6 class="font-weight-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i> Please correct the following errors:</h6>
                <ul class="mb-0 small pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Security & Architecture Info Box -->
        <div class="alert alert-dark p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.2); border-radius: 12px;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <i class="fas fa-shield-alt text-info mr-3" style="font-size: 24px;"></i>
                <div>
                    <span class="font-weight-bold text-white d-block" style="font-size: 13px;">Zero Signal Loss &bull; Privacy-Safe Edge Architecture</span>
                    <span class="text-muted small">Customer PII (emails &amp; phone numbers) is automatically converted to lowercase, trimmed, and hashed with SHA-256 before transmission.</span>
                </div>
            </div>
            <div>
                <span class="badge badge-pill badge-success px-3 py-1 font-mono" style="font-size: 11px;">
                    <i class="fas fa-lock mr-1"></i> SHA-256 Enabled
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.server-tracking.config.update') }}">
            @csrf

            <div class="row">
                <!-- Meta Conversions API (CAPI) Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid rgba(24, 119, 242, 0.3) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.3);">
                        <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: rgba(24, 119, 242, 0.08); border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <div class="d-flex align-items-center">
                                <div style="background: rgba(24, 119, 242, 0.2); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="mr-3">
                                    <i class="fab fa-facebook text-primary" style="font-size: 20px;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-white font-weight-bold mb-0">Meta Conversions API (CAPI)</h5>
                                    <small class="text-muted">Direct Server-to-Meta Graph API</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="meta_capi_enabled" name="meta_capi_enabled" value="1" {{ old('meta_capi_enabled', $settings->meta_capi_enabled ?? $metaConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-white small font-weight-bold" for="meta_capi_enabled">Active</label>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-group mb-3">
                                <label class="text-white small font-weight-bold">Meta Pixel / Dataset ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="meta_pixel_id" id="meta_pixel_id" value="{{ old('meta_pixel_id', $settings->meta_pixel_id ?? $metaConfig['pixel_id']) }}" placeholder="e.g. 981230941262806" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('meta_pixel_id')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Found in Meta Events Manager &gt; Data Sources &gt; Settings &gt; Dataset ID.</small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="text-white small font-weight-bold mb-0">Conversions API Access Token</label>
                                    <button type="button" class="btn btn-link btn-xs text-info p-0" onclick="toggleSecretMask('meta_token_field', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Token
                                    </button>
                                </div>
                                <textarea class="form-control font-mono secret-mask" id="meta_token_field" name="meta_capi_access_token" rows="3" placeholder="EAAB... (Long-lived System User or CAPI Access Token)" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff; font-size: 11px;">{{ old('meta_capi_access_token', $settings->meta_capi_access_token ?? $metaConfig['access_token']) }}</textarea>
                                <small class="form-text text-muted">Generate in Meta Events Manager &gt; Settings &gt; Conversions API &gt; Generate access token.</small>
                            </div>

                            <div class="form-group mb-0">
                                <label class="text-white small font-weight-bold">Test Event Code (Optional)</label>
                                <input type="text" class="form-control font-mono" name="meta_capi_test_event_code" value="{{ old('meta_capi_test_event_code', $settings->meta_capi_test_event_code ?? $metaConfig['test_event_code']) }}" placeholder="e.g. TEST12345" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                <small class="form-text text-muted">From the "Test events" tab in Events Manager to route live events directly into your test feed.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Analytics 4 (GA4) Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid rgba(245, 158, 11, 0.3) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.3);">
                        <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: rgba(245, 158, 11, 0.08); border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <div class="d-flex align-items-center">
                                <div style="background: rgba(245, 158, 11, 0.2); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="mr-3">
                                    <i class="fab fa-google text-warning" style="font-size: 20px;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-white font-weight-bold mb-0">GA4 Measurement Protocol</h5>
                                    <small class="text-muted">Server-to-Google Analytics Engine</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="ga4_server_enabled" name="ga4_server_enabled" value="1" {{ old('ga4_server_enabled', $settings->ga4_server_enabled ?? $ga4Config['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-white small font-weight-bold" for="ga4_server_enabled">Active</label>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-group mb-3">
                                <label class="text-white small font-weight-bold">GA4 Measurement ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="ga4_measurement_id" id="ga4_measurement_id" value="{{ old('ga4_measurement_id', $settings->ga4_measurement_id ?? $settings->google_analytics_id ?? $ga4Config['measurement_id']) }}" placeholder="e.g. G-XXXXXXXXXX" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('ga4_measurement_id')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Found in Google Analytics 4 &gt; Admin &gt; Data Streams &gt; Web Stream &gt; Measurement ID.</small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="text-white small font-weight-bold mb-0">Measurement Protocol API Secret</label>
                                    <button type="button" class="btn btn-link btn-xs text-info p-0" onclick="toggleSecretInput('ga4_api_secret', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Secret
                                    </button>
                                </div>
                                <input type="password" class="form-control font-mono" id="ga4_api_secret" name="ga4_api_secret" value="{{ old('ga4_api_secret', $settings->ga4_api_secret ?? $ga4Config['api_secret']) }}" placeholder="Enter GA4 API Secret" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                <small class="form-text text-muted">Generate in GA4 Admin &gt; Data Streams &gt; Measurement Protocol API secrets &gt; Create.</small>
                            </div>

                            <div class="p-3 rounded mb-0" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06); font-size: 11px; color: #94a3b8;">
                                <i class="fas fa-info-circle text-warning mr-1"></i> Dispatches emit server-side <code>generate_lead</code>, <code>purchase</code>, and <code>view_item</code> hits with automatic client ID deduplication.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TikTok Events API Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid rgba(254, 44, 85, 0.3) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.3);">
                        <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: rgba(254, 44, 85, 0.08); border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <div class="d-flex align-items-center">
                                <div style="background: rgba(254, 44, 85, 0.2); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="mr-3">
                                    <i class="fab fa-tiktok text-danger" style="font-size: 20px;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-white font-weight-bold mb-0">TikTok Events API</h5>
                                    <small class="text-muted">Business API v1.3 Server Endpoint</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="tiktok_server_enabled" name="tiktok_server_enabled" value="1" {{ old('tiktok_server_enabled', $settings->tiktok_server_enabled ?? $tiktokConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-white small font-weight-bold" for="tiktok_server_enabled">Active</label>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-group mb-3">
                                <label class="text-white small font-weight-bold">TikTok Pixel Code / ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control font-mono" name="tiktok_pixel_code" id="tiktok_pixel_code" value="{{ old('tiktok_pixel_code', $settings->tiktok_pixel_code ?? $tiktokConfig['pixel_code']) }}" placeholder="e.g. CXXXXXXXXXX" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('tiktok_pixel_code')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Found in TikTok Ads Manager &gt; Assets &gt; Events &gt; Web Events &gt; Pixel ID.</small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="text-white small font-weight-bold mb-0">TikTok Long-Term Access Token</label>
                                    <button type="button" class="btn btn-link btn-xs text-info p-0" onclick="toggleSecretMask('tiktok_token_field', this)">
                                        <i class="fas fa-eye mr-1"></i> Show Token
                                    </button>
                                </div>
                                <textarea class="form-control font-mono secret-mask" id="tiktok_token_field" name="tiktok_access_token" rows="2" placeholder="Enter TikTok Events API Access Token" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff; font-size: 11px;">{{ old('tiktok_access_token', $settings->tiktok_access_token ?? $tiktokConfig['access_token']) }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label class="text-white small font-weight-bold">Test Event Code (Optional)</label>
                                <input type="text" class="form-control font-mono" name="tiktok_test_event_code" value="{{ old('tiktok_test_event_code', $settings->tiktok_test_event_code ?? $tiktokConfig['test_event_code']) }}" placeholder="e.g. TEST12345" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                <small class="form-text text-muted">Obtained from the Test Events tab in TikTok Events Manager.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Webhook / sGTM Container Panel -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid rgba(139, 92, 246, 0.3) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.3);">
                        <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: rgba(139, 92, 246, 0.08); border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <div class="d-flex align-items-center">
                                <div style="background: rgba(139, 92, 246, 0.2); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;" class="mr-3">
                                    <i class="fas fa-network-wired text-info" style="font-size: 18px;"></i>
                                </div>
                                <div>
                                    <h5 class="card-title text-white font-weight-bold mb-0">Server Webhook / sGTM Container</h5>
                                    <small class="text-muted">Cloud Tag Manager &amp; Custom Relays</small>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="server_tracking_webhook_enabled" name="server_tracking_webhook_enabled" value="1" {{ old('server_tracking_webhook_enabled', $settings->server_tracking_webhook_enabled ?? $webhookConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label text-white small font-weight-bold" for="server_tracking_webhook_enabled">Active</label>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="form-group mb-3">
                                <label class="text-white small font-weight-bold">Server Webhook Endpoint URL</label>
                                <div class="input-group">
                                    <input type="url" class="form-control font-mono" name="server_tracking_webhook_url" id="server_tracking_webhook_url" value="{{ old('server_tracking_webhook_url', $settings->server_tracking_webhook_url ?? $webhookConfig['url']) }}" placeholder="https://sgtm.yourdomain.com/data" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyInput('server_tracking_webhook_url')"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Supports Server-Side Google Tag Manager (sGTM), Stape, Make, or Zapier webhooks.</small>
                            </div>

                            <div class="p-3 rounded mb-0" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06); font-size: 11px; color: #94a3b8;">
                                <i class="fas fa-code text-info mr-1"></i> Webhooks deliver full conversion payloads as JSON POST requests, including event IDs, lead IDs, UTM attribution models, and timestamp headers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Save Bar -->
            <div class="card border-0 p-3 mb-4 d-flex flex-row justify-content-between align-items-center flex-wrap" style="background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.4);">
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
                    <button type="submit" class="btn btn-sm px-4 font-weight-bold" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: #ffffff; border: none; border-radius: 8px; padding: 8px 24px; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);">
                        <i class="fas fa-save mr-1"></i> Save Tracking Credentials
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

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

// Initial hide for token textareas
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
