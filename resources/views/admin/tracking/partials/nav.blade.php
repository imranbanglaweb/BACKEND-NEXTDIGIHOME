{{-- Shared Navigation Bar for Server Tracking & CAPI Control Suite --}}
<div class="st-nav-wrapper mb-4">
    <div class="st-nav-scroller">
        <a href="{{ route('admin.server-tracking.dashboard') }}" 
           class="st-nav-item {{ request()->routeIs('admin.server-tracking.dashboard*') || request()->routeIs('server-tracking.dashboard*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-chart-pie"></i></span>
            <span class="st-nav-text">Overview Dashboard</span>
        </a>

        <a href="{{ route('admin.server-tracking.meta') }}" 
           class="st-nav-item st-nav-meta {{ request()->routeIs('admin.server-tracking.meta*') || request()->routeIs('server-tracking.meta*') || request()->routeIs('tracking-meta*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fab fa-facebook"></i></span>
            <span class="st-nav-text">Meta Pixel &amp; CAPI</span>
            <span class="st-nav-badge meta-badge">EMQ 9.4</span>
        </a>

        <a href="{{ route('admin.server-tracking.ga4') }}" 
           class="st-nav-item st-nav-ga4 {{ request()->routeIs('admin.server-tracking.ga4*') || request()->routeIs('server-tracking.ga4*') || request()->routeIs('tracking-ga4*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-chart-simple"></i></span>
            <span class="st-nav-text">Google Analytics 4</span>
            <span class="st-nav-badge ga4-badge">MP v2</span>
        </a>

        <a href="{{ route('admin.server-tracking.gtm') }}" 
           class="st-nav-item st-nav-gtm {{ request()->routeIs('admin.server-tracking.gtm*') || request()->routeIs('server-tracking.gtm*') || request()->routeIs('tracking-gtm*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-tags"></i></span>
            <span class="st-nav-text">Google Tag Manager</span>
            <span class="st-nav-badge gtm-badge">sGTM Relay</span>
        </a>

        <a href="{{ route('admin.server-tracking.campaigns') }}" 
           class="st-nav-item st-nav-camp {{ request()->routeIs('admin.server-tracking.campaigns*') || request()->routeIs('server-tracking.campaigns*') || request()->routeIs('tracking-campaigns*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-bullhorn"></i></span>
            <span class="st-nav-text">Campaigns &amp; SEO</span>
            <span class="st-nav-badge camp-badge">Attribution</span>
        </a>

        <a href="{{ route('admin.server-tracking.customer-journey') }}" 
           class="st-nav-item st-nav-journey {{ request()->routeIs('admin.server-tracking.customer-journey*') || request()->routeIs('server-tracking.customer-journey*') || request()->routeIs('tracking-customer-journey*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-route"></i></span>
            <span class="st-nav-text">Customer Journey</span>
            <span class="st-nav-badge journey-badge">Discovery</span>
        </a>

        <a href="{{ route('admin.server-tracking.config') }}" 
           class="st-nav-item {{ request()->routeIs('admin.server-tracking.config*') || request()->routeIs('server-tracking.config*') || request()->routeIs('tracking-config*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-sliders-h"></i></span>
            <span class="st-nav-text">Pipeline Credentials</span>
        </a>

        <a href="{{ route('admin.server-tracking.logs') }}" 
           class="st-nav-item {{ request()->routeIs('admin.server-tracking.logs*') || request()->routeIs('server-tracking.logs*') || request()->routeIs('tracking-logs*') ? 'active' : '' }}">
            <span class="st-nav-icon"><i class="fas fa-clipboard-list"></i></span>
            <span class="st-nav-text">Audit Logs &amp; Inspector</span>
        </a>
    </div>
</div>

<style>
    .st-nav-wrapper {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 6px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        position: relative;
    }

    .st-nav-scroller {
        display: flex;
        align-items: center;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 2px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .st-nav-scroller::-webkit-scrollbar {
        display: none;
    }

    .st-nav-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        text-decoration: none !important;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
        border: 1px solid transparent;
    }

    .st-nav-item:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .st-nav-item.active {
        color: #0f172a;
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 3px 8px -2px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    .st-nav-item .st-nav-icon {
        font-size: 14px;
        color: #64748b;
        transition: color 0.2s;
    }

    .st-nav-item.active .st-nav-icon {
        color: #0284c7;
    }

    .st-nav-item.st-nav-meta.active .st-nav-icon {
        color: #0081fb;
    }

    .st-nav-item.st-nav-ga4.active .st-nav-icon {
        color: #ea580c;
    }

    .st-nav-item.st-nav-gtm.active .st-nav-icon {
        color: #0284c7;
    }

    .st-nav-badge {
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        font-family: var(--st-font-mono, monospace);
    }

    .meta-badge {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .ga4-badge {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #ffedd5;
    }

    .gtm-badge {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #dcfce7;
    }

    .camp-badge {
        background: #f5f3ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    .journey-badge {
        background: #ecfeff;
        color: #0e7490;
        border: 1px solid #cffafe;
    }
</style>
