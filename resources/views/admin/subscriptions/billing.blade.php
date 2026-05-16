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
                            <i class="fas fa-credit-card me-3"></i>Billing History
                        </h2>
                        <p class="text-white-50 mb-0">Track and manage all subscription payments and billing records</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light">
                            <i class="fas fa-file-export me-2"></i>Export Report
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
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">${{ number_format($totalRevenue, 0) }}</h3>
                        <p class="text-muted mb-0">Total Revenue</p>
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
                        <h3 class="text-info mb-1">${{ number_format($monthlyRevenue, 0) }}</h3>
                        <p class="text-muted mb-0">This Month</p>
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
                        <h3 class="text-warning mb-1">{{ $pendingPayments }}</h3>
                        <p class="text-muted mb-0">Pending Payments</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-times text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-danger mb-1">{{ $failedPayments }}</h3>
                        <p class="text-muted mb-0">Failed Payments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing History Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-history me-2"></i>Payment History
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search payments..." style="width: 200px;">
                                <select class="form-control form-control-sm" style="width: 120px;">
                                    <option>All Status</option>
                                    <option>Paid</option>
                                    <option>Pending</option>
                                    <option>Failed</option>
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
                                        <th class="border-0 px-4 py-3">Company</th>
                                        <th class="border-0 px-4 py-3">Plan</th>
                                        <th class="border-0 px-4 py-3">Amount</th>
                                        <th class="border-0 px-4 py-3">Method</th>
                                        <th class="border-0 px-4 py-3">Transaction ID</th>
                                        <th class="border-0 px-4 py-3">Date</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-primary text-white">
                                                        {{ $payment->company ? substr($payment->company->company_name, 0, 1) : 'C' }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $payment->company ? $payment->company->company_name : 'Unknown Company' }}</div>
                                                    <small class="text-muted">{{ $payment->company ? $payment->company->email : 'No email' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ $payment->plan ? $payment->plan->name : 'Unknown Plan' }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold text-success">${{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-4 py-3">{{ ucfirst($payment->method) }}</td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ $payment->transaction_id ?: 'N/A' }}</small>
                                        </td>
                                        <td class="px-4 py-3">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="Download Invoice">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                @if($payment->status == 'pending')
                                                <button class="btn btn-outline-success" title="Mark as Paid">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                @endif
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
                                    Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} payments
                                </div>
                                {{ $payments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing Management Tools -->
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-chart-line text-success" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Revenue Analytics</h6>
                        <small class="text-muted">View detailed revenue reports and trends</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-file-invoice-dollar text-info" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Invoice Management</h6>
                        <small class="text-muted">Generate and manage payment invoices</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-bell text-warning" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Payment Reminders</h6>
                        <small class="text-muted">Configure automated payment notifications</small>
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
    .bg-danger { background-color: #dc3545 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection