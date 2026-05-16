@extends('admin.dashboard.master')

@section('title', 'Traffic Sources - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-external-link-alt"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>Traffic Sources</h1>
            <p>Analyze where your visitors are coming from</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <a href="{{ route('metapixel.dashboard') }}" class="btn-new-requisition">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="role-indicator mb-4">
    <div class="alert alert-primary alert-role d-flex align-items-center">
        <i class="fa fa-external-link-alt mr-2"></i>
        <div>
            <strong>Traffic Source Analytics</strong>
            <p class="mb-0 small">Understand your acquisition channels and referral sources</p>
        </div>
    </div>
</div>

<div class="row stats-row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon"><i class="fa fa-link"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Total Referrals</span>
                <span class="stat-value">0</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-search"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Organic Search</span>
                <span class="stat-value">0%</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-share-alt"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Social Media</span>
                <span class="stat-value">0%</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-ad"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Direct</span>
                <span class="stat-value">0%</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-pie mr-2"></i>Source Distribution</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="sourceChart"></canvas>
                </div>
                <p class="text-center text-muted mt-3">No traffic source data available yet.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-list mr-2"></i>Top Referrals</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Visits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">No referral data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('sourceChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: { labels: [], datasets: [] },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
});
</script>
@endsection
