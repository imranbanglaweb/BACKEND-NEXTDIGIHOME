@extends('admin.dashboard.master')

@section('title', 'NextDigiHome — Agency Command Center')

@php
    $user = $user ?? Auth::user();
    $monthLabels = $monthLabels ?? [];
    $monthlyData = $monthlyData ?? [];
    $deptData = collect($deptData ?? []);
    $topUsers = collect($topUsers ?? []);
    $latestPurchases = collect($latestPurchases ?? []);
    $latestProducts = collect($latestProducts ?? []);
    $timeline = collect($timeline ?? []);
    $newInquiries = $newInquiries ?? 0;
    $totalInquiries = $totalInquiries ?? 0;
    $recentInquiries = collect($recentInquiries ?? []);
    $chartMonthLabels = $monthLabels ?: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $chartMonthlyData = $monthlyData ?: [0,0,0,0,0,0,0,0,0,0,0,0];
    $chartCategoryRows = $deptData->values();
    $maxMonthlyValue = max($chartMonthlyData ?: [1]);
    $maxCategoryValue = max($chartCategoryRows->pluck('value')->all() ?: [1]);
    $sbLogo = $dynamicLogoUrl ?? admin_logo_url();
    $adminTitle = !empty($settings->admin_title) ? $settings->admin_title : (!empty($settings->site_title) ? $settings->site_title : 'NextDigiHome');
@endphp

@section('main_content')
@include('admin.partials.premium-ui')

<!-- Preconnect & Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Chart.js CDN for interactive charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<style>
    /* ==========================================================================
       NEXTDIGIHOME EXECUTIVE COMMAND CENTER STYLES
       ========================================================================== */
    .dashboard-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        background: #f8fafc !important;
        color: #1e293b !important;
    }

    /* Executive Hero Banner */
    .ndh-hero-banner {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #090e1a 0%, #0f172a 45%, #1e1b4b 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px 36px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 16px 40px -10px rgba(15, 23, 42, 0.4);
    }

    .ndh-hero-banner::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -40px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(0, 212, 170, 0.18) 0%, rgba(56, 189, 248, 0.12) 40%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .ndh-hero-top {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .ndh-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
        background: rgba(0, 212, 170, 0.12);
        color: #00d4aa;
        border: 1px solid rgba(0, 212, 170, 0.3);
    }

    .ndh-hero-badge .pulse-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #00d4aa;
        box-shadow: 0 0 8px #00d4aa;
        animation: ndhPulse 1.8s infinite;
    }

    @keyframes ndhPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.5; }
    }

    .ndh-hero-title {
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -0.6px;
        margin: 0 0 8px 0;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ndh-hero-subtitle {
        font-size: 14.5px;
        color: rgba(255, 255, 255, 0.72);
        margin: 0;
        max-width: 650px;
        line-height: 1.55;
    }

    .ndh-hero-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .ndh-btn-glow {
        background: linear-gradient(135deg, #00d4aa 0%, #0284c7 100%);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 13.5px;
        padding: 9px 18px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(0, 212, 170, 0.35);
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .ndh-btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 212, 170, 0.5);
        color: #ffffff !important;
    }

    .ndh-btn-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #ffffff !important;
        font-weight: 600;
        font-size: 13.5px;
        padding: 9px 16px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .ndh-btn-glass:hover {
        background: rgba(255, 255, 255, 0.18);
        transform: translateY(-2px);
        color: #ffffff !important;
    }

    /* Sub Navigation Bar */
    .ndh-subnav {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        padding: 8px 10px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        margin-bottom: 22px;
        overflow-x: auto;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .ndh-subnav-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none !important;
        white-space: nowrap;
        transition: all 0.15s ease;
    }

    .ndh-subnav-link:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .ndh-subnav-link.active {
        color: #0284c7;
        background: #eff6ff;
        font-weight: 700;
    }

    .ndh-subnav-badge {
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 999px;
        background: #ef4444;
        color: #ffffff;
        font-weight: 700;
    }

    /* KPI Cards Grid */
    .ndh-kpi-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 1380px) {
        .ndh-kpi-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media (max-width: 900px) {
        .ndh-kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 600px) {
        .ndh-kpi-grid { grid-template-columns: 1fr; }
    }

    .ndh-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 140px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .ndh-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }

    .ndh-kpi-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .ndh-kpi-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .ndh-kpi-icon.purple { background: #f5f3ff; color: #7c3aed; }
    .ndh-kpi-icon.blue   { background: #eff6ff; color: #2563eb; }
    .ndh-kpi-icon.green  { background: #ecfdf5; color: #059669; }
    .ndh-kpi-icon.amber  { background: #fffbeb; color: #d97706; }
    .ndh-kpi-icon.pink   { background: #fdf2f8; color: #db2777; }

    .ndh-kpi-tag {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .ndh-kpi-tag.tag-new { background: #fee2e2; color: #b91c1c; }
    .ndh-kpi-tag.tag-blue { background: #dbeafe; color: #1e40af; }
    .ndh-kpi-tag.tag-green { background: #dcfce7; color: #15803d; }
    .ndh-kpi-tag.tag-amber { background: #fef3c7; color: #b45309; }
    .ndh-kpi-tag.tag-pink { background: #fce7f3; color: #9d174d; }

    .ndh-kpi-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .ndh-kpi-value {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.6px;
        line-height: 1.1;
    }

    .ndh-kpi-sub {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 6px;
        font-weight: 500;
    }

    /* Cards & Grids */
    .ndh-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .ndh-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 10px;
    }

    .ndh-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ndh-card-subtitle {
        font-size: 12.5px;
        color: #64748b;
        margin: 2px 0 0 0;
    }

    /* Category Mix Bars */
    .ndh-cat-row {
        margin-bottom: 14px;
    }

    .ndh-cat-head {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .ndh-cat-track {
        height: 8px;
        background: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
    }

    .ndh-cat-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #00d4aa 0%, #0284c7 100%);
    }

    /* Leaderboard & Tables */
    .ndh-rank-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 14px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: background 0.15s ease;
    }

    .ndh-rank-row:hover {
        background: #f1f5f9;
    }

    .ndh-rank-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .ndh-rank-badge {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .ndh-rank-badge.gold { background: #fef3c7; color: #b45309; }
    .ndh-rank-badge.silver { background: #f1f5f9; color: #475569; }
    .ndh-rank-badge.bronze { background: #ffedd5; color: #9a3412; }
    .ndh-rank-badge.plain { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

    .ndh-rank-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ndh-rank-sales {
        font-size: 12.5px;
        font-weight: 700;
        color: #0284c7;
        background: #eff6ff;
        padding: 3px 9px;
        border-radius: 6px;
        white-space: nowrap;
    }

    /* Inquiries Table Overrides */
    .ndh-table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .ndh-table-custom th {
        background: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .ndh-table-custom td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
    }

    .ndh-table-custom tr:hover td {
        background: #fafafa;
    }

    .client-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    /* Quick Launchpad */
    .ndh-launchpad-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    @media (max-width: 900px) {
        .ndh-launchpad-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 600px) {
        .ndh-launchpad-grid { grid-template-columns: 1fr; }
    }

    .ndh-launch-item {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        color: #1e293b;
        transition: all 0.15s ease;
    }

    .ndh-launch-item:hover {
        background: #0f172a;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
    }

    .ndh-launch-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #eff6ff;
        color: #0284c7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        transition: all 0.15s ease;
    }

    .ndh-launch-item:hover .ndh-launch-icon {
        background: rgba(255, 255, 255, 0.15);
        color: #00d4aa;
    }

    .ndh-launch-title {
        font-size: 13.5px;
        font-weight: 700;
        line-height: 1.2;
    }

    .ndh-launch-sub {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .ndh-launch-item:hover .ndh-launch-sub {
        color: rgba(255, 255, 255, 0.65);
    }

    /* System Timeline */
    .ndh-timeline {
        display: grid;
        gap: 14px;
    }

    .ndh-timeline-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .ndh-timeline-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0284c7;
        box-shadow: 0 0 0 4px #eff6ff;
        margin-top: 6px;
        flex-shrink: 0;
    }

    .ndh-timeline-text {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.4;
    }

    .ndh-timeline-time {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 2px;
    }
</style>

<section role="main" class="content-body premium-page dashboard-page">
    <div class="container-fluid">

        <!-- EXECUTIVE HERO BANNER -->
        <div class="ndh-hero-banner">
            <div class="ndh-hero-top">
                <span class="ndh-hero-badge">
                    <span class="pulse-dot"></span>
                    <span>System Operational</span>
                </span>
                <span class="ndh-hero-badge" style="background:rgba(56, 189, 248, 0.12); color:#38bdf8; border-color:rgba(56, 189, 248, 0.3);">
                    <i class="fas fa-bolt"></i> NextDigiHome Enterprise
                </span>
                @if($newInquiries > 0)
                    <span class="ndh-hero-badge" style="background:rgba(239, 68, 68, 0.15); color:#fca5a5; border-color:rgba(239, 68, 68, 0.35);">
                        <i class="fas fa-bell"></i> {{ $newInquiries }} New Inquiries Awaiting Response
                    </span>
                @endif
            </div>

            <h1 class="ndh-hero-title">
                Welcome back, {{ $user->name }}
            </h1>
            <p class="ndh-hero-subtitle">
                Overview of {{ $adminTitle }} digital agency platform — monitor incoming client inquiries, product marketplace growth, server telemetry, and revenue performance in real-time.
            </p>

            <div class="ndh-hero-actions">
                <a href="{{ route('admin.products.create') }}" class="ndh-btn-glow">
                    <i class="fas fa-plus"></i><span>Add New Product</span>
                </a>
                <a href="{{ route('inquiries.index') }}" class="ndh-btn-glass">
                    <i class="fas fa-paper-plane"></i><span>Project Leads ({{ $totalInquiries }})</span>
                </a>
                <a href="{{ route('tracking.dashboard') }}" class="ndh-btn-glass">
                    <i class="fas fa-server"></i><span>Server Tracking & CAPI</span>
                </a>
                <a href="{{ url('/') }}" target="_blank" class="ndh-btn-glass">
                    <i class="fas fa-external-link-alt"></i><span>View Storefront</span>
                </a>
                <button type="button" onclick="window.location.reload()" class="ndh-btn-glass" title="Refresh Live Data">
                    <i class="fas fa-sync-alt"></i><span>Refresh</span>
                </button>
            </div>
        </div>

        <!-- FAST ACCESS SUB-NAVIGATION -->
        <div class="ndh-subnav">
            <a href="{{ route('admin.dashboard') }}" class="ndh-subnav-link active">
                <i class="fas fa-th-large"></i><span>Overview</span>
            </a>
            <a href="{{ route('inquiries.index') }}" class="ndh-subnav-link">
                <i class="fas fa-paper-plane"></i><span>Project Leads</span>
                @if($newInquiries > 0)<span class="ndh-subnav-badge">{{ $newInquiries }}</span>@endif
            </a>
            <a href="{{ route('admin.products.index') }}" class="ndh-subnav-link">
                <i class="fas fa-box"></i><span>Products</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="ndh-subnav-link">
                <i class="fas fa-shopping-cart"></i><span>Orders</span>
            </a>
            <a href="{{ route('tracking.dashboard') }}" class="ndh-subnav-link">
                <i class="fas fa-bolt"></i><span>Server Tracking & CAPI</span>
            </a>
            <a href="{{ route('admin.pages.index') }}" class="ndh-subnav-link">
                <i class="fas fa-file-alt"></i><span>Content Pages</span>
            </a>
            <a href="{{ route('admin.customers.index') }}" class="ndh-subnav-link">
                <i class="fas fa-users"></i><span>Customers</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="ndh-subnav-link">
                <i class="fas fa-chart-line"></i><span>Reports</span>
            </a>
            <a href="{{ route('admin.settings.general') }}" class="ndh-subnav-link">
                <i class="fas fa-cog"></i><span>Settings</span>
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 5-COLUMN EXECUTIVE METRICS -->
        <div class="ndh-kpi-grid">
            <!-- 1. Project Inquiries -->
            <a href="{{ route('inquiries.index') }}" class="ndh-kpi-card">
                <div>
                    <div class="ndh-kpi-top">
                        <div class="ndh-kpi-icon purple"><i class="fas fa-paper-plane"></i></div>
                        <span class="ndh-kpi-tag tag-new">{{ $newInquiries }} New</span>
                    </div>
                    <div class="ndh-kpi-label">Project Leads</div>
                    <div class="ndh-kpi-value">{{ number_format($totalInquiries) }}</div>
                </div>
                <div class="ndh-kpi-sub">
                    <span class="text-purple fw-bold">{{ $newInquiries }}</span> awaiting consultation
                </div>
            </a>

            <!-- 2. Catalog Products -->
            <a href="{{ route('admin.products.index') }}" class="ndh-kpi-card">
                <div>
                    <div class="ndh-kpi-top">
                        <div class="ndh-kpi-icon blue"><i class="fas fa-box"></i></div>
                        <span class="ndh-kpi-tag tag-blue">{{ number_format($activeProducts ?? 0) }} Active</span>
                    </div>
                    <div class="ndh-kpi-label">Total Catalog</div>
                    <div class="ndh-kpi-value">{{ number_format($totalProducts ?? 0) }}</div>
                </div>
                <div class="ndh-kpi-sub">
                    <span class="text-primary fw-bold">{{ $featuredProducts ?? 0 }}</span> featured in store
                </div>
            </a>

            <!-- 3. Completed Purchases -->
            <a href="{{ route('admin.orders.index') }}" class="ndh-kpi-card">
                <div>
                    <div class="ndh-kpi-top">
                        <div class="ndh-kpi-icon green"><i class="fas fa-shopping-bag"></i></div>
                        <span class="ndh-kpi-tag tag-green">Orders</span>
                    </div>
                    <div class="ndh-kpi-label">Purchases</div>
                    <div class="ndh-kpi-value">{{ number_format($totalPurchases ?? 0) }}</div>
                </div>
                <div class="ndh-kpi-sub">
                    <span class="text-success fw-bold"><i class="fas fa-check"></i> 100%</span> digital fulfillment
                </div>
            </a>

            <!-- 4. Marketplace Revenue -->
            <a href="{{ route('admin.reports.revenue') }}" class="ndh-kpi-card">
                <div>
                    <div class="ndh-kpi-top">
                        <div class="ndh-kpi-icon amber"><i class="fas fa-dollar-sign"></i></div>
                        <span class="ndh-kpi-tag tag-amber">Gross</span>
                    </div>
                    <div class="ndh-kpi-label">Total Revenue</div>
                    <div class="ndh-kpi-value">${{ number_format($totalRevenue ?? 0, 0) }}</div>
                </div>
                <div class="ndh-kpi-sub">
                    Verified sales ledger
                </div>
            </a>

            <!-- 5. Active Customers -->
            <a href="{{ route('admin.customers.index') }}" class="ndh-kpi-card">
                <div>
                    <div class="ndh-kpi-top">
                        <div class="ndh-kpi-icon pink"><i class="fas fa-users"></i></div>
                        <span class="ndh-kpi-tag tag-pink">Buyers</span>
                    </div>
                    <div class="ndh-kpi-label">Customers</div>
                    <div class="ndh-kpi-value">{{ number_format($totalCustomers ?? 0) }}</div>
                </div>
                <div class="ndh-kpi-sub">
                    Registered accounts
                </div>
            </a>
        </div>

        <!-- 2-COLUMN ANALYTICS: PRODUCT GROWTH & CATEGORY MIX -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="ndh-card h-100 mb-0">
                    <div class="ndh-card-header">
                        <div>
                            <h3 class="ndh-card-title"><i class="fas fa-chart-bar text-primary"></i> Product & Sales Momentum</h3>
                            <p class="ndh-card-subtitle">Catalog volume & digital purchase progression over the last 12 months</p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-light text-primary"><i class="fas fa-calendar-alt me-1"></i>Last 12 Months</span>
                            <a href="{{ route('admin.reports.products') }}" class="btn btn-xs btn-outline-primary">Full Report</a>
                        </div>
                    </div>
                    <div style="position: relative; height: 260px; width: 100%;">
                        <canvas id="productGrowthChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ndh-card h-100 mb-0">
                    <div class="ndh-card-header">
                        <div>
                            <h3 class="ndh-card-title"><i class="fas fa-layer-group text-success"></i> Category Mix</h3>
                            <p class="ndh-card-subtitle">Digital assets breakdown by category</p>
                        </div>
                        <span class="badge badge-light text-muted">{{ $chartCategoryRows->count() }} Categories</span>
                    </div>
                    <div class="ndh-cat-list" style="max-height: 260px; overflow-y: auto;">
                        @forelse($chartCategoryRows->take(6) as $category)
                            @php
                                $val = (int) ($category->value ?? 0);
                                $percent = $maxCategoryValue > 0 ? round(($val / $maxCategoryValue) * 100) : 5;
                            @endphp
                            <div class="ndh-cat-row">
                                <div class="ndh-cat-head">
                                    <span>{{ $category->label ?? 'Category' }}</span>
                                    <span class="fw-bold text-primary">{{ number_format($val) }}</span>
                                </div>
                                <div class="ndh-cat-track">
                                    <div class="ndh-cat-fill" style="width: {{ max(4, $percent) }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">No categories created yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT PROJECT LEADS & INQUIRIES -->
        <div class="ndh-card mb-4">
            <div class="ndh-card-header">
                <div>
                    <h3 class="ndh-card-title">
                        <i class="fas fa-paper-plane text-purple"></i> Recent Project Inquiries & Leads
                        @if($newInquiries > 0)
                            <span class="badge badge-danger ms-2">{{ $newInquiries }} New</span>
                        @endif
                    </h3>
                    <p class="ndh-card-subtitle">Client consultation requests submitted through the NextDigiHome digital portal</p>
                </div>
                <a href="{{ route('inquiries.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-arrow-right me-1"></i>View All Leads
                </a>
            </div>

            <div class="table-responsive">
                <table class="ndh-table-custom">
                    <thead>
                        <tr>
                            <th>Client / Company</th>
                            <th>Contact Details</th>
                            <th>Service Interest</th>
                            <th>Est. Budget</th>
                            <th>Status</th>
                            <th>Received</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInquiries as $inquiry)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="client-avatar">
                                            {{ strtoupper(substr($inquiry->name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $inquiry->name }}</div>
                                            @if(!empty($inquiry->company))
                                                <small class="text-muted"><i class="fas fa-building me-1"></i>{{ $inquiry->company }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><a href="mailto:{{ $inquiry->email }}" class="text-decoration-none fw-semibold"><i class="fas fa-envelope text-muted me-1"></i>{{ $inquiry->email }}</a></div>
                                    @if(!empty($inquiry->phone))
                                        <small class="text-muted"><i class="fas fa-phone text-muted me-1"></i>{{ $inquiry->phone }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light text-primary border">
                                        {{ $inquiry->service_interest ?? 'Full-Stack Solution' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success font-monospace">
                                        {{ $inquiry->budget ?: 'Undisclosed' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $st = strtolower($inquiry->status ?? 'new');
                                        $badgeClass = match($st) {
                                            'new' => 'badge-danger',
                                            'in_progress', 'contacted' => 'badge-warning',
                                            'completed', 'converted' => 'badge-success',
                                            default => 'badge-light'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $st)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ optional($inquiry->created_at)->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('inquiries.show', $inquiry->id) }}" class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                    No customer inquiries received yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2-COLUMN BOTTOM: LATEST PURCHASES & TOP PRODUCTS -->
        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="ndh-card h-100 mb-0">
                    <div class="ndh-card-header">
                        <div>
                            <h3 class="ndh-card-title"><i class="fas fa-shopping-cart text-primary"></i> Latest Customer Purchases</h3>
                            <p class="ndh-card-subtitle">Real-time marketplace transactions</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-xs btn-outline-primary">Manage Orders</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="text-muted small">
                                <tr><th>Product</th><th>Buyer</th><th>Date</th><th class="text-end">Amount</th></tr>
                            </thead>
                            <tbody>
                                @forelse($latestPurchases as $purchase)
                                    <tr>
                                        <td class="fw-bold text-dark">
                                            <i class="fas fa-file-code text-primary me-2"></i>
                                            {{ optional($purchase->product)->name ?? 'Digital Asset' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-light text-muted">
                                                {{ optional($purchase->user)->name ?? ('Customer #'.$purchase->user_id) }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ optional($purchase->created_at)->diffForHumans() }}</td>
                                        <td class="text-end fw-bold text-success font-monospace">
                                            ${{ number_format($purchase->total ?? optional($purchase->product)->price ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    @forelse($latestProducts as $product)
                                        <tr>
                                            <td class="fw-bold text-dark">
                                                <i class="fas fa-box text-primary me-2"></i>
                                                {{ $product->name }}
                                            </td>
                                            <td><span class="badge badge-light text-muted">Catalog Entry</span></td>
                                            <td class="text-muted small">{{ optional($product->created_at)->diffForHumans() }}</td>
                                            <td class="text-end fw-bold text-success font-monospace">
                                                ${{ number_format($product->price ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted py-4">No recent activity found.</td></tr>
                                    @endforelse
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ndh-card h-100 mb-0">
                    <div class="ndh-card-header">
                        <div>
                            <h3 class="ndh-card-title"><i class="fas fa-trophy text-amber"></i> Top Selling Assets</h3>
                            <p class="ndh-card-subtitle">Digital items with the highest orders</p>
                        </div>
                        <span class="badge badge-light text-muted">Leaderboard</span>
                    </div>
                    <div class="ndh-ranking-list">
                        @forelse($topUsers as $index => $item)
                            @php
                                $rankClass = match($index) {
                                    0 => 'gold',
                                    1 => 'silver',
                                    2 => 'bronze',
                                    default => 'plain'
                                };
                            @endphp
                            <div class="ndh-rank-row">
                                <div class="ndh-rank-left">
                                    <div class="ndh-rank-badge {{ $rankClass }}">#{{ $index + 1 }}</div>
                                    <span class="ndh-rank-name">{{ $item['name'] ?? 'Digital Product' }}</span>
                                </div>
                                <span class="ndh-rank-sales">{{ number_format($item['total'] ?? 0) }} sales</span>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">No product purchases recorded yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- 2-COLUMN: QUICK LAUNCHPAD & RECENT SYSTEM ACTIVITY -->
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="ndh-card mb-0">
                    <div class="ndh-card-header">
                        <div>
                            <h3 class="ndh-card-title"><i class="fas fa-rocket text-primary"></i> Operations Launchpad</h3>
                            <p class="ndh-card-subtitle">Instant shortcuts for essential agency workflows</p>
                        </div>
                    </div>
                    <div class="ndh-launchpad-grid">
                        <a href="{{ route('admin.products.create') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-plus"></i></div>
                            <div>
                                <div class="ndh-launch-title">Add Product</div>
                                <div class="ndh-launch-sub">Publish digital asset</div>
                            </div>
                        </a>
                        <a href="{{ route('inquiries.index') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-paper-plane"></i></div>
                            <div>
                                <div class="ndh-launch-title">Project Leads</div>
                                <div class="ndh-launch-sub">Manage client requests</div>
                            </div>
                        </a>
                        <a href="{{ route('tracking.dashboard') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-server"></i></div>
                            <div>
                                <div class="ndh-launch-title">Server Tracking</div>
                                <div class="ndh-launch-sub">CAPI & Meta Telemetry</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-clipboard-list"></i></div>
                            <div>
                                <div class="ndh-launch-title">Order Ledger</div>
                                <div class="ndh-launch-sub">Process customer sales</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.pages.index') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-file-alt"></i></div>
                            <div>
                                <div class="ndh-launch-title">Page Content</div>
                                <div class="ndh-launch-sub">Edit agency pages</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.team-members.index') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-user-friends"></i></div>
                            <div>
                                <div class="ndh-launch-title">Team Roster</div>
                                <div class="ndh-launch-sub">Manage developers</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.testimonials.index') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-comment-dots"></i></div>
                            <div>
                                <div class="ndh-launch-title">Testimonials</div>
                                <div class="ndh-launch-sub">Social proof & reviews</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.marketing.seo') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-search"></i></div>
                            <div>
                                <div class="ndh-launch-title">SEO & Growth</div>
                                <div class="ndh-launch-sub">Search rankings</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.settings.general') }}" class="ndh-launch-item">
                            <div class="ndh-launch-icon"><i class="fas fa-cog"></i></div>
                            <div>
                                <div class="ndh-launch-title">Brand & Settings</div>
                                <div class="ndh-launch-sub">Logos & metadata</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ndh-card mb-0">
                    <div class="ndh-card-header">
                        <div>
                            <h3 class="ndh-card-title"><i class="fas fa-history text-muted"></i> System Activity Log</h3>
                            <p class="ndh-card-subtitle">Audit trail & administrative actions</p>
                        </div>
                        <span class="badge badge-light text-muted">Audit</span>
                    </div>
                    <div class="ndh-timeline">
                        @forelse($timeline->take(5) as $activity)
                            <div class="ndh-timeline-item">
                                <span class="ndh-timeline-dot"></span>
                                <div>
                                    <div class="ndh-timeline-text">{!! $activity->description ?? 'System operational event' !!}</div>
                                    <div class="ndh-timeline-time">
                                        {{ $activity->created_at ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : 'Recently' }}
                                        by <strong class="text-dark">{{ $activity->user_name ?? 'System' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">No recent audit logs available.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('productGrowthChart');
        if (ctx && typeof Chart !== 'undefined') {
            const labels = {!! json_encode($chartMonthLabels) !!};
            const dataValues = {!! json_encode($chartMonthlyData) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Catalog Items Created',
                        data: dataValues,
                        backgroundColor: 'rgba(2, 132, 199, 0.75)',
                        hoverBackgroundColor: '#00d4aa',
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 34
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Plus Jakarta Sans', weight: 'bold', size: 13 },
                            bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226, 232, 240, 0.6)' },
                            ticks: {
                                precision: 0,
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
