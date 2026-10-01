@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-truck me-3"></i>Shipped Orders
                        </h2>
                        <p class="text-white-50 mb-0">Orders that have been shipped and are in transit</p>
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
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-truck text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">67</h3>
                        <p class="text-muted mb-0">Shipped Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-map-marker-alt text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">45</h3>
                        <p class="text-muted mb-0">In Transit</p>
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
                        <h3 class="text-info mb-1">2-5 days</h3>
                        <p class="text-muted mb-0">Delivery Time</p>
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
                                <i class="fas fa-truck me-2"></i>Shipping & Tracking Management
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-2"></i>Add Shipment
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-search me-2"></i>Track Package
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Shipping Overview -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Shipping Dashboard:</strong> 67 orders shipped today • 45 in transit • Expected delivery: 2-5 business days
                                </div>
                            </div>
                        </div>

                        <!-- Shipped Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Order ID</th>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Carrier</th>
                                        <th class="border-0 px-3 py-3">Tracking Number</th>
                                        <th class="border-0 px-3 py-3">Shipped Date</th>
                                        <th class="border-0 px-3 py-3">Status</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $shippedOrders = [
                                            [
                                                'id' => '#ORD-2024-011',
                                                'customer' => 'Kevin Brown',
                                                'email' => 'kevin@example.com',
                                                'carrier' => 'FedEx',
                                                'tracking' => 'FE1234567890',
                                                'shipped_date' => '2024-01-15 10:30 AM',
                                                'status' => 'In Transit',
                                                'status_class' => 'info'
                                            ],
                                            [
                                                'id' => '#ORD-2024-012',
                                                'customer' => 'Laura Martinez',
                                                'email' => 'laura@example.com',
                                                'carrier' => 'UPS',
                                                'tracking' => 'UP9876543210',
                                                'shipped_date' => '2024-01-15 09:15 AM',
                                                'status' => 'Out for Delivery',
                                                'status_class' => 'warning'
                                            ],
                                            [
                                                'id' => '#ORD-2024-013',
                                                'customer' => 'Michael Davis',
                                                'email' => 'michael@example.com',
                                                'carrier' => 'USPS',
                                                'tracking' => 'US1122334455',
                                                'shipped_date' => '2024-01-14 04:45 PM',
                                                'status' => 'Delivered',
                                                'status_class' => 'success'
                                            ],
                                            [
                                                'id' => '#ORD-2024-014',
                                                'customer' => 'Nancy Wilson',
                                                'email' => 'nancy@example.com',
                                                'carrier' => 'DHL',
                                                'tracking' => 'DH5566778899',
                                                'shipped_date' => '2024-01-14 02:20 PM',
                                                'status' => 'In Transit',
                                                'status_class' => 'info'
                                            ],
                                            [
                                                'id' => '#ORD-2024-015',
                                                'customer' => 'Oliver Johnson',
                                                'email' => 'oliver@example.com',
                                                'carrier' => 'FedEx',
                                                'tracking' => 'FE0987654321',
                                                'shipped_date' => '2024-01-14 11:00 AM',
                                                'status' => 'Delivered',
                                                'status_class' => 'success'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($shippedOrders as $order)
                                    <tr>
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
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary me-2">{{ $order['carrier'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <code class="text-primary">{{ $order['tracking'] }}</code>
                                        </td>
                                        <td class="px-3 py-3">{{ $order['shipped_date'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $order['status_class'] }} px-3 py-2">{{ $order['status'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" title="Track Package">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                <button class="btn btn-outline-primary" title="Print Label">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Mark Delivered">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Shipping Analytics -->
                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-success mb-1">95%</h5>
                                        <small class="text-muted">On-Time Delivery</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-info mb-1">2.3 days</h5>
                                        <small class="text-muted">Avg Transit Time</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning mb-1">$25</h5>
                                        <small class="text-muted">Avg Shipping Cost</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h5 class="text-primary mb-1">12</h5>
                                        <small class="text-muted">Active Carriers</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carrier Performance -->
                        <hr class="my-4">
                        <h6 class="text-primary mb-3">Carrier Performance</h6>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-white fw-bold">F</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">FedEx</div>
                                        <small class="text-success">96% On-time</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-white fw-bold">U</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">UPS</div>
                                        <small class="text-success">94% On-time</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-white fw-bold">D</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">DHL</div>
                                        <small class="text-warning">89% On-time</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-white fw-bold">P</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">USPS</div>
                                        <small class="text-info">92% On-time</small>
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
    .badge-primary {
        background-color: #007bff;
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