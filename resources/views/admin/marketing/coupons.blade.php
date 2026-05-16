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
                            <i class="fas fa-ticket-alt me-3"></i>Coupons
                        </h2>
                        <p class="text-white-50 mb-0">Create and manage discount coupons and voucher codes</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                            <i class="fas fa-plus me-2"></i>New Coupon
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
                                <i class="fas fa-ticket-alt text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">15</h3>
                        <p class="text-muted mb-0">Active Coupons</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">3,247</h3>
                        <p class="text-muted mb-0">Total Redemptions</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">$12,456</h3>
                        <p class="text-muted mb-0">Total Savings</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-times-circle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-danger mb-1">5</h3>
                        <p class="text-muted mb-0">Expired</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coupons Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Coupon Codes
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" placeholder="Search coupons..." style="width: 250px;">
                                <select class="form-select" style="width: 150px;">
                                    <option>All Status</option>
                                    <option>Active</option>
                                    <option>Expired</option>
                                    <option>Disabled</option>
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
                                        <th>Coupon Code</th>
                                        <th>Type</th>
                                        <th>Discount</th>
                                        <th>Usage Limit</th>
                                        <th>Used</th>
                                        <th>Status</th>
                                        <th>Expires</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-ticket-alt text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">WELCOME2024</h6>
                                                    <small class="text-muted">New customer welcome</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">Fixed Amount</span></td>
                                        <td>$25.00</td>
                                        <td>Unlimited</td>
                                        <td>1,247</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-12-31</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="View Usage">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Disable">
                                                    <i class="fas fa-ban"></i>
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
                                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-percent text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">SAVE50</h6>
                                                    <small class="text-muted">Flash sale discount</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">Percentage</span></td>
                                        <td>50%</td>
                                        <td>500</td>
                                        <td>387</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-01-20</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="View Usage">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Disable">
                                                    <i class="fas fa-ban"></i>
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
                                                    <h6 class="mb-0">BDAY30</h6>
                                                    <small class="text-muted">Birthday special offer</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">Percentage</span></td>
                                        <td>30%</td>
                                        <td>1 per customer</td>
                                        <td>89</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2024-12-31</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="View Usage">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Disable">
                                                    <i class="fas fa-ban"></i>
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
                        <nav aria-label="Coupons pagination" class="mt-4">
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

<!-- Create Coupon Modal -->
<div class="modal fade" id="createCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" placeholder="Enter coupon code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Type</label>
                            <select class="form-select">
                                <option>Fixed Amount</option>
                                <option>Percentage</option>
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
                            <label class="form-label">Usage Limit</label>
                            <input type="number" class="form-control" placeholder="Enter usage limit">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Per Customer Limit</label>
                            <input type="number" class="form-control" placeholder="Uses per customer">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Coupon description"></textarea>
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
                <button type="button" class="btn btn-primary">Create Coupon</button>
            </div>
        </div>
    </div>
</div>
@endsection