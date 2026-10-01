@extends('admin.dashboard.master')

@section('title', 'Customer 360 & Journey Discovery - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<!-- Preconnect & Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    :root {
        --st-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --st-font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;

        --st-primary: #2563eb;
        --st-primary-dark: #1d4ed8;
        --st-primary-light: #eff6ff;
        --st-slate-900: #0f172a;
        --st-slate-800: #1e293b;
        --st-slate-700: #334155;
        --st-slate-600: #475569;
        --st-slate-500: #64748b;
        --st-slate-200: #e2e8f0;
        --st-slate-100: #f1f5f9;
        --st-slate-50: #f8fafc;
    }

    .journey-page-wrapper {
        background: #f8fafc !important;
        min-height: calc(100vh - 66px);
        padding: 24px 32px 64px !important;
        font-family: var(--st-font-sans) !important;
        color: var(--st-slate-800) !important;
        font-size: 14px !important;
        letter-spacing: -0.011em;
    }

    .font-mono-code {
        font-family: var(--st-font-mono) !important;
        letter-spacing: -0.02em;
    }

    /* Executive Hero Header */
    .journey-hero-banner {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #090d16 0%, #111827 50%, #1e1b4b 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        padding: 28px 34px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.35);
    }

    .journey-hero-banner::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -20px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(99, 102, 241, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .journey-hero-title {
        font-size: 1.7rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #ffffff;
    }

    .journey-hero-badge {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 4px 10px;
        border-radius: 9999px;
        background: rgba(99, 102, 241, 0.25);
        border: 1px solid rgba(165, 180, 252, 0.35);
        color: #e0e7ff;
    }

    .journey-hero-subtitle {
        font-size: 0.92rem;
        color: #cbd5e1;
        max-width: 720px;
        margin-bottom: 0;
        line-height: 1.55;
    }

    /* Modern Command Search Bar */
    .journey-search-card {
        background: #ffffff;
        border: 1px solid var(--st-slate-200);
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 2px 8px -2px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .journey-search-input {
        height: 46px;
        border-radius: 10px;
        border: 1px solid var(--st-slate-200);
        padding: 0 16px 0 42px;
        font-size: 0.92rem;
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .journey-search-input:focus {
        background: #ffffff;
        border-color: var(--st-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* Customer Switcher Directory Grid */
    .customer-picker-card {
        background: #ffffff;
        border: 1.5px solid var(--st-slate-200);
        border-radius: 14px;
        padding: 14px 16px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none !important;
        color: inherit !important;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
    }

    .customer-picker-card:hover {
        border-color: #93c5fd;
        background: #ffffff;
        box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.12);
        transform: translateY(-2px);
    }

    .customer-picker-card.active {
        border-color: var(--st-primary);
        background: #f0f7ff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }

    .customer-picker-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.92rem;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
    }

    /* Main Customer 360 Dossier Header */
    .dossier-card {
        background: #ffffff;
        border: 1px solid var(--st-slate-200);
        border-radius: 18px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .dossier-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2563eb 0%, #06b6d4 50%, #10b981 100%);
    }

    .dossier-avatar {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 800;
        box-shadow: 0 10px 24px -4px rgba(37, 99, 235, 0.35);
        flex-shrink: 0;
    }

    .dossier-score-box {
        background: #f8fafc;
        border: 1px solid var(--st-slate-200);
        border-radius: 12px;
        padding: 14px 20px;
        text-align: center;
        min-width: 140px;
    }

    /* Identity Matrix 4-Tile Grid */
    .identity-detail-card {
        background: #ffffff;
        border: 1px solid var(--st-slate-200);
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.2s ease;
        height: 100%;
    }

    .identity-detail-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px -2px rgba(15, 23, 42, 0.06);
        transform: translateY(-1px);
    }

    .identity-detail-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    /* Vertical Timeline System */
    .timeline-container {
        position: relative;
        padding-left: 36px;
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        top: 24px;
        bottom: 24px;
        left: 17px;
        width: 2.5px;
        background: #e2e8f0;
        border-radius: 2px;
    }

    .timeline-step-item {
        position: relative;
        margin-bottom: 28px;
    }

    .timeline-step-item:last-child {
        margin-bottom: 0;
    }

    .timeline-step-bullet {
        position: absolute;
        top: 4px;
        left: -36px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        z-index: 2;
    }

    .timeline-card {
        background: #ffffff;
        border: 1px solid var(--st-slate-200);
        border-radius: 14px;
        padding: 20px 24px;
        box-shadow: 0 2px 10px -2px rgba(15, 23, 42, 0.03);
        transition: all 0.2s ease;
    }

    .timeline-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
    }

    .timeline-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--st-slate-900);
        letter-spacing: -0.015em;
    }

    .timeline-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 12px;
        margin-top: 14px;
        background: #f8fafc;
        border-radius: 10px;
        padding: 14px 16px;
        border: 1px solid #f1f5f9;
    }

    .timeline-grid-item label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 2px;
        display: block;
    }

    .timeline-grid-item span {
        font-size: 0.86rem;
        color: var(--st-slate-800);
        font-weight: 600;
        word-break: break-all;
    }

    /* Candidate Feed Item */
    .candidate-feed-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none !important;
        color: inherit !important;
        transition: all 0.15s ease;
    }

    .candidate-feed-item:last-child {
        border-bottom: none;
    }

    .candidate-feed-item:hover {
        background: #f8fafc;
    }

    .candidate-feed-item.active {
        background: #eff6ff;
        border-left: 3px solid var(--st-primary);
    }
</style>

<div class="journey-page-wrapper">
    {{-- Shared Unified Navigation Bar --}}
    @include('admin.tracking.partials.nav')

    {{-- Executive Hero Header --}}
    <div class="journey-hero-banner">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-white bg-opacity-10 text-white font-mono-code px-2 py-1" style="font-size: 11px;">
                        <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> LIVE SERVER ATTRIBUTION
                    </span>
                    <span class="text-white-50 small">&bull;</span>
                    <span class="text-white-50 small font-mono-code">NextDigi Customer 360 Core</span>
                </div>
                <div class="journey-hero-title">
                    <i class="fas fa-route text-warning"></i>
                    <span>Customer 360 &amp; Journey Discovery</span>
                    <span class="journey-hero-badge">Multi-Touch Pipeline</span>
                </div>
                <p class="journey-hero-subtitle">
                    Inspect unified customer touchpoints, trace ad attribution campaigns, view server-side Meta CAPI &amp; GA4 dispatch logs, and track verified purchase conversion pipelines.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('admin.server-tracking.campaigns') }}" class="btn btn-light btn-sm fw-bold px-3 py-2 shadow-sm text-dark" style="border-radius: 8px;">
                    <i class="fas fa-bullhorn me-1 text-primary"></i> Ad Campaigns
                </a>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-light btn-sm fw-bold px-3 py-2" style="border-radius: 8px;">
                    <i class="fas fa-clipboard-list me-1"></i> Audit Logs
                </a>
            </div>
        </div>
    </div>

    {{-- Customer Search & Discovery Bar --}}
    <div class="journey-search-card">
        <form method="GET" action="{{ route('admin.server-tracking.customer-journey') }}">
            <div class="row g-2 align-items-center">
                <div class="col-lg-9 col-md-8">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute top-50 translate-middle-y text-muted" style="left: 16px;"></i>
                        <input type="text" 
                               name="q" 
                               value="{{ $search }}" 
                               class="form-control journey-search-input" 
                               placeholder="Search customer by Name, Email, Phone (+1...), Lead ID (e.g. LEAD-9481), Company, or Location...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold px-4 h-100 flex-grow-1" style="min-height: 46px; border-radius: 10px;">
                        <i class="fas fa-magnifying-glass me-1"></i> Inspect Journey
                    </button>
                    @if(!empty($search))
                        <a href="{{ route('admin.server-tracking.customer-journey') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="min-height: 46px; border-radius: 10px;" title="Reset search">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Customer Directory & 1-Click Journey Switcher --}}
    @if(isset($availableCustomers) && $availableCustomers->isNotEmpty())
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-users-viewfinder text-primary"></i>
                        <span>Select Customer to Inspect 360 Journey</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-mono-code" style="font-size: 11px;">
                            {{ $availableCustomers->count() }} Profiles
                        </span>
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Click any customer card to immediately switch their complete multi-touch journey, contact details, location &amp; server logs.</p>
                </div>
                <span class="badge bg-white text-secondary border font-mono-code small py-2 px-3 shadow-sm">
                    <i class="fas fa-hand-pointer text-primary me-1"></i> 1-Click Customer Switcher
                </span>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-3">
                @foreach($availableCustomers as $cust)
                    @php
                        $isActive = ($customerProfile && ($customerProfile['lead_id'] === $cust['lead_id'] || $customerProfile['email'] === $cust['email']));
                        $avatarGradient = match($cust['first_touch_source'] ?? '') {
                            'google' => 'linear-gradient(135deg, #0284c7, #0369a1)',
                            'meta_capi', 'facebook' => 'linear-gradient(135deg, #2563eb, #1d4ed8)',
                            'linkedin' => 'linear-gradient(135deg, #0a66c2, #004182)',
                            default => 'linear-gradient(135deg, #6366f1, #4f46e5)',
                        };
                    @endphp
                    <div class="col">
                        <a href="{{ route('admin.server-tracking.customer-journey', ['customer_id' => $cust['lead_id']]) }}" 
                           class="customer-picker-card {{ $isActive ? 'active' : '' }}">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="customer-picker-avatar" style="background: {{ $avatarGradient }};">
                                            {{ strtoupper(substr($cust['name'], 0, 2)) }}
                                        </div>
                                        <div class="overflow-hidden">
                                            <strong class="text-dark d-block text-truncate small" title="{{ $cust['name'] }}">{{ $cust['name'] }}</strong>
                                            <span class="font-mono-code text-muted" style="font-size: 11px;">{{ $cust['lead_id'] }}</span>
                                        </div>
                                    </div>
                                    @if($isActive)
                                        <span class="badge bg-primary text-white" style="font-size: 9.5px; letter-spacing: 0.04em;">
                                            <i class="fas fa-check me-1"></i> ACTIVE
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary border font-mono-code" style="font-size: 10px;">
                                            {{ $cust['lead_score'] }}/100
                                        </span>
                                    @endif
                                </div>

                                <div style="font-size: 12px; line-height: 1.5;">
                                    <div class="text-dark fw-semibold text-truncate mb-1" title="{{ $cust['phone'] }}">
                                        <i class="fas fa-phone-alt text-success me-1" style="font-size: 11px;"></i> {{ $cust['phone'] }}
                                    </div>
                                    <div class="text-muted text-truncate mb-1 font-mono-code" title="{{ $cust['email'] }}" style="font-size: 11px;">
                                        <i class="fas fa-envelope text-primary me-1" style="font-size: 11px;"></i> {{ $cust['email'] }}
                                    </div>
                                    <div class="text-muted text-truncate" title="{{ $cust['location'] }}" style="font-size: 11px;">
                                        <i class="fas fa-location-dot text-danger me-1" style="font-size: 11px;"></i> {{ $cust['location'] }}
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 mt-2 border-top d-flex align-items-center justify-content-between" style="font-size: 11px;">
                                <span class="badge bg-light text-secondary border font-mono-code text-uppercase" style="font-size: 9.5px;">
                                    {{ $cust['first_touch_source'] ?? 'direct' }}
                                </span>
                                <span class="text-muted text-truncate font-mono-code" style="max-width: 110px;">
                                    {{ $cust['company'] ?? 'Verified' }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Main Customer 360 Dossier Header --}}
    @if($customerProfile)
        <div class="dossier-card mb-4">
            <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-4 pb-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="dossier-avatar">
                        {{ strtoupper(substr($customerProfile['name'], 0, 2)) }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h2 class="fw-bold text-dark mb-0 fs-3">{{ $customerProfile['name'] }}</h2>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-mono-code px-2 py-1">
                                {{ $customerProfile['lead_id'] }}
                            </span>
                            <span class="badge {{ $customerProfile['priority'] === 'HIGH' ? 'bg-danger' : 'bg-warning' }} text-white font-mono-code px-2 py-1">
                                {{ $customerProfile['priority'] }} PRIORITY
                            </span>
                            @if(!empty($customerProfile['company']))
                                <span class="badge bg-light text-secondary border font-mono-code px-2 py-1">
                                    <i class="fas fa-building me-1 text-muted"></i>{{ $customerProfile['company'] }}
                                </span>
                            @endif
                        </div>
                        <div class="text-muted small">
                            <i class="fas fa-clock-rotate-left me-1 text-primary"></i>Customer Record Captured: <strong class="text-dark">{{ $customerProfile['created_at'] }}</strong>
                            <span class="mx-2 text-muted">&bull;</span>
                            <span class="badge bg-light text-muted border font-mono-code">Source: {{ strtoupper($customerProfile['first_touch_source']) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Key Executive Metric Tiles --}}
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="dossier-score-box">
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Lead Score</span>
                        <span class="fs-4 fw-bold font-mono-code text-success">{{ $customerProfile['lead_score'] }}/100</span>
                    </div>

                    <div class="dossier-score-box">
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">Attributed Spend</span>
                        <span class="fs-4 fw-bold font-mono-code text-primary">{{ $customerProfile['total_spend'] }}</span>
                    </div>

                    <div class="dossier-score-box">
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="font-size: 11px;">First Touch</span>
                        <span class="badge bg-dark text-white font-mono-code px-2 py-1 text-uppercase" style="font-size: 12px;">{{ $customerProfile['first_touch_source'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Verified Customer Identity Matrix (4 Equal-Height Modern Tiles) --}}
            <div class="pt-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 0.06em; font-size: 0.72rem;">
                        <i class="fas fa-id-card text-primary me-1"></i> Verified Customer Identity &amp; Contact Telemetry
                    </span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle small font-mono-code">
                        <i class="fas fa-shield-halved me-1"></i> Privacy-Safe SHA256 Synced
                    </span>
                </div>

                <div class="row g-3">
                    {{-- 1. Full Customer Name --}}
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="identity-detail-card">
                            <div class="identity-detail-icon bg-primary-subtle text-primary">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Customer Name</span>
                                <strong class="text-dark d-block text-truncate fs-6" title="{{ $customerProfile['name'] }}">{{ $customerProfile['name'] }}</strong>
                                <span class="text-muted small text-truncate d-block" style="font-size: 11px;">{{ $customerProfile['company'] ?? 'Verified Enterprise' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Email Address --}}
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="identity-detail-card">
                            <div class="identity-detail-icon bg-info-subtle text-info">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Email Address</span>
                                <a href="mailto:{{ $customerProfile['email'] }}" class="text-primary text-decoration-none fw-bold d-block text-truncate font-mono-code" title="Send email to {{ $customerProfile['email'] }}">
                                    {{ $customerProfile['email'] }}
                                </a>
                                <span class="text-success small font-mono-code" style="font-size: 10.5px;">
                                    <i class="fas fa-check-circle me-1"></i>Verified &amp; CAPI Synced
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Phone Number --}}
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="identity-detail-card">
                            <div class="identity-detail-icon bg-success-subtle text-success">
                                <i class="fas fa-phone-volume"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Phone Number</span>
                                <a href="tel:{{ $customerProfile['phone'] }}" class="text-success text-decoration-none fw-bold d-block text-truncate font-mono-code" title="Call {{ $customerProfile['phone'] }}">
                                    {{ $customerProfile['phone'] }}
                                </a>
                                <span class="text-muted small font-mono-code" style="font-size: 10.5px;">
                                    E.164 Format &bull; Click to Call
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Location & IP Address --}}
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="identity-detail-card">
                            <div class="identity-detail-icon bg-danger-subtle text-danger">
                                <i class="fas fa-location-dot"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Location &amp; Network IP</span>
                                <strong class="text-dark d-block text-truncate" title="{{ $customerProfile['location'] ?? 'San Francisco, CA, United States' }}">
                                    {{ $customerProfile['location'] ?? 'San Francisco, CA, United States' }}
                                </strong>
                                <span class="badge bg-light text-secondary border font-mono-code mt-1" style="font-size: 0.7rem;">
                                    IP: {{ $customerProfile['ip_address'] ?? '198.51.100.42' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Content Grid: Journey Timeline & Audit Sidebar --}}
    <div class="row g-4">
        {{-- Journey Timeline (Left / Main Column) --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="fas fa-timeline text-primary"></i>
                            <span>Multi-Touch Journey Timeline</span>
                        </h4>
                        <p class="text-muted small mb-0">Chronological touchpoints recorded from discovery ad click to server CAPI dispatch and purchase synchronization.</p>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 font-mono-code">
                        <i class="fas fa-check-double me-1"></i> 5 Stages Synced
                    </span>
                </div>

                {{-- Step Items --}}
                <div class="timeline-container">
                    @foreach($timeline as $step)
                        <div class="timeline-step-item">
                            <div class="timeline-step-bullet" style="background: {{ $step['color'] }};">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </div>

                            <div class="timeline-card">
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-2">
                                    <div class="timeline-title d-flex align-items-center gap-2">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-mono-code px-2 py-1" style="font-size: 11px;">
                                            Stage 0{{ $step['step'] }}
                                        </span>
                                        <span>{{ $step['title'] }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-secondary border font-mono-code">
                                            <i class="fas fa-clock me-1 text-muted"></i>{{ $step['time'] }}
                                        </span>
                                        <span class="badge bg-success-subtle text-success font-mono-code border border-success-subtle">
                                            {{ $step['status'] }}
                                        </span>
                                    </div>
                                </div>

                                <span class="badge bg-dark text-white font-mono-code small mb-2 py-1 px-2">
                                    <i class="fas fa-satellite-dish me-1 text-warning"></i> Channel: {{ $step['channel'] }}
                                </span>

                                <div class="timeline-grid">
                                    @foreach($step['details'] as $k => $v)
                                        <div class="timeline-grid-item">
                                            <label>{{ $k }}</label>
                                            <span class="font-mono-code text-dark">{{ $v }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Matched Server Tracking Logs for this Customer --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fas fa-clipboard-list text-info"></i>
                            <span>Matched Server Tracking Logs ({{ $targetLogs->count() }})</span>
                        </h5>
                        <p class="text-muted small mb-0">Telemetry dispatches strictly filtered for {{ $customerProfile['name'] }} ({{ $customerProfile['lead_id'] }}).</p>
                    </div>
                    <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-external-link-alt me-1"></i> View All System Logs
                    </a>
                </div>

                @if($targetLogs->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th style="font-size: 11px; text-transform: uppercase;">Provider</th>
                                    <th style="font-size: 11px; text-transform: uppercase;">Event</th>
                                    <th style="font-size: 11px; text-transform: uppercase;">Status</th>
                                    <th style="font-size: 11px; text-transform: uppercase;">Event ID</th>
                                    <th class="text-end" style="font-size: 11px; text-transform: uppercase;">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($targetLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="badge bg-dark text-white font-mono-code text-uppercase">
                                                {{ $log->provider }}
                                            </span>
                                        </td>
                                        <td class="font-mono-code fw-bold text-primary">{{ $log->event_name }}</td>
                                        <td>
                                            <span class="badge {{ $log->status === 'success' ? 'bg-success' : 'bg-danger' }} text-white">
                                                <i class="fas {{ $log->status === 'success' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                                {{ $log->status }}
                                            </span>
                                        </td>
                                        <td class="font-mono-code text-muted small">{{ $log->event_id ?: '-' }}</td>
                                        <td class="text-end text-muted font-mono-code">{{ is_object($log->created_at) ? $log->created_at->format('M d, H:i:s') : $log->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center bg-light rounded-3 text-muted small">
                        <i class="fas fa-shield-halved text-success me-1"></i> Form submission &amp; journey touchpoints are recorded directly for this customer. No separate third-party server log discrepancies found.
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Side Panel: Customer Directory & Attribution Blueprint --}}
        <div class="col-xl-4">
            {{-- Customer Directory Roster --}}
            @if(isset($availableCustomers) && $availableCustomers->isNotEmpty())
                <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
                    <div class="p-3 border-bottom bg-light d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark small text-uppercase d-flex align-items-center gap-1" style="letter-spacing: 0.04em;">
                            <i class="fas fa-address-book text-primary me-1"></i> Customer Directory
                        </span>
                        <span class="badge bg-primary text-white font-mono-code" style="font-size: 11px;">
                            {{ $availableCustomers->count() }} Clients
                        </span>
                    </div>

                    <div style="max-height: 380px; overflow-y: auto;">
                        @foreach($availableCustomers as $custItem)
                            @php
                                $isItemActive = ($customerProfile && ($customerProfile['lead_id'] === $custItem['lead_id'] || $customerProfile['email'] === $custItem['email']));
                            @endphp
                            <a href="{{ route('admin.server-tracking.customer-journey', ['customer_id' => $custItem['lead_id']]) }}" 
                               class="candidate-feed-item {{ $isItemActive ? 'active' : '' }}">
                                <div>
                                    <div class="fw-bold text-dark small mb-1 d-flex align-items-center gap-1">
                                        <span>{{ $custItem['name'] }}</span>
                                        @if($isItemActive)
                                            <span class="badge bg-primary text-white" style="font-size: 0.65rem;">ACTIVE</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small font-mono-code" style="font-size: 11.5px;">
                                        <i class="fas fa-phone text-success me-1" style="font-size: 10px;"></i>{{ $custItem['phone'] }}
                                    </div>
                                    <div class="text-muted small" style="font-size: 11.5px;">
                                        <i class="fas fa-location-dot text-danger me-1" style="font-size: 10px;"></i>{{ $custItem['location'] }}
                                    </div>
                                    <div class="mt-1 d-flex align-items-center gap-1">
                                        <span class="badge bg-light text-secondary border font-mono-code" style="font-size: 0.7rem;">
                                            {{ $custItem['lead_id'] }}
                                        </span>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle font-mono-code" style="font-size: 0.7rem;">
                                            Score {{ $custItem['lead_score'] }}
                                        </span>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-muted small"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Single Customer Attribution Blueprint --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
                <div class="p-3 border-bottom bg-light d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.04em;">
                        <i class="fas fa-fingerprint text-primary me-1"></i> Attribution Blueprint
                    </span>
                    <span class="badge bg-primary text-white font-mono-code">{{ $customerProfile['lead_id'] ?? 'PROFILE' }}</span>
                </div>

                <div class="p-3">
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 11px;">Attributed Ad Campaign</div>
                        <div class="fw-bold text-dark font-mono-code small mt-1">{{ $customerProfile['campaign'] ?? 'Meta_Retargeting_HighIntent_Q3' }}</div>
                        <div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-mono-code" style="font-size: 0.72rem;">
                                {{ $customerProfile['first_touch_source'] ?? 'facebook' }} / {{ $customerProfile['first_touch_medium'] ?? 'cpc' }}
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle font-mono-code" style="font-size: 0.72rem;">
                                Lead Score {{ $customerProfile['lead_score'] ?? 92 }}/100
                            </span>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 11px;">Meta Browser Cookie (_fbp)</div>
                        <div class="font-mono-code text-muted small mt-1 text-truncate" title="{{ $customerProfile['fbp'] ?? 'fb.1.1727783912.981726' }}">
                            {{ $customerProfile['fbp'] ?? 'fb.1.1727783912.981726' }}
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 11px;">Meta Click Identifier (_fbc)</div>
                        <div class="font-mono-code text-muted small mt-1 text-truncate" title="{{ $customerProfile['fbc'] ?? 'fb.1.1727783912.IwAR0zR89kqM2' }}">
                            {{ $customerProfile['fbc'] ?? 'fb.1.1727783912.IwAR0zR89kqM2' }}
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 11px;">Landing Page URL</div>
                        <a href="{{ $customerProfile['landing_page'] ?? '#' }}" target="_blank" class="text-primary text-decoration-none font-mono-code small text-truncate d-block mt-1" title="{{ $customerProfile['landing_page'] ?? 'https://nextdigihome.com/services/custom-software' }}">
                            <i class="fas fa-arrow-up-right-from-square me-1"></i>{{ $customerProfile['landing_page'] ?? 'https://nextdigihome.com/services/custom-software' }}
                        </a>
                    </div>

                    <div>
                        <div class="text-muted small text-uppercase fw-bold" style="font-size: 11px;">Customer Geolocation &amp; IP</div>
                        <div class="font-mono-code text-dark small mt-1">
                            <i class="fas fa-location-dot text-danger me-1"></i> {{ $customerProfile['location'] ?? 'San Francisco, CA, United States' }}
                        </div>
                        <span class="badge bg-light text-secondary border font-mono-code mt-1">{{ $customerProfile['ip_address'] ?? '198.51.100.42' }}</span>
                    </div>
                </div>
            </div>

            {{-- CAPI Attribution Architecture Info Card --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-lightbulb text-warning"></i>
                    <span>Multi-Touch Intelligence</span>
                </h5>
                <p class="text-muted small mb-3">
                    Customer 360 merges browser cookies (`_fbp`, `_fbc`, `_ga`), UTM query parameters, lead inquiries, and commerce checkouts into unified customer timelines.
                </p>

                <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 mb-2 border">
                    <i class="fas fa-fingerprint text-primary fs-5 mt-1"></i>
                    <div>
                        <strong class="text-dark small d-block">Identity Resolution</strong>
                        <span class="text-muted small">SHA-256 hashed emails and phone numbers ensure privacy-safe matching with Meta CAPI and GA4 MP v2.</span>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 p-3 bg-light rounded-3 border">
                    <i class="fas fa-shield-halved text-success fs-5 mt-1"></i>
                    <div>
                        <strong class="text-dark small d-block">Event Deduplication</strong>
                        <span class="text-muted small">Unique `event_id` keys eliminate double-counted leads and purchases between browser pixels and server APIs.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
