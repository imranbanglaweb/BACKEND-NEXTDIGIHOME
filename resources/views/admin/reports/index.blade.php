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
                            <i class="fas fa-chart-bar me-3"></i>Reports & Analytics
                        </h2>
                        <p class="text-white-50 mb-0">Comprehensive business intelligence and reporting dashboard</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" onclick="exportAllReports()">
                            <i class="fas fa-file-export me-2"></i>Export All Reports
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
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
                            <i class="fas fa-arrow-up me-1"></i>+12.5% from last month
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-shopping-cart text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ number_format($totalOrders) }}</h3>
                        <p class="text-muted mb-0">Total Orders</p>
                        <small class="text-info">
                            <i class="fas fa-arrow-up me-1"></i>+8.2% from last month
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">{{ number_format($totalCustomers) }}</h3>
                        <p class="text-muted mb-0">Total Customers</p>
                        <small class="text-warning">
                            <i class="fas fa-arrow-up me-1"></i>+15.3% from last month
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-box text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">{{ number_format($totalProducts) }}</h3>
                        <p class="text-muted mb-0">Total Products</p>
                        <small class="text-primary">
                            <i class="fas fa-arrow-up me-1"></i>+5.1% from last month
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
                            <i class="fas fa-chart-line me-2"></i>Monthly Sales Trend
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-th-large me-2"></i>Report Categories
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="{{ route('admin.reports.sales') }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm report-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-chart-line text-success" style="font-size: 48px;"></i>
                                            </div>
                                            <h5 class="card-title">Sales Reports</h5>
                                            <p class="card-text text-muted">Revenue analysis, sales trends, and performance metrics</p>
                                            <span class="badge bg-success">View Report</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="{{ route('admin.reports.products') }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm report-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-box text-info" style="font-size: 48px;"></i>
                                            </div>
                                            <h5 class="card-title">Product Reports</h5>
                                            <p class="card-text text-muted">Product performance, inventory analysis, and category insights</p>
                                            <span class="badge bg-info">View Report</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="{{ route('admin.reports.customers') }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm report-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-users text-warning" style="font-size: 48px;"></i>
                                            </div>
                                            <h5 class="card-title">Customer Reports</h5>
                                            <p class="card-text text-muted">Customer behavior, acquisition trends, and loyalty metrics</p>
                                            <span class="badge bg-warning">View Report</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="{{ route('admin.reports.orders') }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm report-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-shopping-cart text-primary" style="font-size: 48px;"></i>
                                            </div>
                                            <h5 class="card-title">Order Reports</h5>
                                            <p class="card-text text-muted">Order fulfillment, status tracking, and processing analytics</p>
                                            <span class="badge bg-primary">View Report</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="{{ route('admin.reports.revenue') }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm report-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-dollar-sign text-success" style="font-size: 48px;"></i>
                                            </div>
                                            <h5 class="card-title">Revenue Reports</h5>
                                            <p class="card-text text-muted">Financial performance, revenue streams, and profitability analysis</p>
                                            <span class="badge bg-success">View Report</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="{{ route('admin.reports.export') }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm report-card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-file-export text-secondary" style="font-size: 48px;"></i>
                                            </div>
                                            <h5 class="card-title">Data Export</h5>
                                            <p class="card-text text-muted">Export business data in various formats for external analysis</p>
                                            <span class="badge bg-secondary">Export Data</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
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
    const monthlySalesData = @json($monthlySales);

    const labels = monthlySalesData.map(item => {
        const date = new Date(item.year, item.month - 1);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
    });

    const data = monthlySalesData.map(item => item.total);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Sales ($)',
                data: data,
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
                    text: 'Sales Performance'
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

function exportAllReports() {
    if (confirm('This will generate a comprehensive report with all business data. This may take a few moments. Continue?')) {
        // Show loading indicator
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
        btn.disabled = true;

        // Here you would make an AJAX call to generate and download the report
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Report generation feature coming soon!');
        }, 2000);
    }
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
    .report-card {
        transition: all 0.3s ease;
        border: 2px solid transparent !important;
    }
    .report-card:hover {
        border-color: #667eea !important;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3) !important;
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
