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
                            <i class="fas fa-dollar-sign me-3"></i>Revenue Reports
                        </h2>
                        <p class="text-white-50 mb-0">Financial performance analysis and revenue streams</p>
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

        <!-- Date and Period Filter -->
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
                                <label for="period" class="form-label">Group By</label>
                                <select class="form-control" id="period" name="period">
                                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Summary Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">${{ number_format($subscriptionRevenue + $oneTimeRevenue, 0) }}</h3>
                        <p class="text-muted mb-0">Total Revenue</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>Period: {{ $startDate }} to {{ $endDate }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-crown text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">${{ number_format($subscriptionRevenue, 0) }}</h3>
                        <p class="text-muted mb-0">Subscription Revenue</p>
                        <small class="text-info">
                            <i class="fas fa-percentage me-1"></i>{{ $subscriptionRevenue + $oneTimeRevenue > 0 ? number_format(($subscriptionRevenue / ($subscriptionRevenue + $oneTimeRevenue)) * 100, 1) : 0 }}% of total
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-shopping-cart text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">${{ number_format($oneTimeRevenue, 0) }}</h3>
                        <p class="text-muted mb-0">One-time Revenue</p>
                        <small class="text-warning">
                            <i class="fas fa-percentage me-1"></i>{{ $subscriptionRevenue + $oneTimeRevenue > 0 ? number_format(($oneTimeRevenue / ($subscriptionRevenue + $oneTimeRevenue)) * 100, 1) : 0 }}% of total
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-calculator text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">${{ count($revenueData) > 0 ? number_format(($subscriptionRevenue + $oneTimeRevenue) / count($revenueData), 0) : 0 }}</h3>
                        <p class="text-muted mb-0">Avg {{ ucfirst($period) }} Revenue</p>
                        <small class="text-primary">
                            <i class="fas fa-chart-line me-1"></i>Per {{ $period }} period
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Trend Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-chart-line me-2"></i>Revenue Trend ({{ ucfirst($period) }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods Breakdown -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-credit-card me-2"></i>Revenue by Payment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($revenueByMethod as $method)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <i class="fas fa-{{ $method->method == 'stripe' ? 'credit-card' : ($method->method == 'paypal' ? 'paypal' : 'money-bill-wave') }} fa-2x text-primary"></i>
                                        </div>
                                        <h6 class="card-title">{{ ucfirst($method->method) }}</h6>
                                        <h5 class="text-success mb-1">${{ number_format($method->total_revenue, 0) }}</h5>
                                        <small class="text-muted">{{ $method->transaction_count }} transactions</small>
                                        <div class="progress mt-2" style="height: 4px;">
                                            @php
                                                $totalRevenue = $revenueByMethod->sum('total_revenue');
                                                $percentage = $totalRevenue > 0 ? ($method->total_revenue / $totalRevenue) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-success" role="progressbar"
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

        <!-- Revenue Details Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-table me-2"></i>Detailed Revenue Breakdown
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Period</th>
                                        <th class="border-0 px-4 py-3">Revenue</th>
                                        <th class="border-0 px-4 py-3">Transactions</th>
                                        <th class="border-0 px-4 py-3">Avg per Transaction</th>
                                        <th class="border-0 px-4 py-3">Growth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($revenueData as $index => $data)
                                    @php $previousRevenue = $index > 0 ? $revenueData[$index - 1]->revenue : 0; @endphp
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">{{ $data->period }}</td>
                                        <td class="px-4 py-3 fw-bold text-success">${{ number_format($data->revenue, 0) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ number_format($data->transactions) }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-warning">${{ $data->transactions > 0 ? number_format($data->revenue / $data->transactions, 2) : '0.00' }}</td>
                                        <td class="px-4 py-3">
                                            @if($index > 0 && $previousRevenue > 0)
                                                @php
                                                    $growth = (($data->revenue - $previousRevenue) / $previousRevenue) * 100;
                                                @endphp
                                                <span class="{{ $growth >= 0 ? 'text-success' : 'text-danger' }}">
                                                    <i class="fas fa-arrow-{{ $growth >= 0 ? 'up' : 'down' }} me-1"></i>
                                                    {{ number_format(abs($growth), 1) }}%
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-dollar-sign fa-3x mb-3"></i>
                                                <p>No revenue data found for the selected period.</p>
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
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueData);

    const labels = revenueData.map(item => item.period);
    const revenues = revenueData.map(item => item.revenue);
    const transactions = revenueData.map(item => item.transactions);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue ($)',
                data: revenues,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                yAxisID: 'y',
                tension: 0.4,
                fill: true
            }, {
                label: 'Transactions',
                data: transactions,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
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
                    text: 'Revenue and Transaction Trends'
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Revenue ($)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Transactions'
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
    const period = document.getElementById('period').value;

    const url = `/admin/reports/revenue/export?start_date=${startDate}&end_date=${endDate}&period=${period}`;
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