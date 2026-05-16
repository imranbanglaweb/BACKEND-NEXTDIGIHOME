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
                            <i class="fas fa-box me-3"></i>Product Reports
                        </h2>
                        <p class="text-white-50 mb-0">Product performance, sales analysis, and inventory insights</p>
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
                                    <a href="{{ route('admin.reports.products') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Performance Table -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-chart-bar me-2"></i>Product Performance
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Product</th>
                                        <th class="border-0 px-4 py-3">Price</th>
                                        <th class="border-0 px-4 py-3">Units Sold</th>
                                        <th class="border-0 px-4 py-3">Revenue</th>
                                        <th class="border-0 px-4 py-3">Orders</th>
                                        <th class="border-0 px-4 py-3">Stock</th>
                                        <th class="border-0 px-4 py-3">Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productReports as $product)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ substr($product->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $product->name }}</div>
                                                    <small class="text-muted">ID: {{ $product->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-primary">${{ number_format($product->price, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ number_format($product->units_sold) }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">${{ number_format($product->total_revenue, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-warning">{{ number_format($product->customers_count) }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($product->stock > 10)
                                                <span class="badge bg-success">{{ $product->stock }}</span>
                                            @elseif($product->stock > 0)
                                                <span class="badge bg-warning">{{ $product->stock }}</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $maxRevenue = $productReports->max('total_revenue');
                                                $performance = $maxRevenue > 0 ? ($product->total_revenue / $maxRevenue) * 100 : 0;
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: {{ $performance }}%"
                                                         aria-valuenow="{{ $performance }}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ number_format($performance, 0) }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-box fa-3x mb-3"></i>
                                                <p>No product sales data found for the selected period.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($productReports->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $productReports->firstItem() }} to {{ $productReports->lastItem() }} of {{ $productReports->total() }} products
                                </div>
                                {{ $productReports->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Performance -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-tags me-2"></i>Category Performance
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($categoryReports as $category)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="card-title mb-0">{{ $category->category_name }}</h6>
                                            <span class="badge bg-primary">{{ $category->products_count }} products</span>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="text-info fw-bold">{{ number_format($category->total_units) }}</div>
                                                <small class="text-muted">Units Sold</small>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-success fw-bold">${{ number_format($category->total_revenue, 0) }}</div>
                                                <small class="text-muted">Revenue</small>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height: 6px;">
                                            @php
                                                $maxCategoryRevenue = $categoryReports->max('total_revenue');
                                                $categoryPerformance = $maxCategoryRevenue > 0 ? ($category->total_revenue / $maxCategoryRevenue) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-info" role="progressbar"
                                                 style="width: {{ $categoryPerformance }}%"
                                                 aria-valuenow="{{ $categoryPerformance }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                    <p>No category data found for the selected period.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function exportReport() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    const url = `/admin/reports/products/export?start_date=${startDate}&end_date=${endDate}`;
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