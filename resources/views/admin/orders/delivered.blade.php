@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-check-circle me-3"></i>Delivered Orders
                        </h2>
                        <p class="text-white-50 mb-0">Successfully completed and delivered orders</p>
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
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">892</h3>
                        <p class="text-muted mb-0">Delivered Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-star text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">4.7</h3>
                        <p class="text-muted mb-0">Avg Rating</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-redo text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">15</h3>
                        <p class="text-muted mb-0">Returns This Month</p>
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
                                <i class="fas fa-check-circle me-2"></i>Delivery Management & Analytics
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-star me-2"></i>Request Reviews
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-chart-bar me-2"></i>Delivery Reports
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Delivery Success Overview -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Delivery Excellence:</strong> 892 successful deliveries this month • 4.7 average rating • 15 return requests
                                </div>
                            </div>
                        </div>

                        <!-- Recent Deliveries Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Order ID</th>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Delivered Date</th>
                                        <th class="border-0 px-3 py-3">Delivery Time</th>
                                        <th class="border-0 px-3 py-3">Review Status</th>
                                        <th class="border-0 px-3 py-3">Return Window</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $deliveredOrders = [
                                            [
                                                'id' => '#ORD-2024-016',
                                                'customer' => 'Paula Garcia',
                                                'email' => 'paula@example.com',
                                                'delivered_date' => '2024-01-15',
                                                'delivery_time' => '2:30 PM',
                                                'review_status' => 'Reviewed (5★)',
                                                'review_class' => 'success',
                                                'return_window' => '12 days left'
                                            ],
                                            [
                                                'id' => '#ORD-2024-017',
                                                'customer' => 'Quinn Rodriguez',
                                                'email' => 'quinn@example.com',
                                                'delivered_date' => '2024-01-14',
                                                'delivery_time' => '11:15 AM',
                                                'review_status' => 'Pending',
                                                'review_class' => 'warning',
                                                'return_window' => '13 days left'
                                            ],
                                            [
                                                'id' => '#ORD-2024-018',
                                                'customer' => 'Ryan Thompson',
                                                'email' => 'ryan@example.com',
                                                'delivered_date' => '2024-01-14',
                                                'delivery_time' => '4:45 PM',
                                                'review_status' => 'Reviewed (4★)',
                                                'review_class' => 'info',
                                                'return_window' => '13 days left'
                                            ],
                                            [
                                                'id' => '#ORD-2024-019',
                                                'customer' => 'Sophia Lee',
                                                'email' => 'sophia@example.com',
                                                'delivered_date' => '2024-01-13',
                                                'delivery_time' => '1:20 PM',
                                                'review_status' => 'Reviewed (5★)',
                                                'review_class' => 'success',
                                                'return_window' => '14 days left'
                                            ],
                                            [
                                                'id' => '#ORD-2024-020',
                                                'customer' => 'Tyler White',
                                                'email' => 'tyler@example.com',
                                                'delivered_date' => '2024-01-13',
                                                'delivery_time' => '9:30 AM',
                                                'review_status' => 'No Review',
                                                'review_class' => 'secondary',
                                                'return_window' => '14 days left'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($deliveredOrders as $order)
                                    <tr>
                                        <td class="px-3 py-3 fw-bold">{{ $order['id'] }}</td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-success text-white">
                                                        {{ substr($order['customer'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $order['customer'] }}</div>
                                                    <small class="text-muted">{{ $order['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">{{ $order['delivered_date'] }}</td>
                                        <td class="px-3 py-3">{{ $order['delivery_time'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $order['review_class'] }}">{{ $order['review_status'] }}</span>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="text-info">{{ $order['return_window'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-primary" title="Send Follow-up">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <button class="btn btn-outline-warning" title="Request Review">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Post-Delivery Analytics -->
                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-success mb-1">4.7</h5>
                                        <small class="text-muted">Average Rating</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-info mb-1">73%</h5>
                                        <small class="text-muted">Review Response Rate</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning mb-1">15</h5>
                                        <small class="text-muted">Return Requests</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-primary mb-1">98%</h5>
                                        <small class="text-muted">Satisfaction Rate</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Engagement Tools -->
                        <hr class="my-4">
                        <h6 class="text-primary mb-3">Customer Engagement Tools</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-envelope text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Thank You Emails</h6>
                                        <small class="text-muted">Automated post-delivery follow-ups</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-star text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Review Requests</h6>
                                        <small class="text-muted">Prompt customers for feedback</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-shopping-cart text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Upsell Opportunities</h6>
                                        <small class="text-muted">Recommend related products</small>
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
    .badge-success {
        background-color: #28a745;
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