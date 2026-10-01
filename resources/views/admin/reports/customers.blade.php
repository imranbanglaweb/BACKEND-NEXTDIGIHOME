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
                            <i class="fas fa-users me-3"></i>Customer Reports
                        </h2>
                        <p class="text-white-50 mb-0">Customer behavior analysis and purchase patterns</p>
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

        <!-- Date Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.reports.customers') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Acquisition Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-user-plus me-2"></i>Customer Acquisition Trend
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="acquisitionChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reports Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-chart-bar me-2"></i>Customer Purchase Analysis
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Customer</th>
                                        <th class="border-0 px-4 py-3">Total Orders</th>
                                        <th class="border-0 px-4 py-3">Total Spent</th>
                                        <th class="border-0 px-4 py-3">Avg Order Value</th>
                                        <th class="border-0 px-4 py-3">Last Order</th>
                                        <th class="border-0 px-4 py-3">Customer Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customerReports as $customer)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ substr($customer->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $customer->name }}</div>
                                                    <small class="text-muted">{{ $customer->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ number_format($customer->total_orders) }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">${{ number_format($customer->total_spent, 2) }}</td>
                                        <td class="px-4 py-3 fw-bold text-warning">${{ number_format($customer->avg_order_value, 2) }}</td>
                                        <td class="px-4 py-3">
                                            @if($customer->last_order_date)
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($customer->last_order_date)->diffForHumans() }}</small>
                                            @else
                                                <span class="text-muted">Never</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($customer->total_orders > 10)
                                                <span class="badge bg-success">VIP</span>
                                            @elseif($customer->total_orders > 5)
                                                <span class="badge bg-info">Regular</span>
                                            @elseif($customer->total_orders > 1)
                                                <span class="badge bg-warning">Occasional</span>
                                            @else
                                                <span class="badge bg-secondary">New</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3"></i>
                                                <p>No customer data found for the selected period.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($customerReports->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $customerReports->firstItem() }} to {{ $customerReports->lastItem() }} of {{ $customerReports->total() }} customers
                                </div>
                                {{ $customerReports->links() }}
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
    // Customer Acquisition Chart
    const ctx = document.getElementById('acquisitionChart').getContext('2d');
    const acquisitionData = @json($customerAcquisition);

    const labels = acquisitionData.map(item => new Date(item.date).toLocaleDateString());
    const newCustomers = acquisitionData.map(item => item.new_customers);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'New Customers',
                data: newCustomers,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Daily Customer Acquisition'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});

function exportReport() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    const url = `/admin/reports/customers/export?start_date=${startDate}&end_date=${endDate}`;
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
