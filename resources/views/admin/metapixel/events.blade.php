@extends('admin.dashboard.master')

@section('title', 'User Events - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-list"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>User Events</h1>
            <p>Track user interactions and custom events across your platform</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <a href="{{ route('metapixel.dashboard') }}" class="btn-new-requisition">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="role-indicator mb-4">
    <div class="alert alert-info alert-role d-flex align-items-center">
        <i class="fa fa-list mr-2"></i>
        <div>
            <strong>Event Tracking Overview</strong>
            <p class="mb-0 small">Monitor user interactions, clicks, and custom events in real-time</p>
        </div>
    </div>
</div>

<div class="row stats-row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon"><i class="fa fa-mouse-pointer"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Total Events</span>
                <span class="stat-value">0</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Today</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-users"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Unique Users</span>
                <span class="stat-value">0</span>
                <span class="stat-trend stat-trend-neutral"><i class="fa fa-minus"></i> Active</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-chart-line"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Event Types</span>
                <span class="stat-value">6</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Tracked</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-fire"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Top Event</span>
                <span class="stat-value">-</span>
                <span class="stat-trend stat-trend-down"><i class="fa fa-arrow-down"></i> clicks</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-bar mr-2"></i>Events Over Time</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="eventsChart"></canvas>
                </div>
                <p class="text-center text-muted mt-3">No event data available yet. User interactions will appear here.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-pie mr-2"></i>Event Distribution</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="eventDistributionChart"></canvas>
                </div>
                <p class="text-center text-muted mt-3">No events recorded yet.</p>
            </div>
        </div>
    </div>
</div>

<div class="card dashboard-card">
    <div class="card-header dashboard-card-header">
        <h4 class="card-title"><i class="fa fa-history mr-2"></i>Recent Events</h4>
        <div class="card-header-actions">
            <select class="chart-filter">
                <option>Last hour</option>
                <option>Last 24 hours</option>
                <option>Last 7 days</option>
            </select>
        </div>
    </div>
    <div class="card-body dashboard-card-body p-0">
        <div class="activity-list" style="max-height: 400px; overflow-y: auto;">
            <div class="activity-item">
                <div class="activity-content text-center py-4">
                    <p class="activity-text text-muted">No events recorded yet</p>
                    <span class="activity-time">User interactions will appear here</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Empty charts with placeholder
    var ctx1 = document.getElementById('eventsChart');
    if (ctx1) {
        new Chart(ctx1.getContext('2d'), {
            type: 'bar',
            data: { labels: [], datasets: [] },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
    
    var ctx2 = document.getElementById('eventDistributionChart');
    if (ctx2) {
        new Chart(ctx2.getContext('2d'), {
            type: 'doughnut',
            data: { labels: [], datasets: [] },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
});
</script>
@endsection