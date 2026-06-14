@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body customer-page">
    <div class="container-fluid">
        <div class="customer-header">
            <div>
                <div class="customer-eyebrow">Customers</div>
                <h2>Customer Management</h2>
                <p>Review customer accounts, order counts, lifetime value, and recent purchase activity.</p>
            </div>
            <div class="customer-header-actions">
                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Add Customer
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <div class="customer-nav mb-3">
            <a href="{{ route('admin.customers.index') }}" class="active">Customers</a>
            <a href="{{ route('admin.customer-groups.index') }}">Groups</a>
            <a href="{{ route('admin.customers.reviews') }}">Reviews</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-users"></i></span>
                    <div><small>Total Customers</small><strong>{{ number_format($stats['total'] ?? 0) }}</strong></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-user-check"></i></span>
                    <div><small>Active Customers</small><strong>{{ number_format($stats['active'] ?? 0) }}</strong></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-user-clock"></i></span>
                    <div><small>New This Month</small><strong>{{ number_format($stats['new_this_month'] ?? 0) }}</strong></div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="customer-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-shopping-cart"></i></span>
                    <div><small>Avg Order Value</small><strong>$ {{ number_format($stats['average_order_value'] ?? 0, 2) }}</strong></div>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        <div class="customer-panel">
            <div class="customer-panel-title">
                <div>
                    <h5>Customers</h5>
                    <p>Sorted by newest account first. Use table search for name or email.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table customer-table" id="customersTable">
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Last Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td class="fw-bold">#CUST-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($customer->user_image)
                                            <img src="{{ asset('public/admin_resource/assets/images/user_image/'.$customer->user_image) }}" alt="{{ $customer->name }}" class="customer-avatar me-2">
                                        @else
                                            <span class="customer-avatar customer-avatar-empty me-2">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $customer->name }}</div>
                                            <small class="text-muted">{{ $customer->user_name ?: 'No username' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->cell_phone ?: 'N/A' }}</td>
                                <td><span class="badge bg-info">{{ number_format($customer->orders_count) }}</span></td>
                                <td class="fw-bold text-success">$ {{ number_format($customer->total_spent, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ (string) $customer->status === '1' ? 'success' : 'secondary' }}">
                                        {{ (string) $customer->status === '1' ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ optional($customer->created_at)->format('M d, Y') }}</td>
                                <td>{{ $customer->last_order_at ? \Carbon\Carbon::parse($customer->last_order_at)->format('M d, Y') : 'No orders' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No customers found.</td></tr>
                        @endforelse
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
    .stat-blue { background:#dbeafe; color:#1d4ed8; }
    .stat-green { background:#dcfce7; color:#15803d; }
    .stat-amber { background:#fef3c7; color:#b45309; }
    .stat-cyan { background:#cffafe; color:#0e7490; }
    .customer-panel { padding:18px; }
    .customer-panel-title { margin-bottom:16px; }
    .customer-panel-title h5 { color:#111827; font-size:18px; font-weight:700; margin:0 0 3px; }
    .customer-panel-title p { color:#6b7280; }
    .customer-table thead th { background:#f9fafb; border-bottom:1px solid #e5e7eb; color:#4b5563; font-size:12px; font-weight:700; padding:13px 12px; text-transform:uppercase; white-space:nowrap; }
    .customer-table tbody td { border-top:1px solid #edf0f4; color:#1f2937; padding:13px 12px; vertical-align:middle; }
    .customer-avatar { border-radius:50%; height:38px; object-fit:cover; width:38px; }
    .customer-avatar-empty { align-items:center; background:#2563eb; color:#fff; display:inline-flex; font-weight:700; justify-content:center; }
    @media (max-width:767px) { .customer-page { padding:14px; } .customer-header { align-items:flex-start; flex-direction:column; } .customer-header-actions, .customer-header-actions .btn { width:100%; } }
</style>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#customersTable').DataTable({
            pageLength: 15,
            order: [[0, 'desc']],
            language: { emptyTable: 'No customers found' }
        });
    }
});
</script>
@endsection
