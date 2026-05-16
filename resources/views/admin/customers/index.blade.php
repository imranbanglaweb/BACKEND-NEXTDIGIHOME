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
                            <i class="fas fa-users me-3"></i>All Customers
                        </h2>
                        <p class="text-white-50 mb-0">Manage customer accounts and information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-light">
                            <i class="fas fa-user-plus me-2"></i>Add Customer
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
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">1,234</h3>
                        <p class="text-muted mb-0">Total Customers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-check text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">1,189</h3>
                        <p class="text-muted mb-0">Active Customers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">45</h3>
                        <p class="text-muted mb-0">New This Month</p>
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
                        <h3 class="text-info mb-1">$8,456</h3>
                        <p class="text-muted mb-0">Avg Order Value</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-users me-2"></i>All Customers
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-2"></i>Add Customer
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-file-export me-2"></i>Export
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Customer ID</th>
                                        <th class="border-0 px-4 py-3">Name</th>
                                        <th class="border-0 px-4 py-3">Email</th>
                                        <th class="border-0 px-4 py-3">Phone</th>
                                        <th class="border-0 px-4 py-3">Orders</th>
                                        <th class="border-0 px-4 py-3">Total Spent</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Joined</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $customers = [
                                            ['id' => '#CUST-001', 'name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+1-234-567-8901', 'orders' => 12, 'total' => '$1,245.99', 'status' => 'Active', 'joined' => '2023-08-15', 'status_class' => 'success'],
                                            ['id' => '#CUST-002', 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+1-234-567-8902', 'orders' => 8, 'total' => '$892.50', 'status' => 'Active', 'joined' => '2023-09-22', 'status_class' => 'success'],
                                            ['id' => '#CUST-003', 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'phone' => '+1-234-567-8903', 'orders' => 15, 'total' => '$2,134.99', 'status' => 'Active', 'joined' => '2023-07-10', 'status_class' => 'success'],
                                            ['id' => '#CUST-004', 'name' => 'Sarah Wilson', 'email' => 'sarah@example.com', 'phone' => '+1-234-567-8904', 'orders' => 3, 'total' => '$245.99', 'status' => 'Inactive', 'joined' => '2023-11-05', 'status_class' => 'secondary'],
                                            ['id' => '#CUST-005', 'name' => 'Tom Brown', 'email' => 'tom@example.com', 'phone' => '+1-234-567-8905', 'orders' => 6, 'total' => '$567.99', 'status' => 'Active', 'joined' => '2023-10-18', 'status_class' => 'success'],
                                        ];
                                    @endphp
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">{{ $customer['id'] }}</td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-primary text-white">
                                                        {{ substr($customer['name'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $customer['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">{{ $customer['email'] }}</td>
                                        <td class="px-4 py-3">{{ $customer['phone'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ $customer['orders'] }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">{{ $customer['total'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $customer['status_class'] }} px-3 py-2">{{ $customer['status'] }}</span>
                                        </td>
                                        <td class="px-4 py-3">{{ $customer['joined'] }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Send Email">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing 1 to 5 of 1,234 entries
                                </div>
                                <nav aria-label="Customers pagination">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
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
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection