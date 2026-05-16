@extends('admin.dashboard.master')

@section('title', 'My Dashboard - ' . config('app.name'))

@php
$user = Auth::user();
$employee = $user->employee;
@endphp

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #6366f1;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        --card-shadow-hover: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    
    body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    
    /* Header Section */
    .dashboard-header {
        background: var(--bg-gradient);
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.35);
    }
    
    .dashboard-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .welcome-section h1 {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .welcome-section p {
        color: rgba(255,255,255,0.85);
        font-size: 14px;
        margin: 0;
    }
    
    .user-avatar-large {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: var(--primary-color);
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-premium {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-premium {
        background: white;
        color: var(--primary-color);
    }
    
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }
    
    .btn-outline-premium {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .btn-outline-premium:hover {
        background: rgba(255,255,255,0.3);
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }
    
    .stat-card.pending::before { background: var(--warning-color); }
    .stat-card.approved::before { background: var(--success-color); }
    .stat-card.rejected::before { background: var(--danger-color); }
    .stat-card.completed::before { background: var(--info-color); }
    .stat-card.total::before { background: var(--primary-color); }
    
    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .stat-card.pending .stat-icon { background: #fef3c7; color: var(--warning-color); }
    .stat-card.approved .stat-icon { background: #d1fae5; color: var(--success-color); }
    .stat-card.rejected .stat-icon { background: #fee2e2; color: var(--danger-color); }
    .stat-card.completed .stat-icon { background: #cffafe; color: var(--info-color); }
    .stat-card.total .stat-icon { background: #e0e7ff; color: var(--primary-color); }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }
    
    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        margin-top: 10px;
    }
    
    .stat-trend.up { background: #d1fae5; color: var(--success-color); }
    .stat-trend.down { background: #fee2e2; color: var(--danger-color); }
    .stat-trend.neutral { background: #f3f4f6; color: #64748b; }
    
    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px;
        border-radius: 12px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .quick-action-item:hover {
        background: #e0e7ff;
        transform: translateX(5px);
    }
    
    .quick-action-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: var(--primary-color);
        color: white;
    }
    
    .quick-action-text h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    
    .quick-action-text p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    
    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .table-header {
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .table-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-premium thead th {
        background: #f8fafc;
        padding: 14px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-premium tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }
    
    .table-premium tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-pending {
        background: #fef3c7;
        color: #b45309;
    }
    
    .badge-approved {
        background: #d1fae5;
        color: #047857;
    }
    
    .badge-rejected {
        background: #fee2e2;
        color: #b91c1c;
    }
    
    .badge-completed {
        background: #cffafe;
        color: #0e7490;
    }
    
    .badge-in-progress {
        background: #e0e7ff;
        color: #4338ca;
    }
    
    /* Action Buttons */
    .btn-view {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        background: var(--primary-color);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-view:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    
    .empty-state-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }
    
    .empty-state h4 {
        color: #64748b;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #94a3b8;
        font-size: 14px;
    }
    
    /* Timeline */
    .activity-timeline {
        padding: 20px;
    }
    
    .timeline-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .timeline-item:last-child {
        border-bottom: none;
    }
    
    .timeline-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    .timeline-icon.success { background: #d1fae5; color: var(--success-color); }
    .timeline-icon.warning { background: #fef3c7; color: var(--warning-color); }
    .timeline-icon.danger { background: #fee2e2; color: var(--danger-color); }
    .timeline-icon.info { background: #cffafe; color: var(--info-color); }
    
    .timeline-content {
        flex: 1;
    }
    
    .timeline-content h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    
    .timeline-content p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    
    .timeline-time {
        font-size: 12px;
        color: #94a3b8;
    }
    
    @media (max-width: 768px) {
        .dashboard-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .header-actions {
            width: 100%;
            justify-content: center;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Dashboard Header --}}
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <div class="welcome-section">
            <h1><i class="fa fa-user-circle mr-2"></i>Welcome back, {{ $user->name }}!</h1>
            <p>Here's what's happening with your transport requisitions</p>
        </div>
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="user-avatar-large">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="header-actions">
                <a href="{{ route('requisitions.create') }}" class="btn-premium btn-primary-premium">
                    <i class="fa fa-plus"></i> New Request
                </a>
                <button onclick="location.reload()" class="btn-premium btn-outline-premium">
                    <i class="fa fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card total">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-clipboard-list"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-layer-group"></i> All Time</span>
        </div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Total Requests</div>
    </div>
    
    <div class="stat-card pending">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-hourglass-half"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-clock"></i> Awaiting</span>
        </div>
        <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
        <div class="stat-label">Pending Approval</div>
    </div>
    
    <div class="stat-card approved">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Approved</span>
        </div>
        <div class="stat-value">{{ $stats['dept_approved'] ?? 0 }}</div>
        <div class="stat-label">Department Approved</div>
    </div>
    
    <div class="stat-card completed">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-flag-checkered"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Completed</span>
        </div>
        <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
        <div class="stat-label">Completed Trips</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <h4 class="section-title"><i class="fa fa-bolt" style="color: var(--primary-color);"></i> Quick Actions</h4>
    <div class="quick-actions-grid">
        <a href="{{ route('requisitions.create') }}" class="quick-action-item">
            <div class="quick-action-icon">
                <i class="fa fa-plus"></i>
            </div>
            <div class="quick-action-text">
                <h5>New Requisition</h5>
                <p>Submit transport request</p>
            </div>
        </a>
        
        <a href="{{ route('requisitions.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--success-color);">
                <i class="fa fa-list"></i>
            </div>
            <div class="quick-action-text">
                <h5>My Requests</h5>
                <p>View all your requests</p>
            </div>
        </a>
        
        <a href="{{ route('requisitions.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--info-color);">
                <i class="fa fa-search"></i>
            </div>
            <div class="quick-action-text">
                <h5>Track Status</h5>
                <p>Check request status</p>
            </div>
        </a>
        
        <a href="{{ route('user-profile') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--warning-color);">
                <i class="fa fa-user-cog"></i>
            </div>
            <div class="quick-action-text">
                <h5>My Profile</h5>
                <p>Update your details</p>
            </div>
        </a>
    </div>
</div>

{{-- Maintenance Requisition Stats Cards --}}
@if(isset($maintenanceStats) && ($maintenanceStats['total'] > 0 || $isAdmin))
<div class="stats-grid" style="margin-top: 30px;">
    <div class="stat-card total">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #fce7f3; color: #db2777;">
                <i class="fa fa-wrench"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-layer-group"></i> All Time</span>
        </div>
        <div class="stat-value">{{ $maintenanceStats['total'] ?? 0 }}</div>
        <div class="stat-label">Total Maintenance</div>
    </div>
    
    <div class="stat-card pending">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                <i class="fa fa-clock"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-hourglass-half"></i> Awaiting</span>
        </div>
        <div class="stat-value">{{ ($maintenanceStats['pending'] ?? 0) + ($maintenanceStats['pending_approval'] ?? 0) }}</div>
        <div class="stat-label">Pending Maintenance</div>
    </div>
    
    <div class="stat-card approved">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #d1fae5; color: #059669;">
                <i class="fa fa-check-circle"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Approved</span>
        </div>
        <div class="stat-value">{{ $maintenanceStats['approved'] ?? 0 }}</div>
        <div class="stat-label">Approved Maintenance</div>
    </div>
    
    <div class="stat-card completed">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #cffafe; color: #0891b2;">
                <i class="fa fa-flag-checkered"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Completed</span>
        </div>
        <div class="stat-value">{{ $maintenanceStats['completed'] ?? 0 }}</div>
        <div class="stat-label">Completed Maintenance</div>
    </div>
</div>

{{-- Quick Actions for Maintenance --}}
<div class="quick-actions" style="margin-top: 30px;">
    <h4 class="section-title"><i class="fa fa-wrench" style="color: #db2777;"></i> Maintenance Quick Actions</h4>
    <div class="quick-actions-grid">
        <a href="{{ route('maintenance.create') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: #db2777;">
                <i class="fa fa-plus"></i>
            </div>
            <div class="quick-action-text">
                <h5>New Maintenance</h5>
                <p>Submit maintenance request</p>
            </div>
        </a>
        
        <a href="{{ route('maintenance.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: #059669;">
                <i class="fa fa-list"></i>
            </div>
            <div class="quick-action-text">
                <h5>My Maintenance</h5>
                <p>View all maintenance requests</p>
            </div>
        </a>
    </div>
</div>

{{-- Recent Maintenance Requisitions --}}
<div class="table-card" style="margin-top: 30px;">
    <div class="table-header">
        <h4><i class="fa fa-wrench" style="color: #db2777;"></i> My Recent Maintenance Requests</h4>
        <a href="{{ route('maintenance.index') }}" class="btn-view">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    
    @if($latestMaintenance && $latestMaintenance->count() > 0)
    <table class="table-premium">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Vehicle</th>
                <th>Service</th>
                <th>Maintenance Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latestMaintenance as $maintenance)
            <tr>
                <td><strong>{{ $maintenance->requisition_no }}</strong></td>
                <td>{{ $maintenance->vehicle->vehicle_name ?? '-' }} ({{ $maintenance->vehicle->vehicle_no ?? '-' }})</td>
                <td>{{ Str::limit($maintenance->service_title, 30) }}</td>
                <td>{{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('M d, Y') }}</td>
                <td>
                    @if($maintenance->status == 'Completed')
                        <span class="badge-status badge-completed"><i class="fa fa-check"></i> Completed</span>
                    @elseif($maintenance->status == 'Approved')
                        <span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>
                    @elseif($maintenance->status == 'Rejected')
                        <span class="badge-status badge-rejected"><i class="fa fa-times"></i> Rejected</span>
                    @elseif($maintenance->status == 'Pending Approval')
                        <span class="badge-status badge-in-progress"><i class="fa fa-clock"></i> Pending Approval</span>
                    @else
                        <span class="badge-status badge-pending"><i class="fa fa-clock"></i> Pending</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn-view">
                        <i class="fa fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fa fa-wrench"></i>
        </div>
        <h4>No Maintenance Requests</h4>
        <p>You haven't submitted any maintenance requests yet.</p>
        <a href="{{ route('maintenance.create') }}" class="btn-view" style="margin-top: 15px;">
            <i class="fa fa-plus"></i> Create Your First Request
        </a>
    </div>
    @endif
</div>
@endif

{{-- Recent Requisitions --}}
<div class="table-card">
    <div class="table-header">
        <h4><i class="fa fa-history" style="color: var(--primary-color);"></i> My Recent Requisitions</h4>
        <a href="{{ route('requisitions.index') }}" class="btn-view">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    
    @if($latest && $latest->count() > 0)
    <table class="table-premium">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Travel Date</th>
                <th>Purpose</th>
                <th>Destination</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latest as $requisition)
            <tr>
                <td><strong>#REQ-{{ str_pad($requisition->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($requisition->travel_date)->format('M d, Y') }}</td>
                <td>{{ Str::limit($requisition->purpose, 30) }}</td>
                <td>{{ $requisition->to_location }}</td>
                <td>
                    @if($requisition->status == 'Completed')
                        <span class="badge-status badge-completed"><i class="fa fa-check"></i> Completed</span>
                    @elseif($requisition->transport_status == 'Approved')
                        <span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>
                    @elseif($requisition->department_status == 'Rejected' || $requisition->transport_status == 'Rejected')
                        <span class="badge-status badge-rejected"><i class="fa fa-times"></i> Rejected</span>
                    @elseif($requisition->department_status == 'Approved' && $requisition->transport_status == 'Pending')
                        <span class="badge-status badge-in-progress"><i class="fa fa-truck"></i> Transport Pending</span>
                    @else
                        <span class="badge-status badge-pending"><i class="fa fa-clock"></i> Pending</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('requisitions.show', $requisition->id) }}" class="btn-view">
                        <i class="fa fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fa fa-clipboard"></i>
        </div>
        <h4>No Requisitions Yet</h4>
        <p>You haven't submitted any transport requisitions yet.</p>
        <a href="{{ route('requisitions.create') }}" class="btn-view" style="margin-top: 15px;">
            <i class="fa fa-plus"></i> Create Your First Request
        </a>
    </div>
    @endif
</div>
@endsection
