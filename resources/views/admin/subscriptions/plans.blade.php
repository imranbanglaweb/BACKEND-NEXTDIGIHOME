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
                            <i class="fas fa-crown me-3"></i>Subscription Plans Management
                        </h2>
                        <p class="text-white-50 mb-0">Create and manage subscription plans for your services</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createPlanModal">
                            <i class="fas fa-plus me-2"></i>Create Plan
                        </button>
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
                                <i class="fas fa-crown text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">8</h3>
                        <p class="text-muted mb-0">Active Plans</p>
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
                        <h3 class="text-success mb-1">1,247</h3>
                        <p class="text-muted mb-0">Active Subscribers</p>
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
                        <h3 class="text-info mb-1">$12,450</h3>
                        <p class="text-muted mb-0">Monthly Revenue</p>
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
                        <h3 class="text-warning mb-1">+15%</h3>
                        <p class="text-muted mb-0">Growth Rate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Plans Grid -->
        <div class="row">
            @php
                $plans = [
                    [
                        'name' => 'Basic Plan',
                        'price' => '$9.99',
                        'duration' => '1 month',
                        'features' => ['Basic Access', 'Email Support', '5 Projects'],
                        'subscribers' => 234,
                        'status' => 'Active',
                        'popular' => false
                    ],
                    [
                        'name' => 'Pro Plan',
                        'price' => '$29.99',
                        'duration' => '1 month',
                        'features' => ['Advanced Access', 'Priority Support', 'Unlimited Projects', 'API Access'],
                        'subscribers' => 456,
                        'status' => 'Active',
                        'popular' => true
                    ],
                    [
                        'name' => 'Enterprise Plan',
                        'price' => '$99.99',
                        'duration' => '1 month',
                        'features' => ['Full Access', 'Dedicated Support', 'Custom Integration', 'White-label', 'SLA Guarantee'],
                        'subscribers' => 89,
                        'status' => 'Active',
                        'popular' => false
                    ],
                    [
                        'name' => 'Starter Plan',
                        'price' => '$4.99',
                        'duration' => '1 month',
                        'features' => ['Limited Access', 'Community Support', '1 Project'],
                        'subscribers' => 468,
                        'status' => 'Active',
                        'popular' => false
                    ],
                ];
            @endphp

            @foreach($plans as $plan)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100 {{ $plan['popular'] ? 'border-primary' : '' }}" style="background: rgba(255,255,255,0.95); border-radius: 15px; position: relative;">
                    @if($plan['popular'])
                        <div class="badge bg-primary position-absolute" style="top: -10px; right: 20px;">Most Popular</div>
                    @endif

                    <div class="card-header bg-white border-0 text-center">
                        <h5 class="mb-2 text-primary">{{ $plan['name'] }}</h5>
                        <div class="h2 text-success mb-1">{{ $plan['price'] }}</div>
                        <small class="text-muted">per {{ $plan['duration'] }}</small>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-4">
                            @foreach($plan['features'] as $feature)
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                            </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>{{ $plan['subscribers'] }} subscribers
                            </small>
                            <span class="badge bg-{{ $plan['status'] == 'Active' ? 'success' : 'secondary' }}">{{ $plan['status'] }}</span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0">
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                            <button class="btn btn-outline-info btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>View
                            </button>
                            <button class="btn btn-outline-danger btn-sm flex-fill">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Plans Table View -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-table me-2"></i>All Subscription Plans
                            </h5>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download me-2"></i>Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Plan Name</th>
                                        <th class="border-0 px-4 py-3">Price</th>
                                        <th class="border-0 px-4 py-3">Duration</th>
                                        <th class="border-0 px-4 py-3">Subscribers</th>
                                        <th class="border-0 px-4 py-3">Revenue</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Created</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plans as $plan)
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">{{ $plan['name'] }}</td>
                                        <td class="px-4 py-3 text-success fw-bold">{{ $plan['price'] }}</td>
                                        <td class="px-4 py-3">{{ $plan['duration'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary">{{ $plan['subscribers'] }}</span>
                                        </td>
                                        <td class="px-4 py-3">{{ '$' . number_format($plan['subscribers'] * floatval(str_replace('$', '', $plan['price'])), 2) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $plan['status'] == 'Active' ? 'success' : 'secondary' }}">{{ $plan['status'] }}</span>
                                        </td>
                                        <td class="px-4 py-3">2024-01-15</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="Edit Plan">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete Plan">
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
                                    Showing 1 to 4 of 8 subscription plans
                                </div>
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">Previous</a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
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

        <!-- Create Plan Modal -->
        <div class="modal fade" id="createPlanModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Subscription Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createPlanForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Duration <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="duration" min="1" required>
                                        <select class="form-select" name="duration_unit">
                                            <option value="days">Days</option>
                                            <option value="weeks">Weeks</option>
                                            <option value="months" selected>Months</option>
                                            <option value="years">Years</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Plan Type</label>
                                    <select class="form-control" name="type">
                                        <option value="standard">Standard</option>
                                        <option value="premium">Premium</option>
                                        <option value="enterprise">Enterprise</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Plan description and benefits"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Features (one per line)</label>
                                    <textarea class="form-control" name="features" rows="4" placeholder="Feature 1
Feature 2
Feature 3"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" checked>
                                        <label class="form-check-label">
                                            Active (available for purchase)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="$('#createPlanForm').submit()">Create Plan</button>
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