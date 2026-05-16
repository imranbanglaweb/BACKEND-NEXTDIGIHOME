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
                            <i class="fas fa-file-export me-3"></i>Order Data Exports
                        </h2>
                        <p class="text-white-50 mb-0">Export order data for analysis and reporting</p>
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
                                <i class="fas fa-file-export text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">156</h3>
                        <p class="text-muted mb-0">Exports This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-file-csv text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">CSV</h3>
                        <p class="text-muted mb-0">Most Popular Format</p>
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
                        <h3 class="text-info mb-1">2.3 MB</h3>
                        <p class="text-muted mb-0">Avg Export Size</p>
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
                                <i class="fas fa-file-export me-2"></i>Data Export Management
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-2"></i>New Export
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-history me-2"></i>Export History
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Export Dashboard -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-chart-line me-2"></i>
                                    <strong>Export Analytics:</strong> 156 exports this month • 2.3 MB average file size • CSV most popular format
                                </div>
                            </div>
                        </div>

                        <!-- Quick Export Options -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;" onclick="exportOrders('all')">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i class="fas fa-list text-primary" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="mb-2">All Orders</h6>
                                        <small class="text-muted">Complete order database</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;" onclick="exportOrders('monthly')">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i class="fas fa-calendar text-success" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="mb-2">Monthly Report</h6>
                                        <small class="text-muted">Current month orders</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;" onclick="exportOrders('revenue')">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i class="fas fa-dollar-sign text-warning" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="mb-2">Revenue Report</h6>
                                        <small class="text-muted">Sales and earnings data</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;" onclick="exportOrders('customers')">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i class="fas fa-users text-info" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="mb-2">Customer Data</h6>
                                        <small class="text-muted">Customer information</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Export History Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Export ID</th>
                                        <th class="border-0 px-3 py-3">Type</th>
                                        <th class="border-0 px-3 py-3">Format</th>
                                        <th class="border-0 px-3 py-3">Records</th>
                                        <th class="border-0 px-3 py-3">File Size</th>
                                        <th class="border-0 px-3 py-3">Created</th>
                                        <th class="border-0 px-3 py-3">Status</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $exports = [
                                            [
                                                'id' => '#EXP-2024-001',
                                                'type' => 'All Orders',
                                                'format' => 'CSV',
                                                'records' => '1,247',
                                                'size' => '2.4 MB',
                                                'created' => '2024-01-15 10:30 AM',
                                                'status' => 'Completed',
                                                'status_class' => 'success'
                                            ],
                                            [
                                                'id' => '#EXP-2024-002',
                                                'type' => 'Monthly Report',
                                                'format' => 'Excel',
                                                'records' => '89',
                                                'size' => '1.2 MB',
                                                'created' => '2024-01-15 09:15 AM',
                                                'status' => 'Processing',
                                                'status_class' => 'warning'
                                            ],
                                            [
                                                'id' => '#EXP-2024-003',
                                                'type' => 'Revenue Report',
                                                'format' => 'PDF',
                                                'records' => '1',
                                                'size' => '850 KB',
                                                'created' => '2024-01-14 04:45 PM',
                                                'status' => 'Completed',
                                                'status_class' => 'success'
                                            ],
                                            [
                                                'id' => '#EXP-2024-004',
                                                'type' => 'Customer Data',
                                                'format' => 'CSV',
                                                'records' => '1,234',
                                                'size' => '3.1 MB',
                                                'created' => '2024-01-14 02:20 PM',
                                                'status' => 'Failed',
                                                'status_class' => 'danger'
                                            ],
                                            [
                                                'id' => '#EXP-2024-005',
                                                'type' => 'Product Report',
                                                'format' => 'Excel',
                                                'records' => '156',
                                                'size' => '1.8 MB',
                                                'created' => '2024-01-13 11:00 AM',
                                                'status' => 'Completed',
                                                'status_class' => 'success'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($exports as $export)
                                    <tr>
                                        <td class="px-3 py-3 fw-bold">{{ $export['id'] }}</td>
                                        <td class="px-3 py-3">{{ $export['type'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-primary">{{ $export['format'] }}</span>
                                        </td>
                                        <td class="px-3 py-3">{{ $export['records'] }}</td>
                                        <td class="px-3 py-3">{{ $export['size'] }}</td>
                                        <td class="px-3 py-3">{{ $export['created'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $export['status_class'] }}">{{ $export['status'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Export Format Options -->
                        <div class="row mt-4">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <i class="fas fa-file-csv text-success" style="font-size: 24px;"></i>
                                        </div>
                                        <h6 class="mb-1">CSV</h6>
                                        <small class="text-muted">Most Popular</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <i class="fas fa-file-excel text-success" style="font-size: 24px;"></i>
                                        </div>
                                        <h6 class="mb-1">Excel</h6>
                                        <small class="text-muted">Formatted Reports</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <i class="fas fa-file-pdf text-danger" style="font-size: 24px;"></i>
                                        </div>
                                        <h6 class="mb-1">PDF</h6>
                                        <small class="text-muted">Print Ready</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <i class="fas fa-file-code text-info" style="font-size: 24px;"></i>
                                        </div>
                                        <h6 class="mb-1">JSON</h6>
                                        <small class="text-muted">API Format</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Export Automation -->
                        <hr class="my-4">
                        <h6 class="text-primary mb-3">Automated Export Scheduling</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-calendar text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Daily Reports</h6>
                                        <small class="text-muted">Automated daily sales reports</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-clock text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Weekly Summaries</h6>
                                        <small class="text-muted">Weekly performance summaries</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-chart-bar text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Monthly Analytics</h6>
                                        <small class="text-muted">Comprehensive monthly reports</small>
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