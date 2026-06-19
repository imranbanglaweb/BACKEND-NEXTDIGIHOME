@extends('admin.dashboard.master')

@section('main_content')
@include('admin.marketing.partials.premium-styles')

<section role="main" class="content-body commerce-ops-page">
    <div class="container-fluid">
        <div class="commerce-hero commerce-{{ $page['tone'] ?? 'blue' }}">
            <div>
                <div class="commerce-eyebrow">Digital Products Backend</div>
                <h2><i class="{{ $page['icon'] }} me-2"></i>{{ $page['title'] }}</h2>
                <p>{{ $page['subtitle'] }}</p>
            </div>
            <div class="commerce-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light">
                    <i class="fas fa-shopping-cart me-2"></i>Orders
                </a>
            </div>
        </div>

        <div class="row g-3 mb-3">
            @foreach($page['stats'] as $stat)
                <div class="col-xl-4 col-md-6">
                    <div class="commerce-stat-card">
                        <span class="stat-icon {{ $stat['tone'] }}"><i class="{{ $stat['icon'] }}"></i></span>
                        <div>
                            <small>{{ $stat['label'] }}</small>
                            <strong>{{ $stat['value'] }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-3">
            <div class="col-xl-8">
                <div class="commerce-panel">
                    <div class="commerce-panel-title">
                        <div>
                            <h5>Operational Checklist</h5>
                            <p>These are the practical controls normally needed before scaling digital-product sales.</p>
                        </div>
                    </div>

                    <div class="commerce-section-grid">
                        @foreach($page['sections'] as $section)
                            <div class="commerce-section">
                                <h6>{{ $section['title'] }}</h6>
                                @foreach($section['items'] as $item)
                                    <div class="commerce-check-row">
                                        <i class="fas fa-check-circle"></i>
                                        <span>{{ $item }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="commerce-panel sticky-commerce-panel">
                    <div class="commerce-panel-title compact">
                        <div>
                            <h5>Build Priority</h5>
                            <p>Recommended next implementation order.</p>
                        </div>
                    </div>

                    <div class="commerce-roadmap">
                        <div class="roadmap-item is-active">
                            <span>1</span>
                            <div>
                                <strong>Data model</strong>
                                <small>Add tables and audit fields for this workflow.</small>
                            </div>
                        </div>
                        <div class="roadmap-item">
                            <span>2</span>
                            <div>
                                <strong>Admin actions</strong>
                                <small>Create approve, reject, export, and status-change controls.</small>
                            </div>
                        </div>
                        <div class="roadmap-item">
                            <span>3</span>
                            <div>
                                <strong>Automation</strong>
                                <small>Connect emails, webhooks, SMS, or gateway callbacks.</small>
                            </div>
                        </div>
                    </div>

                    <div class="commerce-note">
                        <i class="fas fa-info-circle"></i>
                        <span>This page is a backend workspace shell. It is ready for real data tables and actions when you choose which workflow to build first.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .commerce-ops-page {
        background: #f4f7fb;
        color: #172033;
        min-height: calc(100vh - 70px);
        padding: 24px;
    }

    .commerce-hero {
        align-items: center;
        background: linear-gradient(135deg, #0f172a 0%, #123047 58%, #0f766e 100%);
        border-radius: 8px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, .18);
        color: #fff;
        display: flex;
        gap: 18px;
        justify-content: space-between;
        margin-bottom: 18px;
        overflow: hidden;
        padding: 26px 28px;
        position: relative;
    }

    .commerce-blue { background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%); }
    .commerce-violet { background: linear-gradient(135deg, #111827 0%, #6d28d9 100%); }
    .commerce-red { background: linear-gradient(135deg, #111827 0%, #b91c1c 100%); }
    .commerce-amber { background: linear-gradient(135deg, #111827 0%, #b45309 100%); }
    .commerce-cyan { background: linear-gradient(135deg, #0f172a 0%, #0e7490 100%); }
    .commerce-slate { background: linear-gradient(135deg, #0f172a 0%, #475569 100%); }

    .commerce-hero::after {
        background: linear-gradient(90deg, #22c55e, #38bdf8, #f59e0b);
        bottom: 0;
        content: '';
        height: 4px;
        left: 0;
        position: absolute;
        right: 0;
    }

    .commerce-eyebrow {
        color: #a7f3d0;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    .commerce-hero h2 {
        font-size: 30px;
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.1;
        margin: 0 0 7px;
    }

    .commerce-hero p {
        color: rgba(255, 255, 255, .78);
        font-size: 15px;
        line-height: 1.55;
        margin: 0;
        max-width: 760px;
    }

    .commerce-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .commerce-stat-card,
    .commerce-panel {
        background: #fff;
        border: 1px solid rgba(203, 213, 225, .82);
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .07);
    }

    .commerce-stat-card {
        align-items: center;
        display: flex;
        gap: 14px;
        min-height: 104px;
        padding: 18px;
    }

    .commerce-stat-card small {
        color: #64748b;
        display: block;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .05em;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .commerce-stat-card strong {
        color: #0f172a;
        display: block;
        font-size: 23px;
        font-weight: 900;
        line-height: 1.05;
    }

    .commerce-panel {
        padding: 22px;
    }

    .commerce-panel-title {
        align-items: center;
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .commerce-panel-title h5 {
        color: #0f172a;
        font-size: 20px;
        font-weight: 900;
        margin: 0 0 5px;
    }

    .commerce-panel-title p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.55;
        margin: 0;
    }

    .commerce-section-grid {
        display: grid;
        gap: 14px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .commerce-section {
        background: #f8fafc;
        border: 1px solid #e5edf6;
        border-radius: 8px;
        padding: 16px;
    }

    .commerce-section h6 {
        color: #0f172a;
        font-size: 15px;
        font-weight: 900;
        margin: 0 0 12px;
    }

    .commerce-check-row {
        align-items: flex-start;
        color: #334155;
        display: flex;
        font-size: 13px;
        font-weight: 700;
        gap: 8px;
        line-height: 1.45;
        margin-bottom: 10px;
    }

    .commerce-check-row i {
        color: #0f766e;
        margin-top: 3px;
    }

    .sticky-commerce-panel {
        position: sticky;
        top: 92px;
    }

    .commerce-roadmap {
        display: grid;
        gap: 12px;
    }

    .roadmap-item {
        align-items: flex-start;
        background: #f8fafc;
        border: 1px solid #e5edf6;
        border-radius: 8px;
        display: flex;
        gap: 12px;
        padding: 12px;
    }

    .roadmap-item span {
        align-items: center;
        background: #e2e8f0;
        border-radius: 8px;
        color: #334155;
        display: inline-flex;
        flex: 0 0 34px;
        font-weight: 900;
        height: 34px;
        justify-content: center;
        width: 34px;
    }

    .roadmap-item.is-active span {
        background: #0f766e;
        color: #fff;
    }

    .roadmap-item strong {
        color: #0f172a;
        display: block;
        font-size: 14px;
        font-weight: 900;
    }

    .roadmap-item small {
        color: #64748b;
        display: block;
        font-size: 12px;
        line-height: 1.45;
        margin-top: 3px;
    }

    .commerce-note {
        align-items: flex-start;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        color: #065f46;
        display: flex;
        font-size: 13px;
        font-weight: 750;
        gap: 10px;
        line-height: 1.5;
        margin-top: 16px;
        padding: 12px;
    }

    .commerce-note i {
        margin-top: 3px;
    }

    @media (max-width: 1199px) {
        .commerce-section-grid {
            grid-template-columns: 1fr;
        }

        .sticky-commerce-panel {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .commerce-ops-page {
            padding: 14px;
        }

        .commerce-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .commerce-actions,
        .commerce-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection
