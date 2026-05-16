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
                            <i class="fas fa-chart-line me-3"></i>Sales Reports
                        </h2>
                        <p class="text-white-50 mb-0">Detailed sales performance and revenue analytics</p>
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
                                    <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">${{ number_format($totalSales, 0) }}</h3>
                        <p class="text-muted mb-0">Total Sales</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>Period: {{ $startDate }} to {{ $endDate }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-shopping-cart text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ number_format($totalTransactions) }}</h3>
                        <p class="text-muted mb-0">Total Transactions</p>
                        <small class="text-info">
                            <i class="fas fa-receipt me-1"></i>Payment transactions
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-calculator text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">${{ number_format($averageOrderValue, 2) }}</h3>
                        <p class="text-muted mb-0">Average Order Value</p>
                        <small class="text-warning">
                            <i class="fas fa-chart-bar me-1"></i>Per transaction average
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-chart-line me-2"></i>Sales Trend
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-trophy me-2"></i>Top Selling Products
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">#</th>
                                        <th class="border-0 px-4 py-3">Product Name</th>
                                        <th class="border-0 px-4 py-3">Units Sold</th>
                                        <th class="border-0 px-4 py-3">Total Revenue</th>
                                        <th class="border-0 px-4 py-3">Contribution %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topProducts as $index => $product)
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                    <span class="text-white fw-bold">{{ substr($product->name, 0, 1) }}</span>
                                                </div>
                                                <span class="fw-bold">{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ number_format($product->total_quantity) }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">${{ number_format($product->total_revenue, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: {{ $totalSales > 0 ? ($product->total_revenue / $totalSales) * 100 : 0 }}%"
                                                     aria-valuenow="{{ $totalSales > 0 ? ($product->total_revenue / $totalSales) * 100 : 0 }}"
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    {{ number_format(($product->total_revenue / $totalSales) * 100, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-box fa-3x mb-3"></i>
                                                <p>No sales data found for the selected period.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesData);

    const labels = salesData.map(item => new Date(item.date).toLocaleDateString());
    const sales = salesData.map(item => item.total_sales);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Daily Sales ($)',
                data: sales,
                backgroundColor: 'rgba(102, 126, 234, 0.6)',
                borderColor: '#667eea',
                borderWidth: 1
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
                    text: 'Daily Sales Performance'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});

function exportReport() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    const url = `/admin/reports/sales/export?start_date=${startDate}&end_date=${endDate}`;
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