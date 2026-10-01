@extends('admin.dashboard.master')

@section('title', 'Meta Pixel & Conversions API (CAPI) - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<!-- Preconnect & Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<style>
    :root {
        --st-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --st-font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;

        --meta-blue-primary: #0081fb;
        --meta-blue-dark: #0064e0;
        --meta-blue-light: #e7f3ff;
        --meta-blue-border: #99ccff;
        --meta-gradient: linear-gradient(135deg, #051428 0%, #0a2540 50%, #0064e0 100%);
    }

    .meta-page-wrapper {
        background: #f8fafc !important;
        min-height: calc(100vh - 66px);
        padding: 24px 30px 60px !important;
        font-family: var(--st-font-sans) !important;
        color: #1e293b !important;
        font-size: 14.5px !important;
    }

    .font-mono-code {
        font-family: var(--st-font-mono) !important;
    }

    /* Hero Banner */
    .meta-hero-banner {
        position: relative;
        overflow: hidden;
        background: var(--meta-gradient);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 32px 38px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 16px 40px -8px rgba(0, 100, 224, 0.25);
    }

    .meta-hero-banner::after {
        content: '';
        position: absolute;
        top: -70px;
        right: -30px;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(0, 129, 251, 0.35) 0%, rgba(56, 189, 248, 0.12) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .meta-radar-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0, 129, 251, 0.22);
        border: 1px solid rgba(147, 197, 253, 0.4);
        color: #93c5fd;
        border-radius: 9999px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 14px;
        backdrop-filter: blur(8px);
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #38bdf8;
        box-shadow: 0 0 0 0 rgba(56, 189, 248, 0.7);
        animation: metaPulse 2s infinite;
    }

    @keyframes metaPulse {
        0% { box-shadow: 0 0 0 0 rgba(56, 189, 248, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(56, 189, 248, 0); }
        100% { box-shadow: 0 0 0 0 rgba(56, 189, 248, 0); }
    }

    .meta-title {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.6px;
        margin: 0 0 8px 0;
        line-height: 1.25;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .meta-badge-tag {
        font-size: 13px;
        font-weight: 700;
        padding: 4px 12px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 8px;
        letter-spacing: 0.2px;
    }

    .meta-subtitle {
        font-size: 15px;
        color: #cbd5e1;
        max-width: 820px;
        line-height: 1.6;
        margin: 0;
    }

    /* Period Filter Pills */
    .period-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .period-pills-group {
        display: inline-flex;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        gap: 4px;
    }

    .period-pill {
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        border-radius: 8px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .period-pill:hover {
        color: #0f172a;
    }

    .period-pill.active {
        background: #ffffff;
        color: #0064e0;
        box-shadow: 0 2px 6px rgba(0, 100, 224, 0.15);
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        position: relative;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .kpi-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
    }

    .kpi-icon-bubble {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .kpi-value {
        font-size: 32px;
        font-weight: 900;
        letter-spacing: -1px;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 6px;
    }

    .kpi-subtext {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* 3-Column Period Matrix */
    .period-matrix-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .period-matrix-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .period-matrix-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 16px;
    }

    .period-badge-today {
        background: #e0f2fe;
        color: #0369a1;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .period-badge-week {
        background: #ede9fe;
        color: #6d28d9;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .period-badge-month {
        background: #fef3c7;
        color: #b45309;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .matrix-stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed #f1f5f9;
        font-size: 13.5px;
    }

    .matrix-stat-row:last-child {
        border-bottom: none;
    }

    .matrix-label {
        color: #64748b;
        font-weight: 500;
    }

    .matrix-val {
        font-weight: 700;
        color: #0f172a;
    }

    /* EMQ Telemetry Bar */
    .emq-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .emq-score-dial {
        font-size: 42px;
        font-weight: 900;
        color: #0064e0;
        letter-spacing: -1px;
        line-height: 1;
    }

    .emq-progress-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 6px;
    }

    .emq-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #0081fb, #10b981);
        border-radius: 9999px;
    }

    /* Data Tables & Modals */
    .st-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .st-table-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .st-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .st-table th {
        background: #f8fafc;
        padding: 14px 18px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        border-top: none;
    }

    .st-table td {
        padding: 16px 18px;
        font-size: 13.5px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .st-table tr:hover td {
        background-color: #f8fafc;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .status-pill.success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .status-pill.failed {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .code-chip {
        display: inline-block;
        background: #f1f5f9;
        color: #0f172a;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-family: var(--st-font-mono);
        border: 1px solid #e2e8f0;
    }

    .btn-meta {
        background: #0064e0;
        color: #ffffff !important;
        font-weight: 700;
        border-radius: 10px;
        padding: 8px 18px;
        border: none;
        transition: all 0.2s;
    }

    .btn-meta:hover {
        background: #0052cc;
        box-shadow: 0 4px 12px rgba(0, 100, 224, 0.3);
    }
</style>

<div class="meta-page-wrapper">
    <!-- Top Universal Navigation Tabs -->
    @include('admin.tracking.partials.nav')

    <!-- Meta Hero Banner -->
    <div class="meta-hero-banner">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <div class="meta-radar-pill">
                    <span class="pulse-dot"></span>
                    <span>Meta Graph API {{ $metaConfig['version'] ?? 'v20.0' }} Active</span>
                </div>
                <h1 class="meta-title">
                    <i class="fab fa-facebook text-primary" style="color: #38bdf8 !important;"></i>
                    Meta Pixel &amp; Conversions API (CAPI)
                    <span class="meta-badge-tag">Dataset {{ $metaConfig['dataset_id'] ?? '1786172575724734' }}</span>
                </h1>
                <p class="meta-subtitle">
                    Dual-stream server and browser event telemetry. Events are matched server-to-server with high Event Match Quality (EMQ) and automatically deduplicated with browser pixel events via unique <code class="text-info font-mono-code font-weight-bold">event_id</code>.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-3 mt-lg-0">
                <button type="button" class="btn btn-light font-weight-bold px-3 py-2" data-toggle="modal" data-target="#testMetaModal" style="border-radius: 11px;">
                    <i class="fas fa-paper-plane mr-1 text-primary"></i> Dispatch Test Event
                </button>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-outline-light font-weight-bold px-3 py-2" style="border-radius: 11px; border-color: rgba(255,255,255,0.3);">
                    <i class="fas fa-cog mr-1"></i> CAPI Settings
                </a>
            </div>
        </div>
    </div>

    <!-- Period Filter Switcher & Breakdowns -->
    <div class="period-filter-card">
        <div class="d-flex align-items-center gap-3">
            <span class="font-weight-bold text-dark" style="font-size: 14px;">
                <i class="far fa-calendar-alt text-muted mr-1"></i> Timeframe View:
            </span>
            <div class="period-pills-group">
                <a href="{{ route('admin.server-tracking.meta', ['period' => 'today']) }}" 
                   class="period-pill {{ $selectedPeriod === 'today' ? 'active' : '' }}">
                    Today
                </a>
                <a href="{{ route('admin.server-tracking.meta', ['period' => 'week']) }}" 
                   class="period-pill {{ $selectedPeriod === 'week' || $selectedPeriod === 'all' ? 'active' : '' }}">
                    This Week
                </a>
                <a href="{{ route('admin.server-tracking.meta', ['period' => 'month']) }}" 
                   class="period-pill {{ $selectedPeriod === 'month' ? 'active' : '' }}">
                    This Month
                </a>
            </div>
        </div>
        <div class="text-muted font-weight-500" style="font-size: 13px;">
            Showing <strong class="text-dark">{{ ucfirst(str_replace('_', ' ', $selectedPeriod)) }}</strong> analytics breakdown for Meta CAPI
        </div>
    </div>

    <!-- 4 High Impact Core KPI Cards -->
    <div class="kpi-grid">
        <!-- 1. Total Dispatched -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Dispatched Events</span>
                <div class="kpi-icon-bubble" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fas fa-paper-plane"></i>
                </div>
            </div>
            <div class="kpi-value">{{ number_format($summary[$selectedPeriod]['total'] ?? $summary['week']['total']) }}</div>
            <div class="kpi-subtext">
                <span class="badge badge-light border text-primary font-weight-bold">
                    Today: {{ $summary['today']['total'] }}
                </span>
                <span>• Month: {{ $summary['month']['total'] }}</span>
            </div>
        </div>

        <!-- 2. Delivery Rate -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Delivery Health</span>
                <div class="kpi-icon-bubble" style="background: #ecfdf5; color: #059669;">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
            <div class="kpi-value text-success">{{ $summary[$selectedPeriod]['rate'] ?? $summary['week']['rate'] }}%</div>
            <div class="kpi-subtext text-success font-weight-bold">
                <i class="fas fa-check-circle"></i> {{ $summary[$selectedPeriod]['success'] ?? $summary['week']['success'] }} successfully delivered to Meta
            </div>
        </div>

        <!-- 3. Event Match Quality -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Meta EMQ Rating</span>
                <div class="kpi-icon-bubble" style="background: #fdf2f8; color: #db2777;">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="kpi-value text-primary" style="color: #0064e0 !important;">{{ $emqMetrics['overall_score'] }} <span style="font-size: 16px; color: #64748b;">/ 10</span></div>
            <div class="kpi-subtext text-info font-weight-bold">
                <i class="fas fa-award"></i> Meta Rating: {{ $emqMetrics['rating'] }} (Tier 1 Match)
            </div>
        </div>

        <!-- 4. Deduplication Rate -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Deduplication</span>
                <div class="kpi-icon-bubble" style="background: #fef3c7; color: #d97706;">
                    <i class="fas fa-clone"></i>
                </div>
            </div>
            <div class="kpi-value">{{ $emqMetrics['dedup_rate'] }}%</div>
            <div class="kpi-subtext">
                <span class="text-success font-weight-bold"><i class="fas fa-check"></i> Pixel + CAPI Synced</span>
            </div>
        </div>
    </div>

    <!-- Comparative 3-Column Period Matrix: Today vs This Week vs This Month -->
    <h4 class="font-weight-bold text-dark mb-3" style="font-size: 18px; letter-spacing: -0.3px;">
        <i class="fas fa-table-columns text-primary mr-2"></i> Time Period Breakdown Matrix
    </h4>
    <div class="period-matrix-grid">
        <!-- Today Matrix Card -->
        <div class="period-matrix-card" style="border-top: 4px solid #0081fb;">
            <div class="period-matrix-header">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 16px;">Today's Activity</h5>
                    <span class="text-muted" style="font-size: 12.5px;">{{ now()->format('l, M d, Y') }}</span>
                </div>
                <span class="period-badge-today">TODAY</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Total CAPI Dispatches</span>
                <span class="matrix-val font-mono-code" style="font-size: 15px;">{{ number_format($summary['today']['total']) }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Successful Deliveries</span>
                <span class="matrix-val text-success font-mono-code">{{ number_format($summary['today']['success']) }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Failed / Retries</span>
                <span class="matrix-val text-muted font-mono-code">{{ $summary['today']['failed'] }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Delivery Rate</span>
                <span class="matrix-val text-primary font-weight-bold">{{ $summary['today']['rate'] }}%</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Top Event Type</span>
                <span class="matrix-val text-dark font-weight-bold">Lead ({{ $eventMatrix[0]['today'] ?? 4 }})</span>
            </div>
        </div>

        <!-- This Week Matrix Card -->
        <div class="period-matrix-card" style="border-top: 4px solid #7c3aed;">
            <div class="period-matrix-header">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 16px;">This Week's Activity</h5>
                    <span class="text-muted" style="font-size: 12.5px;">Last 7 Days Rolling Timeline</span>
                </div>
                <span class="period-badge-week">THIS WEEK</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Total CAPI Dispatches</span>
                <span class="matrix-val font-mono-code" style="font-size: 15px;">{{ number_format($summary['week']['total']) }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Successful Deliveries</span>
                <span class="matrix-val text-success font-mono-code">{{ number_format($summary['week']['success']) }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Failed / Retries</span>
                <span class="matrix-val text-muted font-mono-code">{{ $summary['week']['failed'] }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Delivery Rate</span>
                <span class="matrix-val text-primary font-weight-bold">{{ $summary['week']['rate'] }}%</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Top Event Type</span>
                <span class="matrix-val text-dark font-weight-bold">Lead &amp; ViewContent</span>
            </div>
        </div>

        <!-- This Month Matrix Card -->
        <div class="period-matrix-card" style="border-top: 4px solid #d97706;">
            <div class="period-matrix-header">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 16px;">This Month's Activity</h5>
                    <span class="text-muted" style="font-size: 12.5px;">Current 30-Day Aggregation</span>
                </div>
                <span class="period-badge-month">THIS MONTH</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Total CAPI Dispatches</span>
                <span class="matrix-val font-mono-code" style="font-size: 15px;">{{ number_format($summary['month']['total']) }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Successful Deliveries</span>
                <span class="matrix-val text-success font-mono-code">{{ number_format($summary['month']['success']) }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Failed / Retries</span>
                <span class="matrix-val text-muted font-mono-code">{{ $summary['month']['failed'] }}</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Delivery Rate</span>
                <span class="matrix-val text-primary font-weight-bold">{{ $summary['month']['rate'] }}%</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Top Event Type</span>
                <span class="matrix-val text-dark font-weight-bold">ViewContent ({{ $eventMatrix[4]['month'] ?? 120 }})</span>
            </div>
        </div>
    </div>

    <!-- Chart & EMQ Split Row -->
    <div class="row mb-4">
        <!-- Interactive Chart.js Timeline -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card border-0 h-100" style="background: #ffffff; border: 1px solid #e2e8f0 !important; border-radius: 16px; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="font-weight-bold text-dark mb-1" style="font-size: 16.5px;">
                                <i class="fas fa-chart-line text-primary mr-1"></i> Meta CAPI Dispatch Velocity
                            </h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">
                                Temporal dispatch distribution for {{ ucfirst($selectedPeriod) }}
                            </p>
                        </div>
                        <span class="badge badge-light border text-muted px-2 py-1 font-mono-code">Live Telemetry</span>
                    </div>
                    <div style="height: 290px; position: relative;">
                        <canvas id="metaTimelineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- EMQ Parameter Match Diagnostics -->
        <div class="col-lg-4">
            <div class="card border-0 h-100" style="background: #ffffff; border: 1px solid #e2e8f0 !important; border-radius: 16px; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
                            <i class="fas fa-fingerprint text-info mr-1"></i> Match Parameters
                        </h5>
                        <span class="badge badge-success font-weight-bold">EMQ {{ $emqMetrics['overall_score'] }}/10</span>
                    </div>
                    <p class="text-muted" style="font-size: 12.5px; line-height: 1.5; margin-bottom: 16px;">
                        Percentage of server dispatches enriched with customer matching parameters:
                    </p>

                    <!-- Match bars -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between font-weight-bold" style="font-size: 12.5px;">
                            <span><i class="fas fa-envelope text-muted mr-1"></i> SHA-256 Email Match</span>
                            <span class="text-primary font-mono-code">{{ $emqMetrics['email_coverage'] }}%</span>
                        </div>
                        <div class="emq-progress-bar"><div class="emq-progress-fill" style="width: {{ $emqMetrics['email_coverage'] }}%;"></div></div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between font-weight-bold" style="font-size: 12.5px;">
                            <span><i class="fas fa-phone text-muted mr-1"></i> E.164 Phone Match</span>
                            <span class="text-primary font-mono-code">{{ $emqMetrics['phone_coverage'] }}%</span>
                        </div>
                        <div class="emq-progress-bar"><div class="emq-progress-fill" style="width: {{ $emqMetrics['phone_coverage'] }}%;"></div></div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between font-weight-bold" style="font-size: 12.5px;">
                            <span><i class="fas fa-network-wired text-muted mr-1"></i> Client IP (IPv4/v6)</span>
                            <span class="text-success font-mono-code">{{ $emqMetrics['ip_coverage'] }}%</span>
                        </div>
                        <div class="emq-progress-bar"><div class="emq-progress-fill" style="width: {{ $emqMetrics['ip_coverage'] }}%; background: #10b981;"></div></div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between font-weight-bold" style="font-size: 12.5px;">
                            <span><i class="fas fa-cookie text-muted mr-1"></i> _fbp (Browser Cookie)</span>
                            <span class="text-primary font-mono-code">{{ $emqMetrics['fbp_coverage'] }}%</span>
                        </div>
                        <div class="emq-progress-bar"><div class="emq-progress-fill" style="width: {{ $emqMetrics['fbp_coverage'] }}%;"></div></div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between font-weight-bold" style="font-size: 12.5px;">
                            <span><i class="fas fa-ad text-muted mr-1"></i> _fbc (Meta Click ID)</span>
                            <span class="text-primary font-mono-code">{{ $emqMetrics['fbc_coverage'] }}%</span>
                        </div>
                        <div class="emq-progress-bar"><div class="emq-progress-fill" style="width: {{ $emqMetrics['fbc_coverage'] }}%;"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event-by-Event Breakdown Matrix Table -->
    <div class="st-table-card">
        <div class="st-table-header">
            <div>
                <h5 class="font-weight-bold text-dark mb-1" style="font-size: 17px;">
                    <i class="fas fa-layer-group text-primary mr-1"></i> Meta Events Performance Matrix
                </h5>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Granular breakdown of tracked actions across Today, This Week, and This Month
                </p>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold px-3 py-2" data-toggle="modal" data-target="#testMetaModal" style="border-radius: 8px;">
                <i class="fas fa-vial mr-1"></i> Test Event Action
            </button>
        </div>

        <div class="table-responsive">
            <table class="st-table">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Classification</th>
                        <th>Today</th>
                        <th>This Week</th>
                        <th>This Month</th>
                        <th>Lifetime Total</th>
                        <th>Delivery Rate</th>
                        <th class="text-right">Quick Test</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventMatrix as $em)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-light border p-2" style="font-size: 14px; color: #0064e0;">
                                    <i class="fas {{ $em['icon'] }}"></i>
                                </span>
                                <div>
                                    <strong class="text-dark font-weight-bold">{{ $em['name'] }}</strong>
                                    <div class="text-muted" style="font-size: 11.5px;">Priority: {{ $em['priority'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light text-secondary border px-2 py-1">{{ $em['category'] }}</span>
                        </td>
                        <td>
                            <span class="font-weight-bold text-dark font-mono-code" style="font-size: 14px;">{{ $em['today'] }}</span>
                        </td>
                        <td>
                            <span class="font-weight-bold text-dark font-mono-code" style="font-size: 14px;">{{ $em['week'] }}</span>
                        </td>
                        <td>
                            <span class="font-weight-bold text-dark font-mono-code" style="font-size: 14px;">{{ $em['month'] }}</span>
                        </td>
                        <td>
                            <span class="font-weight-bold text-primary font-mono-code" style="font-size: 14px;">{{ number_format($em['total']) }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; width: 70px; background: #e2e8f0; border-radius: 999px;">
                                    <div class="progress-bar bg-success" style="width: {{ $em['rate'] }}%;"></div>
                                </div>
                                <span class="font-weight-bold text-success font-mono-code" style="font-size: 12.5px;">{{ $em['rate'] }}%</span>
                            </div>
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold px-2 py-1" onclick="openTestModalFor('{{ $em['name'] }}')" style="border-radius: 6px; font-size: 12px;">
                                <i class="fas fa-play mr-1"></i> Fire
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Filtered Meta Audit Logs Table -->
    <div class="st-table-card">
        <div class="st-table-header">
            <div>
                <h5 class="font-weight-bold text-dark mb-1" style="font-size: 17px;">
                    <i class="fas fa-history text-primary mr-1"></i> Meta CAPI Conversion Audit Logs
                </h5>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Real-time log stream filtered for Meta Conversions API dispatches
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.server-tracking.export', ['format' => 'csv']) }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
                    <i class="fas fa-file-csv mr-1"></i> Export CSV
                </a>
                <a href="{{ route('admin.server-tracking.logs', ['provider' => 'meta_capi']) }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px; background: #0064e0;">
                    <i class="fas fa-external-link-alt mr-1"></i> Full Log Inspector
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="st-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Event</th>
                        <th>Event ID (Deduplication)</th>
                        <th>Status</th>
                        <th>HTTP</th>
                        <th>Lead / Order Ref</th>
                        <th class="text-right">Payload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="text-muted" style="font-size: 12.5px; white-space: nowrap;">
                            {{ $log->created_at ? $log->created_at->format('M d, H:i:s') : 'N/A' }}
                        </td>
                        <td>
                            <strong class="text-dark">{{ $log->event_name }}</strong>
                        </td>
                        <td>
                            <span class="code-chip">{{ $log->event_id ?: 'auto_gen' }}</span>
                        </td>
                        <td>
                            <span class="status-pill {{ $log->status === 'success' ? 'success' : 'failed' }}">
                                <i class="fas {{ $log->status === 'success' ? 'fa-check' : 'fa-times' }}"></i>
                                {{ $log->status }}
                            </span>
                        </td>
                        <td>
                            <span class="font-mono-code font-weight-bold {{ $log->http_code == 200 ? 'text-success' : 'text-danger' }}">
                                {{ $log->http_code ?: '200' }}
                            </span>
                        </td>
                        <td>
                            @if($log->lead_id)
                                <a href="{{ route('admin.server-tracking.customer-journey', ['q' => $log->lead_id]) }}" class="badge badge-primary font-mono-code text-decoration-none py-1 px-2" style="background: #0064e0; font-size: 11.5px; border-radius: 6px;" title="View Full Customer 360 Dossier & Multi-Touch Journey">
                                    <i class="fas fa-user-circle mr-1"></i> {{ $log->lead_id }}
                                </a>
                            @elseif($log->order_id)
                                <a href="{{ route('admin.server-tracking.customer-journey', ['q' => $log->order_id]) }}" class="badge badge-info font-mono-code text-decoration-none py-1 px-2" style="font-size: 11.5px; border-radius: 6px;" title="View Full Customer 360 Dossier & Multi-Touch Journey">
                                    <i class="fas fa-shopping-bag mr-1"></i> {{ $log->order_id }}
                                </a>
                            @else
                                <span class="text-muted font-mono-code" style="font-size: 12px;">—</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="viewPayload('{{ $log->id }}', @json($log->request_payload), @json($log->response_payload), '{{ $log->lead_id }}', '{{ $log->order_id }}', '{{ $log->ip_address }}')" style="border-radius: 6px; font-size: 12px;">
                                <i class="fas fa-code mr-1"></i> Inspect
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No Meta conversion logs recorded yet in database. Use the button above to fire a live test event!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($logs, 'hasPages') && $logs->hasPages())
        <div class="p-3 border-top d-flex justify-content-center">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal: Test Meta Dispatcher -->
<div class="modal fade" id="testMetaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <div class="modal-header text-white" style="background: var(--meta-gradient); padding: 20px 24px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fab fa-facebook mr-2"></i> Meta CAPI Live Test Dispatcher
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="metaTestForm">
                    @csrf
                    <input type="hidden" name="provider" value="meta_capi">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark" style="font-size: 13px;">Target Event Type</label>
                        <select name="event_name" id="testEventSelect" class="form-control" style="border-radius: 10px; height: 44px;">
                            <option value="Lead" selected>Lead (Inquiry Form Submission)</option>
                            <option value="Purchase">Purchase (Digital Product Order)</option>
                            <option value="AddToCart">AddToCart (Marketplace Cart Item)</option>
                            <option value="InitiateCheckout">InitiateCheckout (Checkout Started)</option>
                            <option value="ViewContent">ViewContent (Product Page View)</option>
                            <option value="Contact">Contact (Support / Direct Message)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark" style="font-size: 13px;">Dataset ID</label>
                        <input type="text" name="dataset_id" class="form-control font-mono-code" value="{{ $metaConfig['dataset_id'] ?? '1786172575724734' }}" readonly style="border-radius: 10px; background: #f8fafc;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark" style="font-size: 13px;">Meta Test Event Code</label>
                        <input type="text" name="test_event_code" class="form-control font-mono-code font-weight-bold" value="{{ $metaConfig['test_event_code'] ?? 'TEST54855' }}" style="border-radius: 10px; color: #0064e0;">
                        <small class="text-muted">Enter code from Meta Events Manager &gt; Test Events to view immediate live payload</small>
                    </div>

                    <div id="testResultBox" class="mt-3 p-3 d-none" style="border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; font-family: var(--st-font-mono); font-size: 12px; max-height: 200px; overflow-y: auto;"></div>

                    <button type="submit" id="btnSubmitTest" class="btn btn-meta btn-block py-2 mt-3" style="font-size: 15px;">
                        <i class="fas fa-paper-plane mr-2"></i> Send Live Test Dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: JSON Payload & User Data Inspector -->
<div class="modal fade" id="payloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 18px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);">
            <div class="modal-header text-white p-3 px-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #090d16 0%, #111c33 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-primary px-2 py-1 font-mono-code" style="background: #0064e0; font-size: 11px;">META CAPI</span>
                    <h6 class="modal-title font-weight-bold text-white mb-0" id="payloadTitle">Telemetry &amp; User Data Inspector</h6>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body p-4" style="background: #0a0f1d; color: #e2e8f0;">
                <!-- User Data Summary Dossier Card -->
                <div class="p-3 mb-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="font-weight-bold text-white small text-uppercase tracking-wider">
                            <i class="fas fa-id-card-alt text-primary mr-1"></i> Customer &amp; User Data Telemetry
                        </span>
                        <a id="payloadJourneyLink" href="#" target="_blank" class="btn btn-primary btn-sm px-3 py-1 font-weight-bold" style="font-size: 12px; border-radius: 8px; background: #0064e0;">
                            <i class="fas fa-route mr-1"></i> View in Customer 360 Journey &rarr;
                        </a>
                    </div>
                    
                    <div class="row g-2" style="font-size: 12.5px;">
                        <div class="col-md-6 mb-2">
                            <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Customer Name</div>
                            <div id="udName" class="font-weight-bold text-white font-mono-code">—</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Email Address</div>
                            <div id="udEmail" class="font-weight-bold text-info font-mono-code">—</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Phone Number</div>
                            <div id="udPhone" class="font-weight-bold text-success font-mono-code">—</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Location / IP</div>
                            <div id="udLocation" class="font-weight-bold text-warning font-mono-code">—</div>
                        </div>
                        <div class="col-12 mt-1 pt-2 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                            <div class="d-flex flex-wrap gap-3 text-muted" style="font-size: 11px;">
                                <span><strong>Reference:</strong> <span id="udRef" class="font-mono-code text-light">—</span></span>
                                <span><strong>Meta Cookie (_fbp):</strong> <span id="udFbp" class="font-mono-code text-light">—</span></span>
                                <span><strong>Click ID (_fbc):</strong> <span id="udFbc" class="font-mono-code text-light">—</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Raw JSON Accordion -->
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="small font-weight-bold text-muted text-uppercase" style="font-size: 10.5px;">
                        <i class="fas fa-code text-success mr-1"></i> Full Server-to-Server Payload JSON
                    </span>
                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size: 11px;" onclick="copyPayloadJson()">
                        <i class="fas fa-copy mr-1"></i> Copy JSON
                    </button>
                </div>
                <pre id="payloadContent" class="m-0 text-success font-mono-code p-3 rounded" style="font-size: 12px; max-height: 280px; overflow-y: auto; background: #070b14; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px;"></pre>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialize Meta Timeline Chart
    const ctx = document.getElementById('metaTimelineChart');
    if (ctx) {
        const labels = @json($chartLabels);
        const successes = @json($chartSuccess);
        const failures = @json($chartFailed);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Successful Dispatches',
                        data: successes,
                        borderColor: '#0081fb',
                        backgroundColor: 'rgba(0, 129, 251, 0.12)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0081fb',
                        pointBorderColor: '#ffffff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Failed Dispatches',
                        data: failures,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.08)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.35,
                        pointBackgroundColor: '#ef4444',
                        pointRadius: 3,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: 600 },
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: 700 },
                        bodyFont: { family: "'JetBrains Mono', monospace", size: 12 },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { family: "'JetBrains Mono', monospace", size: 11 }, precision: 0 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: 600 } }
                    }
                }
            }
        });
    }

    // 2. Test Event Form Submission
    const testForm = document.getElementById('metaTestForm');
    const resultBox = document.getElementById('testResultBox');
    const btnSubmit = document.getElementById('btnSubmitTest');

    if (testForm) {
        testForm.addEventListener('submit', function (e) {
            e.preventDefault();
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Disptaching to Meta CAPI...';
            resultBox.classList.add('d-none');

            const formData = new FormData(testForm);
            fetch("{{ route('admin.server-tracking.test') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Send Live Test Dispatch';
                resultBox.classList.remove('d-none');

                if (data.success) {
                    resultBox.innerHTML = '<div class="text-success font-weight-bold mb-1"><i class="fas fa-check-circle"></i> Success! Event accepted by Meta Graph API.</div>' +
                        '<div><strong>Event:</strong> ' + data.event_name + '</div>' +
                        '<div><strong>Event ID:</strong> ' + (data.result.event_id || 'N/A') + '</div>' +
                        '<div><strong>HTTP Code:</strong> ' + (data.result.http_code || 200) + '</div>' +
                        '<div><strong>Latency:</strong> ' + (data.result.latency_ms || 120) + 'ms</div>';
                } else {
                    resultBox.innerHTML = '<div class="text-danger font-weight-bold mb-1"><i class="fas fa-times-circle"></i> Meta Dispatch Notice:</div>' +
                        '<div class="text-muted">' + (data.result.message || 'Check access token or test code.') + '</div>';
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Send Live Test Dispatch';
                resultBox.classList.remove('d-none');
                resultBox.innerHTML = '<div class="text-danger font-weight-bold"><i class="fas fa-exclamation-triangle"></i> Network Error sending dispatch.</div>';
            });
        });
    }
});

function openTestModalFor(eventName) {
    const sel = document.getElementById('testEventSelect');
    if (sel) {
        sel.value = eventName;
    }
    $('#testMetaModal').modal('show');
}

function viewPayload(id, req, res, leadId, orderId, ipAddress) {
    document.getElementById('payloadTitle').innerText = 'Telemetry Telemetry [Log #' + id + ']';
    const payload = {
        request_payload: req,
        response_payload: res
    };
    document.getElementById('payloadContent').innerText = JSON.stringify(payload, null, 2);

    const ref = leadId || orderId || '—';
    const refQuery = leadId || orderId || '';
    document.getElementById('udRef').innerText = ref;

    const journeyUrl = "{{ route('admin.server-tracking.customer-journey') }}" + (refQuery ? ('?q=' + encodeURIComponent(refQuery)) : '');
    const journeyLink = document.getElementById('payloadJourneyLink');
    if (journeyLink) {
        journeyLink.href = journeyUrl;
    }

    let userData = {};
    if (req && Array.isArray(req.data) && req.data[0] && req.data[0].user_data) {
        userData = req.data[0].user_data;
    } else if (req && req.user_data) {
        userData = req.user_data;
    }

    const clientIp = userData.client_ip_address || ipAddress || '—';
    const country = userData.country || (Array.isArray(userData.country) ? userData.country[0] : '');
    const city = userData.ct || (Array.isArray(userData.ct) ? userData.ct[0] : '');
    let locStr = clientIp;
    if (city || country) {
        locStr += ' (' + [city, country].filter(Boolean).join(', ') + ')';
    }
    document.getElementById('udLocation').innerText = locStr;

    let emailDisplay = '—';
    if (userData.email) {
        emailDisplay = userData.email;
    } else if (userData.em) {
        const emVal = Array.isArray(userData.em) ? userData.em[0] : userData.em;
        emailDisplay = emVal.length === 64 ? (emVal.substring(0, 10) + '•••••••• [SHA-256 Hashed]') : emVal;
    }
    document.getElementById('udEmail').innerText = emailDisplay;

    let phoneDisplay = '—';
    if (userData.phone) {
        phoneDisplay = userData.phone;
    } else if (userData.ph) {
        const phVal = Array.isArray(userData.ph) ? userData.ph[0] : userData.ph;
        phoneDisplay = phVal.length === 64 ? (phVal.substring(0, 8) + '•••••••• [E.164 Hashed]') : phVal;
    }
    document.getElementById('udPhone').innerText = phoneDisplay;

    let nameDisplay = '—';
    if (userData.name) {
        nameDisplay = userData.name;
    } else if (userData.fn || userData.ln) {
        const fn = Array.isArray(userData.fn) ? userData.fn[0] : (userData.fn || '');
        const ln = Array.isArray(userData.ln) ? userData.ln[0] : (userData.ln || '');
        nameDisplay = fn.length === 64 ? ('Verified User (' + ref + ')') : ([fn, ln].filter(Boolean).join(' ') || ('Customer ' + ref));
    } else if (ref && ref !== '—') {
        nameDisplay = 'Customer ' + ref;
    }
    document.getElementById('udName').innerText = nameDisplay;

    document.getElementById('udFbp').innerText = userData.fbp || userData._fbp || '—';
    document.getElementById('udFbc').innerText = userData.fbc || userData._fbc || '—';

    $('#payloadModal').modal('show');
}

function copyPayloadJson() {
    const text = document.getElementById('payloadContent').innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Payload JSON copied to clipboard!');
    });
}
</script>
@endsection
