@extends('admin.dashboard.master')

@section('title', 'Department Dashboard - ' . config('app.name'))

@php
$user = Auth::user();
$department = $user->department;
@endphp

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #0891b2;
        --primary-dark: #0e7490;
        --primary-light: #06b6d4;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #6366f1;
        --bg-gradient: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
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
        box-shadow: 0 10px 40px rgba(6, 182, 212, 0.35);
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
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .welcome-section p {
        color: rgba(255,255,255,0.85);
        font-size: 14px;
        margin: 0;
    }
    
    .department-badge {
        background: rgba(255,255,255,0.2);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
    .stat-card.total::before { background: var(--primary-color); }
    .stat-card.team::before { background: var(--info-color); }
    
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
    .stat-card.total .stat-icon { background: #cffafe; color: var(--primary-color); }
    .stat-card.team .stat-icon { background: #e0e7ff; color: var(--info-color); }
    
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
        background: #cffafe;
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
        margin-bottom: 30px;
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
    
    /* Employee Info */
    .employee-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    
    .employee-details h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .employee-details p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
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
    
    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-approved { background: #d1fae5; color: #047857; }
    .badge-rejected { background: #fee2e2; color: #b91c1c; }
    
    /* Action Buttons */
    .btn-approve {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        background: var(--success-color);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-approve:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    .btn-reject {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        background: var(--danger-color);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-reject:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
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
    
    /* Alert Box */
    .alert-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: none;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .alert-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--warning-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .alert-content h5 {
        font-size: 15px;
        font-weight: 600;
        color: #92400e;
        margin: 0 0 4px 0;
    }
    
    .alert-content p {
        font-size: 13px;
        color: #b45309;
        margin: 0;
    }
    
    .alert-count {
        font-size: 24px;
        font-weight: 700;
        color: var(--warning-color);
        margin-left: auto;
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
            <h1><i class="fa fa-user-tie"></i> Department Head Dashboard</h1>
            <p>Welcome back, {{ $user->name }}! Manage your department's transport requests.</p>
            @if($department)
            <span class="department-badge"><i class="fa fa-building"></i> {{ $department->department_name }}</span>
            @endif
        </div>
        <div class="header-actions">
            <a href="{{ route('department.approvals.index') }}" class="btn-premium btn-primary-premium">
                <i class="fa fa-tasks"></i> Pending Approvals
            </a>
            <button onclick="location.reload()" class="btn-premium btn-outline-premium">
                <i class="fa fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>
</div>

{{-- Pending Approvals Alert --}}
@php
$pendingCount = $stats['pending'] ?? 0;
@endphp

@if($pendingCount > 0)
<div class="alert-pending">
    <div class="alert-icon">
        <i class="fa fa-clock"></i>
    </div>
    <div class="alert-content">
        <h5>Pending Approvals</h5>
        <p>You have requisitions awaiting your department approval</p>
    </div>
    <div class="alert-count">{{ $pendingCount }}</div>
</div>
@endif

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card team">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #e0e7ff; color: var(--info-color);">
                <i class="fa fa-users"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-building"></i> Team</span>
        </div>
        <div class="stat-value">{{ $departmentEmployeeCount ?? 0 }}</div>
        <div class="stat-label">Team Members</div>
    </div>
    
    <div class="stat-card total">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-clipboard-list"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-building"></i> Department</span>
        </div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Total Requests</div>
    </div>
    
    <div class="stat-card pending">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-hourglass-half"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-clock"></i> Action Required</span>
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
    
    <div class="stat-card rejected">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <span class="stat-trend down"><i class="fa fa-arrow-down"></i> Rejected</span>
        </div>
        <div class="stat-value">{{ $stats['rejected'] ?? 0 }}</div>
        <div class="stat-label">Rejected</div>
    </div>
</div>

{{-- Department Maintenance Stats Cards --}}
@if(isset($departmentMaintenanceStats) && ($departmentMaintenanceStats['total'] > 0 || $isManager))
<div class="stats-grid" style="margin-top: 30px;">
    <div class="stat-card total">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #fce7f3; color: #db2777;">
                <i class="fa fa-wrench"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-wrench"></i> Maintenance</span>
        </div>
        <div class="stat-value">{{ $departmentMaintenanceStats['total'] ?? 0 }}</div>
        <div class="stat-label">Total Maintenance</div>
    </div>
    
    <div class="stat-card pending">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                <i class="fa fa-clock"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-hourglass-half"></i> Awaiting</span>
        </div>
        <div class="stat-value">{{ ($departmentMaintenanceStats['pending'] ?? 0) + ($departmentMaintenanceStats['pending_approval'] ?? 0) }}</div>
        <div class="stat-label">Pending Maintenance</div>
    </div>
    
    <div class="stat-card approved">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #d1fae5; color: #059669;">
                <i class="fa fa-check-circle"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Approved</span>
        </div>
        <div class="stat-value">{{ $departmentMaintenanceStats['approved'] ?? 0 }}</div>
        <div class="stat-label">Approved Maintenance</div>
    </div>
    
    <div class="stat-card completed">
        <div class="stat-card-header">
            <div class="stat-icon" style="background: #cffafe; color: #0891b2;">
                <i class="fa fa-flag-checkered"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Completed</span>
        </div>
        <div class="stat-value">{{ $departmentMaintenanceStats['completed'] ?? 0 }}</div>
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
                <h5>All Maintenance</h5>
                <p>View all maintenance requests</p>
            </div>
        </a>
        
        <a href="{{ route('maintenance_approvals.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: #d97706;">
                <i class="fa fa-check-double"></i>
            </div>
            <div class="quick-action-text">
                <h5>Maintenance Approvals</h5>
                <p>Review pending approvals</p>
            </div>
        </a>
    </div>
</div>

{{-- Pending Maintenance Approvals Table --}}
@if($latestDepartmentMaintenance && $latestDepartmentMaintenance->count() > 0)
<div class="table-card" style="margin-top: 30px;">
    <div class="table-header">
        <h4><i class="fa fa-wrench" style="color: #db2777;"></i> Pending Maintenance Approvals</h4>
        <a href="{{ route('maintenance_approvals.index') }}" class="btn-view">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    
    <table class="table-premium">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Request ID</th>
                <th>Vehicle</th>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latestDepartmentMaintenance as $maintenance)
            <tr>
                <td>
                    <div class="employee-info">
                        <div class="employee-avatar" style="background: #db2777;">
                            {{ strtoupper(substr($maintenance->employee->first_name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="employee-details">
                            <h5>{{ $maintenance->employee->first_name ?? 'User' }} {{ $maintenance->employee->last_name ?? '' }}</h5>
                            <p>{{ $maintenance->employee->designation ?? 'Employee' }}</p>
                        </div>
                    </div>
                </td>
                <td><strong>{{ $maintenance->requisition_no }}</strong></td>
                <td>{{ $maintenance->vehicle->vehicle_name ?? '-' }}</td>
                <td>{{ Str::limit($maintenance->service_title, 25) }}</td>
                <td>{{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('M d, Y') }}</td>
                <td>
                    @if($maintenance->status == 'Pending')
                        <span class="badge-status badge-pending"><i class="fa fa-clock"></i> Pending</span>
                    @elseif($maintenance->status == 'Pending Approval')
                        <span class="badge-status badge-pending" style="background: #e0e7ff; color: #4338ca;"><i class="fa fa-clock"></i> Pending Approval</span>
                    @elseif($maintenance->status == 'Approved')
                        <span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>
                    @elseif($maintenance->status == 'Rejected')
                        <span class="badge-status badge-rejected"><i class="fa fa-times"></i> Rejected</span>
                    @else
                        <span class="badge-status badge-pending"><i class="fa fa-clock"></i> {{ $maintenance->status }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn-view">
                        <i class="fa fa-eye"></i> Review
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endif

{{-- Quick Actions --}}
<div class="quick-actions">
    <h4 class="section-title"><i class="fa fa-bolt" style="color: var(--primary-color);"></i> Quick Actions</h4>
    <div class="quick-actions-grid">
        <a href="{{ route('department.approvals.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--warning-color);">
                <i class="fa fa-check-double"></i>
            </div>
            <div class="quick-action-text">
                <h5>Pending Approvals</h5>
                <p>Review department requests</p>
            </div>
        </a>
        
        <a href="{{ route('requisitions.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--info-color);">
                <i class="fa fa-list"></i>
            </div>
            <div class="quick-action-text">
                <h5>All Requests</h5>
                <p>View all requisitions</p>
            </div>
        </a>
        
        <a href="{{ route('admin.employees.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--success-color);">
                <i class="fa fa-users"></i>
            </div>
            <div class="quick-action-text">
                <h5>Team Members</h5>
                <p>Manage department staff</p>
            </div>
        </a>
        
        <a href="{{ route('reports.requisitions') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--danger-color);">
                <i class="fa fa-chart-bar"></i>
            </div>
            <div class="quick-action-text">
                <h5>Department Reports</h5>
                <p>View analytics</p>
            </div>
        </a>
    </div>
</div>

{{-- Pending Approvals Table --}}
<div class="table-card">
    <div class="table-header">
        <h4><i class="fa fa-hourglass-half" style="color: var(--warning-color);"></i> Pending Department Approvals</h4>
        <a href="{{ route('department.approvals.index') }}" class="btn-view">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    
    @if($latest && $latest->count() > 0)
    <table class="table-premium">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Travel Date</th>
                <th>Destination</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latest as $requisition)
            <tr>
                <td>
                    <div class="employee-info">
                        <div class="employee-avatar">
                            {{ strtoupper(substr($requisition->employee->first_name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="employee-details">
                            <h5>{{ $requisition->employee->first_name ?? 'User' }} {{ $requisition->employee->last_name ?? '' }}</h5>
                            <p>{{ $requisition->employee->designation ?? 'Employee' }}</p>
                        </div>
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($requisition->travel_date)->format('M d, Y') }}</td>
                <td>{{ $requisition->destination }}</td>
                <td>{{ Str::limit($requisition->purpose, 25) }}</td>
                <td>
                    @if($requisition->department_status == 'Pending')
                        <span class="badge-status badge-pending"><i class="fa fa-clock"></i> Pending</span>
                    @elseif($requisition->department_status == 'Approved')
                        <span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>
                    @else
                        <span class="badge-status badge-rejected"><i class="fa fa-times"></i> Rejected</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('department.approvals.show', $requisition->id) }}" class="btn-view">
                        <i class="fa fa-eye"></i> Review
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fa fa-check-circle"></i>
        </div>
        <h4>All Caught Up!</h4>
        <p>No pending approvals at the moment.</p>
    </div>
    @endif
</div>
@endsection
