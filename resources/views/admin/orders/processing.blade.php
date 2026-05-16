@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-cog me-3"></i>Processing Orders
                        </h2>
                        <p class="text-white-50 mb-0">Orders currently being prepared and packaged</p>
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
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-cog text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">45</h3>
                        <p class="text-muted mb-0">Processing Orders</p>
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
                        <h3 class="text-success mb-1">12</h3>
                        <p class="text-muted mb-0">Ready to Ship</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">4h 30m</h3>
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
                                <i class="fas fa-cog me-2"></i>Order Processing Management
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-truck me-2"></i>Mark Ready to Ship
                                </button>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-clock me-2"></i>Update Status
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Processing Status Overview -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-primary mb-0">Processing Queue Status</h6>
                                    <span class="badge bg-info">45 Orders in Processing</span>
                                </div>
                            </div>
                        </div>

                        <!-- Processing Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Order ID</th>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Items</th>
                                        <th class="border-0 px-3 py-3">Progress</th>
                                        <th class="border-0 px-3 py-3">Assigned To</th>
                                        <th class="border-0 px-3 py-3">Time Elapsed</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $processingOrders = [
                                            [
                                                'id' => '#ORD-2024-006',
                                                'customer' => 'Frank Miller',
                                                'email' => 'frank@example.com',
                                                'items' => 'Digital Course + 2 Templates',
                                                'progress' => 75,
                                                'assigned' => 'John Packer',
                                                'elapsed' => '1h 30m',
                                                'status' => 'Packing'
                                            ],
                                            [
                                                'id' => '#ORD-2024-007',
                                                'customer' => 'Grace Lee',
                                                'email' => 'grace@example.com',
                                                'items' => 'Premium Theme Bundle',
                                                'progress' => 60,
                                                'assigned' => 'Sarah Prep',
                                                'elapsed' => '45m',
                                                'status' => 'Quality Check'
                                            ],
                                            [
                                                'id' => '#ORD-2024-008',
                                                'customer' => 'Henry Wilson',
                                                'email' => 'henry@example.com',
                                                'items' => '3 Stock Photo Packs',
                                                'progress' => 90,
                                                'assigned' => 'Mike Final',
                                                'elapsed' => '2h 15m',
                                                'status' => 'Final Review'
                                            ],
                                            [
                                                'id' => '#ORD-2024-009',
                                                'customer' => 'Ivy Chen',
                                                'email' => 'ivy@example.com',
                                                'items' => 'Video Course + Resources',
                                                'progress' => 30,
                                                'assigned' => 'Lisa Pack',
                                                'elapsed' => '20m',
                                                'status' => 'Preparing'
                                            ],
                                            [
                                                'id' => '#ORD-2024-010',
                                                'customer' => 'Jack Taylor',
                                                'email' => 'jack@example.com',
                                                'items' => 'Business Tools Suite',
                                                'progress' => 85,
                                                'assigned' => 'Tom Quality',
                                                'elapsed' => '3h 45m',
                                                'status' => 'Testing'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($processingOrders as $order)
                                    <tr>
                                        <td class="px-3 py-3 fw-bold">{{ $order['id'] }}</td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-info text-white">
                                                        {{ substr($order['customer'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $order['customer'] }}</div>
                                                    <small class="text-muted">{{ $order['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">{{ $order['items'] }}</td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                         style="width: {{ $order['progress'] }}%"
                                                         aria-valuenow="{{ $order['progress'] }}"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small class="text-muted">{{ $order['progress'] }}%</small>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="fw-bold">{{ $order['assigned'] }}</div>
                                            <small class="badge bg-secondary">{{ $order['status'] }}</small>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="text-warning fw-bold">{{ $order['elapsed'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" title="Update Progress">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Mark Complete">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-outline-warning" title="Add Note">
                                                    <i class="fas fa-sticky-note"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Processing Metrics -->
                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-success mb-1">4.2h</h5>
                                        <small class="text-muted">Avg Processing Time</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-info mb-1">87%</h5>
                                        <small class="text-muted">On-Time Delivery</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning mb-1">3</h5>
                                        <small class="text-muted">Quality Issues</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-primary mb-1">12</h5>
                                        <small class="text-muted">Staff Active</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Processing Guidelines -->
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-list-check text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Quality Checklist</h6>
                                        <small class="text-muted">Follow standard quality control procedures</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-users text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Team Coordination</h6>
                                        <small class="text-muted">Update order status for team visibility</small>
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
                                        <h6 class="mb-1">SLA Monitoring</h6>
                                        <small class="text-muted">Ensure orders meet processing deadlines</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <h4 class="text-primary mb-3">Automated Order Processing</h4>
                            <p class="text-muted mb-4">Streamlined order fulfillment, inventory tracking, and quality control features coming soon.</p>
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
    .badge-info {
        background-color: #17a2b8;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection