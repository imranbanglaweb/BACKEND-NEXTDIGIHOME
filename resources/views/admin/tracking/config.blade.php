@extends('admin.dashboard.master')

@section('title', 'Pipeline Credentials & Cloud Relays - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    /* ==========================================================================
       NEXTDIGIHOME ENTERPRISE CAPI & TRACKING CONSOLE STYLING
       ========================================================================== */
    :root {
        --st-primary: #4f46e5;
        --st-primary-hover: #4338ca;
        --st-text-dark: #090e17;
        --st-text-body: #1e293b;
        --st-text-muted: #334155;
        --st-text-subtle: #475569;
        --st-card-border: #cbd5e1;
        --st-card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.07), 0 2px 8px -2px rgba(15, 23, 42, 0.04);
        --st-card-hover-shadow: 0 16px 32px -4px rgba(15, 23, 42, 0.12), 0 6px 14px -2px rgba(15, 23, 42, 0.06);
    }

    .premium-page {
        background: #f1f5f9;
        min-height: calc(100vh - 66px);
        padding: 26px 32px;
        font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 15px;
        color: var(--st-text-body);
        line-height: 1.6;
    }

    /* --------------------------------------------------------------------------
       1. HERO HEADER: COSMIC DARK OBSIDIAN GRADIENT
       -------------------------------------------------------------------------- */
    .st-hero-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #090e17 0%, #0f172a 45%, #1e1b4b 100%);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 20px;
        padding: 34px 40px;
        color: #ffffff;
        margin-bottom: 28px;
        box-shadow: 0 16px 45px -4px rgba(15, 23, 42, 0.38);
    }

    .st-hero-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: 40px;
        width: 360px;
        height: 360px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.32) 0%, rgba(6, 182, 212, 0.14) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .st-hero-header::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 25%;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .st-radar-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(16, 185, 129, 0.2);
        border: 1px solid rgba(52, 211, 153, 0.5);
        color: #34d399;
        border-radius: 9999px;
        padding: 7px 16px;
        font-size: 13.5px;
        font-weight: 800;
        letter-spacing: 0.9px;
        text-transform: uppercase;
        margin-bottom: 14px;
        backdrop-filter: blur(10px);
    }

    .st-radar-dot {
        position: relative;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #10b981;
    }

    .st-radar-dot::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: rgba(16, 185, 129, 0.7);
        animation: stRadarPulse 2s infinite ease-out;
    }

    @keyframes stRadarPulse {
        0% { transform: scale(0.6); opacity: 1; }
        100% { transform: scale(2.3); opacity: 0; }
    }

    .st-hero-title {
        font-size: 34px;
        font-weight: 800;
        letter-spacing: -0.8px;
        margin: 0 0 12px;
        color: #ffffff;
        line-height: 1.25;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .st-hero-title-accent {
        background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .st-hero-subtitle {
        color: #f1f5f9;
        font-size: 16px;
        max-width: 820px;
        line-height: 1.65;
        margin-bottom: 22px;
        font-weight: 500;
    }

    .st-hero-tags {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .st-hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.26);
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 9px;
        backdrop-filter: blur(8px);
    }

    .st-hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        z-index: 2;
        position: relative;
    }

    .st-btn-glow {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #06b6d4 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.55) !important;
        border-radius: 11px !important;
        padding: 11px 22px !important;
        font-size: 14.5px !important;
        font-weight: 800 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 9px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer;
        text-decoration: none !important;
    }

    .st-btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(79, 70, 229, 0.75) !important;
        filter: brightness(1.1);
        color: #ffffff !important;
    }

    .st-btn-glass {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 11px !important;
        padding: 11px 20px !important;
        font-size: 14.5px !important;
        font-weight: 700 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 9px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        cursor: pointer;
    }

    .st-btn-glass:hover {
        background: rgba(255, 255, 255, 0.24) !important;
        border-color: rgba(255, 255, 255, 0.5) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    /* --------------------------------------------------------------------------
       2. NAVIGATION BAR
       -------------------------------------------------------------------------- */
    .st-nav-bar {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 16px;
        padding: 10px 14px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: var(--st-card-shadow);
    }

    .st-nav-links {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .st-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        color: var(--st-text-muted);
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .st-nav-link:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .st-nav-link.active {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
    }

    .st-nav-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 700;
        color: #059669;
        background: #d1fae5;
        border: 1px solid #6ee7b7;
        padding: 7px 16px;
        border-radius: 9999px;
    }

    /* --------------------------------------------------------------------------
       3. TELEMETRY KPI OVERVIEW RIBBON
       -------------------------------------------------------------------------- */
    .st-telemetry-ribbon {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    @media (max-width: 1200px) {
        .st-telemetry-ribbon { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .st-telemetry-ribbon { grid-template-columns: 1fr; }
    }

    .st-telemetry-item {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--st-card-shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .st-telemetry-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--st-card-hover-shadow);
    }

    .st-telemetry-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .st-telemetry-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--st-text-subtle);
        margin-bottom: 3px;
    }

    .st-telemetry-val {
        font-size: 19px;
        font-weight: 800;
        color: var(--st-text-dark);
        letter-spacing: -0.3px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* --------------------------------------------------------------------------
       4. PRIVACY & SECURITY BANNER
       -------------------------------------------------------------------------- */
    .st-security-banner {
        background: #ffffff;
        border: 1px solid #bbf7d0;
        border-left: 6px solid #10b981;
        border-radius: 16px;
        padding: 20px 26px;
        margin-bottom: 28px;
        box-shadow: var(--st-card-shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .st-security-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #dcfce7;
        color: #15803d;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* --------------------------------------------------------------------------
       5. PROVIDER CARDS
       -------------------------------------------------------------------------- */
    .st-providers-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 28px;
    }

    @media (max-width: 992px) {
        .st-providers-grid { grid-template-columns: 1fr; }
    }

    .st-provider-card {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 18px;
        box-shadow: var(--st-card-shadow);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .st-provider-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--st-card-hover-shadow);
        border-color: #94a3b8;
    }

    .st-provider-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
    }

    .st-provider-card.card-meta::before { background: linear-gradient(90deg, #1877f2, #38bdf8); }
    .st-provider-card.card-ga4::before { background: linear-gradient(90deg, #d97706, #ea580c); }
    .st-provider-card.card-tiktok::before { background: linear-gradient(90deg, #0f172a, #e11d48, #06b6d4); }
    .st-provider-card.card-webhook::before { background: linear-gradient(90deg, #7c3aed, #4f46e5); }

    .st-provider-header {
        background: #f8fafc;
        border-bottom: 1px solid var(--st-card-border);
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .st-provider-badge-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .st-provider-title {
        font-size: 19px;
        font-weight: 800;
        color: var(--st-text-dark);
        margin-bottom: 3px;
        letter-spacing: -0.3px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-provider-subtitle {
        font-size: 13.5px;
        color: var(--st-text-subtle);
        font-weight: 600;
    }

    .st-provider-body {
        padding: 26px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Target Endpoint Verified Box */
    .st-target-verified-box {
        background: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .st-target-verified-title {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #15803d;
        margin-bottom: 2px;
    }

    .st-target-verified-val {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 15px;
        font-weight: 800;
        color: #14532d;
    }

    /* Form Controls */
    .st-form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .st-form-label {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--st-text-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .st-form-control {
        font-size: 14.5px !important;
        color: #0f172a !important;
        border: 1.5px solid var(--st-card-border) !important;
        border-radius: 11px !important;
        min-height: 48px;
        padding: 10px 16px !important;
        font-weight: 600;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }

    .st-form-control:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        background-color: #ffffff;
    }

    .st-form-control.is-valid {
        border-color: #10b981 !important;
    }

    .st-form-textarea {
        min-height: 96px;
        font-size: 14px !important;
        line-height: 1.6 !important;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
        border-radius: 11px !important;
    }

    .st-form-help {
        font-size: 13px;
        color: var(--st-text-subtle);
        margin-top: 6px;
        line-height: 1.5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 6px;
        font-weight: 500;
    }

    .st-copy-btn {
        background: #f1f5f9;
        border: 1.5px solid var(--st-card-border);
        border-left: none;
        color: var(--st-text-muted);
        border-radius: 0 11px 11px 0 !important;
        padding: 0 18px;
        font-weight: 700;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .st-copy-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Modern In-Place Live Tester Box */
    .st-test-box {
        margin-top: 22px;
        padding: 18px 20px;
        background: #f8fafc;
        border: 1.5px solid var(--st-card-border);
        border-radius: 14px;
    }

    .st-test-btn {
        font-size: 14px;
        font-weight: 800;
        border-radius: 10px;
        padding: 9px 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .st-test-result {
        display: none;
        margin-top: 14px;
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.5;
        animation: stFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes stFadeIn {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --------------------------------------------------------------------------
       6. STICKY SAVE ACTION BAR
       -------------------------------------------------------------------------- */
    .st-sticky-save-bar {
        position: sticky;
        bottom: 24px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1.5px solid #cbd5e1;
        border-radius: 18px;
        padding: 16px 28px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.16), 0 4px 12px rgba(15, 23, 42, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 32px;
    }

    .st-save-btn {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
        color: #ffffff !important;
        font-size: 15px !important;
        font-weight: 800 !important;
        padding: 12px 28px !important;
        border-radius: 11px !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.45) !important;
        transition: all 0.25s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 9px !important;
        cursor: pointer;
    }

    .st-save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.65) !important;
        filter: brightness(1.08);
    }

    .st-dirty-indicator {
        display: none;
        font-size: 13px;
        font-weight: 800;
        color: #b45309;
        background: #fef3c7;
        border: 1px solid #fcd34d;
        padding: 5px 14px;
        border-radius: 9999px;
        align-items: center;
        gap: 6px;
        animation: stPulseGlow 2s infinite ease-in-out;
    }

    @keyframes stPulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
        50% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
    }

    /* --------------------------------------------------------------------------
       7. FLOATING TOAST SYSTEM
       -------------------------------------------------------------------------- */
    .st-toast-container {
        position: fixed;
        bottom: 26px;
        right: 26px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .st-toast {
        pointer-events: auto;
        background: #0f172a;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 12px;
        padding: 14px 22px;
        font-size: 14.5px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
        animation: stToastIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes stToastIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Modal code display */
    .st-json-pre {
        background: #0f172a;
        color: #38bdf8;
        border: 1px solid #1e293b;
        border-radius: 12px;
        padding: 18px;
        font-size: 13.5px;
        line-height: 1.6;
        max-height: 380px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }
</style>

<div class="premium-page">
    <div class="container-fluid px-0">

        <!-- ====================================================================
             1. HERO HEADER WITH LIVE STATUS & ACTIONS
             ==================================================================== -->
        <div class="st-hero-header">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <div class="st-radar-badge">
                        <span class="st-radar-dot"></span>
                        <span>Edge Engine Active &bull; Zero Signal Loss</span>
                    </div>
                    <h1 class="st-hero-title">
                        <span>Pipeline Credentials &amp;</span>
                        <span class="st-hero-title-accent">Cloud Relays</span>
                    </h1>
                    <p class="st-hero-subtitle">
                        Configure encrypted API keys, long-lived Conversions API access tokens, and server-side tracking pipelines with deterministic SHA-256 deduplication and zero signal loss.
                    </p>
                    <div class="st-hero-tags">
                        <div class="st-hero-tag"><i class="fas fa-shield-alt text-success"></i> AES-256 Encrypted</div>
                        <div class="st-hero-tag"><i class="fas fa-fingerprint text-info"></i> Deterministic event_id</div>
                        <div class="st-hero-tag"><i class="fas fa-bolt text-warning"></i> Sub-150ms Cloud Edge</div>
                        <div class="st-hero-tag"><i class="fas fa-check-circle" style="color: #34d399;"></i> GDPR / CCPA Ready</div>
                    </div>
                </div>

                <div class="st-hero-actions mt-3 mt-lg-0">
                    <button type="button" class="st-btn-glow" onclick="openDiagModal(); return false;">
                        <i class="fas fa-stethoscope"></i>
                        <span>Setup Diagnostic</span>
                    </button>
                    <button type="button" class="st-btn-glass" onclick="openSpecsModal(); return false;">
                        <i class="fas fa-book-open"></i>
                        <span>Payload Specs</span>
                    </button>
                    <a href="{{ route('admin.server-tracking.logs') }}" class="st-btn-glass">
                        <i class="fas fa-stream"></i>
                        <span>Audit Stream</span>
                    </a>
                    <a href="{{ route('admin.server-tracking.dashboard') }}" class="st-btn-glass">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: #d1fae5; border: 1.5px solid #6ee7b7; color: #065f46; border-radius: 14px; padding: 16px 22px; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.1);">
                <div class="d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; border-radius: 50%; background: #a7f3d0; color: #047857; font-size: 20px; flex-shrink: 0;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <strong class="d-block" style="font-size: 15.5px; font-weight: 800;">Credentials Saved &amp; Encrypted Successfully</strong>
                    <span style="font-size: 14.5px;">{{ session('success') }}</span>
                </div>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="font-size: 22px; opacity: 0.7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: #fee2e2; border: 1.5px solid #fca5a5; color: #991b1b; border-radius: 14px; padding: 18px 24px; box-shadow: 0 4px 16px rgba(239, 68, 68, 0.1);">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2" style="font-size: 20px;"></i>
                    <h5 class="font-weight-bold mb-0" style="font-size: 16px;">Please correct the configuration errors below:</h5>
                </div>
                <ul class="mb-0 pl-4" style="font-size: 14px; line-height: 1.6;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- ====================================================================
             2. NAVIGATION BAR (MATCHES DASHBOARD CONSOLE)
             ==================================================================== -->
        <div class="st-nav-bar">
            <div class="st-nav-links">
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="st-nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard Overview</span>
                </a>
                <a href="{{ route('admin.server-tracking.config') }}" class="st-nav-link active">
                    <i class="fas fa-sliders-h"></i>
                    <span>Pipeline Credentials</span>
                </a>
                <a href="{{ route('admin.server-tracking.logs') }}" class="st-nav-link">
                    <i class="fas fa-stream"></i>
                    <span>Audit Logs &amp; Inspector</span>
                </a>
            </div>
            <div class="st-nav-status">
                <span class="st-radar-dot" style="width: 8px; height: 8px;"></span>
                <span>Dual-Tagging Hybrid Active &bull; v2.6 Enterprise</span>
            </div>
        </div>

        <!-- ====================================================================
             3. TELEMETRY HEALTH RIBBON
             ==================================================================== -->
        <div class="st-telemetry-ribbon">
            @php
                $activeCount = 0;
                if (!empty($metaConfig['enabled'])) $activeCount++;
                if (!empty($ga4Config['enabled'])) $activeCount++;
                if (!empty($webhookConfig['enabled'])) $activeCount++;
            @endphp
            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #dbeafe; color: #1e40af;">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Active Cloud Relays</div>
                    <div class="st-telemetry-val">
                        <span>{{ $activeCount }} of 3 Ready</span>
                        <span class="badge {{ $activeCount > 0 ? 'badge-success' : 'badge-warning' }}" style="font-size: 11.5px; padding: 4px 8px; border-radius: 6px;">
                            {{ $activeCount > 0 ? 'ONLINE' : 'SETUP NEEDED' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #d1fae5; color: #065f46;">
                    <i class="fas fa-lock"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Encrypted at Rest</div>
                    <div class="st-telemetry-val">
                        <span>AES-256</span>
                        <span class="text-success small font-weight-bold" style="font-size: 13px;"><i class="fas fa-shield-alt mr-1"></i>Encrypted</span>
                    </div>
                </div>
            </div>

            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #ede9fe; color: #5b21b6;">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Deduplication Key</div>
                    <div class="st-telemetry-val">
                        <span>100% Match</span>
                        <span class="text-primary small font-weight-bold" style="font-size: 13px;">event_id + fbp</span>
                    </div>
                </div>
            </div>

            <div class="st-telemetry-item">
                <div class="st-telemetry-icon" style="background: #fef3c7; color: #92400e;">
                    <i class="fas fa-shield-virus"></i>
                </div>
                <div>
                    <div class="st-telemetry-label">Signal Resilience</div>
                    <div class="st-telemetry-val">
                        <span>Zero Loss</span>
                        <span class="text-warning small font-weight-bold" style="font-size: 13px;">Bypasses ATT &amp; AdBlock</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             4. PRIVACY & SECURITY BANNER
             ==================================================================== -->
        <div class="st-security-banner">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="st-security-icon-wrap mr-3">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <strong class="d-block text-dark font-weight-bold" style="font-size: 16px;">Deterministic Normalization &bull; PII Protection Guarantee</strong>
                    <span style="font-size: 14.5px; color: #166534; line-height: 1.5;">All customer emails and phone numbers are normalized, sanitized, and SHA-256 hashed on our edge server prior to transmission, protecting consumer privacy while maximizing ad platform Event Match Quality (EMQ).</span>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-outline-success font-weight-bold px-3 py-2" data-toggle="collapse" data-target="#privacySpecsCollapse" data-bs-toggle="collapse" data-bs-target="#privacySpecsCollapse" style="border-radius: 9px; font-size: 13.5px;">
                    <i class="fas fa-info-circle mr-1"></i> Normalization Rules
                </button>
            </div>
        </div>

        <!-- Normalization Specs Collapsible -->
        <div class="collapse mb-4" id="privacySpecsCollapse">
            <div class="card card-body border-0 p-4" style="background: #ffffff; border: 1.5px solid var(--st-card-border) !important; border-radius: 16px; box-shadow: var(--st-card-shadow);">
                <h6 class="font-weight-bold text-dark mb-3" style="font-size: 16px;">
                    <i class="fas fa-lock text-success mr-2"></i> Client-to-Edge Data Transformation Pipeline
                </h6>
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; height: 100%;">
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 14.5px;"><i class="fas fa-envelope text-primary mr-1"></i> Email Normalization</div>
                            <div class="text-muted small" style="font-size: 13px;">Trimmed of whitespace &rarr; Converted to lowercase &rarr; SHA-256 64-char hexadecimal hash.</div>
                            <div class="mt-2 font-mono text-success small font-weight-bold">hash('sha256', strtolower(trim($email)))</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; height: 100%;">
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 14.5px;"><i class="fas fa-phone text-success mr-1"></i> Phone Normalization</div>
                            <div class="text-muted small" style="font-size: 13px;">Non-digits stripped &rarr; Prefixed with country calling code &rarr; SHA-256 hashed.</div>
                            <div class="mt-2 font-mono text-success small font-weight-bold">hash('sha256', preg_replace('/\D/', '', $phone))</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; height: 100%;">
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 14.5px;"><i class="fas fa-fingerprint text-purple mr-1"></i> Deterministic Deduplication</div>
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

            <div class="st-providers-grid">
                <!-- ==========================================
                     1. META CONVERSIONS API (CAPI) & PIXEL
                     ========================================== -->
                <div class="st-provider-card card-meta">
                    <div>
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #dbeafe; color: #1877f2;">
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        Meta Conversions API
                                        <span class="badge badge-light border font-mono ml-1" style="font-size: 11.5px; padding: 4px 8px; font-weight: 700;">v20.0</span>
                                    </div>
                                    <div class="st-provider-subtitle">Direct Server-to-Meta Graph API (Dataset ID: 1786172575724734)</div>
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
                                <!-- Target Endpoint Verified Banner -->
                                <div class="st-target-verified-box">
                                    <div>
                                        <div class="st-target-verified-title">
                                            <i class="fas fa-check-circle mr-1"></i> Active Meta Graph API Target Endpoint
                                        </div>
                                        <div class="st-target-verified-val">
                                            https://graph.facebook.com/v20.0/1786172575724734/events
                                        </div>
                                    </div>
                                    <span class="badge badge-success px-3 py-1 font-weight-bold" style="border-radius: 6px;">Verified Target</span>
                                </div>

                                <!-- Pixel / Dataset ID -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="meta_pixel_id">
                                        <span>Meta Pixel / Dataset ID <span class="text-danger">*</span></span>
                                        <span id="meta_pixel_feedback" class="small text-muted font-mono" style="font-size: 12.5px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control st-form-control font-mono font-weight-bold form-tracker" 
                                               name="meta_pixel_id" id="meta_pixel_id" 
                                               value="{{ old('meta_pixel_id', $settings->meta_dataset_id ?? $settings->meta_pixel_id ?? $metaConfig['dataset_id'] ?? '1786172575724734') }}" 
                                               placeholder="1786172575724734" oninput="validateMetaPixel(this)">
                                        <div class="input-group-append">
                                            <button class="btn st-copy-btn" type="button" onclick="copyInput('meta_pixel_id')" title="Copy Dataset ID">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="st-form-help">
                                        <span>Configured in Meta Events Manager &gt; Dataset <strong>1786172575724734</strong> &gt; Settings.</span>
                                        <a href="https://adsmanager.facebook.com/events_manager2" target="_blank" rel="noopener noreferrer" class="st-link-helper">
                                            Meta Events Manager <i class="fas fa-external-link-alt" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Access Token -->
                                <div class="st-form-group">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="meta_token_field" class="st-form-label mb-0">
                                            <span>Conversions API Access Token <span class="text-danger">*</span></span>
                                            @if(!empty($settings->meta_capi_access_token) || !empty($metaConfig['access_token']))
                                                <span class="badge badge-success ml-2 font-weight-normal" style="font-size: 11.5px;">
                                                    <i class="fas fa-shield-alt mr-1"></i>Saved Encrypted
                                                </span>
                                            @endif
                                        </label>
                                        <div class="d-flex align-items-center gap-2">
                                            <span id="meta_token_len" class="small text-muted font-mono mr-2" style="font-size: 12px;"></span>
                                            <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="toggleSecretMask('meta_token_field', this)">
                                                <i class="fas fa-eye mr-1"></i> Show Token
                                            </button>
                                        </div>
                                    </div>
                                    <textarea class="form-control st-form-control st-form-textarea font-mono form-tracker" 
                                              id="meta_token_field" name="meta_capi_access_token" rows="3" 
                                              placeholder="EAAB... (Paste Long-lived System User Access Token from Meta Events Manager)" 
                                              oninput="updateTokenCount('meta_token_field', 'meta_token_len')">{{ old('meta_capi_access_token', $settings->meta_capi_access_token ?? $metaConfig['access_token']) }}</textarea>
                                    <div class="st-form-help">
                                        <span>Tokens are encrypted with AES-256 before saving to the database and never logged.</span>
                                        <span class="badge badge-light border text-muted" style="font-size: 12px;">System User Token Recommended</span>
                                    </div>
                                </div>

                                <!-- Test Event Code -->
                                <div class="st-form-group">
                                    <label class="st-form-label" for="meta_capi_test_event_code">
                                        <span>Test Event Code (Optional)</span>
                                        <span class="badge badge-secondary" style="font-size: 11.5px;">Events Manager Live Feed</span>
                                    </label>
                                    <input type="text" class="form-control st-form-control font-mono font-weight-bold form-tracker" 
                                           id="meta_capi_test_event_code" name="meta_capi_test_event_code" 
                                           value="{{ old('meta_capi_test_event_code', $settings->meta_capi_test_event_code ?? $metaConfig['test_event_code'] ?? 'TEST54855') }}" 
                                           placeholder="TEST54855">
                                    <div class="st-form-help">
                                        <span>Matches the code shown in Meta Events Manager &gt; Test Events tab. Default: <code>TEST54855</code>.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- In-Place Live Tester -->
                            <div class="st-test-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-primary st-test-btn" onclick="runInPlaceTest('meta_capi', 'Lead')">
                                        <i class="fas fa-paper-plane mr-1"></i> Dispatch Meta Test Event
                                    </button>
                                    <span class="text-muted small font-weight-bold">
                                        Target: <code class="text-primary font-mono font-weight-bold">1786172575724734</code>
                                    </span>
                                </div>
                                <div id="testResult_meta_capi" class="st-test-result"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     2. GOOGLE ANALYTICS 4 (GA4)
                     ========================================== -->
                <div class="st-provider-card card-ga4">
                    <div>
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #fef3c7; color: #d97706;">
                                    <i class="fab fa-google"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        Google Analytics 4
                                        <span class="badge badge-light border font-mono ml-1" style="font-size: 11.5px; padding: 4px 8px; font-weight: 700;">Measurement Protocol</span>
                                    </div>
                                    <div class="st-provider-subtitle">Direct Server-to-Google Analytics Engine</div>
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
                                        <span id="ga4_id_feedback" class="small text-muted font-mono" style="font-size: 12.5px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control st-form-control font-mono font-weight-bold form-tracker" 
                                               name="ga4_measurement_id" id="ga4_measurement_id" 
                                               value="{{ old('ga4_measurement_id', $settings->ga4_measurement_id ?? $settings->google_analytics_id ?? $ga4Config['measurement_id']) }}" 
                                               placeholder="e.g. G-ZL647FTZQE" oninput="validateGA4Id(this)">
                                        <div class="input-group-append">
                                            <button class="btn st-copy-btn" type="button" onclick="copyInput('ga4_measurement_id')" title="Copy Measurement ID">
                                                <i class="fas fa-copy"></i>
                                            </button>
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
                                    <input type="password" class="form-control st-form-control font-mono form-tracker" 
                                           id="ga4_api_secret" name="ga4_api_secret" 
                                           value="{{ old('ga4_api_secret', $settings->ga4_api_secret ?? $ga4Config['api_secret']) }}" 
                                           placeholder="Enter GA4 Measurement Protocol API Secret">
                                    <div class="st-form-help">
                                        <span>Generate in GA4 Admin &gt; Data Streams &gt; Measurement Protocol API secrets &gt; Create.</span>
                                    </div>
                                </div>

                                <!-- Hit Specifications Callout -->
                                <div class="p-3 mb-0 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; color: #334155; line-height: 1.6;">
                                    <div class="d-flex align-items-center font-weight-bold text-dark mb-1">
                                        <i class="fas fa-info-circle text-primary mr-2"></i> Automatic Client ID Resolution
                                    </div>
                                    <div>Edge dispatches extract GA Client IDs from <code>_ga</code> cookies or generate a deterministic UUID fallback from email hashes to guarantee 0% session fragmentation.</div>
                                </div>
                            </div>

                            <!-- In-Place Live Tester -->
                            <div class="st-test-box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <button type="button" class="btn btn-warning text-dark font-weight-bold st-test-btn" onclick="runInPlaceTest('ga4', 'Lead')">
                                        <i class="fas fa-paper-plane mr-1 text-dark"></i> Dispatch GA4 Test Hit
                                    </button>
                                    <span class="text-muted small">Emits server-side <code>generate_lead</code></span>
                                </div>
                                <div id="testResult_ga4" class="st-test-result"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     3. SERVER WEBHOOK / sGTM
                     ========================================== -->
                <div class="st-provider-card card-webhook">
                    <div>
                        <div class="st-provider-header">
                            <div class="d-flex align-items-center">
                                <div class="st-provider-badge-icon mr-3" style="background: #ede9fe; color: #7c3aed;">
                                    <i class="fas fa-network-wired"></i>
                                </div>
                                <div>
                                    <div class="st-provider-title">
                                        Server Webhook / sGTM
                                        <span class="badge badge-light border font-mono ml-1" style="font-size: 11.5px; padding: 4px 8px; font-weight: 700;">Cloud Relay</span>
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
                                        <span id="webhook_url_feedback" class="small text-muted font-mono" style="font-size: 12.5px;"></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="url" class="form-control st-form-control font-mono font-weight-bold form-tracker" 
                                               name="server_tracking_webhook_url" id="server_tracking_webhook_url" 
                                               value="{{ old('server_tracking_webhook_url', $settings->server_tracking_webhook_url ?? $webhookConfig['url']) }}" 
                                               placeholder="https://sgtm.yourdomain.com/data" oninput="validateWebhookUrl(this)">
                                        <div class="input-group-append">
                                            <button class="btn st-copy-btn" type="button" onclick="copyInput('server_tracking_webhook_url')" title="Copy Webhook URL">
                                                <i class="fas fa-copy"></i>
                                            </button>
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

                                <div class="p-3 mb-0 rounded" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; color: #334155; line-height: 1.6;">
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
                    <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; border-radius: 12px; background: #d1fae5; color: #047857; font-size: 20px; flex-shrink: 0;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-dark" style="font-size: 15px;">Encrypted Key Storage Active</strong>
                            <span id="dirtyIndicator" class="st-dirty-indicator">
                                <i class="fas fa-pen mr-1"></i> Unsaved Changes Pending
                            </span>
                        </div>
                        <span style="font-size: 13.5px; color: var(--st-text-subtle);">
                            Credentials are encrypted in database via AES-256 and accessed exclusively through secure backend services.
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 11px; font-size: 14.5px;">
                        Cancel
                    </a>
                    <button type="submit" class="st-save-btn">
                        <i class="fas fa-save"></i>
                        <span>Save Tracking Credentials</span>
                        <kbd class="ml-2 text-white" style="background: rgba(0,0,0,0.3); border: none; font-size: 11px; padding: 3px 7px; border-radius: 6px;">Ctrl+S</kbd>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- ============================================================================
     7. SETUP DIAGNOSTIC MODAL (REDACTED EXPORT)
     ============================================================================ -->
<div class="modal fade" id="diagnosticModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 10550; display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="z-index: 10560; margin: 40px auto; max-width: 820px;">
        <div class="modal-content" style="border: 1px solid #cbd5e1; border-radius: 18px; box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.3); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: #0f172a; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.12);">
                <div class="d-flex align-items-center">
                    <div style="background: rgba(255, 255, 255, 0.12); color: #38bdf8; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;" class="mr-3">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-white mb-0" style="font-size: 19px;">
                            Server Tracking Setup Diagnostic
                        </h5>
                        <div class="text-white-50" style="font-size: 14px;">Redacted pipeline snapshot for audit and agency sharing</div>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" onclick="closeDiagModal(); return false;" style="opacity: 0.85; font-size: 24px; line-height: 1; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="background: #ffffff;">
                <div class="alert alert-info d-flex align-items-center mb-3" style="background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1e40af; border-radius: 12px; font-size: 14px;">
                    <i class="fas fa-shield-alt mr-2" style="font-size: 18px;"></i>
                    <span>All private API tokens and secrets have been automatically redacted with asterisks for security.</span>
                </div>
                <div class="position-relative">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold position-absolute" style="top: 12px; right: 12px; z-index: 5; font-size: 13px;" onclick="copyDiagnosticJSON()">
                        <i class="fas fa-copy mr-1"></i> Copy JSON
                    </button>
                    <pre id="diagnosticJsonPre" class="st-json-pre mb-0 font-mono"></pre>
                </div>
            </div>
            <div class="modal-footer py-3 px-4" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" data-bs-dismiss="modal" onclick="closeDiagModal(); return false;" style="border-radius: 9px; font-size: 14.5px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     8. PAYLOAD SPECS MODAL
     ============================================================================ -->
<div class="modal fade" id="specsModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 10550; display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="z-index: 10560; margin: 40px auto; max-width: 820px;">
        <div class="modal-content" style="border: 1px solid #cbd5e1; border-radius: 18px; box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.3); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: #0f172a; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.12);">
                <div class="d-flex align-items-center">
                    <div style="background: rgba(255, 255, 255, 0.12); color: #34d399; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;" class="mr-3">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-white mb-0" style="font-size: 19px;">
                            Conversion Event Payload Specifications
                        </h5>
                        <div class="text-white-50" style="font-size: 14px;">Platform mappings for Lead, Purchase, and Inquiries</div>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" onclick="closeSpecsModal(); return false;" style="opacity: 0.85; font-size: 24px; line-height: 1; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="background: #ffffff;">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" style="font-size: 14px;">
                        <thead style="background: #f1f5f9; font-weight: 800; color: #0f172a;">
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
                                <td class="font-weight-bold">Form Submission / Inquiry</td>
                                <td><span class="badge badge-primary px-2 py-1 font-mono">Lead</span></td>
                                <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">generate_lead</span></td>
                                <td><span class="badge badge-dark px-2 py-1 font-mono">SubmitForm</span></td>
                                <td><code class="font-mono">lead_created</code></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Paid Order / Service Purchase</td>
                                <td><span class="badge badge-primary px-2 py-1 font-mono">Purchase</span></td>
                                <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">purchase</span></td>
                                <td><span class="badge badge-dark px-2 py-1 font-mono">CompletePayment</span></td>
                                <td><code class="font-mono">order_completed</code></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Portfolio / Project View</td>
                                <td><span class="badge badge-primary px-2 py-1 font-mono">ViewContent</span></td>
                                <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">view_item</span></td>
                                <td><span class="badge badge-dark px-2 py-1 font-mono">ViewContent</span></td>
                                <td><code class="font-mono">page_viewed</code></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">WhatsApp / Phone Click</td>
                                <td><span class="badge badge-primary px-2 py-1 font-mono">Contact</span></td>
                                <td><span class="badge badge-warning text-dark px-2 py-1 font-mono">contact_click</span></td>
                                <td><span class="badge badge-dark px-2 py-1 font-mono">Contact</span></td>
                                <td><code class="font-mono">contact_engaged</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-3 px-4" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" data-bs-dismiss="modal" onclick="closeSpecsModal(); return false;" style="border-radius: 9px; font-size: 14.5px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     9. FLOATING TOAST SYSTEM
     ============================================================================ -->
<div class="st-toast-container" id="toastContainer"></div>

<!-- ============================================================================
     10. JAVASCRIPT LOGIC & INTERACTIONS
     ============================================================================ -->
<script>
// Toast utility
function showToast(message, icon = 'fa-check-circle text-success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'st-toast';
    toast.innerHTML = `<i class="fas ${icon}"></i> <span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 300);
    }, 2800);
}

// Clipboard copy utility
function copyInput(elementId) {
    const input = document.getElementById(elementId);
    if (!input || !input.value) {
        showToast('Field is empty', 'fa-exclamation-circle text-warning');
        return;
    }
    navigator.clipboard.writeText(input.value).then(() => {
        showToast('Copied to clipboard!', 'fa-copy text-info');
    }).catch(err => {
        const textarea = document.createElement('textarea');
        textarea.value = input.value;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast('Copied to clipboard!', 'fa-copy text-info');
    });
}

// Secret toggling
function toggleSecretInput(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
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
    if (!textarea) return;
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
    if (!feedback) return;
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
    if (!feedback) return;
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
    if (!feedback) return;
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
    if (!feedback) return;
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
    const el = document.getElementById(fieldId);
    const label = document.getElementById(labelId);
    if (!el || !label) return;
    const val = el.value.trim();
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
    let datasetId = '';
    let accessToken = '';
    let webhookUrl = '';

    if (provider === 'meta_capi') {
        testCode = document.getElementById('meta_capi_test_event_code')?.value || 'TEST54855';
        datasetId = document.getElementById('meta_pixel_id')?.value || '1786172575724734';
        accessToken = document.getElementById('meta_token_field')?.value || '';
    } else if (provider === 'webhook') {
        webhookUrl = document.getElementById('server_tracking_webhook_url')?.value || '';
    }

    resultBox.style.display = 'block';
    resultBox.style.background = '#f8fafc';
    resultBox.style.border = '1.5px solid #cbd5e1';
    resultBox.innerHTML = `
        <div class="d-flex align-items-center text-muted font-weight-bold">
            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
            <span>Dispatching live edge event to <strong>${provider.toUpperCase()}</strong>...</span>
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
            test_event_code: testCode,
            dataset_id: datasetId,
            pixel_id: datasetId,
            access_token: accessToken,
            webhook_url: webhookUrl
        })
    })
    .then(res => res.json())
    .then(data => {
        const res = data.result || {};
        const isSuccess = data.success === true || res.status === 'success';
        const latency = res.latency_ms ? `${res.latency_ms} ms` : 'Completed';
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
                    <span class="badge badge-light border font-mono font-weight-bold">${latency}</span>
                </div>
                <div class="small" style="line-height: 1.5;">
                    Event ID: <code class="font-mono text-dark font-weight-bold">${res.test_event_id || 'test_evt'}</code> &bull; 
                    <a href="{{ route('admin.server-tracking.logs') }}" class="font-weight-bold text-success text-underline ml-1">View in Audit Logs &rarr;</a>
                </div>
            `;
            showToast(`Test event successfully delivered to ${provider.toUpperCase()}`, 'fa-check-circle text-success');
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
                    <span class="badge badge-light border font-mono font-weight-bold">${latency}</span>
                </div>
                <div class="small" style="line-height: 1.5;">
                    ${res.message || res.error || 'Check your Access Token and Dataset ID.'}
                    <a href="{{ route('admin.server-tracking.logs') }}" class="font-weight-bold text-danger ml-1">Inspect Telemetry &rarr;</a>
                </div>
            `;
            showToast(`Dispatch failed for ${provider.toUpperCase()}`, 'fa-times-circle text-danger');
        }
    })
    .catch(err => {
        resultBox.style.background = '#fff1f2';
        resultBox.style.border = '1.5px solid #fecdd3';
        resultBox.style.color = '#9f1239';
        resultBox.innerHTML = `
            <div><i class="fas fa-exclamation-triangle text-danger mr-1"></i> Network error communicating with server test endpoint: ${err.message}</div>
        `;
        showToast('Network error during test dispatch', 'fa-times-circle text-danger');
    });
}

// Redacted diagnostic snapshot generator
function generateDiagnosticData() {
    return {
        timestamp: new Date().toISOString(),
        php_engine: "NextDigiHome Server Tracking v2.6 Enterprise",
        meta_capi: {
            enabled: document.getElementById('meta_capi_enabled')?.checked || false,
            dataset_id: document.getElementById('meta_pixel_id')?.value ? document.getElementById('meta_pixel_id').value : '1786172575724734',
            endpoint: "https://graph.facebook.com/v20.0/1786172575724734/events",
            access_token: document.getElementById('meta_token_field')?.value ? 'Configured & Encrypted (' + document.getElementById('meta_token_field').value.length + ' chars)' : 'Not Set',
            test_event_code: document.getElementById('meta_capi_test_event_code')?.value || 'TEST54855'
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
        showToast('Diagnostic JSON copied to clipboard!', 'fa-copy text-info');
    });
}

// Modal handling
function openDiagModal() {
    const pre = document.getElementById('diagnosticJsonPre');
    if (pre) pre.textContent = JSON.stringify(generateDiagnosticData(), null, 2);

    const modal = document.getElementById('diagnosticModal');
    if (!modal) return;
    if (modal.parentNode !== document.body) document.body.appendChild(modal);

    modal.classList.add('show', 'in');
    modal.style.display = 'block';
    modal.style.zIndex = '10550';
    document.body.classList.add('modal-open');

    if (typeof $ !== 'undefined' && $('#diagnosticModal').modal) {
        try { $('#diagnosticModal').modal('show'); } catch (e) {}
    } else if (window.bootstrap && window.bootstrap.Modal) {
        try { bootstrap.Modal.getOrCreateInstance(modal).show(); } catch (e) {}
    }
}

function closeDiagModal() {
    const modal = document.getElementById('diagnosticModal');
    if (modal) {
        modal.classList.remove('show', 'in');
        modal.style.display = 'none';
        if (typeof $ !== 'undefined' && $('#diagnosticModal').modal) {
            try { $('#diagnosticModal').modal('hide'); } catch (e) {}
        } else if (window.bootstrap && window.bootstrap.Modal) {
            try { bootstrap.Modal.getInstance(modal)?.hide(); } catch (e) {}
        }
    }
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    document.body.classList.remove('modal-open');
}

function openSpecsModal() {
    const modal = document.getElementById('specsModal');
    if (!modal) return;
    if (modal.parentNode !== document.body) document.body.appendChild(modal);

    modal.classList.add('show', 'in');
    modal.style.display = 'block';
    modal.style.zIndex = '10550';
    document.body.classList.add('modal-open');

    if (typeof $ !== 'undefined' && $('#specsModal').modal) {
        try { $('#specsModal').modal('show'); } catch (e) {}
    } else if (window.bootstrap && window.bootstrap.Modal) {
        try { bootstrap.Modal.getOrCreateInstance(modal).show(); } catch (e) {}
    }
}

function closeSpecsModal() {
    const modal = document.getElementById('specsModal');
    if (modal) {
        modal.classList.remove('show', 'in');
        modal.style.display = 'none';
        if (typeof $ !== 'undefined' && $('#specsModal').modal) {
            try { $('#specsModal').modal('hide'); } catch (e) {}
        } else if (window.bootstrap && window.bootstrap.Modal) {
            try { bootstrap.Modal.getInstance(modal)?.hide(); } catch (e) {}
        }
    }
    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    document.body.classList.remove('modal-open');
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
            const form = document.getElementById('trackingConfigForm');
            if (form) form.submit();
        }
    });
});
</script>
@endsection
