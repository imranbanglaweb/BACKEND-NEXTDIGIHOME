@extends('admin.dashboard.master')

@section('title', 'Server-Side Tracking & CAPI Console - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    /* ==========================================================================
       NEXTDIGIHOME SERVER-SIDE TRACKING & CAPI - ULTRA PREMIUM UI / UX
       ========================================================================== */

    :root {
        --st-primary: #4f46e5;
        --st-primary-rgb: 79, 70, 229;
        --st-primary-hover: #4338ca;
        --st-accent-cyan: #06b6d4;
        --st-accent-emerald: #10b981;
        --st-accent-amber: #f59e0b;
        --st-accent-rose: #f43f5e;
        --st-accent-purple: #8b5cf6;
        --st-dark-surface: #0b1120;
        --st-card-border: rgba(226, 232, 240, 0.9);
        --st-card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 8px -2px rgba(15, 23, 42, 0.03);
        --st-card-hover-shadow: 0 16px 32px -4px rgba(15, 23, 42, 0.09), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
    }

    .premium-page {
        background: #f8fafc;
        min-height: calc(100vh - 66px);
        padding: 24px 28px;
    }

    /* --------------------------------------------------------------------------
       1. HERO HEADER WITH COSMIC SLATE GRADIENT & LIVE RADAR
       -------------------------------------------------------------------------- */
    .st-hero-header {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #090e17 0%, #0f172a 45%, #1e1b4b 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 28px 32px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 12px 36px -4px rgba(15, 23, 42, 0.25);
    }

    /* Ambient background glowing orbs */
    .st-hero-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: 40px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(6, 182, 212, 0.08) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .st-hero-header::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 20%;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .st-radar-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #34d399;
        border-radius: 9999px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 10px;
        backdrop-filter: blur(8px);
    }

    .st-radar-dot {
        position: relative;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
    }

    .st-radar-dot::after {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: rgba(16, 185, 129, 0.6);
        animation: stRadarPulse 2s infinite ease-out;
    }

    @keyframes stRadarPulse {
        0% { transform: scale(0.6); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    }

    .st-hero-title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.6px;
        margin: 0 0 8px;
        color: #ffffff;
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
        color: rgba(226, 232, 240, 0.85);
        font-size: 14px;
        max-width: 720px;
        line-height: 1.55;
        margin: 0 0 16px;
    }

    .st-hero-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .st-hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #e2e8f0;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        backdrop-filter: blur(4px);
    }

    .st-hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        z-index: 2;
        position: relative;
    }

    .st-btn-glow {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #06b6d4 100%) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        box-shadow: 0 4px 18px rgba(79, 70, 229, 0.45) !important;
        border-radius: 10px !important;
        padding: 9px 20px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer;
    }

    .st-btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.6) !important;
        filter: brightness(1.08);
        color: #ffffff !important;
    }

    .st-btn-glass {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 10px !important;
        padding: 9px 18px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
    }

    .st-btn-glass:hover {
        background: rgba(255, 255, 255, 0.18) !important;
        border-color: rgba(255, 255, 255, 0.35) !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
    }

    /* --------------------------------------------------------------------------
       2. REFINED SUB-NAVIGATION TABS BAR
       -------------------------------------------------------------------------- */
    .st-nav-bar {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 12px;
        padding: 8px 10px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        box-shadow: var(--st-card-shadow);
    }

    .st-nav-links {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }

    .st-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .st-nav-link:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .st-nav-link.active {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }

    .st-nav-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 9999px;
        background: rgba(148, 163, 184, 0.2);
        color: inherit;
    }

    .st-nav-link.active .st-nav-badge {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    .st-nav-quick-info {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 12px;
        color: #64748b;
        padding-right: 8px;
    }

    /* --------------------------------------------------------------------------
       3. INTERACTIVE 4-STAGE PIPELINE ARCHITECTURE FLOW
       -------------------------------------------------------------------------- */
    .st-pipeline-card {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--st-card-shadow);
        position: relative;
    }

    .st-pipeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .st-pipeline-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #0369a1;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-pipeline-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        position: relative;
    }

    @media (max-width: 992px) {
        .st-pipeline-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .st-pipeline-grid {
            grid-template-columns: 1fr;
        }
    }

    .st-step-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        position: relative;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .st-step-box:hover {
        border-color: #94a3b8;
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.07);
    }

    .st-step-box.step-1 { border-top: 3px solid #3b82f6; }
    .st-step-box.step-2 { border-top: 3px solid #10b981; }
    .st-step-box.step-3 { border-top: 3px solid #f59e0b; }
    .st-step-box.step-4 { border-top: 3px solid #8b5cf6; }

    .st-step-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .st-step-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .st-step-pill {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 9999px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .st-step-num {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        font-family: monospace;
    }

    .st-step-heading {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .st-step-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .st-step-footer {
        padding-top: 10px;
        border-top: 1px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
        color: #475569;
        font-weight: 600;
    }

    /* --------------------------------------------------------------------------
       4. ENTERPRISE KPI METRIC STAT CARDS
       -------------------------------------------------------------------------- */
    .st-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 1200px) {
        .st-stats-row { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .st-stats-row { grid-template-columns: 1fr; }
    }

    .st-stat-card {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: var(--st-card-shadow);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .st-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--st-card-hover-shadow);
        border-color: #cbd5e1;
    }

    .st-stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
    }

    .st-stat-card.stat-blue::after { background: linear-gradient(90deg, #3b82f6, #06b6d4); }
    .st-stat-card.stat-green::after { background: linear-gradient(90deg, #10b981, #34d399); }
    .st-stat-card.stat-rose::after { background: linear-gradient(90deg, #f43f5e, #fb7185); }
    .st-stat-card.stat-purple::after { background: linear-gradient(90deg, #8b5cf6, #a855f7); }

    .st-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .st-stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .st-stat-trend {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .st-stat-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .st-stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -0.5px;
        margin-bottom: 6px;
    }

    .st-stat-subtext {
        font-size: 12px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* --------------------------------------------------------------------------
       5. CLOUD CONVERSION DISPATCH CHANNELS (4 PROVIDER CARDS)
       -------------------------------------------------------------------------- */
    .st-section-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-section-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 16px;
    }

    .st-providers-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 1200px) {
        .st-providers-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .st-providers-grid { grid-template-columns: 1fr; }
    }

    .st-channel-card {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 16px;
        padding: 22px;
        box-shadow: var(--st-card-shadow);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .st-channel-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--st-card-hover-shadow);
        border-color: #cbd5e1;
    }

    .st-channel-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .st-channel-meta::before { background: linear-gradient(90deg, #1877f2, #3b82f6); }
    .st-channel-ga4::before { background: linear-gradient(90deg, #f59e0b, #ea580c); }
    .st-channel-tiktok::before { background: linear-gradient(90deg, #0f172a, #fe2c55, #25f4ee); }
    .st-channel-webhook::before { background: linear-gradient(90deg, #8b5cf6, #6366f1); }

    .st-channel-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .st-channel-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .st-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .st-status-badge.active {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .st-status-badge.disabled {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .st-channel-name {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 2px;
    }

    .st-channel-api-ver {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 14px;
        font-weight: 500;
    }

    .st-id-preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
    }

    .st-id-preview-box:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
    }

    .st-id-preview-label {
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
        display: flex;
        justify-content: space-between;
    }

    .st-id-preview-val {
        font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 12px;
        color: #0f172a;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 170px;
    }

    .st-copy-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        border-radius: 6px;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .st-copy-btn:hover {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .st-channel-footer {
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .st-dispatch-count {
        font-size: 12px;
        color: #64748b;
    }

    .st-dispatch-count strong {
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .st-channel-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .st-test-trigger-btn {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .st-test-trigger-btn:hover {
        border-color: #4f46e5;
        color: #4f46e5;
        background: rgba(79, 70, 229, 0.06);
    }

    .st-config-icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }

    .st-config-icon-btn:hover {
        color: #0f172a;
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    /* --------------------------------------------------------------------------
       6. TELEMETRY DIAGNOSTIC TERMINAL (MAC OS CONSOLE LOOK)
       -------------------------------------------------------------------------- */
    .st-terminal-card {
        background: #090e17;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        box-shadow: 0 16px 40px -4px rgba(15, 23, 42, 0.35);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .st-terminal-header {
        background: #0f172a;
        padding: 12px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .st-terminal-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-mac-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
    }

    .st-mac-dot.close { background: #ff5f56; }
    .st-mac-dot.min { background: #ffbd2e; }
    .st-mac-dot.max { background: #27c93f; }

    .st-terminal-title {
        font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 12px;
        font-weight: 600;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-terminal-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-terminal-body {
        padding: 18px 22px;
        background: #090e17;
    }

    .st-terminal-pre {
        font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 12.5px;
        line-height: 1.6;
        color: #38bdf8;
        background: transparent;
        border: none;
        padding: 0;
        margin: 0;
        max-height: 320px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* --------------------------------------------------------------------------
       7. RECENT DISPATCHES STREAM TABLE
       -------------------------------------------------------------------------- */
    .st-table-card {
        background: #ffffff;
        border: 1px solid var(--st-card-border);
        border-radius: 16px;
        box-shadow: var(--st-card-shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .st-table-toolbar {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        background: #ffffff;
    }

    .st-search-input {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 8px 14px 8px 36px;
        font-size: 13px;
        color: #0f172a;
        width: 260px;
        transition: all 0.2s ease;
    }

    .st-search-input:focus {
        background: #ffffff;
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        width: 300px;
    }

    .st-filter-pills {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .st-filter-pill {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .st-filter-pill:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .st-filter-pill.active {
        background: #0f172a;
        color: #ffffff;
        border-color: #0f172a;
    }

    .st-table {
        width: 100%;
        border-collapse: collapse;
    }

    .st-table thead th {
        background: #f8fafc;
        padding: 13px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .st-table tbody td {
        padding: 14px 20px;
        font-size: 13px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .st-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .st-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .st-channel-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .st-channel-pill.meta { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .st-channel-pill.ga4 { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .st-channel-pill.tiktok { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .st-channel-pill.webhook { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

    .st-event-tag {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        background: #f1f5f9;
        color: #0f172a;
    }

    .st-event-tag.Lead { background: #e0e7ff; color: #4338ca; }
    .st-event-tag.Purchase { background: #dcfce7; color: #15803d; }
    .st-event-tag.ViewContent { background: #e0f2fe; color: #0369a1; }
    .st-event-tag.AddToCart { background: #fef3c7; color: #92400e; }
    .st-event-tag.Contact { background: #f3e8ff; color: #7e22ce; }

    .st-delivery-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
    }

    .st-delivery-badge.success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .st-delivery-badge.failed {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
    }

    .st-delivery-badge.skipped {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .st-code-pill {
        font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 11.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
    }

    .st-code-pill.success { background: #ecfdf5; color: #059669; }
    .st-code-pill.error { background: #fff1f2; color: #dc2626; }
    .st-code-pill.muted { background: #f1f5f9; color: #64748b; }

    /* --------------------------------------------------------------------------
       8. FLOATING TOAST NOTIFICATIONS
       -------------------------------------------------------------------------- */
    .st-toast-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .st-toast {
        pointer-events: auto;
        background: #0f172a;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        animation: stToastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes stToastSlideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
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
                        <span>Server-Side Tracking &amp;</span>
                        <span class="st-hero-title-accent">Cloud CAPI Console</span>
                    </h1>
                    <p class="st-hero-subtitle">
                        Direct server-to-server cloud conversion pipeline. Bypasses browser ad-blockers, iOS 14.5+ ATT restrictions, and third-party cookie deprecation with deterministic SHA-256 deduplication.
                    </p>
                    <div class="st-hero-tags">
                        <div class="st-hero-tag"><i class="fas fa-shield-alt text-success"></i> SHA-256 PII Encrypted</div>
                        <div class="st-hero-tag"><i class="fas fa-fingerprint text-info"></i> Deterministic event_id</div>
                        <div class="st-hero-tag"><i class="fas fa-bolt text-warning"></i> Sub-150ms Cloud Edge</div>
                        <div class="st-hero-tag"><i class="fas fa-check-circle text-emerald"></i> GDPR / CCPA Ready</div>
                    </div>
                </div>

                <div class="st-hero-actions mt-3 mt-lg-0">
                    <button type="button" class="st-btn-glow" data-toggle="modal" data-target="#quickTestModal">
                        <i class="fas fa-bolt"></i>
                        <span>Live Test Dispatch</span>
                    </button>
                    <a href="{{ route('admin.server-tracking.logs') }}" class="st-btn-glass">
                        <i class="fas fa-stream"></i>
                        <span>Audit Stream</span>
                    </a>
                    <a href="{{ route('admin.server-tracking.config') }}" class="st-btn-glass">
                        <i class="fas fa-sliders-h"></i>
                        <span>Credentials</span>
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 12px; padding: 14px 18px;">
                <i class="fas fa-check-circle mr-3" style="font-size: 18px; color: #059669;"></i>
                <div class="font-weight-600" style="font-size: 13.5px;">{{ session('success') }}</div>
                <button type="button" class="close ml-auto text-dark" data-dismiss="alert" aria-label="Close" style="opacity: 0.6;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- ====================================================================
             2. SUB-NAVIGATION BAR
             ==================================================================== -->
        <div class="st-nav-bar">
            <div class="st-nav-links">
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="st-nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard Overview</span>
                </a>
                <a href="{{ route('admin.server-tracking.config') }}" class="st-nav-link">
                    <i class="fas fa-sliders-h"></i>
                    <span>Pipeline Credentials</span>
                </a>
                <a href="{{ route('admin.server-tracking.logs') }}" class="st-nav-link">
                    <i class="fas fa-list-alt"></i>
                    <span>Audit Logs &amp; Inspector</span>
                    <span class="st-nav-badge">{{ number_format($totalEvents) }}</span>
                </a>
            </div>

            <div class="st-nav-quick-info d-none d-md-flex">
                <span><i class="fas fa-circle text-success mr-1" style="font-size: 8px;"></i> Dual-Tagging Hybrid Active</span>
                <span class="text-muted">&bull;</span>
                <span class="font-mono text-dark font-weight-bold">v2.6 Enterprise</span>
            </div>
        </div>

        <!-- ====================================================================
             3. DUAL-TAGGING HYBRID PIPELINE DIAGRAM
             ==================================================================== -->
        <div class="st-pipeline-card">
            <div class="st-pipeline-header">
                <div class="st-pipeline-title">
                    <i class="fas fa-project-diagram" style="font-size: 16px;"></i>
                    <span>Zero Signal Loss Conversion Pipeline</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-light border text-muted px-2 py-1 font-mono" style="font-size: 11px;">
                        Browser &harr; Server Dual-Tagging &bull; Instant Deduplication
                    </span>
                </div>
            </div>

            <div class="st-pipeline-grid">
                <!-- Step 1 -->
                <div class="st-step-box step-1">
                    <div>
                        <div class="st-step-top">
                            <div class="st-step-icon" style="background: #eff6ff; color: #2563eb;">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <span class="st-step-num">STAGE 01</span>
                        </div>
                        <h4 class="st-step-heading">Client Touchpoint</h4>
                        <p class="st-step-desc">
                            Browser captures user session cookies (<code>_fbp</code>, <code>_fbc</code>, <code>_ga</code>) and campaign UTM source tags.
                        </p>
                    </div>
                    <div class="st-step-footer">
                        <span>First-Party Cookies</span>
                        <i class="fas fa-arrow-right text-primary"></i>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="st-step-box step-2">
                    <div>
                        <div class="st-step-top">
                            <div class="st-step-icon" style="background: #ecfdf5; color: #059669;">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <span class="st-step-num">STAGE 02</span>
                        </div>
                        <h4 class="st-step-heading">NextDigiHome Edge</h4>
                        <p class="st-step-desc">
                            Edge server ingests conversions and generates a deterministic <code>event_id</code> linking browser and cloud hits.
                        </p>
                    </div>
                    <div class="st-step-footer">
                        <span>Deduplication Key</span>
                        <i class="fas fa-arrow-right text-success"></i>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="st-step-box step-3">
                    <div>
                        <div class="st-step-top">
                            <div class="st-step-icon" style="background: #fffbeb; color: #d97706;">
                                <i class="fas fa-fingerprint"></i>
                            </div>
                            <span class="st-step-num">STAGE 03</span>
                        </div>
                        <h4 class="st-step-heading">SHA-256 Hashing</h4>
                        <p class="st-step-desc">
                            PII (emails, phones) normalized (E.164) and irreversibly hashed via SHA-256 for GDPR and CCPA privacy compliance.
                        </p>
                    </div>
                    <div class="st-step-footer">
                        <span>Privacy Shield</span>
                        <i class="fas fa-arrow-right text-warning"></i>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="st-step-box step-4">
                    <div>
                        <div class="st-step-top">
                            <div class="st-step-icon" style="background: #f5f3ff; color: #7c3aed;">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <span class="st-step-num">STAGE 04</span>
                        </div>
                        <h4 class="st-step-heading">Cloud Relays</h4>
                        <p class="st-step-desc">
                            Encrypted conversion payloads dispatched directly to Meta Graph API, GA4 Protocol, TikTok &amp; Webhooks.
                        </p>
                    </div>
                    <div class="st-step-footer">
                        <span>Multi-Cloud CAPI</span>
                        <i class="fas fa-check-double text-purple" style="color: #8b5cf6;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             4. ENTERPRISE KPI METRIC CARDS
             ==================================================================== -->
        @php
            $successRate = $totalEvents > 0 ? round(($totalSuccess / $totalEvents) * 100, 1) : 100;
            $activePipelines = 0;
            if (!empty($metaConfig['enabled'])) $activePipelines++;
            if (!empty($ga4Config['enabled'])) $activePipelines++;
            if (!empty($tiktokConfig['enabled'])) $activePipelines++;
            if (!empty($webhookConfig['enabled'])) $activePipelines++;
        @endphp

        <div class="st-stats-row">
            <!-- Total Dispatches -->
            <div class="st-stat-card stat-blue">
                <div>
                    <div class="st-stat-top">
                        <div class="st-stat-icon-wrapper" style="background: #eff6ff; color: #2563eb;">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <span class="st-stat-trend" style="background: #eff6ff; color: #1d4ed8;">
                            <i class="fas fa-arrow-up mr-1"></i> Live
                        </span>
                    </div>
                    <div class="st-stat-label">Total Cloud Dispatches</div>
                    <div class="st-stat-value">{{ number_format($totalEvents) }}</div>
                </div>
                <div class="st-stat-subtext">
                    <i class="fas fa-database text-muted"></i>
                    <span>All-time recorded edge transactions</span>
                </div>
            </div>

            <!-- Delivery Success Rate -->
            <div class="st-stat-card stat-green">
                <div>
                    <div class="st-stat-top">
                        <div class="st-stat-icon-wrapper" style="background: #ecfdf5; color: #059669;">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <span class="st-stat-trend" style="background: #ecfdf5; color: #047857;">
                            {{ $successRate }}%
                        </span>
                    </div>
                    <div class="st-stat-label">Delivery Success Rate</div>
                    <div class="st-stat-value text-success">{{ number_format($totalSuccess) }}</div>
                </div>
                <div>
                    <div class="progress mb-2" style="height: 5px; background: #e2e8f0; border-radius: 9999px;">
                        <div class="progress-bar" style="width: {{ $successRate }}%; background: linear-gradient(90deg, #10b981, #34d399); border-radius: 9999px;"></div>
                    </div>
                    <div class="st-stat-subtext">
                        <span>2xx API confirmations received</span>
                    </div>
                </div>
            </div>

            <!-- Failed / Dropped -->
            <div class="st-stat-card {{ $totalFailed > 0 ? 'stat-rose' : 'stat-green' }}">
                <div>
                    <div class="st-stat-top">
                        <div class="st-stat-icon-wrapper" style="background: {{ $totalFailed > 0 ? '#fff1f2' : '#f0fdf4' }}; color: {{ $totalFailed > 0 ? '#dc2626' : '#16a34a' }};">
                            <i class="fas {{ $totalFailed > 0 ? 'fa-exclamation-triangle' : 'fa-shield-alt' }}"></i>
                        </div>
                        <span class="st-stat-trend" style="background: {{ $totalFailed > 0 ? '#fff1f2' : '#f0fdf4' }}; color: {{ $totalFailed > 0 ? '#be123c' : '#15803d' }};">
                            {{ $totalFailed > 0 ? 'Attention' : 'Clean' }}
                        </span>
                    </div>
                    <div class="st-stat-label">Failed / Dropped</div>
                    <div class="st-stat-value {{ $totalFailed > 0 ? 'text-danger' : 'text-dark' }}">{{ number_format($totalFailed) }}</div>
                </div>
                <div class="st-stat-subtext">
                    <span>{{ $totalFailed > 0 ? 'Inspect audit log entries for error details' : 'Zero signal drops detected in pipeline' }}</span>
                </div>
            </div>

            <!-- Active Channels -->
            <div class="st-stat-card stat-purple">
                <div>
                    <div class="st-stat-top">
                        <div class="st-stat-icon-wrapper" style="background: #f5f3ff; color: #7c3aed;">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <span class="st-stat-trend" style="background: #f5f3ff; color: #6d28d9;">
                            {{ $activePipelines }}/4 Channels
                        </span>
                    </div>
                    <div class="st-stat-label">Active Cloud Relays</div>
                    <div class="st-stat-value" style="color: #6d28d9;">
                        {{ $activePipelines }} <span style="font-size: 16px; color: #94a3b8; font-weight: 500;">/ 4 Active</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 pt-1">
                    <span class="badge badge-pill {{ !empty($metaConfig['enabled']) ? 'badge-primary' : 'badge-light text-muted border' }}" style="font-size: 10px;">Meta</span>
                    <span class="badge badge-pill {{ !empty($ga4Config['enabled']) ? 'badge-warning text-dark' : 'badge-light text-muted border' }}" style="font-size: 10px;">GA4</span>
                    <span class="badge badge-pill {{ !empty($tiktokConfig['enabled']) ? 'badge-danger' : 'badge-light text-muted border' }}" style="font-size: 10px;">TikTok</span>
                    <span class="badge badge-pill {{ !empty($webhookConfig['enabled']) ? 'badge-info' : 'badge-light text-muted border' }}" style="font-size: 10px;">sGTM</span>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             5. CONVERSION DISPATCH CHANNELS (4 ENTERPRISE PROVIDER CARDS)
             ==================================================================== -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="st-section-title">
                    <i class="fas fa-cubes text-primary"></i>
                    <span>Cloud Conversion Dispatch Relays</span>
                </h3>
                <p class="st-section-sub">Direct API connectors transmitting normalized conversion events</p>
            </div>
            <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-sm btn-outline-secondary font-weight-600" style="border-radius: 8px;">
                <i class="fas fa-sliders-h mr-1"></i> Manage Credentials
            </a>
        </div>

        <div class="st-providers-grid">
            <!-- Meta CAPI -->
            <div class="st-channel-card st-channel-meta">
                <div>
                    <div class="st-channel-top">
                        <div class="st-channel-icon-wrap" style="background: #eff6ff; color: #1877f2;">
                            <i class="fab fa-facebook"></i>
                        </div>
                        @if(!empty($metaConfig['enabled']))
                            <span class="st-status-badge active"><i class="fas fa-circle" style="font-size: 6px;"></i> Active</span>
                        @else
                            <span class="st-status-badge disabled"><i class="fas fa-circle" style="font-size: 6px;"></i> Inactive</span>
                        @endif
                    </div>
                    <h4 class="st-channel-name">Meta Conversions API</h4>
                    <div class="st-channel-api-ver">Meta Graph API v{{ $metaConfig['version'] ?? '20.0' }}</div>

                    <div class="st-id-preview-box">
                        <div class="st-id-preview-label">
                            <span>Pixel / Dataset ID</span>
                            @if(!empty($metaConfig['pixel_id']))
                            <span class="text-success"><i class="fas fa-shield-alt"></i> Configured</span>
                            @else
                            <span class="text-muted">Not Set</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="st-id-preview-val font-mono" title="{{ $metaConfig['pixel_id'] ?? '' }}">
                                {{ !empty($metaConfig['pixel_id']) ? $metaConfig['pixel_id'] : '—' }}
                            </span>
                            @if(!empty($metaConfig['pixel_id']))
                            <button type="button" class="st-copy-btn" onclick="copyToClipboard('{{ $metaConfig['pixel_id'] }}', 'Meta Pixel ID copied')">
                                <i class="fas fa-copy"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="st-channel-footer">
                        <div class="st-dispatch-count">
                            <span>Dispatched:</span>
                            <strong>{{ number_format($metaCount) }}</strong>
                        </div>
                        <div class="st-channel-actions">
                            <button type="button" class="st-test-trigger-btn trigger-test-btn" data-provider="meta_capi" data-provider-name="Meta Conversions API (CAPI)">
                                <i class="fas fa-bolt text-primary"></i> Test
                            </button>
                            <a href="{{ route('admin.server-tracking.config') }}" class="st-config-icon-btn" title="Configure Meta CAPI">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Analytics 4 -->
            <div class="st-channel-card st-channel-ga4">
                <div>
                    <div class="st-channel-top">
                        <div class="st-channel-icon-wrap" style="background: #fffbeb; color: #f59e0b;">
                            <i class="fab fa-google"></i>
                        </div>
                        @if(!empty($ga4Config['enabled']))
                            <span class="st-status-badge active"><i class="fas fa-circle" style="font-size: 6px;"></i> Active</span>
                        @else
                            <span class="st-status-badge disabled"><i class="fas fa-circle" style="font-size: 6px;"></i> Inactive</span>
                        @endif
                    </div>
                    <h4 class="st-channel-name">Google Analytics 4</h4>
                    <div class="st-channel-api-ver">Measurement Protocol API</div>

                    <div class="st-id-preview-box">
                        <div class="st-id-preview-label">
                            <span>Measurement ID</span>
                            @if(!empty($ga4Config['measurement_id']))
                            <span class="text-success"><i class="fas fa-shield-alt"></i> Configured</span>
                            @else
                            <span class="text-muted">Not Set</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="st-id-preview-val font-mono" title="{{ $ga4Config['measurement_id'] ?? '' }}">
                                {{ !empty($ga4Config['measurement_id']) ? $ga4Config['measurement_id'] : '—' }}
                            </span>
                            @if(!empty($ga4Config['measurement_id']))
                            <button type="button" class="st-copy-btn" onclick="copyToClipboard('{{ $ga4Config['measurement_id'] }}', 'GA4 Measurement ID copied')">
                                <i class="fas fa-copy"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="st-channel-footer">
                        <div class="st-dispatch-count">
                            <span>Dispatched:</span>
                            <strong>{{ number_format($ga4Count) }}</strong>
                        </div>
                        <div class="st-channel-actions">
                            <button type="button" class="st-test-trigger-btn trigger-test-btn" data-provider="ga4" data-provider-name="GA4 Measurement Protocol">
                                <i class="fas fa-bolt text-warning"></i> Test
                            </button>
                            <a href="{{ route('admin.server-tracking.config') }}" class="st-config-icon-btn" title="Configure GA4 Protocol">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TikTok Events API -->
            <div class="st-channel-card st-channel-tiktok">
                <div>
                    <div class="st-channel-top">
                        <div class="st-channel-icon-wrap" style="background: #fff1f2; color: #fe2c55;">
                            <i class="fab fa-tiktok"></i>
                        </div>
                        @if(!empty($tiktokConfig['enabled']))
                            <span class="st-status-badge active"><i class="fas fa-circle" style="font-size: 6px;"></i> Active</span>
                        @else
                            <span class="st-status-badge disabled"><i class="fas fa-circle" style="font-size: 6px;"></i> Inactive</span>
                        @endif
                    </div>
                    <h4 class="st-channel-name">TikTok Events API</h4>
                    <div class="st-channel-api-ver">TikTok Business API v1.3</div>

                    <div class="st-id-preview-box">
                        <div class="st-id-preview-label">
                            <span>Pixel Code</span>
                            @if(!empty($tiktokConfig['pixel_code']))
                            <span class="text-success"><i class="fas fa-shield-alt"></i> Configured</span>
                            @else
                            <span class="text-muted">Not Set</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="st-id-preview-val font-mono" title="{{ $tiktokConfig['pixel_code'] ?? '' }}">
                                {{ !empty($tiktokConfig['pixel_code']) ? $tiktokConfig['pixel_code'] : '—' }}
                            </span>
                            @if(!empty($tiktokConfig['pixel_code']))
                            <button type="button" class="st-copy-btn" onclick="copyToClipboard('{{ $tiktokConfig['pixel_code'] }}', 'TikTok Pixel Code copied')">
                                <i class="fas fa-copy"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="st-channel-footer">
                        <div class="st-dispatch-count">
                            <span>Dispatched:</span>
                            <strong>{{ number_format($tiktokCount) }}</strong>
                        </div>
                        <div class="st-channel-actions">
                            <button type="button" class="st-test-trigger-btn trigger-test-btn" data-provider="tiktok" data-provider-name="TikTok Events API">
                                <i class="fas fa-bolt text-danger"></i> Test
                            </button>
                            <a href="{{ route('admin.server-tracking.config') }}" class="st-config-icon-btn" title="Configure TikTok API">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Server Webhook / sGTM Container -->
            <div class="st-channel-card st-channel-webhook">
                <div>
                    <div class="st-channel-top">
                        <div class="st-channel-icon-wrap" style="background: #f5f3ff; color: #8b5cf6;">
                            <i class="fas fa-cloud-download-alt"></i>
                        </div>
                        @if(!empty($webhookConfig['enabled']))
                            <span class="st-status-badge active"><i class="fas fa-circle" style="font-size: 6px;"></i> Active</span>
                        @else
                            <span class="st-status-badge disabled"><i class="fas fa-circle" style="font-size: 6px;"></i> Inactive</span>
                        @endif
                    </div>
                    <h4 class="st-channel-name">Server Webhook / sGTM</h4>
                    <div class="st-channel-api-ver">Stape, Make, Zapier &amp; Cloud Relay</div>

                    <div class="st-id-preview-box">
                        <div class="st-id-preview-label">
                            <span>Endpoint URL</span>
                            @if(!empty($webhookConfig['url']))
                            <span class="text-success"><i class="fas fa-shield-alt"></i> Configured</span>
                            @else
                            <span class="text-muted">Not Set</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="st-id-preview-val font-mono" title="{{ $webhookConfig['url'] ?? '' }}">
                                {{ !empty($webhookConfig['url']) ? $webhookConfig['url'] : '—' }}
                            </span>
                            @if(!empty($webhookConfig['url']))
                            <button type="button" class="st-copy-btn" onclick="copyToClipboard('{{ $webhookConfig['url'] }}', 'Webhook URL copied')">
                                <i class="fas fa-copy"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="st-channel-footer">
                        <div class="st-dispatch-count">
                            <span>Dispatched:</span>
                            <strong>{{ number_format($webhookCount) }}</strong>
                        </div>
                        <div class="st-channel-actions">
                            <button type="button" class="st-test-trigger-btn trigger-test-btn" data-provider="webhook" data-provider-name="Server Webhook / sGTM">
                                <i class="fas fa-bolt text-info"></i> Test
                            </button>
                            <a href="{{ route('admin.server-tracking.config') }}" class="st-config-icon-btn" title="Configure Webhook Relay">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====================================================================
             6. LIVE TELEMETRY CONSOLE TERMINAL (REVEALS UPON TEST EXECUTION)
             ==================================================================== -->
        <div id="live-console-card" class="st-terminal-card d-none">
            <div class="st-terminal-header">
                <div class="st-terminal-controls">
                    <span class="st-mac-dot close" onclick="document.getElementById('live-console-card').classList.add('d-none')" style="cursor: pointer;" title="Close Terminal"></span>
                    <span class="st-mac-dot min"></span>
                    <span class="st-mac-dot max"></span>
                    <span class="st-terminal-title ml-3" id="console-title">
                        <i class="fas fa-terminal text-info mr-1"></i> Telemetry Console Output
                    </span>
                </div>
                <div class="st-terminal-actions">
                    <span class="badge badge-pill badge-dark font-mono text-success border border-secondary" id="console-latency" style="font-size: 11px; padding: 4px 10px;">
                        -- ms
                    </span>
                    <button type="button" class="btn btn-xs btn-outline-light" onclick="copyConsoleOutput()" style="font-size: 11px; border-radius: 6px;">
                        <i class="fas fa-copy mr-1"></i> Copy Payload JSON
                    </button>
                    <button type="button" class="btn btn-xs btn-link text-white p-0 ml-2" onclick="document.getElementById('live-console-card').classList.add('d-none');">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="st-terminal-body">
                <pre id="console-output-pre" class="st-terminal-pre"></pre>
            </div>
        </div>

        <!-- ====================================================================
             7. RECENT DISPATCHES STREAM AUDIT TABLE
             ==================================================================== -->
        <div class="st-table-card">
            <div class="st-table-toolbar">
                <div>
                    <h3 class="st-section-title mb-1">
                        <i class="fas fa-stream text-primary"></i>
                        <span>Recent Cloud Dispatches Stream</span>
                        <span class="st-radar-dot ml-2" style="display: inline-block;"></span>
                    </h3>
                    <p class="small text-muted mb-0">Live audit stream of outgoing conversion transmissions</p>
                </div>

                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute text-muted" style="left: 12px; top: 11px; font-size: 12px;"></i>
                        <input type="text" id="streamSearchInput" class="st-search-input" placeholder="Search event or ID...">
                    </div>

                    <div class="st-filter-pills">
                        <button type="button" class="st-filter-pill active" data-filter="all">All</button>
                        <button type="button" class="st-filter-pill" data-filter="meta_capi">Meta</button>
                        <button type="button" class="st-filter-pill" data-filter="ga4">GA4</button>
                        <button type="button" class="st-filter-pill" data-filter="tiktok">TikTok</button>
                        <button type="button" class="st-filter-pill" data-filter="webhook">Webhook</button>
                    </div>

                    <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-primary font-weight-700" style="border-radius: 8px; padding: 7px 14px; font-size: 12.5px;">
                        View All ({{ number_format($totalEvents) }}) <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="st-table" id="recentLogsTable">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Channel</th>
                            <th>Event Name</th>
                            <th>Ref / Lead ID</th>
                            <th>Status</th>
                            <th>HTTP Code</th>
                            <th>Payload &amp; Diagnostics</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                        <tr class="log-stream-row" data-provider="{{ $log->provider }}" data-search="{{ strtolower($log->event_name . ' ' . $log->lead_id . ' ' . $log->order_id . ' ' . $log->event_id) }}">
                            <td class="small text-muted font-mono" style="white-space: nowrap;">
                                <span title="{{ $log->created_at ? $log->created_at->toDayDateTimeString() : 'N/A' }}">
                                    {{ $log->created_at ? $log->created_at->diffForHumans() : 'N/A' }}
                                </span>
                                <small class="d-block text-muted" style="font-size: 10px;">
                                    {{ $log->created_at ? $log->created_at->format('M d, H:i:s') : '' }}
                                </small>
                            </td>
                            <td>
                                @if($log->provider === 'meta_capi')
                                    <span class="st-channel-pill meta"><i class="fab fa-facebook mr-1"></i> META CAPI</span>
                                @elseif($log->provider === 'ga4')
                                    <span class="st-channel-pill ga4"><i class="fab fa-google mr-1"></i> GA4</span>
                                @elseif($log->provider === 'tiktok')
                                    <span class="st-channel-pill tiktok"><i class="fab fa-tiktok mr-1"></i> TIKTOK</span>
                                @else
                                    <span class="st-channel-pill webhook"><i class="fas fa-network-wired mr-1"></i> WEBHOOK</span>
                                @endif
                            </td>
                            <td>
                                <span class="st-event-tag {{ $log->event_name }}">
                                    {{ $log->event_name }}
                                </span>
                            </td>
                            <td class="font-mono small">
                                @if($log->lead_id || $log->order_id)
                                    <span class="text-primary font-weight-bold" style="cursor: pointer;" onclick="copyToClipboard('{{ $log->lead_id ?: $log->order_id }}', 'Ref ID copied')">
                                        {{ $log->lead_id ?: $log->order_id }}
                                        <i class="fas fa-copy ml-1 text-muted" style="font-size: 10px;"></i>
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($log->status === 'success')
                                    <span class="st-delivery-badge success">
                                        <i class="fas fa-check-circle mr-1"></i> DELIVERED
                                    </span>
                                @elseif($log->status === 'failed')
                                    <span class="st-delivery-badge failed">
                                        <i class="fas fa-times-circle mr-1"></i> FAILED
                                    </span>
                                @else
                                    <span class="st-delivery-badge skipped">
                                        <i class="fas fa-minus-circle mr-1"></i> SKIPPED
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="st-code-pill {{ ($log->http_code >= 200 && $log->http_code < 300) ? 'success' : ($log->http_code ? 'error' : 'muted') }}">
                                    {{ $log->http_code ?: '—' }}
                                </span>
                            </td>
                            <td class="small text-muted" style="max-width: 260px;">
                                <div class="text-truncate" title="{{ $log->error_message ?: '200 OK — Successfully delivered' }}">
                                    {{ $log->error_message ?: '200 OK — Successfully delivered' }}
                                </div>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-xs btn-outline-secondary font-weight-600 inspect-payload-btn"
                                        style="border-radius: 6px; font-size: 11.5px; padding: 3px 8px;"
                                        data-log-id="{{ $log->id }}"
                                        data-provider="{{ strtoupper($log->provider) }}"
                                        data-event="{{ $log->event_name }}"
                                        data-event-id="{{ $log->event_id }}"
                                        data-status="{{ $log->status }}"
                                        data-http="{{ $log->http_code }}"
                                        data-ip="{{ $log->ip_address ?? 'N/A' }}"
                                        data-time="{{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : 'N/A' }}"
                                        data-request='@json($log->request_payload)'
                                        data-response='@json($log->response_payload)'
                                        data-error="{{ $log->error_message }}">
                                    <i class="fas fa-search mr-1"></i> Inspect
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="p-4" style="max-width: 480px; margin: 0 auto;">
                                    <div class="mb-3" style="width: 56px; height: 56px; border-radius: 14px; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; color: #94a3b8;">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h5 class="font-weight-800 text-dark mb-1">No Server Tracking Logs Yet</h5>
                                    <p class="small text-muted mb-3">Launch a live test dispatch to test your Meta CAPI, GA4, TikTok, or Webhook cloud connection.</p>
                                    <button type="button" class="st-btn-glow" data-toggle="modal" data-target="#quickTestModal">
                                        <i class="fas fa-bolt"></i> Launch First Test Event
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- ============================================================================
     8. LIVE TEST DISPATCH MODAL
     ============================================================================ -->
<div class="modal fade" id="quickTestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.25); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="d-flex align-items-center">
                    <div style="background: linear-gradient(135deg, #3b82f6, #06b6d4); color: #ffffff; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;" class="mr-3 shadow-sm">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold mb-0 text-white" style="font-size: 16px;">Live Cloud Test Dispatcher</h5>
                        <small class="text-white-50">Transmit synthetic conversion payload to ad cloud endpoints</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="background: #ffffff;">
                <form id="liveTestForm">
                    <div class="form-group mb-3">
                        <label class="text-dark small font-weight-bold mb-1">Target Cloud Channel</label>
                        <select class="form-control" id="modal-provider" style="border-color: #cbd5e1; height: 42px; border-radius: 8px; font-weight: 600;">
                            <option value="meta_capi">Meta Conversions API (CAPI Graph v20)</option>
                            <option value="ga4">Google Analytics 4 Measurement Protocol</option>
                            <option value="tiktok">TikTok Events API (Business v1.3)</option>
                            <option value="webhook">Server Webhook / sGTM Container</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-dark small font-weight-bold mb-1">Standard Conversion Event</label>
                        <select class="form-control" id="modal-event-name" style="border-color: #cbd5e1; height: 42px; border-radius: 8px; font-weight: 600;">
                            <option value="Lead" selected>🎯 Lead (Generate Lead / Inquiry Form)</option>
                            <option value="Purchase">💰 Purchase (E-Commerce Order Confirmed)</option>
                            <option value="ViewContent">👁 ViewContent (Portfolio / Detail Page)</option>
                            <option value="AddToCart">🛒 AddToCart (Service / Package Added)</option>
                            <option value="InitiateCheckout">💳 InitiateCheckout (Checkout Step 1)</option>
                            <option value="Contact">💬 Contact (WhatsApp / Telephone Click)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-dark small font-weight-bold mb-1">
                            Ad Manager Test Event Code <span class="text-muted font-weight-normal">(Optional Override)</span>
                        </label>
                        <input type="text" class="form-control font-mono" id="modal-test-code" placeholder="e.g. TEST12345 (Leave empty to use saved setting)" style="border-color: #cbd5e1; height: 42px; border-radius: 8px; font-size: 13px;">
                        <small class="text-muted">Matches the real-time test event screen in Meta or TikTok Events Manager.</small>
                    </div>

                    <div class="p-3 rounded mb-0" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #475569; border-radius: 10px;">
                        <i class="fas fa-shield-alt text-success mr-1"></i> Dispatches include realistic customer metadata (normalized phone, SHA-256 hashed email, client IP, User-Agent &amp; unique deterministic <code>event_id</code>).
                    </div>
                </form>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid #edf0f4; background: #f8fafc;">
                <button type="button" class="btn btn-sm btn-secondary font-weight-600 px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" class="st-btn-glow px-4" id="executeTestBtn">
                    <i class="fas fa-paper-plane mr-1"></i> Transmit Test Event
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     9. PAYLOAD INSPECTOR MODAL
     ============================================================================ -->
<div class="modal fade" id="payloadInspectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.25); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="background: #0f172a; color: #ffffff; border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center">
                    <div style="background: rgba(255, 255, 255, 0.1); color: #38bdf8; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;" class="mr-3">
                        <i class="fas fa-search-plus"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-white mb-0" id="inspectModalTitle" style="font-size: 16px;">
                            Event Diagnostics Inspector
                        </h5>
                        <small class="text-white-50" id="inspectModalSubtitle">Full cloud payload inspection</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="background: #ffffff;">
                <!-- Summary Chips -->
                <div class="d-flex flex-wrap gap-2 mb-3" id="inspectModalChips"></div>

                <!-- Tabs: Request vs Response -->
                <ul class="nav nav-pills mb-3" id="inspectTab" role="tablist" style="gap: 8px;">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="tab-request-link" data-toggle="pill" href="#tab-request" role="tab" style="border-radius: 8px; font-size: 12.5px; padding: 6px 14px;">
                            <i class="fas fa-arrow-up mr-1 text-primary"></i> Outgoing Request Payload
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="tab-response-link" data-toggle="pill" href="#tab-response" role="tab" style="border-radius: 8px; font-size: 12.5px; padding: 6px 14px;">
                            <i class="fas fa-arrow-down mr-1 text-success"></i> Cloud API Response
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="inspectTabContent">
                    <div class="tab-pane fade show active" id="tab-request" role="tabpanel">
                        <div class="position-relative">
                            <button type="button" class="btn btn-xs btn-outline-secondary position-absolute" style="top: 10px; right: 10px; z-index: 5;" onclick="copyInspectRequest()">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>
                            <pre id="inspectRequestPre" class="p-3 mb-0 font-mono text-dark" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 12px; max-height: 380px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-response" role="tabpanel">
                        <div class="position-relative">
                            <button type="button" class="btn btn-xs btn-outline-secondary position-absolute" style="top: 10px; right: 10px; z-index: 5;" onclick="copyInspectResponse()">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>
                            <pre id="inspectResponsePre" class="p-3 mb-0 font-mono text-dark" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 12px; max-height: 380px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-3 px-4" style="background: #f8fafc; border-top: 1px solid #edf0f4;">
                <button type="button" class="btn btn-sm btn-secondary font-weight-600 px-3" data-dismiss="modal" style="border-radius: 8px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================================
     10. FLOATING TOAST SYSTEM
     ============================================================================ -->
<div class="st-toast-container" id="toastContainer"></div>

<!-- ============================================================================
     11. JAVASCRIPT LOGIC & INTERACTIONS
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

// Copy to clipboard utility
function copyToClipboard(text, successMsg = 'Copied to clipboard!') {
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        showToast(successMsg, 'fa-copy text-info');
    }).catch(err => {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showToast(successMsg, 'fa-copy text-info');
    });
}

// Wire quick test buttons on provider cards
document.querySelectorAll('.trigger-test-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const provider = this.getAttribute('data-provider');
        const select = document.getElementById('modal-provider');
        if (select && provider) {
            select.value = provider;
        }
        if (typeof $ !== 'undefined' && $('#quickTestModal').modal) {
            $('#quickTestModal').modal('show');
        }
    });
});

// Live Test Form execution
document.getElementById('executeTestBtn').addEventListener('click', function() {
    const provider = document.getElementById('modal-provider').value;
    const eventName = document.getElementById('modal-event-name').value;
    const testCode = document.getElementById('modal-test-code').value;

    const origHtml = this.innerHTML;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Transmitting...';
    this.disabled = true;

    fetch('{{ route("admin.server-tracking.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            provider: provider,
            event_name: eventName,
            test_event_code: testCode
        })
    })
    .then(res => res.json())
    .then(data => {
        if (typeof $ !== 'undefined' && $('#quickTestModal').modal) {
            $('#quickTestModal').modal('hide');
        }

        const card = document.getElementById('live-console-card');
        const pre = document.getElementById('console-output-pre');
        const latencyBadge = document.getElementById('console-latency');
        const title = document.getElementById('console-title');

        card.classList.remove('d-none');
        title.innerHTML = `<i class="fas fa-terminal mr-2 text-info"></i>Telemetry Console: [${provider.toUpperCase()}] &rarr; ${eventName}`;

        const latency = (data.result && data.result.latency_ms) ? data.result.latency_ms + ' ms' : 'Completed';
        latencyBadge.textContent = latency;

        pre.textContent = JSON.stringify(data, null, 2);
        card.scrollIntoView({ behavior: 'smooth' });

        showToast(`Test event dispatched to ${provider.toUpperCase()}`, 'fa-paper-plane text-success');
    })
    .catch(err => {
        alert('Test dispatch network error: ' + err);
    })
    .finally(() => {
        this.innerHTML = origHtml;
        this.disabled = false;
    });
});

// Copy console output
function copyConsoleOutput() {
    const text = document.getElementById('console-output-pre').textContent;
    copyToClipboard(text, 'Console response JSON copied to clipboard!');
}

// Client-side search & filtering for recent activity table
const searchInput = document.getElementById('streamSearchInput');
const filterPills = document.querySelectorAll('.st-filter-pill');
const tableRows = document.querySelectorAll('.log-stream-row');

function filterTable() {
    const searchVal = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const activePill = document.querySelector('.st-filter-pill.active');
    const filterProvider = activePill ? activePill.getAttribute('data-filter') : 'all';

    tableRows.forEach(row => {
        const rowProvider = row.getAttribute('data-provider');
        const rowSearch = row.getAttribute('data-search') || '';

        const matchesProvider = (filterProvider === 'all' || rowProvider === filterProvider);
        const matchesSearch = !searchVal || rowSearch.includes(searchVal);

        if (matchesProvider && matchesSearch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

if (searchInput) {
    searchInput.addEventListener('input', filterTable);
}

filterPills.forEach(pill => {
    pill.addEventListener('click', function() {
        filterPills.forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        filterTable();
    });
});

// Inspect Payload Modal logic
let currentInspectRequest = '';
let currentInspectResponse = '';

document.querySelectorAll('.inspect-payload-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const provider = this.getAttribute('data-provider');
        const eventName = this.getAttribute('data-event');
        const eventId = this.getAttribute('data-event-id');
        const status = this.getAttribute('data-status');
        const http = this.getAttribute('data-http');
        const ip = this.getAttribute('data-ip');
        const time = this.getAttribute('data-time');

        let reqData = this.getAttribute('data-request');
        let resData = this.getAttribute('data-response');

        try { reqData = JSON.parse(reqData); } catch (e) {}
        try { resData = JSON.parse(resData); } catch (e) {}

        currentInspectRequest = JSON.stringify(reqData, null, 2);
        currentInspectResponse = JSON.stringify(resData, null, 2);

        document.getElementById('inspectModalTitle').textContent = `${provider} - ${eventName}`;
        document.getElementById('inspectModalSubtitle').textContent = `Event ID: ${eventId || 'N/A'} • Timestamp: ${time}`;

        const chipsContainer = document.getElementById('inspectModalChips');
        chipsContainer.innerHTML = `
            <span class="badge badge-primary px-2 py-1 font-mono">${provider}</span>
            <span class="badge badge-info px-2 py-1 font-mono">${eventName}</span>
            <span class="badge ${status === 'success' ? 'badge-success' : (status === 'failed' ? 'badge-danger' : 'badge-secondary')} px-2 py-1">${status.toUpperCase()}</span>
            <span class="badge badge-light border px-2 py-1 font-mono">HTTP ${http || '—'}</span>
            <span class="badge badge-light border px-2 py-1 font-mono">IP: ${ip}</span>
        `;

        document.getElementById('inspectRequestPre').textContent = currentInspectRequest || 'No request payload recorded.';
        document.getElementById('inspectResponsePre').textContent = currentInspectResponse || 'No response payload recorded.';

        if (typeof $ !== 'undefined' && $('#payloadInspectModal').modal) {
            $('#payloadInspectModal').modal('show');
        }
    });
});

function copyInspectRequest() {
    copyToClipboard(currentInspectRequest, 'Request payload copied!');
}

function copyInspectResponse() {
    copyToClipboard(currentInspectResponse, 'Response payload copied!');
}
</script>
@endsection
