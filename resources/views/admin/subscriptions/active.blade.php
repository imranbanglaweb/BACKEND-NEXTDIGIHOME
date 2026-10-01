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
                            <i class="fas fa-check-circle me-3"></i>Active Subscriptions
                        </h2>
                        <p class="text-white-50 mb-0">Monitor and manage current active user subscriptions</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>New Subscription
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
                                <i class="fas fa-check-circle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">1,247</h3>
                        <p class="text-muted mb-0">Active Subscriptions</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-calendar-alt text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">23</h3>
                        <p class="text-muted mb-0">Expiring Soon</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-redo text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">89</h3>
                        <p class="text-muted mb-0">Auto-Renewals</p>
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
                        <h3 class="text-primary mb-1">$15,630</h3>
                        <p class="text-muted mb-0">Monthly Recurring</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Subscriptions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-users me-2"></i>Current Active Subscriptions
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search subscriptions..." style="width: 200px;">
                                <select class="form-control form-control-sm" style="width: 150px;">
                                    <option>All Plans</option>
                                    <option>Basic Plan</option>
                                    <option>Pro Plan</option>
                                    <option>Enterprise Plan</option>
                                </select>
                                <button class="btn btn-info btn-sm">
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
                                        <th class="border-0 px-4 py-3">Subscriber</th>
                                        <th class="border-0 px-4 py-3">Plan</th>
                                        <th class="border-0 px-4 py-3">Amount</th>
                                        <th class="border-0 px-4 py-3">Billing Cycle</th>
                                        <th class="border-0 px-4 py-3">Next Billing</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Auto-Renew</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subscriptions = [
                                            [
                                                'subscriber' => 'John Doe',
                                                'email' => 'john@example.com',
                                                'plan' => 'Pro Plan',
                                                'amount' => '$29.99',
                                                'cycle' => 'Monthly',
                                                'next_billing' => '2024-02-15',
                                                'status' => 'Active',
                                                'auto_renew' => true
                                            ],
                                            [
                                                'subscriber' => 'Jane Smith',
                                                'email' => 'jane@example.com',
                                                'plan' => 'Enterprise Plan',
                                                'amount' => '$99.99',
                                                'cycle' => 'Monthly',
                                                'next_billing' => '2024-02-10',
                                                'status' => 'Active',
                                                'auto_renew' => true
                                            ],
                                            [
                                                'subscriber' => 'Mike Johnson',
                                                'email' => 'mike@example.com',
                                                'plan' => 'Basic Plan',
                                                'amount' => '$9.99',
                                                'cycle' => 'Monthly',
                                                'next_billing' => '2024-02-08',
                                                'status' => 'Active',
                                                'auto_renew' => false
                                            ],
                                            [
                                                'subscriber' => 'Sarah Wilson',
                                                'email' => 'sarah@example.com',
                                                'plan' => 'Pro Plan',
                                                'amount' => '$29.99',
                                                'cycle' => 'Yearly',
                                                'next_billing' => '2025-01-15',
                                                'status' => 'Active',
                                                'auto_renew' => true
                                            ],
                                            [
                                                'subscriber' => 'Tom Brown',
                                                'email' => 'tom@example.com',
                                                'plan' => 'Enterprise Plan',
                                                'amount' => '$99.99',
                                                'cycle' => 'Monthly',
                                                'next_billing' => '2024-02-05',
                                                'status' => 'Trial',
                                                'auto_renew' => true
                                            ],
                                        ];
                                    @endphp
                                    @foreach($subscriptions as $subscription)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-primary text-white">
                                                        {{ substr($subscription['subscriber'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $subscription['subscriber'] }}</div>
                                                    <small class="text-muted">{{ $subscription['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ $subscription['plan'] }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">{{ $subscription['amount'] }}</td>
                                        <td class="px-4 py-3">{{ $subscription['cycle'] }}</td>
                                        <td class="px-4 py-3">
                                            <span class="text-info">{{ $subscription['next_billing'] }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $subscription['status'] == 'Active' ? 'success' : ($subscription['status'] == 'Trial' ? 'warning' : 'secondary') }}">
                                                {{ $subscription['status'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($subscription['auto_renew'])
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Enabled
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times me-1"></i>Disabled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-warning" title="Modify Plan">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="Payment History">
                                                    <i class="fas fa-credit-card"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Cancel Subscription">
                                                    <i class="fas fa-ban"></i>
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
                                    Showing 1 to 5 of 1,247 active subscriptions
                                </div>
                                <nav aria-label="Subscriptions pagination">
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

        <!-- Subscription Management Tools -->
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-sync text-info" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Bulk Actions</h6>
                        <small class="text-muted">Apply changes to multiple subscriptions</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-bell text-warning" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Renewal Alerts</h6>
                        <small class="text-muted">Configure subscription renewal notifications</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-chart-line text-success" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Analytics</h6>
                        <small class="text-muted">View subscription trends and metrics</small>
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
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection