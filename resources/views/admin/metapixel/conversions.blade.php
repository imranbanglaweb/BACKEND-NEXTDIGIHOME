@extends('admin.dashboard.master')

@section('title', 'Conversions - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-chart-line"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>Conversion Tracking</h1>
            <p>Track purchases, leads, and conversion funnels</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <a href="{{ route('metapixel.dashboard') }}" class="btn-new-requisition">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="role-indicator mb-4">
    <div class="alert alert-warning alert-role d-flex align-items-center">
        <i class="fa fa-chart-line mr-2"></i>
        <div>
            <strong>Conversion Analytics</strong>
            <p class="mb-0 small">Track purchases, leads, and measure conversion performance</p>
        </div>
    </div>
</div>

<div class="row stats-row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Total Conversions</span>
                <span class="stat-value">0</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> All time</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-percentage"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Conversion Rate</span>
                <span class="stat-value">0%</span>
                <span class="stat-trend stat-trend-neutral"><i class="fa fa-minus"></i> Visitors</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-dollar-sign"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Revenue</span>
                <span class="stat-value">$0</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Generated</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-chart-funnel"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Avg. Funnel</span>
                <span class="stat-value">0%</span>
                <span class="stat-trend stat-trend-down"><i class="fa fa-arrow-down"></i> Complete</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-line mr-2"></i>Conversions Over Time</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="conversionsChart"></canvas>
                </div>
                <p class="text-center text-muted mt-3">No conversion data available yet. Track leads and purchases to see analytics.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-funnel-dollar mr-2"></i>Conversion Funnel</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="text-center py-4">
                    <i class="fa fa-funnel-dollar fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No conversion funnel data</p>
                    <small>Track leads and purchases to build funnel</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card dashboard-card">
    <div class="card-header dashboard-card-header">
        <h4 class="card-title"><i class="fa fa-list mr-2"></i>Recent Conversions</h4>
        <div class="card-header-actions">
            <select class="chart-filter">
                <option>Last 24 hours</option>
                <option>Last 7 days</option>
                <option>Last 30 days</option>
            </select>
        </div>
    </div>
    <div class="card-body dashboard-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Source</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No conversions recorded yet</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('conversionsChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: { labels: [], datasets: [] },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
});
</script>
@endsection
