@extends('admin.dashboard.master')

@section('title', 'Meta Pixel Dashboard - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-chart-pie"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>Meta Pixel Analytics</h1>
            <p>Track and analyze user engagement across your platform</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <button onclick="location.reload()" class="btn-refresh">
            <i class="fa fa-sync-alt"></i> Refresh
        </button>
        <a href="{{ route('metapixel.config') }}" class="btn-new-requisition">
            <i class="fa fa-cog"></i> Settings
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-role d-flex align-items-center mb-4">
    <i class="fa fa-check-circle mr-2"></i>
    <div>
        <strong>Success!</strong>
        <p class="mb-0 small">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Status Indicator -->
<div class="role-indicator mb-4">
    <div class="alert {{ $is_enabled ? 'alert-success' : 'alert-danger' }} alert-role d-flex align-items-center">
        <i class="fa {{ $is_enabled ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
        <div>
            <strong>{{ $is_enabled ? 'Meta Pixel Active' : 'Meta Pixel Inactive' }}</strong>
            <p class="mb-0 small">Pixel ID: {{ $pixel_id }} | Admin Tracking: {{ $track_admin ? 'Enabled' : 'Disabled' }} | User Details: {{ $track_user_details ? 'Enabled' : 'Disabled' }}</p>
        </div>
    </div>
</div>

<!-- Key Metrics Row -->
<div class="row stats-row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon"><i class="fa fa-eye"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Total Page Views</span>
                <span class="stat-value">{{ number_format($page_views_total) }}</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Today</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-users"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Unique Visitors</span>
                <span class="stat-value">{{ number_format($unique_visitors) }}</span>
                <span class="stat-trend stat-trend-neutral"><i class="fa fa-minus"></i> All Time</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Conversions</span>
                <span class="stat-value">{{ number_format($conversion_count) }}</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Completed</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-mouse-pointer"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Admin Interactions</span>
                <span class="stat-value">{{ number_format($admin_interactions) }}</span>
                <span class="stat-trend stat-trend-down"><i class="fa fa-arrow-down"></i> This Week</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-bar mr-2"></i>Page Views Analytics</h4>
                <div class="card-header-actions">
                    <select class="chart-filter" id="pageViewFilter">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>
                </div>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="pageViewsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-pie mr-2"></i>Top Pages</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="topPagesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Row -->
<div class="row dashboard-widgets mb-4">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-bolt mr-2"></i>Quick Analytics Actions</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('metapixel.pages') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-primary"><i class="fa fa-file-alt"></i></div>
                        <span>Page Analytics</span>
                    </a>
                    <a href="{{ route('metapixel.events') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-info"><i class="fa fa-list"></i></div>
                        <span>User Events</span>
                    </a>
                    <a href="{{ route('metapixel.sources') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-warning"><i class="fa fa-external-link-alt"></i></div>
                        <span>Traffic Sources</span>
                    </a>
                    <a href="{{ route('metapixel.conversions') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-success"><i class="fa fa-chart-line"></i></div>
                        <span>Conversions</span>
                    </a>
                    <a href="{{ route('metapixel.config') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-danger"><i class="fa fa-cog"></i></div>
                        <span>Configuration</span>
                    </a>
                    <a href="{{ route('metapixel.dashboard') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-secondary"><i class="fa fa-redo"></i></div>
                        <span>Refresh Data</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-history mr-2"></i>Recent Events</h4>
                <a href="{{ route('metapixel.events') }}" class="card-header-link">View All</a>
            </div>
            <div class="card-body dashboard-card-body p-0">
                @if(!empty($recent_events) && count($recent_events) > 0)
                <div class="activity-list">
                    @foreach($recent_events as $activity)
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-{{ $activity['type'] ?? 'info' }}">
                            <i class="fa fa-{{ $activity['icon'] ?? 'info' }}"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">{{ $activity['description'] ?? 'Event recorded' }}</p>
                            <span class="activity-time">{{ $activity['time'] ?? 'Just now' }}</span>
                        </div>
                        <div class="activity-actions">
                            <button class="activity-btn" title="View Details"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-success"><i class="fa fa-chart-line"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">No tracking data yet. Start by visiting pages!</p>
                            <span class="activity-time">No events recorded</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Configuration Summary -->
<div class="row dashboard-widgets">
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-cogs mr-2"></i>Tracking Configuration</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="config-list">
                    <div class="config-item">
                        <span class="config-label">Pixel Status</span>
                        <span class="config-value {{ $is_enabled ? 'text-success' : 'text-danger' }}"><i class="fa fa-{{ $is_enabled ? 'check' : 'times' }}-circle"></i> {{ $is_enabled ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="config-item">
                        <span class="config-label">Admin Tracking</span>
                        <span class="config-value {{ $track_admin ? 'text-success' : 'text-muted' }}"><i class="fa fa-{{ $track_admin ? 'check' : 'ban' }}"></i> {{ $track_admin ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="config-item">
                        <span class="config-label">User Details</span>
                        <span class="config-value {{ $track_user_details ? 'text-success' : 'text-muted' }}"><i class="fa fa-{{ $track_user_details ? 'check' : 'ban' }}"></i> {{ $track_user_details ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="config-item">
                        <span class="config-label">Excluded Routes</span>
                        <span class="config-value">{{ count($excluded_routes) }} routes</span>
                    </div>
                    <div class="config-item">
                        <span class="config-label">Active Events</span>
                        <span class="config-value">{{ count($tracked_events) }} events</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-code mr-2"></i>Pixel Implementation</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle mr-2"></i>
                    <strong>Meta Pixel ID:</strong> {{ $pixel_id }}
                </div>
                <p class="small text-muted mb-3">The Meta Pixel is automatically included on all pages via the layout files.</p>
                <div class="code-snippet">
                    <pre class="bg-light p-2 rounded"><code>&lt;!-- Meta Pixel Code --&gt;
&lt;script&gt;
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $pixel_id }}');
fbq('track', 'PageView');
&lt;/script&gt;</code></pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-question-circle mr-2"></i>Help & Support</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fa fa-book mr-2 text-primary"></i>
                        <a href="https://developers.facebook.com/docs/meta-pixel" target="_blank">Meta Pixel Docs</a>
                    </li>
                    <li class="mb-2">
                        <i class="fa fa-graduation-cap mr-2 text-success"></i>
                        <a href="{{ route('metapixel.config') }}">Configure Tracking</a>
                    </li>
                    <li class="mb-2">
                        <i class="fa fa-chart-line mr-2 text-info"></i>
                        <a href="{{ route('metapixel.events') }}">View Events</a>
                    </li>
                    <li class="mb-2">
                        <i class="fa fa-exclamation-triangle mr-2 text-warning"></i>
                        <a href="#debug" onclick="document.getElementById('debug-panel').style.display='block'">Debug Mode</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Debug Panel (for admins with APP_DEBUG=true) -->
@if(config('app.debug'))
<div id="debug-panel" style="position: fixed; bottom: 10px; right: 10px; background: rgba(0,0,0,0.9); color: white; padding: 15px; border-radius: 8px; font-size: 12px; z-index: 9999; max-width: 350px; display: none;">
    <strong style="color: #00ff00;">Meta Pixel Debug Panel</strong><br>
    <small>Pixel ID: {{ $pixel_id }}</small><br>
    <small>Status: {{ $is_enabled ? 'Enabled' : 'Disabled' }}</small><br>
    <small>Route: {{ $current_route ?? 'N/A' }}</small><br>
    <small>Tracked: {{ implode(', ', $tracked_events) ?: 'None' }}</small><br>
    <small>User: {{ auth()->user()->name ?? 'Guest' }}</small><br>
    <small>Role: {{ auth()->user()->role ?? auth()->user()->roles()->first()->name ?? 'N/A' }}</small><br>
    <button onclick="document.getElementById('debug-panel').style.display='none'" style="background: #ff4444; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-top: 10px;">Close</button>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize charts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Page Views Chart
    var pageViewsCtx = document.getElementById('pageViewsChart');
    if (pageViewsCtx) {
        new Chart(pageViewsCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Page Views',
                    data: [120, 190, 150, 200, 180, 220, 250],
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Top Pages Chart
    var topPagesCtx = document.getElementById('topPagesChart');
    if (topPagesCtx) {
        new Chart(topPagesCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Dashboard', 'Requisitions', 'Reports', 'Vehicle Mgmt', 'Drivers'],
                datasets: [{
                    data: [35, 25, 20, 12, 8],
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Animate stat cards on hover
    var statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-6px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Chart filter functionality
document.getElementById('pageViewFilter')?.addEventListener('change', function() {
    // In a real implementation, this would fetch new data based on the selected period
    var filter = this.value;
    console.log('Loading page views for period:', filter);
    // You would make an AJAX request here to load new chart data
});
</script>

<style>
.stats-row {
    gap: 16px;
}
.dashboard-widgets {
    gap: 16px;
}
.config-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.config-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
}
.config-item:last-child {
    border-bottom: none;
}
.config-label {
    font-size: 14px;
    color: #6b7280;
}
.config-value {
    font-weight: 600;
    font-size: 14px;
}
.code-snippet {
    background: #f8f9fa;
    border-radius: 6px;
    overflow: hidden;
}
.code-snippet pre {
    margin: 0;
    font-size: 12px;
    overflow-x: auto;
}
</style>
@endsection