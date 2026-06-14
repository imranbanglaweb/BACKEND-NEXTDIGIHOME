@extends('admin.dashboard.master')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-shopping-cart me-3"></i>Order Reports
                        </h2>
                        <p class="text-white-50 mb-0">Order fulfillment analysis and processing metrics</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" onclick="exportReport()">
                            <i class="fas fa-file-export me-2"></i>Export Report
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.reports.orders') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Breakdown -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-chart-pie me-2"></i>Order Status Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($statusBreakdown as $statusItem)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted text-capitalize">{{ $statusItem->status }}</span>
                                            <span class="fw-bold">{{ $statusItem->count }}</span>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            @php
                                                $totalOrders = $statusBreakdown->sum('count');
                                                $percentage = $totalOrders > 0 ? ($statusItem->count / $totalOrders) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar
                                                @if($statusItem->status == 'delivered') bg-success
                                                @elseif($statusItem->status == 'shipped') bg-info
                                                @elseif($statusItem->status == 'processing') bg-warning
                                                @elseif($statusItem->status == 'pending') bg-secondary
                                                @else bg-danger
                                                @endif"
                                                role="progressbar"
                                                style="width: {{ $percentage }}%"
                                                aria-valuenow="{{ $percentage }}"
                                                aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders by Date Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>Orders Over Time
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-list me-2"></i>Order Details
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Order ID</th>
                                        <th class="border-0 px-4 py-3">Customer</th>
                                        <th class="border-0 px-4 py-3">Items</th>
                                        <th class="border-0 px-4 py-3">Total</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Date</th>
                                        <th class="border-0 px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary">#{{ $order->id }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="fw-bold">{{ $order->customer_name ?: 'N/A' }}</div>
                                            <small class="text-muted">{{ $order->customer_email ?: 'N/A' }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ $order->product_name }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge
                                                @if($order->status == 'delivered') bg-success
                                                @elseif($order->status == 'shipped') bg-info
                                                @elseif($order->status == 'processing') bg-warning
                                                @elseif($order->status == 'pending') bg-secondary
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button class="btn btn-outline-primary btn-sm" title="View Order" onclick="viewOrder({{ $order->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                                <p>No orders found for the selected filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                                </div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Orders Chart
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersData = @json($ordersByDate);

    const labels = ordersData.map(item => new Date(item.date).toLocaleDateString());
    const orderCounts = ordersData.map(item => item.order_count);
    const orderAmounts = ordersData.map(item => item.total_amount);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Order Count',
                data: orderCounts,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                yAxisID: 'y',
                tension: 0.4
            }, {
                label: 'Order Amount ($)',
                data: orderAmounts,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                yAxisID: 'y1',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            stacked: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Orders and Revenue Over Time'
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Order Count'
                    },
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Revenue ($)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            }
        }
    });
});

function exportReport() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const status = document.getElementById('status').value;

    const url = `/admin/reports/orders/export?start_date=${startDate}&end_date=${endDate}&status=${status}`;
    window.open(url, '_blank');
}
</script>

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
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-secondary { background-color: #6c757d !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection
