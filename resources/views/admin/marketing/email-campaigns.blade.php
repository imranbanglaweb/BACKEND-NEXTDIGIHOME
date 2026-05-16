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
                            <i class="fas fa-mail-bulk me-3"></i>Email Campaigns
                        </h2>
                        <p class="text-white-50 mb-0">Create and manage email marketing campaigns</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#createCampaignModal">
                            <i class="fas fa-plus me-2"></i>New Campaign
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
                                <i class="fas fa-paper-plane text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">12</h3>
                        <p class="text-muted mb-0">Active Campaigns</p>
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
                        <h3 class="text-success mb-1">45,231</h3>
                        <p class="text-muted mb-0">Total Recipients</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-eye text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">23.4%</h3>
                        <p class="text-muted mb-0">Avg Open Rate</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-mouse-pointer text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">8.7%</h3>
                        <p class="text-muted mb-0">Avg Click Rate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaigns Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Email Campaigns
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" placeholder="Search campaigns..." style="width: 250px;">
                                <select class="form-select" style="width: 150px;">
                                    <option>All Status</option>
                                    <option>Draft</option>
                                    <option>Scheduled</option>
                                    <option>Sending</option>
                                    <option>Sent</option>
                                    <option>Paused</option>
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
                                        <th>Campaign Name</th>
                                        <th>Subject</th>
                                        <th>Recipients</th>
                                        <th>Status</th>
                                        <th>Sent Date</th>
                                        <th>Open Rate</th>
                                        <th>Click Rate</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-mail-bulk text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Winter Sale 2024</h6>
                                                    <small class="text-muted">Promotional campaign</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>🔥 Hot Winter Deals - Up to 50% Off!</td>
                                        <td>12,456</td>
                                        <td><span class="badge bg-success">Sent</span></td>
                                        <td>2024-01-15</td>
                                        <td>28.5%</td>
                                        <td>12.3%</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="View Report">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
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
                                                    <i class="fas fa-newspaper text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Monthly Newsletter</h6>
                                                    <small class="text-muted">January 2024 edition</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>January Product Updates & Tips</td>
                                        <td>8,932</td>
                                        <td><span class="badge bg-warning">Scheduled</span></td>
                                        <td>2024-01-20</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" title="View Report">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
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
                                                    <i class="fas fa-birthday-cake text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Customer Anniversary</h6>
                                                    <small class="text-muted">Automated campaign</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Happy Anniversary! Special Thanks</td>
                                        <td>2,341</td>
                                        <td><span class="badge bg-primary">Sending</span></td>
                                        <td>In Progress</td>
                                        <td>18.2%</td>
                                        <td>5.7%</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-warning" title="Pause">
                                                    <i class="fas fa-pause"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
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
                        <nav aria-label="Campaigns pagination" class="mt-4">
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

<!-- Create Campaign Modal -->
<div class="modal fade" id="createCampaignModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Email Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Campaign Name</label>
                            <input type="text" class="form-control" placeholder="Enter campaign name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Campaign Type</label>
                            <select class="form-select">
                                <option>Promotional</option>
                                <option>Newsletter</option>
                                <option>Transactional</option>
                                <option>Re-engagement</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject Line</label>
                        <input type="text" class="form-control" placeholder="Enter email subject">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Template</label>
                        <select class="form-select">
                            <option>Select a template...</option>
                            <option>Welcome Email</option>
                            <option>Newsletter Template</option>
                            <option>Promotional Template</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target Audience</label>
                            <select class="form-select">
                                <option>All Subscribers</option>
                                <option>Active Customers</option>
                                <option>Inactive Users</option>
                                <option>Custom Segment</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Schedule</label>
                            <input type="datetime-local" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Create Campaign</button>
            </div>
        </div>
    </div>
</div>
@endsection