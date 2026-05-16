@extends('admin.dashboard.master')

@section('title', 'Dashboard - ' . config('app.name'))

@php
    // Define role variables if not already defined
    $isSuperAdmin = $isSuperAdmin ?? auth()->user()->hasRole('Super Admin');
    $isAdmin = $isAdmin ?? auth()->user()->hasRole('Admin');
    $isManager = $isManager ?? (auth()->user()->hasRole('Department Head') || auth()->user()->hasRole('Manager'));
    $isTransport = $isTransport ?? auth()->user()->hasRole('Transport');
    $isEmployee = $isEmployee ?? auth()->user()->hasRole('Employee');
    $isDriver = $isDriver ?? auth()->user()->hasRole('Driver');
@endphp

@section('main_content')
{{-- Premium Page Header --}}
<div class="premium-dashboard-header">
    <!-- Animated Background -->
    <div class="header-bg-gradient"></div>
    <div class="floating-elements">
        <div class="float-element float-1"></div>
        <div class="float-element float-2"></div>
        <div class="float-element float-3"></div>
        <div class="float-element float-4"></div>
        <div class="float-element float-5"></div>
    </div>

    <div class="premium-header-content">
        <div class="premium-header-left">
            <div class="premium-header-icon">
                <div class="icon-container">
                    <i class="fa fa-rocket"></i>
                    <div class="icon-glow"></div>
                    <div class="icon-particles">
                        <span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
            </div>
            <div class="premium-header-text">
                <h1 class="premium-title">
                    <span class="gradient-text">Next Digi Home</span>
                    <span class="subtitle">Dashboard</span>
                </h1>
                <p class="premium-welcome">Welcome back, <span class="user-name">{{ Auth::user()->name }}</span>! 🚀</p>
                <div class="premium-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['total'] ?? 0 }}</span>
                        <span class="stat-label">Total Orders</span>
                        <div class="stat-trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+12.5%</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['approved'] ?? 0 }}</span>
                        <span class="stat-label">Completed</span>
                        <div class="stat-trend-up">
                            <i class="fa fa-arrow-up"></i>
                            <span>+8.3%</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $stats['pending'] ?? 0 }}</span>
                        <span class="stat-label">Pending</span>
                        <div class="stat-trend-neutral">
                            <i class="fa fa-clock"></i>
                            <span>Processing</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="premium-header-right">
            <div class="premium-actions">
                <button onclick="location.reload()" class="premium-btn premium-btn-secondary">
                    <i class="fa fa-sync-alt"></i>
                    <span>Refresh</span>
                    <div class="btn-pulse"></div>
                </button>
                <a href="#" class="premium-btn premium-btn-primary">
                    <i class="fa fa-plus"></i>
                    <span>Add Product</span>
                    <div class="btn-shine"></div>
                </a>
            </div>
            <div class="premium-time">
                <div class="time-display">
                    <i class="fa fa-clock"></i>
                    <span id="current-time">{{ now()->format('H:i') }}</span>
                </div>
                <div class="date-display">
                    <span>{{ now()->format('l, F j, Y') }}</span>
                </div>
                <div class="live-indicator">
                    <div class="live-dot"></div>
                    <span>Live</span>
                </div>
            </div>
        </div>
    </div>
    <div class="premium-header-decoration">
        <div class="decoration-line"></div>
        <div class="decoration-dots">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="decoration-shapes">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="shape-3"></div>
        </div>
    </div>
</div>

{{-- Premium Role Indicator --}}
<div class="premium-role-indicator">
    @if($isSuperAdmin)
    <div class="premium-role-card premium-role-super">
        <div class="role-bg-glow"></div>
        <div class="role-bg-pattern"></div>
        <div class="role-icon">
            <i class="fa fa-crown"></i>
            <div class="icon-particles">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
            <div class="icon-ripple"></div>
        </div>
        <div class="role-content">
            <h3>Super Administrator</h3>
            <p>Full system access with all privileges</p>
            <div class="role-badge premium-badge">PREMIUM ACCESS</div>
        </div>
        <div class="role-decoration">
            <div class="decoration-stars">
                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
            </div>
        </div>
    </div>
    @elseif($isAdmin)
    <div class="premium-role-card premium-role-admin">
        <div class="role-bg-glow"></div>
        <div class="role-icon">
            <i class="fa fa-shield-alt"></i>
            <div class="icon-particles">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="role-content">
            <h3>Administrator</h3>
            <p>Administrative privileges for Next Digi Home</p>
            <div class="role-badge admin-badge">ADMIN ACCESS</div>
        </div>
    </div>
    @elseif($isManager)
    <div class="premium-role-card premium-role-manager">
        <div class="role-bg-glow"></div>
        <div class="role-icon">
            <i class="fa fa-user-tie"></i>
            <div class="icon-particles">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="role-content">
            <h3>Manager Dashboard</h3>
            <p>Product approval and team management access</p>
            <div class="role-badge manager-badge">MANAGER ACCESS</div>
        </div>
    </div>
    @elseif($isTransport)
    <div class="premium-role-card premium-role-transport">
        <div class="role-bg-glow"></div>
        <div class="role-icon">
            <i class="fa fa-truck"></i>
            <div class="icon-particles">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="role-content">
            <h3>Fulfillment Manager</h3>
            <p>Order fulfillment and delivery coordination</p>
            <div class="role-badge transport-badge">FULFILLMENT</div>
        </div>
    </div>
    @elseif($isDriver)
    <div class="premium-role-card premium-role-driver">
        <div class="role-bg-glow"></div>
        <div class="role-icon">
            <i class="fa fa-id-card"></i>
            <div class="icon-particles">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="role-content">
            <h3>Delivery Partner</h3>
            <p>View your deliveries, schedule, and update availability</p>
            <div class="role-badge driver-badge">DELIVERY</div>
        </div>
    </div>
    @else
    <div class="premium-role-card premium-role-employee">
        <div class="role-bg-glow"></div>
        <div class="role-icon">
            <i class="fa fa-user"></i>
            <div class="icon-particles">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="role-content">
            <h3>Team Member</h3>
            <p>Manage your digital products and orders</p>
            <div class="role-badge employee-badge">TEAM MEMBER</div>
        </div>
    </div>
    @endif
</div>

{{-- Premium Stats Cards --}}
<div class="premium-stats-grid">
    <div class="premium-stat-card premium-stat-orders">
        <div class="stat-card-glass"></div>
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-shopping-cart"></i>
                <div class="icon-bg"></div>
                <div class="icon-glow-pulse"></div>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($stats['total'] ?? 0) }}</div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-arrow-up"></i>
                    <span>+12.5% this month</span>
                </div>
            </div>
            <div class="stat-decoration">
                <div class="decoration-shape"></div>
                <div class="decoration-particles">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
        <div class="card-shine"></div>
        <div class="card-shadow-3d"></div>
    </div>

    <div class="premium-stat-card premium-stat-pending">
        <div class="stat-card-glass"></div>
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-clock"></i>
                <div class="icon-bg"></div>
                <div class="icon-glow-pulse"></div>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($stats['pending'] ?? 0) }}</div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-trend trend-neutral">
                    <i class="fa fa-clock"></i>
                    <span>Processing</span>
                </div>
            </div>
            <div class="stat-decoration">
                <div class="decoration-shape"></div>
                <div class="decoration-particles">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
        <div class="card-shine"></div>
        <div class="card-shadow-3d"></div>
    </div>

    <div class="premium-stat-card premium-stat-completed">
        <div class="stat-card-glass"></div>
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
                <div class="icon-bg"></div>
                <div class="icon-glow-pulse"></div>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ number_format($stats['approved'] ?? 0) }}</div>
                <div class="stat-label">Completed Orders</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-rocket"></i>
                    <span>Successfully delivered</span>
                </div>
            </div>
            <div class="stat-decoration">
                <div class="decoration-shape"></div>
                <div class="decoration-particles">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
        <div class="card-shine"></div>
        <div class="card-shadow-3d"></div>
    </div>

    <div class="premium-stat-card premium-stat-revenue">
        <div class="stat-card-glass"></div>
        <div class="stat-card-inner">
            <div class="stat-icon">
                <i class="fa fa-dollar-sign"></i>
                <div class="icon-bg"></div>
                <div class="icon-glow-pulse"></div>
            </div>
            <div class="stat-content">
                <div class="stat-number">$45,678</div>
                <div class="stat-label">Monthly Revenue</div>
                <div class="stat-trend trend-up">
                    <i class="fa fa-chart-line"></i>
                    <span>+8.2% growth</span>
                </div>
            </div>
            <div class="stat-decoration">
                <div class="decoration-shape"></div>
                <div class="decoration-particles">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
        <div class="card-shine"></div>
        <div class="card-shadow-3d"></div>
    </div>
</div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-clock"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Pending Orders</span>
                <span class="stat-value">{{ $stats['pending'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-neutral"><i class="fa fa-minus"></i> Processing</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-check-circle"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Completed Orders</span>
                <span class="stat-value">{{ $stats['approved'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Delivered</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-times-circle"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Cancelled Orders</span>
                <span class="stat-value">{{ $stats['rejected'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-down"><i class="fa fa-arrow-down"></i> Refunded</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

{{-- Premium Charts Section --}}
<div class="premium-charts-section">
    <div class="premium-chart-card premium-chart-large">
        <div class="chart-card-header">
            <div class="chart-title">
                <div class="chart-icon">
                    <i class="fa fa-chart-line"></i>
                </div>
                <div class="chart-text">
                    <h3>Monthly Sales Performance</h3>
                    <p>Revenue trends and growth analytics</p>
                </div>
            </div>
            <div class="chart-controls">
                <select class="premium-select" id="monthFilter">
                    <option value="12">Last 12 Months</option>
                    <option value="6">Last 6 Months</option>
                    <option value="3">Last 3 Months</option>
                </select>
                <button class="premium-btn premium-btn-outline">
                    <i class="fa fa-download"></i>
                    Export
                </button>
            </div>
        </div>
        <div class="chart-card-body">
            <div class="chart-container">
                <canvas id="monthlyRequisitionsChart"></canvas>
            </div>
            <div class="chart-insights">
                <div class="insight-item">
                    <span class="insight-value">+24.5%</span>
                    <span class="insight-label">Growth Rate</span>
                </div>
                <div class="insight-item">
                    <span class="insight-value">$156K</span>
                    <span class="insight-label">Best Month</span>
                </div>
                <div class="insight-item">
                    <span class="insight-value">89%</span>
                    <span class="insight-label">Target Achievement</span>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-chart-card premium-chart-small">
        <div class="chart-card-header">
            <div class="chart-title">
                <div class="chart-icon">
                    <i class="fa fa-chart-pie"></i>
                </div>
                <div class="chart-text">
                    <h3>Order Status Distribution</h3>
                    <p>Current order pipeline overview</p>
                </div>
            </div>
        </div>
        <div class="chart-card-body">
            <div class="chart-container">
                <canvas id="statusDistributionChart"></canvas>
            </div>
            <div class="status-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background: #10b981;"></span>
                    <span class="legend-text">Completed ({{ $stats['approved'] ?? 0 }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #f59e0b;"></span>
                    <span class="legend-text">Pending ({{ $stats['pending'] ?? 0 }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #ef4444;"></span>
                    <span class="legend-text">Cancelled ({{ $stats['rejected'] ?? 0 }})</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Premium Activity & Actions Section --}}
<div class="premium-activity-actions">
    <div class="premium-activity-card">
        <div class="activity-card-glass"></div>
        <div class="activity-card-header">
            <div class="activity-title">
                <div class="activity-icon">
                    <i class="fa fa-history"></i>
                    <div class="activity-icon-glow"></div>
                </div>
                <div class="activity-text">
                    <h3>Recent Activity</h3>
                    <p>Latest orders and system updates</p>
                </div>
            </div>
            <a href="#" class="premium-link">
                <span>View All</span>
                <i class="fa fa-arrow-right"></i>
                <div class="link-glow"></div>
            </a>
        </div>
        <div class="activity-card-body">
            @if($timeline && $timeline->count() > 0)
            <div class="activity-timeline">
                @foreach($timeline as $activity)
                <div class="activity-timeline-item">
                    <div class="timeline-dot timeline-dot-{{ $activity->status == 'Approved' ? 'success' : ($activity->status == 'Pending' ? 'warning' : 'info') }}">
                        <i class="fa fa-{{ $activity->status == 'Approved' ? 'check' : ($activity->status == 'Pending' ? 'clock' : 'info') }}"></i>
                        <div class="timeline-dot-pulse"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-text">{!! $activity->description ?? 'Order update' !!}</div>
                        <div class="timeline-meta">
                            <span class="timeline-time">{{ $activity->created_at->diffForHumans() }}</span>
                            <span class="timeline-user">{{ $activity->user_name ?? 'System' }}</span>
                        </div>
                    </div>
                    <div class="timeline-actions">
                        <button class="timeline-action-btn" title="View Details">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="activity-empty">
                <div class="empty-icon">
                    <i class="fa fa-rocket"></i>
                    <div class="empty-icon-glow"></div>
                </div>
                <div class="empty-content">
                    <h4>Welcome to Next Digi Home!</h4>
                    <p>Your marketplace activity will appear here</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="premium-actions-card">
        <div class="actions-card-glass"></div>
        <div class="actions-card-header">
            <div class="actions-title">
                <div class="actions-icon">
                    <i class="fa fa-bolt"></i>
                    <div class="actions-icon-glow"></div>
                </div>
                <div class="actions-text">
                    <h3>Quick Actions</h3>
                    <p>Common tasks and shortcuts</p>
                </div>
            </div>
        </div>
        <div class="actions-card-body">
            <div class="premium-action-grid">
                <a href="#" class="premium-action-item premium-action-primary">
                    <div class="action-glass"></div>
                    <div class="action-icon">
                        <i class="fa fa-plus-circle"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Add Product</span>
                        <span class="action-subtitle">Create new digital product</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                    <div class="action-shine"></div>
                </a>

                <a href="#" class="premium-action-item premium-action-info">
                    <div class="action-glass"></div>
                    <div class="action-icon">
                        <i class="fa fa-shopping-cart"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">View Orders</span>
                        <span class="action-subtitle">Manage customer orders</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="#" class="premium-action-item premium-action-success">
                    <div class="action-glass"></div>
                    <div class="action-icon">
                        <i class="fa fa-users"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Customers</span>
                        <span class="action-subtitle">Manage customer accounts</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="#" class="premium-action-item premium-action-warning">
                    <div class="action-glass"></div>
                    <div class="action-icon">
                        <i class="fa fa-chart-line"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Analytics</span>
                        <span class="action-subtitle">View sales reports</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                @if($isAdmin)
                <a href="#" class="premium-action-item premium-action-secondary">
                    <div class="action-glass"></div>
                    <div class="action-icon">
                        <i class="fa fa-cog"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Settings</span>
                        <span class="action-subtitle">Configure system</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <a href="#" class="premium-action-item premium-action-danger">
                    <div class="action-glass"></div>
                    <div class="action-icon">
                        <i class="fa fa-user-plus"></i>
                        <div class="action-pulse"></div>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Add User</span>
                        <span class="action-subtitle">Create new team member</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Premium Bottom Section --}}
<div class="premium-bottom-section">
    <div class="premium-notifications-card">
        <div class="notifications-card-header">
            <div class="notifications-title">
                <div class="notifications-icon">
                    <i class="fa fa-bell"></i>
                    @if($notifications && $notifications->count() > 0)
                    <span class="notification-badge">{{ $notifications->count() }}</span>
                    @endif
                </div>
                <div class="notifications-text">
                    <h3>Notifications</h3>
                    <p>Latest updates and alerts</p>
                </div>
            </div>
            <div class="notifications-actions">
                <button class="premium-btn premium-btn-outline small">
                    <i class="fa fa-check-double"></i>
                    Mark Read
                </button>
                <a href="#" class="premium-link">
                    <span>View All</span>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="notifications-card-body">
            @if($notifications && $notifications->count() > 0)
            <div class="premium-notification-list">
                @foreach($notifications as $notification)
                <div class="premium-notification-item">
                    <div class="notification-avatar notification-{{ $notification->type == 'App\Notifications\DepartmentApproved' ? 'success' : ($notification->type == 'App\Notifications\TransportApproved' ? 'info' : 'warning') }}">
                        <i class="fa fa-{{ $notification->type == 'App\Notifications\DepartmentApproved' ? 'check-circle' : ($notification->type == 'App\Notifications\TransportApproved' ? 'truck' : 'exclamation-triangle') }}"></i>
                    </div>
                    <div class="notification-details">
                        <div class="notification-message">{{ $notification->data['message'] ?? 'New notification' }}</div>
                        <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="notification-action">
                        <button class="notification-action-btn" title="View">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="notifications-empty">
                <div class="empty-icon">
                    <i class="fa fa-bell-slash"></i>
                </div>
                <div class="empty-content">
                    <h4>All Caught Up! 🎉</h4>
                    <p>No new notifications at this time</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="premium-products-card">
        <div class="products-card-header">
            <div class="products-title">
                <div class="products-icon">
                    <i class="fa fa-star"></i>
                </div>
                <div class="products-text">
                    <h3>Top Products</h3>
                    <p>Best performing digital products</p>
                </div>
            </div>
            <a href="#" class="premium-link">
                <span>View All</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="products-card-body">
            @if($topVehicles && $topVehicles->count() > 0)
            <div class="premium-products-list">
                @foreach($topVehicles as $index => $vehicle)
                <div class="premium-product-item">
                    <div class="product-rank-badge rank-{{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : 'bronze') }}">
                        @if($index === 0)
                            <i class="fa fa-crown"></i>
                        @elseif($index === 1)
                            <i class="fa fa-medal"></i>
                        @else
                            <i class="fa fa-medal"></i>
                        @endif
                        <span>#{{ $index + 1 }}</span>
                    </div>
                    <div class="product-details">
                        <div class="product-name">{{ $vehicle->vehicle_name ?? 'Digital Product' }}</div>
                        <div class="product-metrics">
                            <span class="metric-value">{{ number_format($vehicle->requisitions_count ?? 0) }}</span>
                            <span class="metric-label">sales</span>
                        </div>
                    </div>
                    <div class="product-progress">
                        @php $maxSales = $topVehicles->max('requisitions_count'); @endphp
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ ($vehicle->requisitions_count / ($maxSales ?: 1)) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="products-empty">
                <div class="empty-icon">
                    <i class="fa fa-file-code"></i>
                </div>
                <div class="empty-content">
                    <h4>No Products Yet</h4>
                    <p>Start adding digital products to see performance metrics</p>
                    <a href="#" class="premium-btn premium-btn-primary small">
                        <i class="fa fa-plus"></i>
                        Add First Product
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="premium-team-card">
        <div class="team-card-header">
            <div class="team-title">
                <div class="team-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="team-text">
                    <h3>Team Overview</h3>
                    <p>Active team members</p>
                </div>
            </div>
            <a href="#" class="premium-link">
                <span>Manage Team</span>
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="team-card-body">
            <div class="premium-team-grid">
                <div class="premium-team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #00d4aa 0%, #8b5cf6 100%);">
                        <span>IR</span>
                        <div class="status-dot online"></div>
                    </div>
                    <div class="member-info">
                        <div class="member-name">Imran Rahman</div>
                        <div class="member-role">CEO</div>
                    </div>
                    <div class="member-stats">
                        <div class="stat">
                            <span className="stat-value">24</span>
                            <span className="stat-label">Products</span>
                        </div>
                    </div>
                </div>

                <div class="premium-team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #8b5cf6 0%, #00d4aa 100%);">
                        <span>BA</span>
                        <div class="status-dot online"></div>
                    </div>
                    <div class="member-info">
                        <div class="member-name">Bristy Akter</div>
                        <div class="member-role">Operations Manager</div>
                    </div>
                    <div class="member-stats">
                        <div class="stat">
                            <span className="stat-value">156</span>
                            <span className="stat-label">Tasks</span>
                        </div>
                    </div>
                </div>

                <div class="premium-team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%);">
                        <span>I</span>
                        <div class="status-dot online"></div>
                    </div>
                    <div class="member-info">
                        <div class="member-name">Inaya</div>
                        <div class="member-role">Marketing Specialist</div>
                    </div>
                    <div class="member-stats">
                        <div class="stat">
                            <span className="stat-value">89</span>
                            <span className="stat-label">Campaigns</span>
                        </div>
                    </div>
                    <div class="member-info">
                        <div class="member-name">Imran Rahman</div>
                        <div class="member-role">CEO</div>
                    </div>
                    <div class="member-stats">
                        <div class="stat">
                            <span class="stat-value">24</span>
                            <span class="stat-label">Products</span>
                        </div>
                    </div>
                </div>

                <div class="premium-team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #8b5cf6 0%, #00d4aa 100%);">
                        <span>BA</span>
                        <div class="status-dot online"></div>
                    </div>
                    <div class="member-info">
                        <div class="member-name">Bristy Akter</div>
                        <div class="member-role">Operations Manager</div>
                    </div>
                    <div class="member-stats">
                        <div class="stat">
                            <span class="stat-value">156</span>
                            <span class="stat-label">Tasks</span>
                        </div>
                    </div>
                </div>

                <div class="premium-team-member">
                    <div class="member-avatar" style="background: linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%);">
                        <span>I</span>
                        <div class="status-dot online"></div>
                    </div>
                    <div class="member-info">
                        <div class="member-name">Inaya</div>
                        <div class="member-role">Marketing Specialist</div>
                    </div>
                    <div class="member-stats">
                        <div class="stat">
                            <span class="stat-value">89</span>
                            <span class="stat-label">Campaigns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function initCharts() {
    // Monthly Requisitions Bar Chart
    const monthlyCtx = document.getElementById('monthlyRequisitionsChart');
    if (monthlyCtx) {
        const monthLabels = {!! json_encode($monthLabels ?: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']) !!};
        const monthlyData = {!! json_encode($monthlyData ?: [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
        const monthlyDataNumbers = monthlyData.map(function(x) { return parseInt(x) || 0; });
        
        new Chart(monthlyCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Requisitions',
                    data: monthlyDataNumbers,
                    backgroundColor: 'rgba(79, 70, 229, 0.8)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#64748b' } },
                    y: { grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { color: '#64748b' }, beginAtZero: true }
                }
            }
        });
    }
    
    // Status Distribution Doughnut Chart
    const statusCtx = document.getElementById('statusDistributionChart');
    if (statusCtx) {
        const statusCountsRaw = {!! json_encode($statusCounts ?: ['Approved' => 0, 'Pending' => 0, 'Rejected' => 0]) !!};
        const statusLabels = Object.keys(statusCountsRaw);
        const statusValues = Object.values(statusCountsRaw).map(function(x) { return parseInt(x) || 0; });
        
        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
}

// Initialize charts when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initCharts, 100);
    });
} else {
    setTimeout(initCharts, 100);
}
</script>

{{-- Push Notifications Initialization --}}
<script>
// Service Worker Registration for Push Notifications
if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', async () => {
        try {
            // Register service worker from public folder
            const registration = await navigator.serviceWorker.register('{{ asset('service-worker.js') }}');
            console.log('Service Worker registered:', registration.scope);

            // Wait for the service worker to be ready
            await registration.ready;
            console.log('Service Worker ready');

            // Request notification permission
            if (Notification.permission !== 'granted') {
                const permission = await Notification.requestPermission();
                console.log('Notification permission:', permission);
                
                if (permission === 'granted') {
                    await subscribeToPush(registration);
                }
            } else {
                await subscribeToPush(registration);
            }
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    });
}

async function subscribeToPush(registration) {
    try {
        // VAPID public key (hardcoded for testing)
        const vapidPublicKey = 'BL8nB7H3jyXBugZ7NQbhyBidyynLlM9Ieuc1DaEYGpAp_adPZ1v8wGr94K2MGF1iXmX-qQSkZD9FdoNgXjY8SOY';
        
        // Validate VAPID key
        if (!vapidPublicKey || vapidPublicKey.length < 10) {
            console.error('Invalid VAPID public key:', vapidPublicKey);
            return;
        }
        
        console.log('VAPID key length:', vapidPublicKey.length);
        console.log('VAPID key:', vapidPublicKey);
        
        // Convert VAPID key to Uint8Array
        const applicationServerKey = urlBase64ToUint8Array(vapidPublicKey);
        
        console.log('Application server key:', applicationServerKey);
        
        // Subscribe to push
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: applicationServerKey
        });
        
        console.log('Push subscription:', subscription);
        
        // Send subscription to server
        const subscriptionData = subscription.toJSON();
        
        // Format data for the controller
        const formData = new FormData();
        formData.append('endpoint', subscriptionData.endpoint);
        formData.append('keys[auth]', subscriptionData.keys.auth);
        formData.append('keys[p256dh]', subscriptionData.keys.p256dh);
        
        await fetch('{{ url('/api/push/subscribe') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });
        
        console.log('Push subscription sent to server');
    } catch (error) {
        console.error('Push subscription failed:', error);
    }
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');
    
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
</script>


<style>
/* Dashboard Container */
.content-body {
  background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
  padding: 32px 40px;
}

.mb-4 {
  margin-bottom: 32px !important;
}

.row {
  margin-left: -16px;
  margin-right: -16px;
}

.col-xl-3, .col-xl-4, .col-xl-6, .col-xl-8,
.col-lg-5, .col-lg-6, .col-lg-7,
.col-md-12 {
  padding-left: 16px;
  padding-right: 16px;
}

.stats-row {
  gap: 16px;
}

.dashboard-widgets {
  gap: 16px;
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 16px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.35);
}

.dashboard-header-left { display: flex; align-items: center; gap: 16px; }

.dashboard-header-icon {
    width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: white;
}

.dashboard-header-content h1 { color: white; font-size: 20px; font-weight: 600; margin: 0 0 4px 0; }
.dashboard-header-content p { color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0; }

.dashboard-header-right { display: flex; gap: 12px; }

.btn-refresh, .btn-new-requisition {
    padding: 10px 18px; border-radius: 8px; font-weight: 500; font-size: 14px;
    cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    transition: all 0.2s ease; text-decoration: none;
}

.btn-refresh { background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); }
.btn-refresh:hover { background: rgba(255, 255, 255, 0.3); }

.btn-new-requisition { background: white; color: #4f46e5; border: none; }
.btn-new-requisition:hover { background: rgba(255, 255, 255, 0.9); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }

/* Stats Cards */
.stat-card {
    border-radius: 14px; padding: 26px 24px; position: relative; overflow: hidden;
    min-height: 140px; display: flex; justify-content: space-between; align-items: flex-start;
    transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1); color: white;
}

.stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18); }

.stat-card-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.stat-card-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
.stat-card-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
.stat-card-danger { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }

.stat-card-icon { 

...66620 bytes truncated...

The tool call succeeded but the output was truncated. Full output saved to: C:\Users\UGIT\.local\share\kilo\tool-output\tool_9e3f6cb0a1b8Q38IGd6ZfdMjuW
Use the Task tool to have explore agent process this file with Grep and Read (with offset/limit). Do NOT read the full file yourself - delegate to save context.