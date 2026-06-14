@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body customer-page">
    <div class="container-fluid">
        <div class="customer-header">
            <div>
                <div class="customer-eyebrow">Customers</div>
                <h2>Customer Groups</h2>
                <p>Live customer segments calculated from account and purchase behavior.</p>
            </div>
            <div class="customer-header-actions">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">
                    <i class="fas fa-users me-2"></i>Customers
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <div class="customer-nav mb-3">
            <a href="{{ route('admin.customers.index') }}">Customers</a>
            <a href="{{ route('admin.customer-groups.index') }}" class="active">Groups</a>
            <a href="{{ route('admin.customers.reviews') }}">Reviews</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-blue"><i class="fas fa-users-cog"></i></span><div><small>Segments</small><strong>{{ number_format($stats['groups'] ?? 0) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-green"><i class="fas fa-users"></i></span><div><small>Segment Members</small><strong>{{ number_format($stats['grouped_customers'] ?? 0) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-cyan"><i class="fas fa-dollar-sign"></i></span><div><small>Segment Revenue</small><strong>$ {{ number_format($stats['group_revenue'] ?? 0, 2) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-amber"><i class="fas fa-user"></i></span><div><small>Total Customers</small><strong>{{ number_format($stats['total_customers'] ?? 0) }}</strong></div></div></div>
        </div>

        <div class="customer-panel mb-3">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>
                These groups are dynamic segments. A dedicated customer-group table is not present in this codebase, so members are calculated from orders and registration dates.
            </div>
        </div>

        <div class="customer-panel">
            <div class="customer-panel-title">
                <div>
                    <h5>Segments</h5>
                    <p>Use these segments for analysis, campaigns, and customer follow-up.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table customer-table" id="groupsTable">
                    <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Members</th>
                            <th>Revenue</th>
                            <th>Avg Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td class="fw-bold">{{ $group['name'] }}</td>
                                <td><span class="badge bg-info">{{ $group['type'] }}</span></td>
                                <td>{{ $group['description'] }}</td>
                                <td><span class="badge bg-primary">{{ number_format($group['members']) }}</span></td>
                                <td class="fw-bold text-success">$ {{ number_format($group['revenue'], 2) }}</td>
                                <td>$ {{ $group['members'] > 0 ? number_format($group['revenue'] / $group['members'], 2) : '0.00' }}</td>
                                <td><span class="badge bg-success">{{ $group['status'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
    .customer-page { background:#f6f8fb; min-height:calc(100vh - 70px); padding:24px; }
    .customer-header { align-items:center; background:#111827; border-radius:8px; color:#fff; display:flex; justify-content:space-between; margin-bottom:18px; padding:22px 24px; }
    .customer-header h2 { font-size:26px; font-weight:700; margin:0 0 4px; }
    .customer-header p, .customer-panel-title p { margin:0; }
    .customer-header p { color:rgba(255,255,255,.72); }
    .customer-eyebrow { color:#60a5fa; font-size:12px; font-weight:700; text-transform:uppercase; }
    .customer-header-actions, .customer-nav { display:flex; flex-wrap:wrap; gap:10px; }
    .customer-nav { background:#fff; border:1px solid #e5e7eb; border-radius:8px; gap:8px; padding:10px; }
    .customer-nav a { border-radius:6px; color:#4b5563; font-size:13px; font-weight:700; padding:8px 12px; text-decoration:none; }
    .customer-nav a:hover, .customer-nav a.active { background:#111827; color:#fff; }
    .customer-stat-card, .customer-panel { background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 8px 24px rgba(15,23,42,.06); }
    .customer-stat-card { align-items:center; display:flex; gap:14px; min-height:102px; padding:18px; }
    .customer-stat-card small { color:#6b7280; display:block; font-size:13px; margin-bottom:5px; }
    .customer-stat-card strong { color:#111827; display:block; font-size:24px; line-height:1; }
    .stat-icon { align-items:center; border-radius:8px; display:inline-flex; flex:0 0 46px; height:46px; justify-content:center; width:46px; }
    .stat-blue { background:#dbeafe; color:#1d4ed8; } .stat-green { background:#dcfce7; color:#15803d; } .stat-amber { background:#fef3c7; color:#b45309; } .stat-cyan { background:#cffafe; color:#0e7490; }
    .customer-panel { padding:18px; }
    .customer-panel-title { margin-bottom:16px; }
    .customer-panel-title h5 { color:#111827; font-size:18px; font-weight:700; margin:0 0 3px; }
    .customer-panel-title p { color:#6b7280; }
    .customer-table thead th { background:#f9fafb; border-bottom:1px solid #e5e7eb; color:#4b5563; font-size:12px; font-weight:700; padding:13px 12px; text-transform:uppercase; white-space:nowrap; }
    .customer-table tbody td { border-top:1px solid #edf0f4; color:#1f2937; padding:13px 12px; vertical-align:middle; }
    @media (max-width:767px) { .customer-page { padding:14px; } .customer-header { align-items:flex-start; flex-direction:column; } .customer-header-actions, .customer-header-actions .btn { width:100%; } }
</style>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#groupsTable').DataTable({ pageLength: 15, order: [[3, 'desc']] });
    }
});
</script>
@endsection
