@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-undo me-3"></i>Order Refunds Management
                        </h2>
                        <p class="text-white-50 mb-0">Handle refund requests and process returns</p>
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
                                <i class="fas fa-undo text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">23</h3>
                        <p class="text-muted mb-0">Pending Refunds</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">$2,847</h3>
                        <p class="text-muted mb-0">Refunded This Month</p>
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
                        <h3 class="text-info mb-1">3.2 days</h3>
                        <p class="text-muted mb-0">Avg Processing Time</p>
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
                                <i class="fas fa-undo me-2"></i>Refund Processing & Management
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-plus me-2"></i>New Refund Request
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>Refund Reports
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Refund Status Overview -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Refund Queue:</strong> 23 pending requests • $2,847.00 total value • Average processing: 3.2 days
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>This Month:</strong> 45 refunds processed • $12,456.00 returned • 98% satisfaction rate
                                </div>
                            </div>
                        </div>

                        <!-- Refund Requests Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Refund ID</th>
                                        <th class="border-0 px-3 py-3">Order ID</th>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Reason</th>
                                        <th class="border-0 px-3 py-3">Amount</th>
                                        <th class="border-0 px-3 py-3">Status</th>
                                        <th class="border-0 px-3 py-3">Requested</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $refunds = [
                                            [
                                                'id' => '#REF-2024-001',
                                                'order_id' => '#ORD-2024-021',
                                                'customer' => 'Uma Patel',
                                                'email' => 'uma@example.com',
                                                'reason' => 'Product Damaged',
                                                'amount' => '$149.99',
                                                'status' => 'Under Review',
                                                'status_class' => 'warning',
                                                'requested' => '2024-01-15'
                                            ],
                                            [
                                                'id' => '#REF-2024-002',
                                                'order_id' => '#ORD-2024-022',
                                                'customer' => 'Victor Nguyen',
                                                'email' => 'victor@example.com',
                                                'reason' => 'Wrong Item',
                                                'amount' => '$79.99',
                                                'status' => 'Approved',
                                                'status_class' => 'success',
                                                'requested' => '2024-01-14'
                                            ],
                                            [
                                                'id' => '#REF-2024-003',
                                                'order_id' => '#ORD-2024-023',
                                                'customer' => 'Wendy Zhang',
                                                'email' => 'wendy@example.com',
                                                'reason' => 'Not as Described',
                                                'amount' => '$299.99',
                                                'status' => 'Processing',
                                                'status_class' => 'info',
                                                'requested' => '2024-01-13'
                                            ],
                                            [
                                                'id' => '#REF-2024-004',
                                                'order_id' => '#ORD-2024-024',
                                                'customer' => 'Xavier Kim',
                                                'email' => 'xavier@example.com',
                                                'reason' => 'Duplicate Order',
                                                'amount' => '$199.99',
                                                'status' => 'Rejected',
                                                'status_class' => 'danger',
                                                'requested' => '2024-01-12'
                                            ],
                                            [
                                                'id' => '#REF-2024-005',
                                                'order_id' => '#ORD-2024-025',
                                                'customer' => 'Yara Silva',
                                                'email' => 'yara@example.com',
                                                'reason' => 'Changed Mind',
                                                'amount' => '$49.99',
                                                'status' => 'Completed',
                                                'status_class' => 'success',
                                                'requested' => '2024-01-11'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($refunds as $refund)
                                    <tr>
                                        <td class="px-3 py-3 fw-bold">{{ $refund['id'] }}</td>
                                        <td class="px-3 py-3">
                                            <a href="#" class="text-primary">{{ $refund['order_id'] }}</a>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-warning text-white">
                                                        {{ substr($refund['customer'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $refund['customer'] }}</div>
                                                    <small class="text-muted">{{ $refund['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">{{ $refund['reason'] }}</td>
                                        <td class="px-3 py-3 fw-bold text-success">{{ $refund['amount'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $refund['status_class'] }} px-3 py-2">{{ $refund['status'] }}</span>
                                        </td>
                                        <td class="px-3 py-3">{{ $refund['requested'] }}</td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button class="btn btn-outline-primary" title="Process Payment">
                                                    <i class="fas fa-credit-card"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Refund Processing Stats -->
                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning mb-1">3.2 days</h5>
                                        <small class="text-muted">Avg Processing Time</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-success mb-1">89%</h5>
                                        <small class="text-muted">Approval Rate</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-info mb-1">$2,847</h5>
                                        <small class="text-muted">Monthly Refunds</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-danger mb-1">11%</h5>
                                        <small class="text-muted">Rejection Rate</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Policy Guidelines -->
                        <hr class="my-4">
                        <h6 class="text-primary mb-3">Refund Processing Guidelines</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-clock text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">30-Day Window</h6>
                                        <small class="text-muted">Standard refund period for all purchases</small>
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
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Quality Inspection</h6>
                                        <small class="text-muted">Required for damaged or defective items</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-hand-holding-usd text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Payment Methods</h6>
                                        <small class="text-muted">Original payment method for refunds</small>
                                    </div>
                                </div>
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
    .bg-success { background-color: #28a745 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection