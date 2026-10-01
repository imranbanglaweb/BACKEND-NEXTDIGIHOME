@extends('admin.dashboard.master')

@section('title', 'Page Analytics - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-file-alt"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>Page Analytics</h1>
            <p>Detailed page-by-page tracking and performance metrics</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <button onclick="location.reload()" class="btn-refresh">
            <i class="fa fa-sync-alt"></i> Refresh
        </button>
        <a href="{{ route('metapixel.dashboard') }}" class="btn-new-requisition">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="role-indicator mb-4">
    <div class="alert alert-primary alert-role d-flex align-items-center">
        <i class="fa fa-info-circle mr-2"></i>
        <div>
            <strong>Page Analytics Overview</strong>
            <p class="mb-0 small">Analyze page views, load times, and user engagement metrics</p>
        </div>
    </div>
</div>

<div class="row stats-row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon"><i class="fa fa-file-alt"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Total Tracked Pages</span>
                <span class="stat-value">0</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Active</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-clock"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Avg Load Time</span>
                <span class="stat-value">0s</span>
                <span class="stat-trend stat-trend-neutral"><i class="fa fa-minus"></i> ms</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-tachometer-alt"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Fastest Page</span>
                <span class="stat-value">-</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> ms</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Slowest Page</span>
                <span class="stat-value">-</span>
                <span class="stat-trend stat-trend-down"><i class="fa fa-arrow-down"></i> ms</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-line mr-2"></i>Page Performance Over Time</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="pagePerformanceChart"></canvas>
                </div>
                <p class="text-center text-muted mt-3">No performance data available yet. Visit pages to generate tracking data.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-list mr-2"></i>Tracked Events by Page</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="eventsByPageChart"></canvas>
                </div>
                <p class="text-center text-muted mt-3">No event data available yet.</p>
            </div>
        </div>
    </div>
</div>

<div class="card dashboard-card">
    <div class="card-header dashboard-card-header">
        <h4 class="card-title"><i class="fa fa-table mr-2"></i>Page Load Times</h4>
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
                        <th>Page</th>
                        <th>Views</th>
                        <th>Avg Load Time</th>
                        <th>Min Time</th>
                        <th>Max Time</th>
                        <th>Bounce Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No page data available. Visit pages to generate tracking data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perfCtx = document.getElementById('pagePerformanceChart');
    if (perfCtx) {
        new Chart(perfCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                }
            }
        });
    }
});
</script>

<style>
.table-responsive { max-height: 400px; overflow-y: auto; }
.table-responsive::-webkit-scrollbar { width: 6px; }
.table-responsive::-webkit-scrollbar-track { background: transparent; }
.table-responsive::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
</style>
@endsection