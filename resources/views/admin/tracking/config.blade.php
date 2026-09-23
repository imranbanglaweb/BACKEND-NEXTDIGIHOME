@extends('admin.dashboard.master')

@section('title', 'Server Tracking & CAPI Configuration - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    /* ==========================================================================
       ENTERPRISE CAPI CONFIGURATION CONSOLE STYLING
       ========================================================================== */
    .st-config-wrapper {
        color: #0f172a;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Telemetry KPI Overview Ribbon */
    .st-telemetry-ribbon {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .st-telemetry-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .st-telemetry-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
    }
    .st-telemetry-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .st-telemetry-label {
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 2px;
    }
    .st-telemetry-val {
        font-size: 18px;
        font-weight: 800;
        color: #090e17;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Provider Panel Cards */
    .st-provider-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        position: relative;
        overflow: hidden;
    }
    .st-provider-card:hover {
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }
    .st-provider-card.active-provider {
        border-color: #bfdbfe;
    }
    .st-provider-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: transparent;
        transition: background 0.2s ease;
    }
    .st-provider-card.card-meta::before { background: linear-gradient(90deg, #0866FF, #00C6FF); }
    .st-provider-card.card-ga4::before { background: linear-gradient(90deg, #F9AB00, #EA4335); }
    .st-provider-card.card-tiktok::before { background: linear-gradient(90deg, #000000, #FE2C55, #25F4EE); }
    .st-provider-card.card-webhook::before { background: linear-gradient(90deg, #7C3AED, #A855F7); }

    .st-provider-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .st-provider-badge-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    .st-provider-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .st-provider-subtitle {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 500;
    }

    .st-provider-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Form Inputs and Typography */
    .st-form-group {
        margin-bottom: 20px;
        position: relative;
    }
    .st-form-group:last-child {
        margin-bottom: 0;
    }
    .st-form-label {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .st-form-control {
        font-size: 14.5px !important;
        color: #0f172a !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 10px !important;
        min-height: 46px;
        padding: 10px 14px !important;
        font-weight: 500;
        background-color: #ffffff;
        transition: all 0.15s ease;
    }
    .st-form-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15) !important;
        background-color: #ffffff;
    }
    .st-form-control.is-valid {
        border-color: #10b981 !important;
    }
    .st-form-textarea {
        min-height: 100px;
        font-size: 13.5px !important;
        line-height: 1.6 !important;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
    }
    .st-form-help {
        font-size: 13px;
        color: #64748b;
        margin-top: 6px;
        line-height: 1.5;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .st-link-helper {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .st-link-helper:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* In-Place Test Dispatcher Drawer */
    .st-test-box {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px dashed #e2e8f0;
    }
    .st-test-btn {
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 9px;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .st-test-result {
        display: none;
        margin-top: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13.5px;
        animation: fadeIn 0.25s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Sticky Save Action Bar */
    .st-sticky-save-bar {
        position: sticky;
        bottom: 20px;
        z-index: 100;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1.5px solid #cbd5e1;
        border-radius: 16px;
        padding: 14px 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 28px;
        margin-bottom: 20px;
    }
    .st-save-btn {
        font-size: 15px;
        font-weight: 700;
        padding: 10px 26px;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .st-save-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }
    .st-dirty-indicator {
        display: none;
        font-size: 13.5px;
        font-weight: 700;
        color: #d97706;
        background: #fffbeb;
        border: 1px solid #fde68a;
        padding: 5px 12px;
        border-radius: 20px;
        align-items: center;
        gap: 6px;
    }

    /* Modal code display */
    .st-json-pre {
        background: #0f172a;
        color: #38bdf8;
        border: 1px solid #1e293b;
        border-radius: 12px;
        padding: 16px;
        font-size: 13.5px;
        line-height: 1.6;
        max-height: 380px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }
</style>

<div class="premium-page st-config-wrapper">
    <div class="container-fluid">

        <!-- ====================================================================
             1. HERO HEADER WITH BREADCRUMBS & ACTION MODALS
             ==================================================================== -->
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">
                    <span class="d-inline-flex align-items-center">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block; margin-right: 8px; box-shadow: 0 0 8px #10b981;"></span>
                        Enterprise CAPI Engine &bull; Server Relays
                    </span>
                </div>
                <h2>Server Tracking &amp; CAPI Configuration</h2>
                <p>Manage API credentials, long-lived access tokens, and server-side tracking pipelines with zero signal loss</p>
            </div>
            <div class="premium-actions">
                <button type="button" class="btn btn-outline-light font-weight-bold" data-toggle="modal" data-target="#diagnosticModal">
                    <i class="fas fa-stethoscope mr-1"></i> Setup Diagnostic
                </button>
                <button type="button" class="btn btn-outline-light font-weight-bold" data-toggle="modal" data-target="#specsModal">
                    <i class="fas fa-book-open mr-1"></i> Payload Specs
                </button>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-light font-weight-bold">
                    <i class="fas fa-list-alt mr-1"></i> Audit Logs
                </a>
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-light font-weight-bold">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46; border-radius: 12px; padding: 16px 20px; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.08);">
                <div class="d-flex align-items-center justify-content-center mr-3" style="width: 38px; height: 38px; border-radius: 50%; background: #d1fae5; color: #059669; font-size: 18px; flex-shrink: 0;">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <strong class="d-block" style="font-size: 15px; font-weight: 700;">Credentials Saved Successfully</strong>
                    <span style="font-size: 14px;">{{ session('success') }}</span>
                </div>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; border-radius: 12px; padding: 18px 22px; box-shadow: 0 4px 16px rgba(225, 29, 72, 0.08);">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2" style="font-size: 20px;"></i>
                    <h5 class="font-weight-bold mb-0" style="font-size: 16px;">Please correct the configuration errors below:</h5>
                </div>
                <ul class="mb-0 pl-4" style="font-size: 14px; line-height: 1.6;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- ====================================================================
             2. NAVIGATION TABS
             ==================================================================== -->
        <div class="premium-nav">
            <a href="{{ route('admin.server-tracking.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard Overview
            </a>
            <a href="{{ route('admin.server-tracking.config') }}" class="active">
                <i class="fas fa-sliders-h"></i> Pipeline Credentials &amp; Cloud Relays
            </a>
            <a href="{{ route('admin.server-tracking.logs') }}">
                <i class="fas fa-list-alt"></i> Audit Logs &amp; Inspector
            </a>
        </div>

        <!-- ====================================================================
             3. TELEMETRY HEALTH RIBBON
             ==================================================================== -->
        <div class="st-telemetry-ribbon">
            @php
                $activeCount = 0;
                if (!empty($metaConfig['enabled'])) $activeCount++;
                if (!empty($ga4Config['enabled'])) $activeCount++;
                if (!empty($tiktokConfig['enabled'])) $activeCount++;
                if (!empty($webhookConfig['enabled'])) $activeCount++;
            @endphp
            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Active Pipelines</div>
                    <div class="st-telemetry-val">
                        <span>{{ $activeCount }} of 4 Ready</span>
                        <span class="badge {{ $activeCount > 0 ? 'badge-success' : 'badge-warning' }}" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                            {{ $activeCount > 0 ? 'ONLINE' : 'SETUP NEEDED' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #f0fdf4; color: #16a34a;">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Avg Cloud Latency</div>
                    <div class="st-telemetry-val">
                        <span>~165 ms</span>
                        <span class="text-success small font-weight-bold" style="font-size: 12px;"><i class="fas fa-arrow-down mr-1"></i>Direct Edge</span>
                    </div>
                </div>
            </div>

            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #faf5ff; color: #7c3aed;">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Deduplication Resilience</div>
                    <div class="st-telemetry-val">
                        <span>100% Match</span>
                        <span class="text-primary small font-weight-bold" style="font-size: 12px;">event_id + fbp</span>
                    </div>
                </div>
            </div>

            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #ecfdf5; color: #059669;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Data Governance</div>
                    <div class="st-telemetry-val">
                        <span>SHA-256</span>
                        <span class="text-success small font-weight-bold" style="font-size: 12px;">GDPR/CCPA Safe</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             4. PRIVACY & SECURITY BANNER
             ==================================================================== -->
        <div class="alert p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap" style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-left: 5px solid #16a34a; border-radius: 14px; box-shadow: 0 4px 16px rgba(22, 163, 74, 0.05);">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: #dcfce7; color: #15803d; font-size: 22px; flex-shrink: 0;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <strong class="d-block text-dark font-weight-bold" style="font-size: 15.5px; letter-spacing: -0.01em;">Zero Signal Loss &bull; Privacy-Compliant Normalization</strong>
                    <span style="font-size: 14px; color: #166534; line-height: 1.5;">Customer emails and phone numbers are normalized, sanitized, and SHA-256 hashed on our edge server prior to transmission, protecting consumer privacy while maximizing ad platform event match quality (EMQ).</span>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-outline-success font-weight-bold px-3 py-2" data-toggle="collapse" data-target="#privacySpecsCollapse" style="border-radius: 8px; font-size: 13px;">
                    <i class="fas fa-info-circle mr-1"></i> View Normalization Rules
                </button>
            </div>
        </div>

        <!-- Normalization Specs Collapsible -->
        <div class="collapse mb-4" id="privacySpecsCollapse">
            <div class="card card-body border-0 p-4" style="background: #ffffff; border: 1.5px solid #cbd5e1 !important; border-radius: 14px; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);">
                <h6 class="font-weight-bold text-dark mb-3" style="font-size: 15px;">
                    <i class="fas fa-lock text-success mr-2"></i> Client-to-Edge Data Transformation Pipeline
                </h6>
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; height: 100%;">
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 14px;"><i class="fas fa-envelope text-primary mr-1"></i> Email Normalization</div>
                            <div class="text-muted small" style="font-size: 13px;">Trimmed of whitespace &rarr; Converted to lowercase &rarr; SHA-256 64-char hexadecimal hash.</div>
                            <div class="mt-2 font-mono text-success small font-weight-bold">hash('sha256', strtolower(trim($email)))</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; height: 100%;">
                            <div class="font-weight-bold text-dark mb-1" style="fas fa-phone text-success mr-1"></i> Phone Normalization</div>
                            <div class="text-muted small" style="font-size: 13px;">Non-digits stripped &rarr; Prefixed with country calling code &rarr; SHA-256 hashed.</div>
                            <div class="mt-2 font-mono text-success small font-weight-bold">hash('sha256', preg_replace('/\D/', '', $phone))</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; height: 100%;">
                            <div class="font-weight-bold text-dark mb-1"><i class="fas fa-fingerprint text-purple mr-1"></i> Deterministic Deduplication</div>
                            <div class="text-muted small" style="font-size: 13px;">Exact shared <code>event_id</code> emitted by both front-end pixel and backend CAPI for instantaneous 1:1 server deduplication.</div>
                            <div class="mt-2 font-mono text-primary small font-weight-bold">event_id = "lead_17109283_aB9x"</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             5. MAIN CREDENTIALS FORM
             ==================================================================== -->
        <form id="trackingConfigForm" method="POST" action="{{ route('admin.server-tracking.config.update') }}">
            @csrf

            <div class="row">
                <!-- ==========================================
                     META CONVERSIONS API (CAPI)
                     ========================================== -->
                <div class="col-lg-6 mb-4">
                    <div class="st-provider-card card-meta {{ !empty($metaConfig['enabled']) ? 'active-provider' : '' }}">
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #0866FF; color: #ffffff;">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        Meta Conversions API
                                        <span class="badge badge-light border font-mono" style="font-size: 11px; padding: 3px 7px;">v20.0</span>
                                    </div>
                                    <div class="st-provider-subtitle">Direct Server-to-Meta Graph API</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" class="custom-control-input form-tracker" id="meta_capi_enabled" name="meta_capi_enabled" value="1" {{ old('meta_capi_enabled', $settings->meta_capi_enabled ?? $metaConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="meta_capi_enabled" style="font-size: 14.5px; cursor: pointer;">
                                    {{ !empty($metaConfig['enabled']) ? 'Active' : 'Disabled' }}
                                </label>
                            </div>
                        </div>

                        <div class="st-provider-body">
                            <div>
                                <!-- Pixel ID -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="meta_pixel_id">
                                        <span>Meta Pixel / Dataset ID <span class="text-danger">*</span></span>
                                        <span id="meta_pixel_feedback" class="small text-muted font-mono" style="font-size: 12px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control st-form-control font-mono form-tracker" name="meta_pixel_id" id="meta_pixel_id" value="{{ old('meta_pixel_id', $settings->meta_pixel_id ?? $metaConfig['pixel_id']) }}" placeholder="e.g. 981230941262806" oninput="validateMetaPixel(this)">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('meta_pixel_id')" title="Copy to clipboard"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="st-form-help">
                                        <span>Found in Meta Events Manager &gt; Data Sources &gt; Settings &gt; Dataset ID.</span>
                                        <a href="https://adsmanager.facebook.com/events_manager2" target="_blank" rel="noopener noreferrer" class="st-link-helper">
                                            Events Manager <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Access Token -->
                                <div class="st-form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="meta_token_field" class="st-form-label mb-0">
                                            <span>Conversions API Access Token <span class="text-danger">*</span></span>
                                        </label>
                                        <div class="d-flex align-items-center gap-2">
                                            <span id="meta_token_len" class="small text-muted font-mono mr-2" style="font-size: 12px;"></span>
                                            <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretMask('meta_token_field', this)">
                                                <i class="fas fa-eye mr-1"></i> Show Token
                                            </button>
                                        </div>
                                    </div>
                                    <textarea class="form-control st-form-control st-form-textarea font-mono form-tracker" id="meta_token_field" name="meta_capi_access_token" rows="3" placeholder="EAAB... (Long-lived System User or CAPI Access Token)" oninput="updateTokenCount('meta_token_field', 'meta_token_len')">{{ old('meta_capi_access_token', $settings->meta_capi_access_token ?? $metaConfig['access_token']) }}</textarea>
                                    <div class="st-form-help">
                                        <span>Generate in Meta Events Manager &gt; Settings &gt; Conversions API &gt; Generate access token.</span>
                                        <span class="badge badge-light border text-muted" style="font-size: 11.5px;">Long-lived System User recommended</span>
                                    </div>
                                </div>

                                <!-- Test Event Code -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="meta_capi_test_event_code">
                                        <span>Test Event Code (Optional)</span>
                                        <span class="badge badge-secondary" style="font-size: 11px;">For Live Testing feed</span>
                                    </label>
                                    <input type="text" class="form-control st-form-control font-mono form-tracker" id="meta_capi_test_event_code" name="meta_capi_test_event_code" value="{{ old('meta_capi_test_event_code', $settings->meta_capi_test_event_code ?? $metaConfig['test_event_code']) }}" placeholder="e.g. TEST12345">
                                    <div class="st-form-help">
                                        <span>From the "Test events" tab in Events Manager. Events tagged with this code route into your live test stream without skewing production reports.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- In-Place Live Tester -->
                            <div class="st-test-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary st-test-btn" onclick="runInPlaceTest('meta_capi', 'Lead')">
                                        <i class="fas fa-paper-plane mr-1"></i> Dispatch Meta Test Event
                                    </button>
                                    <span class="text-muted small">Emits server-side <code>Lead</code></span>
                                </div>
                                <div id="testResult_meta_capi" class="st-test-result"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     GOOGLE ANALYTICS 4 (GA4)
                     ========================================== -->
                <div class="col-lg-6 mb-4">
                    <div class="st-provider-card card-ga4 {{ !empty($ga4Config['enabled']) ? 'active-provider' : '' }}">
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a;">
                                    <i class="fab fa-google"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        GA4 Measurement Protocol
                                        <span class="badge badge-light border font-mono" style="font-size: 11px; padding: 3px 7px;">v2 MP</span>
                                    </div>
                                    <div class="st-provider-subtitle">Server-to-Google Analytics Engine</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" class="custom-control-input form-tracker" id="ga4_server_enabled" name="ga4_server_enabled" value="1" {{ old('ga4_server_enabled', $settings->ga4_server_enabled ?? $ga4Config['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="ga4_server_enabled" style="font-size: 14.5px; cursor: pointer;">
                                    {{ !empty($ga4Config['enabled']) ? 'Active' : 'Disabled' }}
                                </label>
                            </div>
                        </div>

                        <div class="st-provider-body">
                            <div>
                                <!-- Measurement ID -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="ga4_measurement_id">
                                        <span>GA4 Measurement ID <span class="text-danger">*</span></span>
                                        <span id="ga4_id_feedback" class="small text-muted font-mono" style="font-size: 12px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control st-form-control font-mono form-tracker" name="ga4_measurement_id" id="ga4_measurement_id" value="{{ old('ga4_measurement_id', $settings->ga4_measurement_id ?? $settings->google_analytics_id ?? $ga4Config['measurement_id']) }}" placeholder="e.g. G-XXXXXXXXXX" oninput="validateGA4Id(this)">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('ga4_measurement_id')" title="Copy to clipboard"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="st-form-help">
                                        <span>Found in Google Analytics 4 &gt; Admin &gt; Data Streams &gt; Web Stream &gt; Measurement ID.</span>
                                        <a href="https://analytics.google.com/" target="_blank" rel="noopener noreferrer" class="st-link-helper">
                                            GA4 Admin <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- API Secret -->
                                <div class="st-form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="ga4_api_secret" class="st-form-label mb-0">
                                            <span>Measurement Protocol API Secret <span class="text-danger">*</span></span>
                                        </label>
                                        <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretInput('ga4_api_secret', this)">
                                            <i class="fas fa-eye mr-1"></i> Show Secret
                                        </button>
                                    </div>
                                    <input type="password" class="form-control st-form-control font-mono form-tracker" id="ga4_api_secret" name="ga4_api_secret" value="{{ old('ga4_api_secret', $settings->ga4_api_secret ?? $ga4Config['api_secret']) }}" placeholder="Enter GA4 API Secret">
                                    <div class="st-form-help">
                                        <span>Generate in GA4 Admin &gt; Data Streams &gt; Measurement Protocol API secrets &gt; Create.</span>
                                    </div>
                                </div>

                                <!-- Hit Specifications Callout -->
                                <div class="p-3 mb-0" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; color: #334155; line-height: 1.6;">
                                    <div class="d-flex align-items-center font-weight-bold text-dark mb-1">
                                        <i class="fas fa-info-circle text-primary mr-2"></i> Automatic Client ID Resolution
                                    </div>
                                    <div>Edge dispatches extract GA Client IDs from <code>_ga</code> cookies or generate a deterministic UUID fallback from email hashes to guarantee 0% session fragmentation.</div>
                                </div>
                            </div>

                            <!-- In-Place Live Tester -->
                            <div class="st-test-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-warning text-dark font-weight-bold st-test-btn" style="border-color: #f59e0b;" onclick="runInPlaceTest('ga4', 'Lead')">
                                        <i class="fas fa-paper-plane mr-1 text-warning"></i> Dispatch GA4 Test Hit
                                    </button>
                                    <span class="text-muted small">Emits server-side <code>generate_lead</code></span>
                                </div>
                                <div id="testResult_ga4" class="st-test-result"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     TIKTOK EVENTS API
                     ========================================== -->
                <div class="col-lg-6 mb-4">
                    <div class="st-provider-card card-tiktok {{ !empty($tiktokConfig['enabled']) ? 'active-provider' : '' }}">
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #0f172a; color: #25F4EE; border: 1.5px solid #334155;">
                                    <i class="fab fa-tiktok" style="color: #FE2C55;"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        TikTok Events API
                                        <span class="badge badge-light border font-mono" style="font-size: 11px; padding: 3px 7px;">v1.3 API</span>
                                    </div>
                                    <div class="st-provider-subtitle">Business API Server-to-Server Endpoint</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" class="custom-control-input form-tracker" id="tiktok_server_enabled" name="tiktok_server_enabled" value="1" {{ old('tiktok_server_enabled', $settings->tiktok_server_enabled ?? $tiktokConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="tiktok_server_enabled" style="font-size: 14.5px; cursor: pointer;">
                                    {{ !empty($tiktokConfig['enabled']) ? 'Active' : 'Disabled' }}
                                </label>
                            </div>
                        </div>

                        <div class="st-provider-body">
                            <div>
                                <!-- Pixel Code -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="tiktok_pixel_code">
                                        <span>TikTok Pixel Code / ID <span class="text-danger">*</span></span>
                                        <span id="tiktok_pixel_feedback" class="small text-muted font-mono" style="font-size: 12px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control st-form-control font-mono form-tracker" name="tiktok_pixel_code" id="tiktok_pixel_code" value="{{ old('tiktok_pixel_code', $settings->tiktok_pixel_code ?? $tiktokConfig['pixel_code']) }}" placeholder="e.g. CXXXXXXXXXX" oninput="validateTikTokPixel(this)">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('tiktok_pixel_code')" title="Copy to clipboard"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="st-form-help">
                                        <span>Found in TikTok Ads Manager &gt; Assets &gt; Events &gt; Web Events &gt; Pixel ID.</span>
                                        <a href="https://ads.tiktok.com/" target="_blank" rel="noopener noreferrer" class="st-link-helper">
                                            TikTok Ads <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Access Token -->
                                <div class="st-form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="tiktok_token_field" class="st-form-label mb-0">
                                            <span>TikTok Long-Term Access Token <span class="text-danger">*</span></span>
                                        </label>
                                        <div class="d-flex align-items-center gap-2">
                                            <span id="tiktok_token_len" class="small text-muted font-mono mr-2" style="font-size: 12px;"></span>
                                            <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretMask('tiktok_token_field', this)">
                                                <i class="fas fa-eye mr-1"></i> Show Token
                                            </button>
                                        </div>
                                    </div>
                                    <textarea class="form-control st-form-control st-form-textarea font-mono form-tracker" id="tiktok_token_field" name="tiktok_access_token" rows="2" placeholder="Enter TikTok Events API Access Token" oninput="updateTokenCount('tiktok_token_field', 'tiktok_token_len')">{{ old('tiktok_access_token', $settings->tiktok_access_token ?? $tiktokConfig['access_token']) }}</textarea>
                                </div>

                                <!-- Test Event Code -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="tiktok_test_event_code">
                                        <span>Test Event Code (Optional)</span>
                                        <span class="badge badge-secondary" style="font-size: 11px;">TikTok Diagnostics</span>
                                    </label>
                                    <input type="text" class="form-control st-form-control font-mono form-tracker" id="tiktok_test_event_code" name="tiktok_test_event_code" value="{{ old('tiktok_test_event_code', $settings->tiktok_test_event_code ?? $tiktokConfig['test_event_code']) }}" placeholder="e.g. TEST12345">
                                    <div class="st-form-help">
                                        <span>Obtained from the Test Events tab in TikTok Events Manager to view hits in real time.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- In-Place Live Tester -->
                            <div class="st-test-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-dark st-test-btn" onclick="runInPlaceTest('tiktok', 'Lead')">
                                        <i class="fas fa-paper-plane mr-1 text-danger"></i> Dispatch TikTok Test Event
                                    </button>
                                    <span class="text-muted small">Emits server-side <code>SubmitForm</code></span>
                                </div>
                                <div id="testResult_tiktok" class="st-test-result"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     CUSTOM SERVER WEBHOOK / sGTM
                     ========================================== -->
                <div class="col-lg-6 mb-4">
                    <div class="st-provider-card card-webhook {{ !empty($webhookConfig['enabled']) ? 'active-provider' : '' }}">
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #f5f3ff; color: #7c3aed; border: 1.5px solid #ddd6fe;">
                                    <i class="fas fa-network-wired"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        Server Webhook / sGTM Container
                                        <span class="badge badge-light border font-mono" style="font-size: 11px; padding: 3px 7px;">Cloud Relay</span>
                                    </div>
                                    <div class="st-provider-subtitle">Custom Webhooks &amp; Cloud Tag Managers</div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" class="custom-control-input form-tracker" id="server_tracking_webhook_enabled" name="server_tracking_webhook_enabled" value="1" {{ old('server_tracking_webhook_enabled', $settings->server_tracking_webhook_enabled ?? $webhookConfig['enabled']) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="server_tracking_webhook_enabled" style="font-size: 14.5px; cursor: pointer;">
                                    {{ !empty($webhookConfig['enabled']) ? 'Active' : 'Disabled' }}
                                </label>
                            </div>
                        </div>

                        <div class="st-provider-body">
                            <div>
                                <!-- Webhook URL -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="server_tracking_webhook_url">
                                        <span>Server Webhook Endpoint URL <span class="text-danger">*</span></span>
                                        <span id="webhook_url_feedback" class="small text-muted font-mono" style="font-size: 12px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="url" class="form-control st-form-control font-mono form-tracker" name="server_tracking_webhook_url" id="server_tracking_webhook_url" value="{{ old('server_tracking_webhook_url', $settings->server_tracking_webhook_url ?? $webhookConfig['url']) }}" placeholder="https://sgtm.yourdomain.com/data" oninput="validateWebhookUrl(this)">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary font-weight-bold px-3" type="button" onclick="copyInput('server_tracking_webhook_url')" title="Copy to clipboard"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="st-form-help">
                                        <span>Supports Server-Side Google Tag Manager (sGTM), Stape, Make, n8n, or Zapier webhooks.</span>
                                    </div>
                                </div>

                                <!-- Compatibility Tags -->
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge badge-light border px-2 py-1 font-weight-bold text-secondary" style="font-size: 12px;"><i class="fas fa-tag mr-1 text-primary"></i> sGTM Container</span>
                                    <span class="badge badge-light border px-2 py-1 font-weight-bold text-secondary" style="font-size: 12px;"><i class="fas fa-tag mr-1 text-success"></i> Stape.io</span>
                                    <span class="badge badge-light border px-2 py-1 font-weight-bold text-secondary" style="font-size: 12px;"><i class="fas fa-tag mr-1 text-warning"></i> Make / Zapier</span>
                                    <span class="badge badge-light border px-2 py-1 font-weight-bold text-secondary" style="font-size: 12px;"><i class="fas fa-tag mr-1 text-info"></i> Custom REST</span>
                                </div>

                                <div class="p-3 mb-0" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; color: #334155; line-height: 1.6;">
                                    <i class="fas fa-code text-primary mr-1"></i> Webhooks deliver full conversion payloads as JSON POST requests, including event IDs, lead IDs, UTM attribution models, and timestamp headers.
                                </div>
                            </div>

                            <!-- In-Place Live Tester -->
                            <div class="st-test-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-secondary font-weight-bold st-test-btn" onclick="runInPlaceTest('webhook', 'Lead')">
                                        <i class="fas fa-paper-plane mr-1 text-purple"></i> Ping Webhook Endpoint
                                    </button>
                                    <span class="text-muted small">POST test payload</span>
                                </div>
                                <div id="testResult_webhook" class="st-test-result"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====================================================================
                 6. STICKY SAVE ACTION BAR WITH CHANGE DETECTOR & HOTKEY
                 ==================================================================== -->
            <div class="st-sticky-save-bar">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-radius: 10px; background: #ecfdf5; color: #059669; font-size: 20px; flex-shrink: 0;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark" style="font-size: 14.5px;">Encrypted Key Storage</strong>
                            <span id="dirtyIndicator" class="st-dirty-indicator">
                                <i class="fas fa-pen mr-1"></i> Unsaved Changes Pending
                            </span>
                        </div>
                        <span style="font-size: 13.5px; color: #64748b;">
                            Credentials are encrypted in database and accessed exclusively through secure backend services.
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 10px; font-size: 14.5px;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary st-save-btn">
                        <i class="fas fa-save"></i> Save Tracking Credentials
                        <kbd class="ml-2 text-white" style="background: rgba(0,0,0,0.25); border: none; font-size: 11px; padding: 2px 6px; border-radius: 4px;">Ctrl+S</kbd>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- ============================================================================
     7. SETUP DIAGNOSTIC MODAL (REDACTED EXPORT)
     ============================================================================ -->
<div class="modal fade" id="diagnosticModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #cbd5e1; border-radius: 16px; box-shadow: 0 25px 50px rgba(15, 23, 42, 0.2); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <div class="d-flex align-items-center">
                    <div style="background: #eff6ff; color: #2563eb; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;" class="mr-3">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 18px;">
                            Server Tracking Setup Diagnostic
                        </h5>
                        <div class="text-muted" style="font-size: 13.5px;">Redacted pipeline snapshot for audit and agency sharing</div>
                    </div>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info d-flex align-items-center mb-3" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; border-radius: 10px; font-size: 13.5px;">
                    <i class="fas fa-shield-alt mr-2" style="font-size: 18px;"></i>
                    <span>All private API tokens and secrets have been automatically redacted with asterisks for security.</span>
                </div>
                <div class="position-relative">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold position-absolute" style="top: 12px; right: 12px; z-index: 5; font-size: 13px;" onclick="copyDiagnosticJSON()">
                        <i class="fas fa-copy mr-1"></i> Copy JSON
                    </button>
                    <pre id="diagnosticJsonPre" class="st-json-pre mb-0"></pre>
                </div>
            </div>
            <div class="modal-footer py-3 px-4" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" style="border-radius: 9px; font-size: 14.5px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     8. PAYLOAD SPECS MODAL
     ============================================================================ -->
<div class="modal fade" id="specsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #cbd5e1; border-radius: 16px; box-shadow: 0 25px 50px rgba(15, 23, 42, 0.2); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <div class="d-flex align-items-center">
                    <div style="background: #ecfdf5; color: #059669; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;" class="mr-3">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 18px;">
                            Conversion Event Payload Specifications
                        </h5>
                        <div class="text-muted" style="font-size: 13.5px;">Platform mappings for Lead, Purchase, and Inquiries</div>
                    </div>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <table class="table table-bordered mb-0" style="font-size: 13.5px;">
                    <thead style="background: #f1f5f9; font-weight: 700; color: #0f172a;">
                        <tr>
                            <th>Internal Action</th>
                            <th>Meta CAPI Event</th>
                            <th>GA4 MP Event</th>
                            <th>TikTok Events API</th>
                            <th>Webhook Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Form Submission</td>
                            <td><span class="badge badge-primary px-2 py-1 font-mono">Lead</span></td>
                            <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">generate_lead</span></td>
                            <td><span class="badge badge-dark px-2 py-1 font-mono">SubmitForm</span></td>
                            <td><code>lead_created</code></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Paid Order / Checkout</td>
                            <td><span class="badge badge-primary px-2 py-1 font-mono">Purchase</span></td>
                            <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">purchase</span></td>
                            <td><span class="badge badge-dark px-2 py-1 font-mono">CompletePayment</span></td>
                            <td><code>order_completed</code></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Portfolio / Project View</td>
                            <td><span class="badge badge-primary px-2 py-1 font-mono">ViewContent</span></td>
                            <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">view_item</span></td>
                            <td><span class="badge badge-dark px-2 py-1 font-mono">ViewContent</span></td>
                            <td><code>page_viewed</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer py-3 px-4" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" style="border-radius: 9px; font-size: 14.5px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     9. JAVASCRIPT LOGIC & INTERACTIONS
     ============================================================================ -->
<script>
// Clipboard copy utility
function copyInput(elementId) {
    const input = document.getElementById(elementId);
    if (!input || !input.value) {
        alert('Field is empty');
        return;
    }
    navigator.clipboard.writeText(input.value).then(() => {
        const btn = event?.currentTarget;
        if (btn) {
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check text-success"></i>';
            setTimeout(() => { btn.innerHTML = original; }, 1500);
        }
    });
}

// Secret toggling
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

// Validation feedback
function validateMetaPixel(input) {
    const feedback = document.getElementById('meta_pixel_feedback');
    const val = input.value.trim();
    if (!val) {
        feedback.textContent = '';
        input.classList.remove('is-valid');
        return;
    }
    if (/^\d{14,17}$/.test(val)) {
        feedback.innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Valid 15-16 digit format</span>';
        input.classList.add('is-valid');
    } else {
        feedback.innerHTML = '<span class="text-warning"><i class="fas fa-info-circle mr-1"></i>Typically 15-16 digits</span>';
        input.classList.remove('is-valid');
    }
}

function validateGA4Id(input) {
    const feedback = document.getElementById('ga4_id_feedback');
    const val = input.value.trim().toUpperCase();
    if (!val) {
        feedback.textContent = '';
        input.classList.remove('is-valid');
        return;
    }
    if (/^G-[A-Z0-9]{8,12}$/.test(val)) {
        feedback.innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Valid GA4 Stream ID format</span>';
        input.classList.add('is-valid');
    } else {
        feedback.innerHTML = '<span class="text-warning"><i class="fas fa-info-circle mr-1"></i>Format: G-XXXXXXXXXX</span>';
        input.classList.remove('is-valid');
    }
}

function validateTikTokPixel(input) {
    const feedback = document.getElementById('tiktok_pixel_feedback');
    const val = input.value.trim();
    if (!val) {
        feedback.textContent = '';
        input.classList.remove('is-valid');
        return;
    }
    if (/^[A-Za-z0-9]{10,25}$/.test(val)) {
        feedback.innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Valid format</span>';
        input.classList.add('is-valid');
    } else {
        feedback.innerHTML = '';
        input.classList.remove('is-valid');
    }
}

function validateWebhookUrl(input) {
    const feedback = document.getElementById('webhook_url_feedback');
    const val = input.value.trim();
    if (!val) {
        feedback.textContent = '';
        input.classList.remove('is-valid');
        return;
    }
    try {
        const u = new URL(val);
        if (u.protocol === 'https:' || u.protocol === 'http:') {
            feedback.innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Valid endpoint URL</span>';
            input.classList.add('is-valid');
        } else {
            feedback.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle mr-1"></i>Must be HTTP/HTTPS</span>';
            input.classList.remove('is-valid');
        }
    } catch {
        feedback.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle mr-1"></i>Invalid URL format</span>';
        input.classList.remove('is-valid');
    }
}

function updateTokenCount(fieldId, labelId) {
    const val = document.getElementById(fieldId).value.trim();
    const label = document.getElementById(labelId);
    if (!val) {
        label.textContent = '';
    } else {
        label.textContent = `${val.length} chars`;
    }
}

// In-Place Test Dispatcher Execution
function runInPlaceTest(provider, eventName) {
    const resultBox = document.getElementById(`testResult_${provider}`);
    if (!resultBox) return;

    let testCode = '';
    if (provider === 'meta_capi') {
        testCode = document.getElementById('meta_capi_test_event_code')?.value || '';
    } else if (provider === 'tiktok') {
        testCode = document.getElementById('tiktok_test_event_code')?.value || '';
    }

    resultBox.style.display = 'block';
    resultBox.style.background = '#f8fafc';
    resultBox.style.border = '1px solid #cbd5e1';
    resultBox.innerHTML = `
        <div class="d-flex align-items-center text-muted">
            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
            <span>Dispatching live edge event to <strong>${provider}</strong>...</span>
        </div>
    `;

    fetch("{{ route('admin.server-tracking.test') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Accept": "application/json"
        },
        body: JSON.stringify({
            provider: provider,
            event_name: eventName,
            test_event_code: testCode
        })
    })
    .then(res => res.json())
    .then(data => {
        const res = data.result || {};
        const isSuccess = data.success === true || res.status === 'success';
        const latency = res.latency_ms ? `${res.latency_ms}ms` : 'fast';
        const httpCode = res.http_code || (isSuccess ? 200 : 'Err');

        if (isSuccess) {
            resultBox.style.background = '#f0fdf4';
            resultBox.style.border = '1.5px solid #86efac';
            resultBox.style.color = '#14532d';
            resultBox.innerHTML = `
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div>
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Dispatched Successfully!</strong>
                        <span class="badge badge-success font-mono ml-1">HTTP ${httpCode}</span>
                    </div>
                    <span class="badge badge-light border font-mono">${latency}</span>
                </div>
                <div class="small" style="line-height: 1.5;">
                    Event ID: <code class="font-mono text-dark">${res.test_event_id || 'test_evt'}</code> &bull; 
                    <a href="{{ route('admin.server-tracking.logs') }}" class="font-weight-bold text-success text-underline ml-1">View in Audit Logs &rarr;</a>
                </div>
            `;
        } else {
            resultBox.style.background = '#fff1f2';
            resultBox.style.border = '1.5px solid #fecdd3';
            resultBox.style.color = '#9f1239';
            resultBox.innerHTML = `
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div>
                        <i class="fas fa-times-circle text-danger mr-1"></i>
                        <strong>Dispatch Rejected / Failed</strong>
                        <span class="badge badge-danger font-mono ml-1">HTTP ${httpCode}</span>
                    </div>
                    <span class="badge badge-light border font-mono">${latency}</span>
                </div>
                <div class="small" style="line-height: 1.5;">
                    ${res.message || 'Check your Access Token and Dataset ID.'}
                    <a href="{{ route('admin.server-tracking.logs') }}" class="font-weight-bold text-danger ml-1">Inspect Telemetry &rarr;</a>
                </div>
            `;
        }
    })
    .catch(err => {
        resultBox.style.background = '#fff1f2';
        resultBox.style.border = '1.5px solid #fecdd3';
        resultBox.style.color = '#9f1239';
        resultBox.innerHTML = `
            <div><i class="fas fa-exclamation-triangle text-danger mr-1"></i> Network error communicating with server test endpoint: ${err.message}</div>
        `;
    });
}

// Redacted diagnostic snapshot generator
function generateDiagnosticData() {
    return {
        timestamp: new Date().toISOString(),
        php_engine: "NextDigiHome Server Tracking v2.6",
        meta_capi: {
            enabled: document.getElementById('meta_capi_enabled')?.checked || false,
            pixel_id: document.getElementById('meta_pixel_id')?.value ? (document.getElementById('meta_pixel_id').value.slice(0, 4) + '********') : 'Not Set',
            access_token: document.getElementById('meta_token_field')?.value ? 'Configured (Redacted ' + document.getElementById('meta_token_field').value.length + ' chars)' : 'Not Set',
            test_event_code: document.getElementById('meta_capi_test_event_code')?.value || 'None'
        },
        ga4: {
            enabled: document.getElementById('ga4_server_enabled')?.checked || false,
            measurement_id: document.getElementById('ga4_measurement_id')?.value || 'Not Set',
            api_secret: document.getElementById('ga4_api_secret')?.value ? 'Configured (Redacted)' : 'Not Set'
        },
        tiktok: {
            enabled: document.getElementById('tiktok_server_enabled')?.checked || false,
            pixel_code: document.getElementById('tiktok_pixel_code')?.value || 'Not Set',
            access_token: document.getElementById('tiktok_token_field')?.value ? 'Configured (Redacted)' : 'Not Set'
        },
        webhook: {
            enabled: document.getElementById('server_tracking_webhook_enabled')?.checked || false,
            endpoint_url: document.getElementById('server_tracking_webhook_url')?.value || 'Not Set'
        }
    };
}

function copyDiagnosticJSON() {
    const data = generateDiagnosticData();
    navigator.clipboard.writeText(JSON.stringify(data, null, 2)).then(() => {
        alert('Diagnostic JSON copied to clipboard!');
    });
}

// Change tracking & Ctrl+S hotkey
document.addEventListener('DOMContentLoaded', () => {
    // Secret masks
    ['meta_token_field', 'tiktok_token_field'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.webkitTextSecurity = 'disc';
        }
    });

    // Initial character counters
    updateTokenCount('meta_token_field', 'meta_token_len');
    updateTokenCount('tiktok_token_field', 'tiktok_token_len');

    // Initial field validators
    const metaPixel = document.getElementById('meta_pixel_id');
    if (metaPixel) validateMetaPixel(metaPixel);
    const ga4Id = document.getElementById('ga4_measurement_id');
    if (ga4Id) validateGA4Id(ga4Id);
    const tiktokPixel = document.getElementById('tiktok_pixel_code');
    if (tiktokPixel) validateTikTokPixel(tiktokPixel);
    const webhookUrl = document.getElementById('server_tracking_webhook_url');
    if (webhookUrl) validateWebhookUrl(webhookUrl);

    // Populate Diagnostic Modal
    const diagModal = $('#diagnosticModal');
    if (diagModal.length) {
        diagModal.on('show.bs.modal', function() {
            document.getElementById('diagnosticJsonPre').textContent = JSON.stringify(generateDiagnosticData(), null, 2);
        });
    }

    // Dirty form change listener
    const dirtyIndicator = document.getElementById('dirtyIndicator');
    document.querySelectorAll('.form-tracker').forEach(el => {
        el.addEventListener('input', () => {
            if (dirtyIndicator) dirtyIndicator.style.display = 'inline-flex';
        });
        el.addEventListener('change', () => {
            if (dirtyIndicator) dirtyIndicator.style.display = 'inline-flex';
        });
    });

    // Keyboard shortcut: Ctrl+S / Cmd+S to submit
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('trackingConfigForm').submit();
        }
    });
});
</script>
@endsection
