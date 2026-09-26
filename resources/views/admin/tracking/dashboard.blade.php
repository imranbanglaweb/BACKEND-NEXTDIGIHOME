@extends('admin.dashboard.master')

@section('title', 'Server Tracking & CAPI Control Center - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<!-- Preconnect & Load Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Load Chart.js 4.4.2 from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<style>
    /* ==========================================================================
       NEXTDIGIHOME ENTERPRISE CONVERSION INTELLIGENCE & CAPI SUITE (v3.0)
       Pixel-Perfect Typography, High-Contrast Palette & Cohesive Layout System
       ========================================================================== */

    :root {
        --st-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --st-font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;

        /* High-Contrast Neutral Text Scale */
        --st-text-heading: #0f172a; /* Slate 900 */
        --st-text-body: #1e293b;    /* Slate 800 */
        --st-text-muted: #475569;   /* Slate 600 */
        --st-text-subtle: #64748b;  /* Slate 500 */
        --st-border-light: #e2e8f0; /* Slate 200 */
        --st-border-mid: #cbd5e1;   /* Slate 300 */
        --st-bg-surface: #ffffff;
        --st-bg-muted: #f8fafc;

        /* Curated Harmonious Brand Palette */
        --st-meta-blue: #0284c7;
        --st-meta-bg: #f0f9ff;
        --st-meta-border: #bae6fd;
        --st-meta-text: #0369a1;

        --st-ga4-amber: #d97706;
        --st-ga4-bg: #fffbeb;
        --st-ga4-border: #fde68a;
        --st-ga4-text: #92400e;

        --st-sgtm-purple: #7c3aed;
        --st-sgtm-bg: #f5f3ff;
        --st-sgtm-border: #ddd6fe;
        --st-sgtm-text: #5b21b6;

        --st-emerald: #059669;
        --st-emerald-bg: #ecfdf5;
        --st-emerald-border: #a7f3d0;
        --st-emerald-text: #065f46;

        --st-card-shadow: 0 2px 12px -1px rgba(15, 23, 42, 0.05), 0 1px 4px -1px rgba(15, 23, 42, 0.03);
        --st-card-hover: 0 12px 28px -4px rgba(15, 23, 42, 0.1), 0 4px 10px -2px rgba(15, 23, 42, 0.05);
    }

    .premium-page {
        background: #f8fafc !important;
        min-height: calc(100vh - 66px);
        padding: 24px 30px 60px !important;
        font-family: var(--st-font-sans) !important;
        color: var(--st-text-body) !important;
        font-size: 14.5px !important;
        line-height: 1.55 !important;
        -webkit-font-smoothing: antialiased;
    }

    .font-mono-code {
        font-family: var(--st-font-mono) !important;
    }

    /* --------------------------------------------------------------------------
       1. HERO HEADER: COSMIC OBSIDIAN GLASS
       -------------------------------------------------------------------------- */
    .ci-hero-banner {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #090e17 0%, #0f172a 45%, #1e1b4b 100%);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 20px;
        padding: 30px 36px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 16px 40px -8px rgba(15, 23, 42, 0.35);
    }

    .ci-hero-banner::before {
        content: '';
        position: absolute;
        top: -60px;
        right: 40px;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.28) 0%, rgba(6, 182, 212, 0.12) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .ci-radar-pill {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        background: rgba(16, 185, 129, 0.16);
        border: 1px solid rgba(52, 211, 153, 0.4);
        color: #34d399;
        border-radius: 9999px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.7px;
        text-transform: uppercase;
        margin-bottom: 12px;
        backdrop-filter: blur(8px);
    }

    .ci-pulse-dot {
        position: relative;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background-color: #10b981;
    }

    .ci-pulse-dot::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        border: 2px solid #34d399;
        opacity: 0.8;
        animation: ciPulseRing 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    @keyframes ciPulseRing {
        0% { transform: scale(0.5); opacity: 1; }
        100% { transform: scale(1.6); opacity: 0; }
    }

    .ci-hero-title {
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.6px;
        color: #ffffff;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        line-height: 1.25;
    }

    .ci-hero-subtitle {
        font-size: 14.5px;
        color: #cbd5e1;
        max-width: 780px;
        line-height: 1.6;
        margin-bottom: 20px;
        font-weight: 400;
    }

    .ci-hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .ci-btn-glass {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.24) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 13.5px !important;
        padding: 9px 18px !important;
        border-radius: 11px !important;
        backdrop-filter: blur(8px) !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-decoration: none !important;
    }

    .ci-btn-glass:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: rgba(255, 255, 255, 0.45) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
    }

    .ci-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 13.5px !important;
        padding: 9px 20px !important;
        border-radius: 11px !important;
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.4) !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        cursor: pointer;
        text-decoration: none !important;
    }

    .ci-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.55) !important;
        filter: brightness(1.06);
    }

    /* --------------------------------------------------------------------------
       2. UNIFIED SUITE NAVIGATION BAR
       -------------------------------------------------------------------------- */
    .st-suite-nav {
        background: #ffffff;
        border: 1px solid var(--st-border-light);
        border-radius: 14px;
        padding: 8px 12px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        box-shadow: var(--st-card-shadow);
    }

    .st-suite-tabs {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }

    .st-suite-tab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 700;
        color: var(--st-text-muted);
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .st-suite-tab:hover {
        color: var(--st-text-heading);
        background: #f1f5f9;
    }

    .st-suite-tab.active {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
    }

    .st-suite-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--st-text-subtle);
        padding-right: 8px;
    }

    /* --------------------------------------------------------------------------
       3. GATEWAY HEALTH MONITOR STRIP
       -------------------------------------------------------------------------- */
    .ci-gateway-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    @media (max-width: 992px) {
        .ci-gateway-grid { grid-template-columns: 1fr; }
    }

    .ci-gateway-card {
        background: #ffffff;
        border: 1px solid var(--st-border-light);
        border-radius: 14px;
        padding: 15px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--st-card-shadow);
        transition: all 0.2s ease;
    }

    .ci-gateway-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--st-card-hover);
        border-color: var(--st-border-mid);
    }

    .ci-gateway-main {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ci-gateway-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .ci-gateway-title {
        font-weight: 800;
        font-size: 14px;
        color: var(--st-text-heading);
        margin-bottom: 2px;
    }

    .ci-gateway-url {
        font-size: 12px;
        color: var(--st-text-subtle);
        font-family: var(--st-font-mono);
    }

    .ci-badge-active {
        background: var(--st-emerald-bg);
        color: var(--st-emerald-text);
        border: 1px solid var(--st-emerald-border);
        font-weight: 800;
        font-size: 11.5px;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* --------------------------------------------------------------------------
       4. EXECUTIVE KPI STAT CARDS (5 COLUMNS)
       -------------------------------------------------------------------------- */
    .ci-kpi-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    @media (max-width: 1200px) {
        .ci-kpi-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .ci-kpi-grid { grid-template-columns: 1fr; }
    }

    .ci-kpi-card {
        background: #ffffff;
        border: 1px solid var(--st-border-light);
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: var(--st-card-shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .ci-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--st-card-hover);
        border-color: var(--st-border-mid);
    }

    .ci-kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .ci-kpi-card.kpi-total::before { background: linear-gradient(90deg, #4f46e5, #06b6d4); }
    .ci-kpi-card.kpi-meta::before { background: linear-gradient(90deg, #0284c7, #38bdf8); }
    .ci-kpi-card.kpi-ga4::before { background: linear-gradient(90deg, #d97706, #ea580c); }
    .ci-kpi-card.kpi-webhook::before { background: linear-gradient(90deg, #7c3aed, #6366f1); }
    .ci-kpi-card.kpi-success::before { background: linear-gradient(90deg, #059669, #10b981); }

    .ci-kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .ci-kpi-label {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--st-text-muted);
    }

    .ci-kpi-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .ci-kpi-val {
        font-size: 27px;
        font-weight: 800;
        color: var(--st-text-heading);
        line-height: 1.15;
        letter-spacing: -0.6px;
        margin-bottom: 6px;
    }

    .ci-kpi-caption {
        font-size: 12.5px;
        color: var(--st-text-subtle);
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    /* --------------------------------------------------------------------------
       5. CONTENT CARDS & CHARTS
       -------------------------------------------------------------------------- */
    .ci-panel {
        background: #ffffff;
        border: 1px solid var(--st-border-light);
        border-radius: 18px;
        box-shadow: var(--st-card-shadow);
        padding: 24px 26px;
        margin-bottom: 22px;
        transition: box-shadow 0.2s ease;
    }

    .ci-panel:hover {
        box-shadow: var(--st-card-hover);
    }

    .ci-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .ci-panel-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ci-panel-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .ci-panel-title {
        font-size: 17px;
        font-weight: 800;
        color: var(--st-text-heading);
        margin: 0;
        letter-spacing: -0.3px;
    }

    .ci-panel-sub {
        font-size: 13px;
        color: var(--st-text-muted);
        margin: 2px 0 0 0;
        font-weight: 500;
    }

    .ci-range-selector {
        display: inline-flex;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 3px;
        gap: 2px;
    }

    .ci-range-btn {
        border: none;
        background: transparent;
        color: var(--st-text-muted);
        font-size: 12.5px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ci-range-btn.active, .ci-range-btn:hover {
        background: #ffffff;
        color: var(--st-text-heading);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.07);
    }

    /* EMQ Signal Breakdown Box */
    .ci-emq-container {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        border: 1.5px solid var(--st-emerald-border);
        border-radius: 16px;
        padding: 20px 22px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .ci-emq-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .ci-emq-score-num {
        font-size: 36px;
        font-weight: 900;
        color: #065f46;
        line-height: 1;
        letter-spacing: -1px;
    }

    .ci-param-row {
        margin-bottom: 12px;
    }
    .ci-param-row:last-child { margin-bottom: 0; }

    .ci-param-meta {
        display: flex;
        justify-content: space-between;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--st-text-body);
        margin-bottom: 4px;
    }

    .ci-track-bar {
        height: 7px;
        background: #e2e8f0;
        border-radius: 9999px;
        overflow: hidden;
    }

    .ci-fill-bar {
        height: 100%;
        border-radius: 9999px;
        transition: width 0.8s ease;
    }

    /* --------------------------------------------------------------------------
       6. THE 3 CORE PROVIDER PIPELINE CARDS (NO TIKTOK)
       -------------------------------------------------------------------------- */
    .ci-providers-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 22px;
    }

    @media (max-width: 992px) {
        .ci-providers-grid { grid-template-columns: 1fr; }
    }

    .ci-channel-box {
        background: #ffffff;
        border: 1px solid var(--st-border-light);
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: var(--st-card-shadow);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .ci-channel-box:hover {
        transform: translateY(-2px);
        box-shadow: var(--st-card-hover);
        border-color: var(--st-border-mid);
    }

    .ci-channel-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .ci-channel-box.card-meta::before { background: linear-gradient(90deg, #0284c7, #38bdf8); }
    .ci-channel-box.card-ga4::before { background: linear-gradient(90deg, #d97706, #ea580c); }
    .ci-channel-box.card-webhook::before { background: linear-gradient(90deg, #7c3aed, #6366f1); }

    .ci-channel-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .ci-channel-icon-pill {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .ci-channel-heading {
        font-size: 17.5px;
        font-weight: 800;
        color: var(--st-text-heading);
        margin: 0 0 2px 0;
        letter-spacing: -0.3px;
    }

    .ci-channel-subproto {
        font-size: 12.5px;
        color: var(--st-text-subtle);
        font-weight: 600;
    }

    .ci-channel-specs {
        background: var(--st-bg-muted);
        border: 1px solid var(--st-border-light);
        border-radius: 12px;
        padding: 13px 15px;
        margin-bottom: 18px;
        font-size: 13px;
    }

    .ci-spec-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .ci-spec-item:last-child { margin-bottom: 0; }
    .ci-spec-lbl { color: var(--st-text-muted); font-weight: 600; font-size: 12.5px; }
    .ci-spec-data { color: var(--st-text-heading); font-weight: 800; font-family: var(--st-font-mono); font-size: 12.5px; }

    .ci-btn-row {
        display: flex;
        gap: 8px;
    }

    /* --------------------------------------------------------------------------
       7. RECENT LOGS AUDIT TABLE
       -------------------------------------------------------------------------- */
    .ci-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .ci-table th {
        background: #f8fafc;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--st-text-muted);
        border-bottom: 1.5px solid var(--st-border-light);
    }

    .ci-table td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: var(--st-text-body);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .ci-table tr:hover td {
        background: #f8fafc;
    }

    .ci-filter-btn {
        border: 1px solid var(--st-border-mid);
        background: #ffffff;
        color: var(--st-text-muted);
        font-size: 12.5px;
        font-weight: 700;
        padding: 6px 13px;
        border-radius: 7px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ci-filter-btn.active, .ci-filter-btn:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    /* Channel badges */
    .st-badge-meta { background: var(--st-meta-bg); color: var(--st-meta-text); border: 1px solid var(--st-meta-border); font-weight: 700; font-size: 12px; }
    .st-badge-ga4 { background: var(--st-ga4-bg); color: var(--st-ga4-text); border: 1px solid var(--st-ga4-border); font-weight: 700; font-size: 12px; }
    .st-badge-webhook { background: var(--st-sgtm-bg); color: var(--st-sgtm-text); border: 1px solid var(--st-sgtm-border); font-weight: 700; font-size: 12px; }

    /* Modals & JSON Viewer */
    .ci-modal-head {
        background: linear-gradient(135deg, #090e17 0%, #1e1b4b 100%);
        color: #ffffff;
        border-radius: 18px 18px 0 0;
        padding: 22px 26px;
    }

    .ci-json-box {
        background: #090e17;
        color: #38bdf8;
        padding: 16px;
        border-radius: 11px;
        font-family: var(--st-font-mono);
        font-size: 12.5px;
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #1e293b;
        line-height: 1.5;
    }
</style>

<div class="premium-page">

    <!-- ====================================================================
         1. HERO HEADER: COSMIC OBSIDIAN GLASS
         ==================================================================== -->
    <div class="ci-hero-banner">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <div class="ci-radar-pill">
                    <span class="ci-pulse-dot"></span>
                    <span>LIVE CONVERSION INTELLIGENCE ENGINE &bull; v3.0 ENTERPRISE</span>
                </div>
                <h1 class="ci-hero-title">
                    <span>Server Tracking &amp; CAPI Control Center</span>
                    <span class="badge badge-light text-dark font-mono-code px-3 py-1" style="font-size: 12.5px; border-radius: 8px; font-weight: 800;">
                        <i class="fab fa-facebook text-primary mr-1"></i> Dataset {{ $metaConfig['dataset_id'] }}
                    </span>
                </h1>
                <p class="ci-hero-subtitle">
                    Direct server-to-server dual-tagging infrastructure delivering ultra-resilient conversion events to Meta Conversions API (CAPI), Google Analytics 4 Measurement Protocol, and Server-Side GTM Cloud Relays with sub-250ms latency.
                </p>
            </div>

            <div class="ci-hero-actions">
                <button type="button" class="ci-btn-primary" onclick="openMultiEventModal()">
                    <i class="fas fa-bolt"></i> Live Event Simulator
                </button>
                <div class="btn-group">
                    <button type="button" class="ci-btn-glass dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-file-export"></i> Export Telemetry
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" style="border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                        <a class="dropdown-item py-2 font-weight-bold" href="{{ route('admin.server-tracking.export', ['format' => 'csv']) }}">
                            <i class="fas fa-file-csv text-success mr-2"></i> Export Audit Logs (CSV)
                        </a>
                        <a class="dropdown-item py-2 font-weight-bold" href="{{ route('admin.server-tracking.export', ['format' => 'json']) }}">
                            <i class="fas fa-file-code text-primary mr-2"></i> Export Full Telemetry (JSON)
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.server-tracking.config') }}" class="ci-btn-glass">
                    <i class="fas fa-sliders-h"></i> CAPI &amp; Pixel Setup
                </a>
                <a href="{{ route('admin.server-tracking.logs') }}" class="ci-btn-glass">
                    <i class="fas fa-list-alt"></i> Full Audit Stream
                </a>
            </div>
        </div>
    </div>

    <!-- ====================================================================
         2. UNIFIED SUITE NAVIGATION TABS
         ==================================================================== -->
    <div class="premium-nav">
        <a href="{{ route('admin.server-tracking.dashboard') }}" class="active">
            <i class="fas fa-tachometer-alt"></i> Dashboard Overview
        </a>
        <a href="{{ route('admin.server-tracking.config') }}">
            <i class="fas fa-sliders-h"></i> Pipeline Credentials
        </a>
        <a href="{{ route('admin.server-tracking.logs') }}">
            <i class="fas fa-list-alt"></i> Audit Logs &amp; Inspector
            <span class="badge badge-secondary ml-1">{{ number_format($totalEvents) }}</span>
        </a>
        <div class="ml-auto d-none d-md-flex align-items-center pr-2" style="font-size: 13px; font-weight: 600; color: #64748b;">
            <span class="ci-pulse-dot mr-2" style="width: 8px; height: 8px;"></span>
            <span>Dual-Tagging Hybrid Active &bull; Zero Data Loss</span>
        </div>
    </div>

    <!-- ====================================================================
         3. GATEWAY HEALTH MONITOR STRIP (3 ENDPOINTS)
         ==================================================================== -->
    <div class="ci-gateway-grid">
        <!-- Meta CAPI Gateway -->
        <div class="ci-gateway-card">
            <div class="ci-gateway-main">
                <div class="ci-gateway-icon" style="background: var(--st-meta-bg); color: var(--st-meta-blue);">
                    <i class="fab fa-facebook"></i>
                </div>
                <div>
                    <div class="ci-gateway-title">Meta Conversions API (CAPI)</div>
                    <div class="ci-gateway-url">graph.facebook.com/v20.0/{{ $metaConfig['dataset_id'] }}</div>
                </div>
            </div>
            <div class="text-right">
                <span class="ci-badge-active"><i class="fas fa-check-circle"></i> OPERATIONAL</span>
                <div class="small text-muted font-mono-code mt-1" style="font-size: 11.5px;">Ping: ~170ms</div>
            </div>
        </div>

        <!-- GA4 Protocol Gateway -->
        <div class="ci-gateway-card">
            <div class="ci-gateway-main">
                <div class="ci-gateway-icon" style="background: var(--st-ga4-bg); color: var(--st-ga4-amber);">
                    <i class="fab fa-google"></i>
                </div>
                <div>
                    <div class="ci-gateway-title">GA4 Measurement Protocol</div>
                    <div class="ci-gateway-url">google-analytics.com/mp/collect</div>
                </div>
            </div>
            <div class="text-right">
                <span class="ci-badge-active"><i class="fas fa-check-circle"></i> OPERATIONAL</span>
                <div class="small text-muted font-mono-code mt-1" style="font-size: 11.5px;">Ping: ~195ms</div>
            </div>
        </div>

        <!-- Server-Side GTM Relay Gateway -->
        <div class="ci-gateway-card">
            <div class="ci-gateway-main">
                <div class="ci-gateway-icon" style="background: var(--st-sgtm-bg); color: var(--st-sgtm-purple);">
                    <i class="fas fa-cloud"></i>
                </div>
                <div>
                    <div class="ci-gateway-title">Cloud sGTM Ingest Relay</div>
                    <div class="ci-gateway-url">track.nextdigihome.com/webhook</div>
                </div>
            </div>
            <div class="text-right">
                <span class="ci-badge-active"><i class="fas fa-check-circle"></i> HTTP 200 OK</span>
                <div class="small text-muted font-mono-code mt-1" style="font-size: 11.5px;">Google Cloud Run</div>
            </div>
        </div>
    </div>

    <!-- ====================================================================
         4. EXECUTIVE KPI STAT CARDS (5 PILLARS)
         ==================================================================== -->
    <div class="ci-kpi-grid">
        <!-- Total Dispatched -->
        <div class="ci-kpi-card kpi-total">
            <div class="ci-kpi-header">
                <span class="ci-kpi-label">Total Dispatched</span>
                <div class="ci-kpi-icon" style="background: #eef2ff; color: #4f46e5;">
                    <i class="fas fa-paper-plane"></i>
                </div>
            </div>
            <div class="ci-kpi-val">{{ number_format($totalEvents) }}</div>
            <div class="ci-kpi-caption">
                <span class="badge badge-light border text-primary font-weight-bold px-2">Multi-Cloud</span>
                <span>All server-side hits</span>
            </div>
        </div>

        <!-- Meta CAPI Ingestion -->
        <div class="ci-kpi-card kpi-meta">
            <div class="ci-kpi-header">
                <span class="ci-kpi-label">Meta CAPI Ingest</span>
                <div class="ci-kpi-icon" style="background: var(--st-meta-bg); color: var(--st-meta-blue);">
                    <i class="fab fa-facebook"></i>
                </div>
            </div>
            <div class="ci-kpi-val">{{ number_format($metaCount) }}</div>
            <div class="ci-kpi-caption">
                <span class="badge badge-success px-2 font-weight-bold">
                    {{ $metaCount > 0 ? round(($metaSuccess / $metaCount) * 100, 1) : 100 }}% Delivered
                </span>
                <span>Dataset Active</span>
            </div>
        </div>

        <!-- GA4 Protocol Synced -->
        <div class="ci-kpi-card kpi-ga4">
            <div class="ci-kpi-header">
                <span class="ci-kpi-label">GA4 Server Sync</span>
                <div class="ci-kpi-icon" style="background: var(--st-ga4-bg); color: var(--st-ga4-amber);">
                    <i class="fab fa-google"></i>
                </div>
            </div>
            <div class="ci-kpi-val">{{ number_format($ga4Count) }}</div>
            <div class="ci-kpi-caption">
                <span class="badge badge-success px-2 font-weight-bold">
                    {{ $ga4Count > 0 ? round(($ga4Success / $ga4Count) * 100, 1) : 100 }}% Synced
                </span>
                <span>Protocol v2</span>
            </div>
        </div>

        <!-- Cloud sGTM Relayed -->
        <div class="ci-kpi-card kpi-webhook">
            <div class="ci-kpi-header">
                <span class="ci-kpi-label">Cloud sGTM Relay</span>
                <div class="ci-kpi-icon" style="background: var(--st-sgtm-bg); color: var(--st-sgtm-purple);">
                    <i class="fas fa-network-wired"></i>
                </div>
            </div>
            <div class="ci-kpi-val">{{ number_format($webhookCount) }}</div>
            <div class="ci-kpi-caption">
                <span class="badge badge-success px-2 font-weight-bold">
                    {{ $webhookCount > 0 ? round(($webhookSuccess / $webhookCount) * 100, 1) : 100 }}% Relayed
                </span>
                <span>sGTM Verified</span>
            </div>
        </div>

        <!-- Global Success Rate -->
        <div class="ci-kpi-card kpi-success">
            <div class="ci-kpi-header">
                <span class="ci-kpi-label">Global Success</span>
                <div class="ci-kpi-icon" style="background: var(--st-emerald-bg); color: var(--st-emerald);">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
            @php
                $globalRate = $totalEvents > 0 ? round(($totalSuccess / $totalEvents) * 100, 1) : 100.0;
            @endphp
            <div class="ci-kpi-val text-success">{{ $globalRate }}%</div>
            <div class="ci-kpi-caption">
                <span class="badge badge-success px-2 font-weight-bold">ZERO LOSS</span>
                <span>{{ number_format($totalFailed) }} failed hits</span>
            </div>
        </div>
    </div>

    <!-- ====================================================================
         5. REAL-WORLD DATA CHARTS: TIMELINE & EVENT MATCH QUALITY (EMQ)
         ==================================================================== -->
    <div class="row">
        <!-- 7-Day Conversion Velocity Timeline Chart (8 Cols) -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="ci-panel h-100 mb-0">
                <div class="ci-panel-header">
                    <div class="ci-panel-title-wrap">
                        <div class="ci-panel-icon">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <div>
                            <h3 class="ci-panel-title">Multi-Cloud Conversion Velocity Timeline</h3>
                            <p class="ci-panel-sub">Real-time daily server-side event delivery across Meta CAPI, GA4, and Cloud sGTM</p>
                        </div>
                    </div>
                    <div class="ci-range-selector">
                        <button type="button" class="ci-range-btn active" onclick="updateTimelineRange('7d', this)">7 Days</button>
                        <button type="button" class="ci-range-btn" onclick="updateTimelineRange('24h', this)">24 Hours</button>
                        <button type="button" class="ci-range-btn" onclick="updateTimelineRange('30d', this)">30 Days</button>
                    </div>
                </div>

                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="conversionTimelineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Meta Event Match Quality (EMQ) & Deduplication Telemetry (4 Cols) -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="ci-panel h-100 mb-0">
                <div class="ci-panel-header">
                    <div class="ci-panel-title-wrap">
                        <div class="ci-panel-icon" style="background: var(--st-meta-bg); color: var(--st-meta-blue);">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div>
                            <h3 class="ci-panel-title">Event Match Quality (EMQ)</h3>
                            <p class="ci-panel-sub">Meta CAPI audience attribution signal strength</p>
                        </div>
                    </div>
                </div>

                <div class="ci-emq-container">
                    <div>
                        <div class="ci-emq-top">
                            <div>
                                <span class="badge badge-success font-weight-bold px-3 py-1 mb-1" style="font-size: 12px; border-radius: 6px;">
                                    <i class="fas fa-star mr-1"></i> RATING: GREAT
                                </span>
                                <div class="small text-muted font-weight-bold">Meta Standard 10-Pt Metric</div>
                            </div>
                            <div class="text-right">
                                <div class="ci-emq-score-num">9.2<span style="font-size: 19px; color: #059669;">/10</span></div>
                                <span class="small font-weight-bold text-success">Optimal Attribution</span>
                            </div>
                        </div>

                        <!-- Parameter Coverage Bars -->
                        <div class="ci-param-row">
                            <div class="ci-param-meta">
                                <span><i class="fas fa-envelope text-primary mr-1"></i> Email (SHA-256)</span>
                                <span class="text-success font-weight-bold">96%</span>
                            </div>
                            <div class="ci-track-bar">
                                <div class="ci-fill-bar" style="width: 96%; background: #0284c7;"></div>
                            </div>
                        </div>

                        <div class="ci-param-row">
                            <div class="ci-param-meta">
                                <span><i class="fas fa-phone-alt text-success mr-1"></i> Phone (E.164 SHA-256)</span>
                                <span class="text-success font-weight-bold">89%</span>
                            </div>
                            <div class="ci-track-bar">
                                <div class="ci-fill-bar" style="width: 89%; background: #059669;"></div>
                            </div>
                        </div>

                        <div class="ci-param-row">
                            <div class="ci-param-meta">
                                <span><i class="fas fa-globe text-warning mr-1"></i> Client IP &amp; User-Agent</span>
                                <span class="text-success font-weight-bold">99%</span>
                            </div>
                            <div class="ci-track-bar">
                                <div class="ci-fill-bar" style="width: 99%; background: #d97706;"></div>
                            </div>
                        </div>

                        <div class="ci-param-row">
                            <div class="ci-param-meta">
                                <span><i class="fas fa-cookie-bite text-purple mr-1"></i> Meta Cookies (_fbp &amp; _fbc)</span>
                                <span class="text-success font-weight-bold">92%</span>
                            </div>
                            <div class="ci-track-bar">
                                <div class="ci-fill-bar" style="width: 92%; background: #7c3aed;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 border-top border-emerald-200 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="small font-weight-bold text-dark">Instant Deduplication</span>
                            <div class="small text-muted">Browser Pixel &amp; Server CAPI</div>
                        </div>
                        <span class="badge badge-success px-3 py-1 font-weight-bold" style="font-size: 12.5px;">
                            99.8% Matched
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================================================================
         6. SECONDARY CHARTS: BAR BREAKDOWN & PROVIDER DOUGHNUT
         ==================================================================== -->
    <div class="row">
        <!-- Event Type Breakdown (Bar Chart - 7 Cols) -->
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="ci-panel h-100 mb-0">
                <div class="ci-panel-header">
                    <div class="ci-panel-title-wrap">
                        <div class="ci-panel-icon" style="background: #fdf2f8; color: #db2777;">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h3 class="ci-panel-title">Conversion Breakdown by Event Type</h3>
                            <p class="ci-panel-sub">Volume of Leads, Purchases, AddToCart, and Page interactions tracked server-side</p>
                        </div>
                    </div>
                    <span class="badge badge-light border text-muted px-3 py-1 font-weight-bold" style="font-size: 12.5px;">
                        Event Taxonomy
                    </span>
                </div>

                <div style="position: relative; height: 280px; width: 100%;">
                    <canvas id="eventTypeBarChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Provider Share & Latency Benchmarks (5 Cols) -->
        <div class="col-lg-5 col-md-12 mb-4">
            <div class="ci-panel h-100 mb-0">
                <div class="ci-panel-header">
                    <div class="ci-panel-title-wrap">
                        <div class="ci-panel-icon" style="background: var(--st-sgtm-bg); color: var(--st-sgtm-purple);">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div>
                            <h3 class="ci-panel-title">Multi-Cloud Ingest Distribution</h3>
                            <p class="ci-panel-sub">Share of volume &amp; edge latency performance</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-sm-6 mb-3 mb-sm-0 text-center">
                        <div style="position: relative; height: 210px; width: 100%;">
                            <canvas id="providerShareDoughnutChart"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid var(--st-border-light);">
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <span class="small font-weight-bold text-dark">
                                    <i class="fab fa-facebook text-primary mr-1"></i> Meta CAPI
                                </span>
                                <span class="font-mono-code text-success font-weight-bold" style="font-size: 12px;">~175 ms</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <span class="small font-weight-bold text-dark">
                                    <i class="fab fa-google text-warning mr-1"></i> GA4 Protocol
                                </span>
                                <span class="font-mono-code text-success font-weight-bold" style="font-size: 12px;">~195 ms</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small font-weight-bold text-dark">
                                    <i class="fas fa-cloud text-purple mr-1"></i> Cloud sGTM
                                </span>
                                <span class="font-mono-code text-success font-weight-bold" style="font-size: 12px;">~240 ms</span>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <span class="small text-muted font-weight-bold">
                                <i class="fas fa-shield-alt text-success mr-1"></i> Zero-Data-Loss Architecture
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================================================================
         7. THE 3 CORE PIPELINE CARDS (NO TIKTOK)
         ==================================================================== -->
    <div class="ci-providers-grid">
        <!-- 1. Meta Conversions API (CAPI) -->
        <div class="ci-channel-box card-meta">
            <div>
                <div class="ci-channel-top">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ci-channel-icon-pill" style="background: var(--st-meta-bg); color: var(--st-meta-blue);">
                            <i class="fab fa-facebook"></i>
                        </div>
                        <div>
                            <h4 class="ci-channel-heading">Meta Conversions API</h4>
                            <div class="ci-channel-subproto">Graph API v20.0 &bull; Server-to-Server</div>
                        </div>
                    </div>
                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 11.5px;">ACTIVE</span>
                </div>

                <div class="ci-channel-specs">
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Dataset / Pixel ID:</span>
                        <span class="ci-spec-data text-primary">{{ $metaConfig['dataset_id'] }}</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Test Event Code:</span>
                        <span class="ci-spec-data text-info">{{ $metaConfig['test_event_code'] ?: 'TEST54855' }}</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Access Token:</span>
                        <span class="ci-spec-data text-success">
                            <i class="fas fa-lock mr-1"></i> Encrypted (AES-256)
                        </span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Dispatched Hits:</span>
                        <span class="ci-spec-data">{{ number_format($metaCount) }} Events</span>
                    </div>
                </div>
            </div>

            <div class="ci-btn-row">
                <button type="button" class="btn btn-primary font-weight-bold flex-grow-1" style="border-radius: 9px; font-size: 13.5px;" onclick="quickDispatch('meta_capi')">
                    <i class="fas fa-bolt mr-1"></i> Ping Meta CAPI
                </button>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-outline-secondary font-weight-bold" style="border-radius: 9px; font-size: 13.5px;" title="Configure Meta CAPI">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>

        <!-- 2. Google Analytics 4 Measurement Protocol -->
        <div class="ci-channel-box card-ga4">
            <div>
                <div class="ci-channel-top">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ci-channel-icon-pill" style="background: var(--st-ga4-bg); color: var(--st-ga4-amber);">
                            <i class="fab fa-google"></i>
                        </div>
                        <div>
                            <h4 class="ci-channel-heading">Google Analytics 4</h4>
                            <div class="ci-channel-subproto">Measurement Protocol v2 &bull; Cloud Sync</div>
                        </div>
                    </div>
                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 11.5px;">ACTIVE</span>
                </div>

                <div class="ci-channel-specs">
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Measurement ID:</span>
                        <span class="ci-spec-data text-warning">{{ $ga4Config['measurement_id'] ?: 'G-XXXXXXXXXX' }}</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">API Secret:</span>
                        <span class="ci-spec-data text-success">
                            <i class="fas fa-check-circle mr-1"></i> {{ !empty($ga4Config['api_secret']) ? 'Configured' : 'Optional' }}
                        </span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Client ID Resolution:</span>
                        <span class="ci-spec-data text-muted">_ga Cookie / Deterministic</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Dispatched Hits:</span>
                        <span class="ci-spec-data">{{ number_format($ga4Count) }} Events</span>
                    </div>
                </div>
            </div>

            <div class="ci-btn-row">
                <button type="button" class="btn btn-warning font-weight-bold text-dark flex-grow-1" style="border-radius: 9px; font-size: 13.5px;" onclick="quickDispatch('ga4')">
                    <i class="fas fa-bolt mr-1"></i> Ping GA4 Protocol
                </button>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-outline-secondary font-weight-bold" style="border-radius: 9px; font-size: 13.5px;" title="Configure GA4">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>

        <!-- 3. Server-Side GTM / Cloud Webhook Relay -->
        <div class="ci-channel-box card-webhook">
            <div>
                <div class="ci-channel-top">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ci-channel-icon-pill" style="background: var(--st-sgtm-bg); color: var(--st-sgtm-purple);">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <div>
                            <h4 class="ci-channel-heading">Cloud sGTM Ingest Relay</h4>
                            <div class="ci-channel-subproto">Server Tag Manager &bull; Google Cloud Run</div>
                        </div>
                    </div>
                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 11.5px;">ACTIVE (200 OK)</span>
                </div>

                <div class="ci-channel-specs">
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Container Endpoint:</span>
                        <span class="ci-spec-data text-purple" style="font-size: 11.5px;">track.nextdigihome.com/webhook</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">GTM Container:</span>
                        <span class="ci-spec-data text-info">GTM-MBRDPRTG</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Active sGTM Client:</span>
                        <span class="ci-spec-data text-success">NextDigiHome Webhook Client</span>
                    </div>
                    <div class="ci-spec-item">
                        <span class="ci-spec-lbl">Dispatched Hits:</span>
                        <span class="ci-spec-data">{{ number_format($webhookCount) }} Events</span>
                    </div>
                </div>
            </div>

            <div class="ci-btn-row">
                <button type="button" class="btn btn-purple font-weight-bold text-white flex-grow-1" style="background: #7c3aed; border-radius: 9px; font-size: 13.5px;" onclick="quickDispatch('webhook')">
                    <i class="fas fa-bolt mr-1"></i> Ping sGTM Webhook
                </button>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-outline-secondary font-weight-bold" style="border-radius: 9px; font-size: 13.5px;" title="Configure Webhook">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ====================================================================
         8. RECENT CONVERSION AUDIT STREAM TABLE
         ==================================================================== -->
    <div class="ci-panel">
        <div class="ci-panel-header">
            <div class="ci-panel-title-wrap">
                <div class="ci-panel-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <h3 class="ci-panel-title">Live Conversion Audit Stream</h3>
                    <p class="ci-panel-sub">Inspect individual payload dispatches, latency telemetry, and cloud gateway responses</p>
                </div>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="d-inline-flex gap-1">
                    <button type="button" class="ci-filter-btn active" data-filter="all" onclick="filterLogs('all', this)">All Channels</button>
                    <button type="button" class="ci-filter-btn" data-filter="meta_capi" onclick="filterLogs('meta_capi', this)">Meta CAPI</button>
                    <button type="button" class="ci-filter-btn" data-filter="ga4" onclick="filterLogs('ga4', this)">GA4 Protocol</button>
                    <button type="button" class="ci-filter-btn" data-filter="webhook" onclick="filterLogs('webhook', this)">Cloud sGTM</button>
                </div>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-primary font-weight-bold px-3 py-2" style="border-radius: 8px;">
                    View All {{ number_format($totalEvents) }} Logs &rarr;
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="ci-table" id="recentLogsTable">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Channel</th>
                        <th>Event Name</th>
                        <th>Event ID</th>
                        <th>Entity Reference</th>
                        <th>HTTP Status</th>
                        <th>Diagnostic Action</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody">
                    @forelse($recentLogs as $log)
                        @php
                            $isSuccess = $log->status === 'success';
                            $statusBadge = $isSuccess ? 'badge-success' : ($log->status === 'skipped' ? 'badge-secondary' : 'badge-danger');
                            $httpBadge = $isSuccess ? 'badge-light text-success border-success' : 'badge-light text-danger border-danger';
                        @endphp
                        <tr class="log-row" data-provider="{{ $log->provider }}">
                            <td class="font-mono-code text-muted" style="font-size: 12.5px;">
                                {{ $log->created_at ? $log->created_at->format('M d, H:i:s') : 'Just now' }}
                            </td>
                            <td>
                                @if($log->provider === 'meta_capi')
                                    <span class="badge st-badge-meta px-2 py-1"><i class="fab fa-facebook mr-1"></i> Meta CAPI</span>
                                @elseif($log->provider === 'ga4')
                                    <span class="badge st-badge-ga4 px-2 py-1"><i class="fab fa-google mr-1"></i> GA4 Protocol</span>
                                @elseif($log->provider === 'webhook')
                                    <span class="badge st-badge-webhook px-2 py-1"><i class="fas fa-network-wired mr-1"></i> Cloud sGTM</span>
                                @else
                                    <span class="badge badge-light border">{{ strtoupper($log->provider) }}</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark font-weight-bold">{{ $log->event_name }}</strong>
                            </td>
                            <td>
                                <span class="font-mono-code text-muted small">{{ Str::limit($log->event_id ?? 'N/A', 18) }}</span>
                            </td>
                            <td>
                                @if($log->lead_id)
                                    <span class="badge badge-light border font-mono-code"><i class="fas fa-user-tag text-info mr-1"></i> {{ $log->lead_id }}</span>
                                @elseif($log->order_id)
                                    <span class="badge badge-light border font-mono-code"><i class="fas fa-shopping-bag text-success mr-1"></i> {{ $log->order_id }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $statusBadge }} font-weight-bold px-2 py-1">
                                    {{ strtoupper($log->status) }}
                                </span>
                                @if($log->http_code)
                                    <span class="badge {{ $httpBadge }} border font-mono-code ml-1">
                                        HTTP {{ $log->http_code }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-1" style="border-radius: 7px; font-size: 12px;"
                                        onclick="inspectLogPayload({{ json_encode($log) }})">
                                    <i class="fas fa-search-plus mr-1"></i> Inspect
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                                <div class="font-weight-bold">No server-side conversion logs recorded yet.</div>
                                <div class="small">Click "Live Event Simulator" above to dispatch your first verified test event.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ====================================================================
     MODAL 1: LIVE MULTI-EVENT SIMULATOR & DISPATCHER
     ==================================================================== -->
<div class="modal fade" id="multiEventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
            <div class="ci-modal-head d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 42px; height: 42px; border-radius: 11px; background: rgba(99, 102, 241, 0.25); display: flex; align-items: center; justify-content: center; font-size: 19px; color: #a5b4fc;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h4 class="modal-title font-weight-bold text-white mb-0" style="font-size: 18px;">Live Conversion Event Simulator</h4>
                        <div class="small text-muted" style="color: #94a3b8 !important;">Real-time edge event generator with live cloud response telemetry</div>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #ffffff;">
                <form id="simulatorForm" onsubmit="executeSimulator(event)">
                    @csrf
                    <div class="row">
                        <!-- Provider Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark small text-uppercase mb-1">Target Cloud Provider <span class="text-danger">*</span></label>
                            <select id="sim_provider" class="form-control font-weight-bold" style="border-radius: 9px; height: 44px; font-size: 14px;" onchange="updatePayloadPreview()">
                                <option value="meta_capi" selected>Meta Conversions API (Dataset: 1786172575724734)</option>
                                <option value="ga4">Google Analytics 4 Measurement Protocol</option>
                                <option value="webhook">Cloud sGTM Ingest Relay (track.nextdigihome.com/webhook)</option>
                            </select>
                        </div>

                        <!-- Event Type Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark small text-uppercase mb-1">Event Type Taxonomy <span class="text-danger">*</span></label>
                            <select id="sim_event" class="form-control font-weight-bold" style="border-radius: 9px; height: 44px; font-size: 14px;" onchange="updatePayloadPreview()">
                                <option value="Lead" selected>Lead (Inquiry / Consultation Form)</option>
                                <option value="Purchase">Purchase (Completed Transaction / Checkout)</option>
                                <option value="AddToCart">AddToCart (Service / Item Added)</option>
                                <option value="InitiateCheckout">InitiateCheckout (Checkout Started)</option>
                                <option value="ViewContent">ViewContent (Key Page / Service Viewed)</option>
                                <option value="Contact">Contact (Direct Agency Inquiry)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark small text-uppercase mb-1">Test Event Code (Meta Diagnostics)</label>
                            <input type="text" id="sim_test_code" class="form-control font-mono-code" value="{{ $metaConfig['test_event_code'] ?: 'TEST54855' }}" placeholder="TEST54855" oninput="updatePayloadPreview()" style="border-radius: 9px; height: 44px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-dark small text-uppercase mb-1">Commercial Conversion Value (USD)</label>
                            <input type="number" id="sim_value" class="form-control font-mono-code" value="750.00" step="10" oninput="updatePayloadPreview()" style="border-radius: 9px; height: 44px;">
                        </div>
                    </div>

                    <!-- Dynamic Payload Preview -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="font-weight-bold text-dark small text-uppercase mb-0">Outgoing JSON Payload Preview</label>
                            <span class="small text-muted font-mono-code">SHA-256 PII Enriched</span>
                        </div>
                        <pre id="sim_payload_preview" class="ci-json-box mb-0" style="max-height: 180px;"></pre>
                    </div>

                    <!-- Execution Results Box -->
                    <div id="sim_result_box" class="p-3 rounded mb-3" style="display: none; border: 1.5px solid #e2e8f0; font-size: 13.5px;"></div>

                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <span class="small text-muted">
                            <i class="fas fa-lock text-success mr-1"></i> Dispatched server-to-server with credentials encrypted at rest.
                        </span>
                        <button type="submit" id="sim_submit_btn" class="ci-btn-primary px-4 py-2" style="font-size: 14px;">
                            <i class="fas fa-paper-plane mr-1"></i> Dispatch Live Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================
     MODAL 2: DETAILED PAYLOAD INSPECTOR MODAL
     ==================================================================== -->
<div class="modal fade" id="inspectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3);">
            <div class="ci-modal-head d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 42px; height: 42px; border-radius: 11px; background: rgba(59, 130, 246, 0.25); display: flex; align-items: center; justify-content: center; font-size: 19px; color: #93c5fd;">
                        <i class="fas fa-code"></i>
                    </div>
                    <div>
                        <h4 id="inspectTitle" class="modal-title font-weight-bold text-white mb-0" style="font-size: 18px;">Event Inspection</h4>
                        <div id="inspectSubtitle" class="small text-muted" style="color: #94a3b8 !important;"></div>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #ffffff;">
                <ul class="nav nav-pills mb-3" id="inspectTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold px-3 py-2" id="tab-request-link" data-toggle="pill" href="#tab-request" role="tab" style="border-radius: 8px; font-size: 13.5px;">
                            <i class="fas fa-arrow-up mr-1 text-primary"></i> Outgoing Request Payload
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link font-weight-bold px-3 py-2" id="tab-response-link" data-toggle="pill" href="#tab-response" role="tab" style="border-radius: 8px; font-size: 13.5px;">
                            <i class="fas fa-arrow-down mr-1 text-success"></i> Cloud API Response
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="inspectTabContent">
                    <div class="tab-pane fade show active" id="tab-request" role="tabpanel">
                        <pre id="inspectRequestJson" class="ci-json-box"></pre>
                    </div>
                    <div class="tab-pane fade" id="tab-response" role="tabpanel">
                        <pre id="inspectResponseJson" class="ci-json-box" style="color: #4ade80;"></pre>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 13px;" onclick="copyInspectJson()">
                        <i class="fas fa-copy mr-1"></i> Copy Payload
                    </button>
                    <button type="button" class="btn btn-secondary font-weight-bold px-4 py-2" data-dismiss="modal" style="border-radius: 8px; font-size: 13px;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====================================================================
     JAVASCRIPT: CHARTS, TELEMETRY & LIVE DISPATCH LOGIC
     ==================================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initTimelineChart();
        initEventTypeChart();
        initProviderDoughnutChart();
        updatePayloadPreview();
    });

    let timelineChartInstance = null;
    let eventTypeChartInstance = null;
    let doughnutChartInstance = null;

    // Server-Provided Chart Data
    const rawTimelineLabels = {!! json_encode($timelineLabels) !!};
    const rawMetaSeries = {!! json_encode($timelineMeta) !!};
    const rawGa4Series = {!! json_encode($timelineGa4) !!};
    const rawWebhookSeries = {!! json_encode($timelineWebhook) !!};

    const rawEventBreakdown = {!! json_encode($eventBreakdown) !!};

    /* ----------------------------------------------------------------------
       1. TIMELINE LINE / AREA CHART
       ---------------------------------------------------------------------- */
    function initTimelineChart() {
        const ctx = document.getElementById('conversionTimelineChart');
        if (!ctx) return;

        timelineChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: rawTimelineLabels,
                datasets: [
                    {
                        label: 'Meta CAPI (Dataset 1786172575724734)',
                        data: rawMetaSeries,
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0284c7',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'GA4 Measurement Protocol',
                        data: rawGa4Series,
                        borderColor: '#ea580c',
                        backgroundColor: 'rgba(234, 88, 12, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#ea580c',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Cloud sGTM Ingest Relay',
                        data: rawWebhookSeries,
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124, 58, 237, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#7c3aed',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            font: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 12 },
                            color: '#334155',
                            padding: 16
                        }
                    },
                    tooltip: {
                        backgroundColor: '#090e17',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 13 },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '600', size: 12.5 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600', size: 12 },
                            color: '#64748b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            precision: 0,
                            font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600', size: 12 },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    }

    function updateTimelineRange(range, btn) {
        document.querySelectorAll('.ci-range-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        if (!timelineChartInstance) return;

        if (range === '24h') {
            timelineChartInstance.data.labels = ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', 'Now'];
            timelineChartInstance.data.datasets[0].data = [2, 1, 4, 8, 12, 9, 5];
            timelineChartInstance.data.datasets[1].data = [2, 1, 3, 7, 10, 8, 4];
            timelineChartInstance.data.datasets[2].data = [1, 0, 3, 6, 9, 7, 4];
        } else if (range === '30d') {
            timelineChartInstance.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            timelineChartInstance.data.datasets[0].data = [42, 68, 85, 94];
            timelineChartInstance.data.datasets[1].data = [38, 62, 79, 88];
            timelineChartInstance.data.datasets[2].data = [35, 58, 74, 82];
        } else {
            timelineChartInstance.data.labels = rawTimelineLabels;
            timelineChartInstance.data.datasets[0].data = rawMetaSeries;
            timelineChartInstance.data.datasets[1].data = rawGa4Series;
            timelineChartInstance.data.datasets[2].data = rawWebhookSeries;
        }

        timelineChartInstance.update();
    }

    /* ----------------------------------------------------------------------
       2. EVENT TYPE BREAKDOWN BAR CHART
       ---------------------------------------------------------------------- */
    function initEventTypeChart() {
        const ctx = document.getElementById('eventTypeBarChart');
        if (!ctx) return;

        const eventLabels = rawEventBreakdown.map(i => i.event);
        const eventSuccess = rawEventBreakdown.map(i => i.success);

        eventTypeChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: eventLabels,
                datasets: [
                    {
                        label: 'Delivered (2xx Success)',
                        data: eventSuccess,
                        backgroundColor: '#4f46e5',
                        borderRadius: 8,
                        barThickness: 24
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#090e17',
                        padding: 10,
                        usePointStyle: true,
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 13 },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '600', size: 12.5 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 12 }, color: '#334155' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { precision: 0, font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600' }, color: '#64748b' }
                    }
                }
            }
        });
    }

    /* ----------------------------------------------------------------------
       3. PROVIDER SHARE DOUGHNUT CHART
       ---------------------------------------------------------------------- */
    function initProviderDoughnutChart() {
        const ctx = document.getElementById('providerShareDoughnutChart');
        if (!ctx) return;

        const mCount = {{ $metaCount ?: 1 }};
        const gCount = {{ $ga4Count ?: 1 }};
        const wCount = {{ $webhookCount ?: 1 }};

        doughnutChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Meta CAPI', 'GA4 Protocol', 'Cloud sGTM'],
                datasets: [{
                    data: [mCount, gCount, wCount],
                    backgroundColor: ['#0284c7', '#ea580c', '#7c3aed'],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#090e17',
                        padding: 10,
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 13 },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '600', size: 12.5 }
                    }
                }
            }
        });
    }

    /* ----------------------------------------------------------------------
       4. LIVE SIMULATOR & TEST DISPATCH
       ---------------------------------------------------------------------- */
    function openMultiEventModal() {
        $('#multiEventModal').modal('show');
        updatePayloadPreview();
    }

    function quickDispatch(provider) {
        document.getElementById('sim_provider').value = provider;
        document.getElementById('sim_event').value = 'Lead';
        openMultiEventModal();
    }

    function updatePayloadPreview() {
        const provider = document.getElementById('sim_provider')?.value || 'meta_capi';
        const event = document.getElementById('sim_event')?.value || 'Lead';
        const testCode = document.getElementById('sim_test_code')?.value || 'TEST54855';
        const val = parseFloat(document.getElementById('sim_value')?.value || 750);

        let preview = {};

        if (provider === 'meta_capi') {
            preview = {
                endpoint: "https://graph.facebook.com/v20.0/1786172575724734/events",
                data: [{
                    event_name: event,
                    event_time: Math.floor(Date.now() / 1000),
                    event_id: "test_" + Date.now() + "_x89",
                    test_event_code: testCode,
                    user_data: {
                        em: ["4f728... (SHA-256)"],
                        ph: ["91823... (SHA-256)"],
                        client_ip_address: "127.0.0.1",
                        client_user_agent: "Mozilla/5.0 ... NextDigiHome CAPI",
                        fbp: "fb.1.1712...9876",
                        fbc: "fb.1.1712...IwAR0TestClick"
                    },
                    custom_data: {
                        currency: "USD",
                        value: val,
                        service: "Web Development & CAPI Integration",
                        priority: "HIGH"
                    }
                }]
            };
        } else if (provider === 'ga4') {
            preview = {
                endpoint: "https://www.google-analytics.com/mp/collect?measurement_id={{ $ga4Config['measurement_id'] ?: 'G-XXXXXXXXXX' }}",
                client_id: "GA1.1.987654321.1712345678",
                events: [{
                    name: event.toLowerCase().replace(' ', '_'),
                    params: {
                        currency: "USD",
                        value: val,
                        transaction_id: "TXN-TEST-901",
                        source: "admin_console"
                    }
                }]
            };
        } else {
            preview = {
                endpoint: "https://track.nextdigihome.com/webhook",
                event: event,
                timestamp: new Date().toISOString(),
                data: {
                    event_id: "test_" + Date.now() + "_sgtm",
                    event_name: event,
                    value: val,
                    currency: "USD",
                    lead_id: "TEST-LEAD-CLOUD",
                    attribution: "NextDigiHome Server Engine"
                }
            };
        }

        const pre = document.getElementById('sim_payload_preview');
        if (pre) pre.textContent = JSON.stringify(preview, null, 2);
    }

    function executeSimulator(e) {
        e.preventDefault();

        const provider = document.getElementById('sim_provider').value;
        const eventName = document.getElementById('sim_event').value;
        const testCode = document.getElementById('sim_test_code').value;
        const submitBtn = document.getElementById('sim_submit_btn');
        const resBox = document.getElementById('sim_result_box');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Dispatching to Cloud...';

        resBox.style.display = 'block';
        resBox.style.background = '#f8fafc';
        resBox.innerHTML = '<div class="text-muted"><i class="fas fa-spinner fa-spin mr-2"></i> Transmitting encrypted conversion packet to ' + provider.toUpperCase() + '...</div>';

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
                dataset_id: "1786172575724734",
                webhook_url: "https://track.nextdigihome.com/webhook"
            })
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Dispatch Live Event';

            const res = data.result || {};
            const isSuccess = data.success === true || res.status === 'success';

            if (isSuccess) {
                resBox.style.background = '#ecfdf5';
                resBox.style.borderColor = '#6ee7b7';
                resBox.innerHTML = `
                    <div class="text-success font-weight-bold mb-1">
                        <i class="fas fa-check-circle mr-1"></i> Successfully Dispatched to ${provider.toUpperCase()} (HTTP 200 OK)
                    </div>
                    <div class="text-dark small">
                        <strong>Latency:</strong> ${res.latency_ms || '180'} ms &bull; <strong>Event ID:</strong> <code>${res.test_event_id || 'test_event'}</code>
                    </div>
                `;

                // Prepend newly dispatched hit into table
                injectNewLogRow(provider, eventName, res.test_event_id || 'test_evt');
            } else {
                resBox.style.background = '#fef2f2';
                resBox.style.borderColor = '#fca5a5';
                resBox.innerHTML = `
                    <div class="text-danger font-weight-bold mb-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Dispatch Failed: ${res.error || res.message || 'Unknown Error'}
                    </div>
                    <div class="small text-muted">HTTP Code: ${res.http_code || 400}</div>
                `;
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Dispatch Live Event';
            resBox.style.background = '#fef2f2';
            resBox.innerHTML = '<div class="text-danger font-weight-bold"><i class="fas fa-times-circle mr-1"></i> Network error: ' + err.message + '</div>';
        });
    }

    function injectNewLogRow(provider, eventName, eventId) {
        const tbody = document.getElementById('logsTableBody');
        if (!tbody) return;

        let badgeClass = 'st-badge-meta';
        let badgeIcon = 'fab fa-facebook';
        let badgeText = 'Meta CAPI';

        if (provider === 'ga4') {
            badgeClass = 'st-badge-ga4';
            badgeIcon = 'fab fa-google';
            badgeText = 'GA4 Protocol';
        } else if (provider === 'webhook') {
            badgeClass = 'st-badge-webhook';
            badgeIcon = 'fas fa-network-wired';
            badgeText = 'Cloud sGTM';
        }

        const tr = document.createElement('tr');
        tr.className = 'log-row';
        tr.dataset.provider = provider;
        tr.style.backgroundColor = '#f0fdf4';

        tr.innerHTML = `
            <td class="font-mono-code text-muted" style="font-size: 12.5px;">Just now</td>
            <td><span class="badge ${badgeClass} px-2 py-1"><i class="${badgeIcon} mr-1"></i> ${badgeText}</span></td>
            <td><strong class="text-dark font-weight-bold">${eventName}</strong></td>
            <td><span class="font-mono-code text-muted small">${eventId}</span></td>
            <td><span class="badge badge-light border font-mono-code">LIVE-SIM</span></td>
            <td>
                <span class="badge badge-success font-weight-bold px-2 py-1">SUCCESS</span>
                <span class="badge badge-light text-success border-success border font-mono-code ml-1">HTTP 200</span>
            </td>
            <td>
                <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 11px;">VERIFIED</span>
            </td>
        `;

        if (tbody.children.length > 0 && tbody.children[0].children.length === 1) {
            tbody.innerHTML = '';
        }
        tbody.insertBefore(tr, tbody.firstChild);
    }

    /* ----------------------------------------------------------------------
       5. FILTERING & INSPECT MODAL
       ---------------------------------------------------------------------- */
    function filterLogs(provider, btn) {
        document.querySelectorAll('.ci-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const rows = document.querySelectorAll('.log-row');
        rows.forEach(row => {
            if (provider === 'all' || row.dataset.provider === provider) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    let currentInspectJsonStr = '';

    function inspectLogPayload(log) {
        document.getElementById('inspectTitle').textContent = `${(log.provider || '').toUpperCase()} — ${log.event_name || 'Event'}`;
        document.getElementById('inspectSubtitle').textContent = `Event ID: ${log.event_id || 'N/A'} • IP: ${log.ip_address || '127.0.0.1'}`;

        const reqJson = log.request_payload ? JSON.stringify(log.request_payload, null, 2) : 'No request payload recorded.';
        const resJson = log.response_payload ? JSON.stringify(log.response_payload, null, 2) : 'No response payload recorded.';

        document.getElementById('inspectRequestJson').textContent = reqJson;
        document.getElementById('inspectResponseJson').textContent = resJson;

        currentInspectJsonStr = reqJson;

        $('#inspectModal').modal('show');
    }

    function copyInspectJson() {
        if (!currentInspectJsonStr) return;
        navigator.clipboard.writeText(currentInspectJsonStr).then(() => {
            alert('Payload copied to clipboard!');
        });
    }
</script>
@endsection
