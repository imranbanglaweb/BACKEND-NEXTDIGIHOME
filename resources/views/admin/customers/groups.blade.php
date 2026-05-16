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
                            <i class="fas fa-users-cog me-3"></i>Customer Groups Management
                        </h2>
                        <p class="text-white-50 mb-0">Organize customers into groups for targeted marketing and management</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                            <i class="fas fa-plus me-2"></i>Create Group
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Customers
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
                                <i class="fas fa-users-cog text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">12</h3>
                        <p class="text-muted mb-0">Active Groups</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">1,089</h3>
                        <p class="text-muted mb-0">Grouped Customers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">$156K</h3>
                        <p class="text-muted mb-0">Group Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-chart-line text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">+23%</h3>
                        <p class="text-muted mb-0">Growth Rate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Groups Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-users-cog me-2"></i>Customer Groups
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search groups..." style="width: 200px;">
                                <select class="form-control form-control-sm" style="width: 150px;">
                                    <option>All Types</option>
                                    <option>VIP Customers</option>
                                    <option>Regular Buyers</option>
                                    <option>New Customers</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Group Name</th>
                                        <th class="border-0 px-4 py-3">Type</th>
                                        <th class="border-0 px-4 py-3">Members</th>
                                        <th class="border-0 px-4 py-3">Revenue</th>
                                        <th class="border-0 px-4 py-3">Avg Order</th>
                                        <th class="border-0 px-4 py-3">Created</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groups = [
                                            ['name' => 'VIP Customers', 'type' => 'Premium', 'members' => 156, 'revenue' => '$45,230', 'avg_order' => '$290', 'created' => '2023-08-15', 'status' => 'Active', 'status_class' => 'success'],
                                            ['name' => 'Regular Buyers', 'type' => 'Standard', 'members' => 423, 'revenue' => '$67,890', 'avg_order' => '$160', 'created' => '2023-07-22', 'status' => 'Active', 'status_class' => 'success'],
                                            ['name' => 'New Customers', 'type' => 'Onboarding', 'members' => 89, 'revenue' => '$12,450', 'avg_order' => '$140', 'created' => '2024-01-10', 'status' => 'Active', 'status_class' => 'success'],
                                            ['name' => 'Wholesale Clients', 'type' => 'Business', 'members' => 34, 'revenue' => '$89,670', 'avg_order' => '$2,637', 'created' => '2023-06-05', 'status' => 'Active', 'status_class' => 'success'],
                                            ['name' => 'Inactive Users', 'type' => 'Archived', 'members' => 234, 'revenue' => '$23,450', 'avg_order' => '$100', 'created' => '2023-09-18', 'status' => 'Inactive', 'status_class' => 'secondary'],
                                        ];
                                    @endphp
                                    @foreach($groups as $group)
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">{{ $group['name'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ $group['type'] }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary">{{ $group['members'] }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">{{ $group['revenue'] }}</td>
                                        <td class="px-4 py-3">{{ $group['avg_order'] }}</td>
                                        <td class="px-4 py-3">{{ $group['created'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $group['status_class'] }} px-3 py-2">{{ $group['status'] }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="View Members">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-warning" title="Edit Group">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Send Campaign">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete Group">
                                                    <i class="fas fa-trash"></i>
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
                                    Showing 1 to 5 of 12 customer groups
                                </div>
                                <nav aria-label="Groups pagination">
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

        <!-- Add Group Modal -->
        <div class="modal fade" id="addGroupModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Customer Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Group Name</label>
                                <input type="text" class="form-control" placeholder="Enter group name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Group Type</label>
                                <select class="form-control">
                                    <option>Standard</option>
                                    <option>Premium</option>
                                    <option>VIP</option>
                                    <option>Business</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" placeholder="Group description"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Create Group</button>
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
    .bg-secondary { background-color: #6c757d !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-secondary { color: #6c757d !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection