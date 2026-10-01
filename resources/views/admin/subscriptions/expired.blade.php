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
                            <i class="fas fa-times-circle me-3"></i>Expired Subscriptions
                        </h2>
                        <p class="text-white-50 mb-0">Track and manage expired user subscriptions</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light">
                            <i class="fas fa-envelope me-2"></i>Send Renewal Offers
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
                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-times-circle text-white fa-2x"></i>
                            </div>
                        </div>
                         <h3 class="text-danger mb-1">{{ $totalExpired }}</h3>
                         <p class="text-muted mb-0">Expired Subscriptions</p>
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
                         <h3 class="text-warning mb-1">{{ $recentlyExpired }}</h3>
                         <p class="text-muted mb-0">Recently Expired</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-undo text-white fa-2x"></i>
                            </div>
                        </div>
                         <h3 class="text-info mb-1">{{ $reactivated }}</h3>
                         <p class="text-muted mb-0">Reactivated</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                         <h3 class="text-secondary mb-1">${{ number_format($lostRevenue, 0) }}</h3>
                         <p class="text-muted mb-0">Lost Revenue</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Subscriptions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-clock me-2"></i>Expired Subscription Management
                            </h5>
                            <div class="d-flex gap-2">
                                <select class="form-control form-control-sm" style="width: 150px;">
                                    <option>Last 30 Days</option>
                                    <option>Last 90 Days</option>
                                    <option>Last 6 Months</option>
                                    <option>All Time</option>
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
                                        <th class="border-0 px-4 py-3">Expired Date</th>
                                        <th class="border-0 px-4 py-3">Days Expired</th>
                                        <th class="border-0 px-4 py-3">Last Payment</th>
                                        <th class="border-0 px-4 py-3">Reactivation</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($expiredSubscriptions as $subscription)
                                     <tr class="{{ $subscription->days_expired > 30 ? 'table-secondary' : ($subscription->days_expired > 7 ? 'table-warning' : '') }}">
                                         <td class="px-4 py-3">
                                             <div class="d-flex align-items-center">
                                                 <div class="avatar avatar-sm me-3">
                                                     <div class="avatar-initial rounded-circle bg-secondary text-white">
                                                         {{ $subscription->company ? substr($subscription->company->name, 0, 1) : 'U' }}
                                                     </div>
                                                 </div>
                                                 <div>
                                                     <div class="fw-bold">{{ $subscription->company ? $subscription->company->company_name : 'Unknown Company' }}</div>
                                                     <small class="text-muted">{{ $subscription->company ? $subscription->company->email : 'No email' }}</small>
                                                 </div>
                                             </div>
                                         </td>
                                         <td class="px-4 py-3">
                                             <span class="badge bg-info">{{ $subscription->plan ? $subscription->plan->name : 'Unknown Plan' }}</span>
                                         </td>
                                         <td class="px-4 py-3">{{ $subscription->end_date ? $subscription->end_date->format('Y-m-d') : 'N/A' }}</td>
                                         <td class="px-4 py-3">
                                             <span class="{{ $subscription->days_expired > 30 ? 'text-danger fw-bold' : ($subscription->days_expired > 7 ? 'text-warning fw-bold' : 'text-info') }}">
                                                 {{ $subscription->days_expired }} days
                                             </span>
                                         </td>
                                         <td class="px-4 py-3 fw-bold text-success">
                                             ${{ $subscription->payments->last() ? number_format($subscription->payments->last()->amount, 2) : '0.00' }}
                                         </td>
                                         <td class="px-4 py-3">
                                             <span class="badge bg-{{ $subscription->reactivation_status == 'Reactivated' ? 'success' : ($subscription->reactivation_status == 'Contacted' ? 'info' : ($subscription->reactivation_status == 'Eligible' ? 'warning' : 'secondary')) }}">
                                                 {{ $subscription->reactivation_status }}
                                             </span>
                                         </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Reactivate">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                                <button class="btn btn-outline-info" title="Send Offer">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Archive">
                                                    <i class="fas fa-archive"></i>
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
                                     Showing {{ $expiredSubscriptions->firstItem() }} to {{ $expiredSubscriptions->lastItem() }} of {{ $expiredSubscriptions->total() }} expired subscriptions
                                 </div>
                                 {{ $expiredSubscriptions->links() }}
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reactivation Tools -->
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-magic text-success" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Win-back Campaigns</h6>
                        <small class="text-muted">Create targeted campaigns to reactivate expired subscribers</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-percentage text-warning" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Discount Offers</h6>
                        <small class="text-muted">Generate special offers for expired subscribers</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-light border-0 text-center h-100" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-chart-bar text-info" style="font-size: 32px;"></i>
                        </div>
                        <h6 class="mb-2">Churn Analysis</h6>
                        <small class="text-muted">Analyze patterns in subscription cancellations</small>
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
    .bg-secondary { background-color: #6c757d !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-danger { color: #dc3545 !important; }
    .text-secondary { color: #6c757d !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
    .table-secondary {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
</style>
@endsection