@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-clock me-3"></i>Pending Orders
                        </h2>
                        <p class="text-white-50 mb-0">Orders awaiting processing and fulfillment</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">
                            <i class="fas fa-list me-2"></i>All Orders
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-hourglass-half text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">23</h3>
                        <p class="text-muted mb-0">Pending Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-exclamation-triangle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-danger mb-1">5</h3>
                        <p class="text-muted mb-0">Urgent Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">2h 15m</h3>
                        <p class="text-muted mb-0">Avg Wait Time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-cog me-2"></i>Order Processing Management
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-2"></i>Add Order
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-chart-line me-2"></i>Reports
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Pending Orders Actions -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary mb-0">Pending Orders Queue</h5>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-success btn-sm" id="bulk-approve">
                                            <i class="fas fa-check me-2"></i>Bulk Approve
                                        </button>
                                        <button class="btn btn-warning btn-sm" id="bulk-process">
                                            <i class="fas fa-play me-2"></i>Start Processing
                                        </button>
                                        <button class="btn btn-info btn-sm" id="refresh-queue">
                                            <i class="fas fa-sync me-2"></i>Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th class="border-0 px-3 py-3">Order ID</th>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Items</th>
                                        <th class="border-0 px-3 py-3">Total</th>
                                        <th class="border-0 px-3 py-3">Time Pending</th>
                                        <th class="border-0 px-3 py-3">Priority</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $pendingOrders = [
                                            [
                                                'id' => '#ORD-2024-001',
                                                'customer' => 'Alice Johnson',
                                                'email' => 'alice@example.com',
                                                'items' => 3,
                                                'total' => '$299.99',
                                                'pending_time' => '2h 15m',
                                                'priority' => 'High',
                                                'priority_class' => 'danger'
                                            ],
                                            [
                                                'id' => '#ORD-2024-002',
                                                'customer' => 'Bob Smith',
                                                'email' => 'bob@example.com',
                                                'items' => 1,
                                                'total' => '$149.99',
                                                'pending_time' => '4h 30m',
                                                'priority' => 'Medium',
                                                'priority_class' => 'warning'
                                            ],
                                            [
                                                'id' => '#ORD-2024-003',
                                                'customer' => 'Carol Davis',
                                                'email' => 'carol@example.com',
                                                'items' => 2,
                                                'total' => '$199.99',
                                                'pending_time' => '1h 45m',
                                                'priority' => 'High',
                                                'priority_class' => 'danger'
                                            ],
                                            [
                                                'id' => '#ORD-2024-004',
                                                'customer' => 'David Wilson',
                                                'email' => 'david@example.com',
                                                'items' => 4,
                                                'total' => '$399.99',
                                                'pending_time' => '6h 20m',
                                                'priority' => 'Low',
                                                'priority_class' => 'info'
                                            ],
                                            [
                                                'id' => '#ORD-2024-005',
                                                'customer' => 'Eva Brown',
                                                'email' => 'eva@example.com',
                                                'items' => 1,
                                                'total' => '$79.99',
                                                'pending_time' => '3h 10m',
                                                'priority' => 'Medium',
                                                'priority_class' => 'warning'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($pendingOrders as $order)
                                    <tr>
                                        <td class="px-3 py-3">
                                            <input type="checkbox" class="order-checkbox" value="{{ $order['id'] }}">
                                        </td>
                                        <td class="px-3 py-3 fw-bold">{{ $order['id'] }}</td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-primary text-white">
                                                        {{ substr($order['customer'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $order['customer'] }}</div>
                                                    <small class="text-muted">{{ $order['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-secondary">{{ $order['items'] }} items</span>
                                        </td>
                                        <td class="px-3 py-3 fw-bold text-success">{{ $order['total'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="text-danger fw-bold">{{ $order['pending_time'] }}</span>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $order['priority_class'] }}">{{ $order['priority'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-success" title="Approve Order">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-outline-primary" title="Start Processing">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Reject Order">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing 1 to 5 of 23 pending orders
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Previous</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <hr class="my-4">

                        <!-- Processing Guidelines -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-check-circle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Approval Process</h6>
                                        <small class="text-muted">Verify payment and customer details before approval</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-clock text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Priority Handling</h6>
                                        <small class="text-muted">Process high-priority orders within 2 hours</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-shield-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Fraud Check</h6>
                                        <small class="text-muted">Run security checks on suspicious orders</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <h4 class="text-primary mb-3">Pending Orders Processing</h4>
                            <p class="text-muted mb-4">Advanced order queue management and automated processing features coming soon.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-list me-2"></i>All Orders
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .badge-warning {
        background-color: #ffc107;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-warning { color: #ffc107 !important; }
    .text-danger { color: #dc3545 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>

<script>
$(document).ready(function() {
    // Select All functionality
    $('#select-all').on('change', function() {
        $('.order-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkButtons();
    });

    $('.order-checkbox').on('change', function() {
        updateBulkButtons();
    });

    function updateBulkButtons() {
        var checkedCount = $('.order-checkbox:checked').length;
        $('#bulk-approve, #bulk-process').prop('disabled', checkedCount === 0);
    }

    // Bulk approve action
    $('#bulk-approve').on('click', function() {
        var selectedOrders = $('.order-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedOrders.length > 0) {
            if (confirm('Approve ' + selectedOrders.length + ' selected orders?')) {
                // Handle bulk approval
                alert('Orders approved successfully!');
                $('.order-checkbox:checked').closest('tr').fadeOut();
            }
        }
    });

    // Bulk process action
    $('#bulk-process').on('click', function() {
        var selectedOrders = $('.order-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedOrders.length > 0) {
            if (confirm('Start processing ' + selectedOrders.length + ' selected orders?')) {
                // Handle bulk processing
                alert('Orders moved to processing queue!');
                $('.order-checkbox:checked').closest('tr').fadeOut();
            }
        }
    });

    // Refresh queue
    $('#refresh-queue').on('click', function() {
        $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Refreshing...');
        setTimeout(() => {
            $(this).html('<i class="fas fa-sync me-2"></i>Refresh');
            // Simulate refresh
            location.reload();
        }, 1000);
    });

    // Initialize
    updateBulkButtons();
});
</script>
@endsection