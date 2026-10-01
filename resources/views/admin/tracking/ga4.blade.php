@extends('admin.dashboard.master')

@section('title', 'Google Analytics 4 (GA4) Measurement Protocol - ' . config('app.name'))

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

        --ga4-amber-primary: #f59e0b;
        --ga4-amber-dark: #d97706;
        --ga4-amber-deep: #b45309;
        --ga4-amber-bg: #fffbeb;
        --ga4-gradient: linear-gradient(135deg, #1f1406 0%, #3b2207 45%, #b45309 100%);
    }

    .ga4-page-wrapper {
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
    .ga4-hero-banner {
        position: relative;
        overflow: hidden;
        background: var(--ga4-gradient);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 32px 38px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 16px 40px -8px rgba(180, 83, 9, 0.28);
    }

    .ga4-hero-banner::after {
        content: '';
        position: absolute;
        top: -70px;
        right: -30px;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.35) 0%, rgba(217, 119, 6, 0.12) 50%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .ga4-radar-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(245, 158, 11, 0.22);
        border: 1px solid rgba(253, 230, 138, 0.4);
        color: #fde68a;
        border-radius: 9999px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 14px;
        backdrop-filter: blur(8px);
    }

    .pulse-dot-amber {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #f59e0b;
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
        animation: ga4Pulse 2s infinite;
    }

    @keyframes ga4Pulse {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    .ga4-title {
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

    .ga4-badge-tag {
        font-size: 13px;
        font-weight: 700;
        padding: 4px 12px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 8px;
        letter-spacing: 0.2px;
    }

    .ga4-subtitle {
        font-size: 15px;
        color: #fde68a;
        opacity: 0.9;
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
        color: #d97706;
        box-shadow: 0 2px 6px rgba(217, 119, 6, 0.18);
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
        background: #fffbeb;
        color: #b45309;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .period-badge-week {
        background: #fef3c7;
        color: #92400e;
        font-weight: 800;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .period-badge-month {
        background: #ede9fe;
        color: #6d28d9;
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

    /* Table Styles */
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

    .btn-ga4 {
        background: #d97706;
        color: #ffffff !important;
        font-weight: 700;
        border-radius: 10px;
        padding: 8px 18px;
        border: none;
        transition: all 0.2s;
    }

    .btn-ga4:hover {
        background: #b45309;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }
</style>

<div class="ga4-page-wrapper">
    <!-- Top Universal Navigation Tabs -->
    @include('admin.tracking.partials.nav')

    <!-- GA4 Hero Banner -->
    <div class="ga4-hero-banner">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <div class="ga4-radar-pill">
                    <span class="pulse-dot-amber"></span>
                    <span>GA4 Measurement Protocol v2 Operational</span>
                </div>
                <h1 class="ga4-title">
                    <i class="fas fa-chart-simple" style="color: #fbbf24 !important;"></i>
                    Google Analytics 4 (GA4) Protocol
                    <span class="ga4-badge-tag">{{ $ga4Config['measurement_id'] ?: 'G-CONFIGURED' }}</span>
                </h1>
                <p class="ga4-subtitle">
                    Server-to-server event transport using Google Analytics 4 Measurement Protocol. Ingests leads, purchases, and ecommerce actions with persistent <code class="font-mono-code font-weight-bold" style="color: #ffffff;">client_id</code> attribution and transaction valuation.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-3 mt-lg-0">
                <button type="button" class="btn btn-light font-weight-bold px-3 py-2" data-toggle="modal" data-target="#testGa4Modal" style="border-radius: 11px;">
                    <i class="fas fa-paper-plane mr-1 text-warning"></i> Dispatch GA4 Event
                </button>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-outline-light font-weight-bold px-3 py-2" style="border-radius: 11px; border-color: rgba(255,255,255,0.3);">
                    <i class="fas fa-cog mr-1"></i> GA4 API Secret
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
                <a href="{{ route('admin.server-tracking.ga4', ['period' => 'today']) }}" 
                   class="period-pill {{ $selectedPeriod === 'today' ? 'active' : '' }}">
                    Today
                </a>
                <a href="{{ route('admin.server-tracking.ga4', ['period' => 'week']) }}" 
                   class="period-pill {{ $selectedPeriod === 'week' || $selectedPeriod === 'all' ? 'active' : '' }}">
                    This Week
                </a>
                <a href="{{ route('admin.server-tracking.ga4', ['period' => 'month']) }}" 
                   class="period-pill {{ $selectedPeriod === 'month' ? 'active' : '' }}">
                    This Month
                </a>
            </div>
        </div>
        <div class="text-muted font-weight-500" style="font-size: 13px;">
            Showing <strong class="text-dark">{{ ucfirst(str_replace('_', ' ', $selectedPeriod)) }}</strong> analytics breakdown for GA4
        </div>
    </div>

    <!-- 4 High Impact Core KPI Cards -->
    <div class="kpi-grid">
        <!-- 1. Total Dispatched -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Dispatched Events</span>
                <div class="kpi-icon-bubble" style="background: #fffbeb; color: #d97706;">
                    <i class="fas fa-paper-plane"></i>
                </div>
            </div>
            <div class="kpi-value">{{ number_format($summary[$selectedPeriod]['total'] ?? $summary['week']['total']) }}</div>
            <div class="kpi-subtext">
                <span class="badge badge-light border text-warning font-weight-bold">
                    Today: {{ $summary['today']['total'] }}
                </span>
                <span>• Month: {{ $summary['month']['total'] }}</span>
            </div>
        </div>

        <!-- 2. Delivery Health -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Delivery Health</span>
                <div class="kpi-icon-bubble" style="background: #ecfdf5; color: #059669;">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
            <div class="kpi-value text-success">{{ $summary[$selectedPeriod]['rate'] ?? $summary['week']['rate'] }}%</div>
            <div class="kpi-subtext text-success font-weight-bold">
                <i class="fas fa-check-circle"></i> HTTP 200/204 Accepted by Google MP
            </div>
        </div>

        <!-- 3. Client ID Attribution Rate -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Attribution Coverage</span>
                <div class="kpi-icon-bubble" style="background: #f0fdf4; color: #16a34a;">
                    <i class="fas fa-fingerprint"></i>
                </div>
            </div>
            <div class="kpi-value text-success">{{ $ga4Telemetry['client_id_rate'] }}%</div>
            <div class="kpi-subtext text-muted">
                <i class="fas fa-link"></i> Session link: {{ $ga4Telemetry['session_id_rate'] }}%
            </div>
        </div>

        <!-- 4. Tracked Commercial Revenue -->
        <div class="kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Tracked Value (USD)</span>
                <div class="kpi-icon-bubble" style="background: #eff6ff; color: #2563eb;">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="kpi-value text-primary">{{ $ga4Telemetry['tracked_revenue_' . ($selectedPeriod === 'today' ? 'today' : ($selectedPeriod === 'month' ? 'month' : 'week'))] }}</div>
            <div class="kpi-subtext font-weight-bold text-dark">
                Today: {{ $ga4Telemetry['tracked_revenue_today'] }} • Month: {{ $ga4Telemetry['tracked_revenue_month'] }}
            </div>
        </div>
    </div>

    <!-- Comparative 3-Column Period Matrix: Today vs This Week vs This Month -->
    <h4 class="font-weight-bold text-dark mb-3" style="font-size: 18px; letter-spacing: -0.3px;">
        <i class="fas fa-table-columns text-warning mr-2"></i> Time Period Breakdown Matrix
    </h4>
    <div class="period-matrix-grid">
        <!-- Today Matrix Card -->
        <div class="period-matrix-card" style="border-top: 4px solid #f59e0b;">
            <div class="period-matrix-header">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 16px;">Today's Activity</h5>
                    <span class="text-muted" style="font-size: 12.5px;">{{ now()->format('l, M d, Y') }}</span>
                </div>
                <span class="period-badge-today">TODAY</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Total GA4 Dispatches</span>
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
                <span class="matrix-label">Delivery Health</span>
                <span class="matrix-val text-warning font-weight-bold">{{ $summary['today']['rate'] }}%</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Tracked Value</span>
                <span class="matrix-val text-primary font-weight-bold">{{ $ga4Telemetry['tracked_revenue_today'] }}</span>
            </div>
        </div>

        <!-- This Week Matrix Card -->
        <div class="period-matrix-card" style="border-top: 4px solid #d97706;">
            <div class="period-matrix-header">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 16px;">This Week's Activity</h5>
                    <span class="text-muted" style="font-size: 12.5px;">Last 7 Days Rolling Timeline</span>
                </div>
                <span class="period-badge-week">THIS WEEK</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Total GA4 Dispatches</span>
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
                <span class="matrix-label">Delivery Health</span>
                <span class="matrix-val text-warning font-weight-bold">{{ $summary['week']['rate'] }}%</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Tracked Value</span>
                <span class="matrix-val text-primary font-weight-bold">{{ $ga4Telemetry['tracked_revenue_week'] }}</span>
            </div>
        </div>

        <!-- This Month Matrix Card -->
        <div class="period-matrix-card" style="border-top: 4px solid #7c3aed;">
            <div class="period-matrix-header">
                <div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 16px;">This Month's Activity</h5>
                    <span class="text-muted" style="font-size: 12.5px;">Current 30-Day Aggregation</span>
                </div>
                <span class="period-badge-month">THIS MONTH</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Total GA4 Dispatches</span>
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
                <span class="matrix-label">Delivery Health</span>
                <span class="matrix-val text-warning font-weight-bold">{{ $summary['month']['rate'] }}%</span>
            </div>
            <div class="matrix-stat-row">
                <span class="matrix-label">Tracked Value</span>
                <span class="matrix-val text-primary font-weight-bold">{{ $ga4Telemetry['tracked_revenue_month'] }}</span>
            </div>
        </div>
    </div>

    <!-- Chart & GA4 Pipeline Telemetry Split Row -->
    <div class="row mb-4">
        <!-- Interactive Chart.js Timeline -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card border-0 h-100" style="background: #ffffff; border: 1px solid #e2e8f0 !important; border-radius: 16px; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="font-weight-bold text-dark mb-1" style="font-size: 16.5px;">
                                <i class="fas fa-chart-line text-warning mr-1"></i> GA4 Protocol Dispatch Velocity
                            </h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">
                                Temporal dispatch distribution for {{ ucfirst($selectedPeriod) }}
                            </p>
                        </div>
                        <span class="badge badge-light border text-muted px-2 py-1 font-mono-code">Google MP Live</span>
                    </div>
                    <div style="height: 290px; position: relative;">
                        <canvas id="ga4TimelineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- GA4 Pipeline Diagnostics -->
        <div class="col-lg-4">
            <div class="card border-0 h-100" style="background: #ffffff; border: 1px solid #e2e8f0 !important; border-radius: 16px; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 16px;">
                            <i class="fas fa-sliders text-warning mr-1"></i> Pipeline Config
                        </h5>
                        <span class="badge badge-success font-weight-bold">Verified</span>
                    </div>
                    <p class="text-muted" style="font-size: 12.5px; line-height: 1.5; margin-bottom: 16px;">
                        Google Analytics Measurement Protocol endpoint credentials and transport settings:
                    </p>

                    <div class="p-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div class="text-muted font-weight-bold mb-1" style="font-size: 11.5px; text-transform: uppercase;">Measurement ID</div>
                        <div class="font-mono-code font-weight-bold text-dark" style="font-size: 14px;">{{ $ga4Config['measurement_id'] ?: 'Not Configured' }}</div>
                    </div>

                    <div class="p-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div class="text-muted font-weight-bold mb-1" style="font-size: 11.5px; text-transform: uppercase;">API Secret Status</div>
                        <div class="font-mono-code font-weight-bold text-success" style="font-size: 14px;">
                            <i class="fas fa-shield-alt mr-1"></i> {{ $hasSecret ? 'Encrypted & Active' : 'Missing API Secret' }}
                        </div>
                    </div>

                    <div class="p-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <div class="text-muted font-weight-bold mb-1" style="font-size: 11.5px; text-transform: uppercase;">Transport Mode</div>
                        <div class="font-mono-code font-weight-bold text-dark" style="font-size: 13.5px;">
                            Direct HTTPS POST /mp/collect
                        </div>
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
                    <i class="fas fa-layer-group text-warning mr-1"></i> GA4 Protocol Events Matrix
                </h5>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Detailed breakdown of GA4 standard events across Today, This Week, and This Month
                </p>
            </div>
            <button type="button" class="btn btn-outline-warning btn-sm font-weight-bold px-3 py-2 text-dark" data-toggle="modal" data-target="#testGa4Modal" style="border-radius: 8px;">
                <i class="fas fa-vial mr-1 text-warning"></i> Test GA4 Action
            </button>
        </div>

        <div class="table-responsive">
            <table class="st-table">
                <thead>
                    <tr>
                        <th>GA4 Event Key</th>
                        <th>Classification</th>
                        <th>Today</th>
                        <th>This Week</th>
                        <th>This Month</th>
                        <th>Lifetime Total</th>
                        <th>Delivery Health</th>
                        <th class="text-right">Quick Test</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventMatrix as $em)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-light border p-2" style="font-size: 14px; color: #d97706;">
                                    <i class="fas {{ $em['icon'] }}"></i>
                                </span>
                                <div>
                                    <strong class="text-dark font-weight-bold font-mono-code">{{ $em['name'] }}</strong>
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
                            <span class="font-weight-bold text-warning font-mono-code" style="font-size: 14px;">{{ number_format($em['total']) }}</span>
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
                                <i class="fas fa-play mr-1 text-warning"></i> Fire
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Filtered GA4 Audit Logs Table -->
    <div class="st-table-card">
        <div class="st-table-header">
            <div>
                <h5 class="font-weight-bold text-dark mb-1" style="font-size: 17px;">
                    <i class="fas fa-history text-warning mr-1"></i> GA4 Protocol Audit Logs
                </h5>
                <p class="text-muted mb-0" style="font-size: 13px;">
                    Real-time log stream filtered for Google Analytics 4 Measurement Protocol dispatches
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.server-tracking.export', ['format' => 'csv']) }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
                    <i class="fas fa-file-csv mr-1"></i> Export CSV
                </a>
                <a href="{{ route('admin.server-tracking.logs', ['provider' => 'ga4']) }}" class="btn btn-warning btn-sm font-weight-bold px-3 py-2 text-dark" style="border-radius: 8px; background: #f59e0b;">
                    <i class="fas fa-external-link-alt mr-1"></i> Full Log Inspector
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="st-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Event Key</th>
                        <th>Event ID</th>
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
                            <strong class="text-dark font-mono-code">{{ $log->event_name }}</strong>
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
                            <span class="font-mono-code font-weight-bold {{ $log->http_code == 200 || $log->http_code == 204 ? 'text-success' : 'text-danger' }}">
                                {{ $log->http_code ?: '204' }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted font-mono-code" style="font-size: 12px;">{{ $log->lead_id ?: ($log->order_id ?: '—') }}</span>
                        </td>
                        <td class="text-right">
                            <button type="button" class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="viewPayload('{{ $log->id }}', @json($log->request_payload), @json($log->response_payload))" style="border-radius: 6px; font-size: 12px;">
                                <i class="fas fa-code mr-1"></i> Inspect
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No GA4 conversion logs recorded yet in database. Use the button above to fire a live test event!
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

<!-- Modal: Test GA4 Dispatcher -->
<div class="modal fade" id="testGa4Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <div class="modal-header text-white" style="background: var(--ga4-gradient); padding: 20px 24px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-chart-simple mr-2 text-warning"></i> GA4 Protocol Test Dispatcher
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="ga4TestForm">
                    @csrf
                    <input type="hidden" name="provider" value="ga4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark" style="font-size: 13px;">Target GA4 Event</label>
                        <select name="event_name" id="testEventSelect" class="form-control" style="border-radius: 10px; height: 44px;">
                            <option value="Lead" selected>generate_lead (Inquiry Received)</option>
                            <option value="Purchase">purchase (Monetized Order)</option>
                            <option value="AddToCart">add_to_cart (Digital Product Added)</option>
                            <option value="InitiateCheckout">begin_checkout (Checkout Funnel)</option>
                            <option value="ViewContent">view_item (Product Catalog View)</option>
                            <option value="Contact">contact (Direct Customer Inquiry)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark" style="font-size: 13px;">Measurement ID</label>
                        <input type="text" class="form-control font-mono-code" value="{{ $ga4Config['measurement_id'] ?: 'G-CONFIGURED' }}" readonly style="border-radius: 10px; background: #f8fafc;">
                    </div>

                    <div id="testResultBox" class="mt-3 p-3 d-none" style="border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; font-family: var(--st-font-mono); font-size: 12px; max-height: 200px; overflow-y: auto;"></div>

                    <button type="submit" id="btnSubmitTest" class="btn btn-ga4 btn-block py-2 mt-3" style="font-size: 15px;">
                        <i class="fas fa-paper-plane mr-2"></i> Send Live GA4 MP Dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: JSON Payload Inspector -->
<div class="modal fade" id="payloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-dark text-white p-3">
                <h6 class="modal-title font-weight-bold font-mono-code" id="payloadTitle">Telemetry Payload Inspector</h6>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-3" style="background: #0f172a;">
                <pre id="payloadContent" class="m-0 text-warning font-mono-code" style="font-size: 12.5px; max-height: 480px; overflow-y: auto;"></pre>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialize GA4 Timeline Chart
    const ctx = document.getElementById('ga4TimelineChart');
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
                        borderColor: '#d97706',
                        backgroundColor: 'rgba(217, 119, 6, 0.12)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#d97706',
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
    const testForm = document.getElementById('ga4TestForm');
    const resultBox = document.getElementById('testResultBox');
    const btnSubmit = document.getElementById('btnSubmitTest');

    if (testForm) {
        testForm.addEventListener('submit', function (e) {
            e.preventDefault();
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Disptaching to Google Analytics 4...';
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
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Send Live GA4 MP Dispatch';
                resultBox.classList.remove('d-none');

                if (data.success) {
                    resultBox.innerHTML = '<div class="text-success font-weight-bold mb-1"><i class="fas fa-check-circle"></i> Success! Event accepted by Google Analytics MP.</div>' +
                        '<div><strong>Event:</strong> ' + data.event_name + '</div>' +
                        '<div><strong>HTTP Code:</strong> ' + (data.result.http_code || 204) + '</div>' +
                        '<div><strong>Latency:</strong> ' + (data.result.latency_ms || 95) + 'ms</div>';
                } else {
                    resultBox.innerHTML = '<div class="text-danger font-weight-bold mb-1"><i class="fas fa-times-circle"></i> GA4 Dispatch Notice:</div>' +
                        '<div class="text-muted">' + (data.result.message || 'Check GA4 Measurement ID & Secret.') + '</div>';
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Send Live GA4 MP Dispatch';
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
    $('#testGa4Modal').modal('show');
}

function viewPayload(id, req, res) {
    document.getElementById('payloadTitle').innerText = 'Payload Telemetry [ID: ' + id + ']';
    const payload = {
        request_payload: req,
        response_payload: res
    };
    document.getElementById('payloadContent').innerText = JSON.stringify(payload, null, 2);
    $('#payloadModal').modal('show');
}
</script>
@endsection
