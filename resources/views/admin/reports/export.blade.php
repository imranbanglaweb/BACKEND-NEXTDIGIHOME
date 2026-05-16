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
                            <i class="fas fa-file-export me-3"></i>Data Export
                        </h2>
                        <p class="text-white-50 mb-0">Export business data in various formats for external analysis</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Configuration -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-cogs me-2"></i>Export Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="exportForm" method="POST" action="{{ route('reports.export.process') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="data_type" class="form-label">Data Type</label>
                                    <select class="form-control" id="data_type" name="data_type" required>
                                        <option value="orders" {{ $dataType == 'orders' ? 'selected' : '' }}>Orders</option>
                                        <option value="customers" {{ $dataType == 'customers' ? 'selected' : '' }}>Customers</option>
                                        <option value="products" {{ $dataType == 'products' ? 'selected' : '' }}>Products</option>
                                        <option value="payments" {{ $dataType == 'payments' ? 'selected' : '' }}>Payments</option>
                                        <option value="subscriptions" {{ $dataType == 'subscriptions' ? 'selected' : '' }}>Subscriptions</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="format" class="form-label">Export Format</label>
                                    <select class="form-control" id="format" name="format" required>
                                        <option value="csv">CSV</option>
                                        <option value="excel">Excel</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="include_headers" name="include_headers" checked>
                                        <label class="form-check-label" for="include_headers">
                                            Include column headers
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="compress" name="compress">
                                        <label class="form-check-label" for="compress">
                                            Compress file (ZIP)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary" onclick="previewExport()">
                                        <i class="fas fa-eye me-2"></i>Preview Data
                                    </button>
                                    <button type="submit" class="btn btn-success ms-2" id="exportBtn" disabled>
                                        <i class="fas fa-download me-2"></i>Export Data
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Preview -->
        <div class="row mb-4" id="previewSection" style="display: none;">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-table me-2"></i>Data Preview ({{ ucfirst($dataType) }})
                        </h5>
                        <span class="badge bg-info">{{ $totalRecords }} total records</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="previewTable">
                                <!-- Table content will be populated by JavaScript -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export History -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-history me-2"></i>Recent Exports
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Data Type</th>
                                        <th>Date Range</th>
                                        <th>Format</th>
                                        <th>Records</th>
                                        <th>Export Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- This would be populated from a database table tracking exports -->
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-history fa-3x mb-3"></i>
                                                <p>No export history available. Your exports will appear here after completion.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show initial preview if data exists
    @if($sampleData->isNotEmpty())
        showPreview(@json($sampleData), '{{ $dataType }}');
    @endif
});

function previewExport() {
    const formData = new FormData(document.getElementById('exportForm'));
    const data = {
        data_type: formData.get('data_type'),
        start_date: formData.get('start_date'),
        end_date: formData.get('end_date'),
        format: formData.get('format')
    };

    // Show loading
    const previewSection = document.getElementById('previewSection');
    const previewTable = document.getElementById('previewTable');
    previewTable.innerHTML = '<tr><td colspan="10" class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading preview...</td></tr>';

    // Simulate API call (in real implementation, this would be an AJAX call)
    setTimeout(() => {
        // For demo purposes, we'll use the existing sample data
        // In a real implementation, you'd fetch fresh data based on the form parameters
        @if($sampleData->isNotEmpty())
            showPreview(@json($sampleData), data.data_type);
        @else
            previewTable.innerHTML = '<tr><td colspan="10" class="text-center py-4 text-muted">No data available for the selected criteria.</td></tr>';
        @endif

        // Enable export button
        document.getElementById('exportBtn').disabled = false;
    }, 1000);
}

function showPreview(data, dataType) {
    const previewSection = document.getElementById('previewSection');
    const previewTable = document.getElementById('previewTable');

    let headers = [];
    let rows = '';

    if (dataType === 'orders' && data.length > 0) {
        headers = ['ID', 'Customer', 'Product', 'Total', 'Status', 'Date'];
        data.forEach(item => {
            rows += `<tr>
                <td>${item.id}</td>
                <td>${item.customer_name || 'N/A'}</td>
                <td>${item.product_name || 'N/A'}</td>
                <td>$${parseFloat(item.total).toFixed(2)}</td>
                <td><span class="badge bg-${getStatusColor(item.status)}">${item.status}</span></td>
                <td>${new Date(item.created_at).toLocaleDateString()}</td>
            </tr>`;
        });
    } else if (dataType === 'customers' && data.length > 0) {
        headers = ['ID', 'Name', 'Email', 'Role', 'Joined'];
        data.forEach(item => {
            rows += `<tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.email}</td>
                <td>${item.role || 'user'}</td>
                <td>${new Date(item.created_at).toLocaleDateString()}</td>
            </tr>`;
        });
    } else if (dataType === 'products' && data.length > 0) {
        headers = ['ID', 'Name', 'Price', 'Stock', 'Category', 'Status'];
        data.forEach(item => {
            rows += `<tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>$${parseFloat(item.price).toFixed(2)}</td>
                <td>${item.stock}</td>
                <td>${item.category || 'N/A'}</td>
                <td><span class="badge bg-${item.active == '1' ? 'success' : 'secondary'}">${item.active == '1' ? 'Active' : 'Inactive'}</span></td>
            </tr>`;
        });
    } else if (dataType === 'payments' && data.length > 0) {
        headers = ['ID', 'Amount', 'Method', 'Status', 'Date'];
        data.forEach(item => {
            rows += `<tr>
                <td>${item.id}</td>
                <td>$${parseFloat(item.amount).toFixed(2)}</td>
                <td>${item.method}</td>
                <td><span class="badge bg-${item.status === 'paid' ? 'success' : 'warning'}">${item.status}</span></td>
                <td>${new Date(item.paid_at).toLocaleDateString()}</td>
            </tr>`;
        });
    }

    let headerHtml = '<thead class="bg-light"><tr>';
    headers.forEach(header => {
        headerHtml += `<th class="border-0 px-4 py-3">${header}</th>`;
    });
    headerHtml += '</tr></thead>';

    previewTable.innerHTML = headerHtml + '<tbody>' + rows + '</tbody>';
    previewSection.style.display = 'block';
}

function getStatusColor(status) {
    const colors = {
        'pending': 'warning',
        'processing': 'info',
        'shipped': 'primary',
        'delivered': 'success',
        'cancelled': 'danger'
    };
    return colors[status] || 'secondary';
}

// Form submission handler
document.getElementById('exportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('exportBtn');
    const originalText = btn.innerHTML;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    btn.disabled = true;

    // In a real implementation, this would submit to a processing endpoint
    // For now, we'll simulate the export
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Export feature will be implemented. In the meantime, you can preview the data above.');
    }, 2000);
});
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