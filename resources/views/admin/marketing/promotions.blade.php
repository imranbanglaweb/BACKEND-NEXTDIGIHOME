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
                            <i class="fas fa-percent me-3"></i>Promotions
                        </h2>
                        <p class="text-white-50 mb-0">Manage promotional campaigns and special offers</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createPromotionModal">
                            <i class="fas fa-plus me-2"></i>New Promotion
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
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-percent text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">8</h3>
                        <p class="text-muted mb-0">Active Promotions</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">3</h3>
                        <p class="text-muted mb-0">Scheduled</p>
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
                        <h3 class="text-info mb-1">12,456</h3>
                        <p class="text-muted mb-0">Redemptions</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">$45,231</h3>
                        <p class="text-muted mb-0">Revenue Generated</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Promotional Campaigns
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" placeholder="Search promotions..." style="width: 250px;">
                                <select class="form-select" style="width: 150px;">
                                    <option>All Status</option>
                                    <option>Active</option>
                                    <option>Scheduled</option>
                                    <option>Expired</option>
                                    <option>Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input"></th>
                                        <th>Promotion Name</th>
                                        <th>Type</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Redemptions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-percent text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Winter Sale 2024</h6>
                                                    <small class="text-muted">Seasonal discount campaign</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">Percentage</span></td>
                                        <td>50% Off</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-01-01</td>
                                        <td>2024-01-31</td>
                                        <td>2,341</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="View Report">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Pause">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-tag text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">New Customer Welcome</h6>
                                                    <small class="text-muted">First-time buyer discount</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">Fixed Amount</span></td>
                                        <td>$25 Off</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-01-01</td>
                                        <td>2024-12-31</td>
                                        <td>8,932</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="View Report">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Pause">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-birthday-cake text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Birthday Special</h6>
                                                    <small class="text-muted">Birthday month celebration</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">Percentage</span></td>
                                        <td>30% Off</td>
                                        <td><span class="badge bg-warning">Scheduled</span></td>
                                        <td>2024-02-01</td>
                                        <td>2024-02-28</td>
                                        <td>0</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="View Report">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Promotions pagination" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link">1</span>
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
</section>

<!-- Create Promotion Modal -->
<div class="modal fade" id="createPromotionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Promotion Name</label>
                            <input type="text" class="form-control" placeholder="Enter promotion name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Promotion Type</label>
                            <select class="form-select">
                                <option>Percentage Discount</option>
                                <option>Fixed Amount</option>
                                <option>Buy One Get One</option>
                                <option>Free Shipping</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Value</label>
                            <input type="number" class="form-control" placeholder="Enter discount value">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Minimum Purchase</label>
                            <input type="number" class="form-control" placeholder="Enter minimum amount">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Promotion description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Applicable Products</label>
                        <select class="form-select" multiple>
                            <option>All Products</option>
                            <option>Electronics</option>
                            <option>Clothing</option>
                            <option>Books</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Create Promotion</button>
            </div>
        </div>
    </div>
</div>
@endsection