@extends('admin.dashboard.master')

@section('title', 'My Subscription')

@section('main_content')
<style>
    body { background: #f8fafc; }
    .subscription-card {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
        border-radius: 20px;
        color: #fff;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(30, 58, 95, 0.3);
    }
    .plan-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 14px;
        display: inline-block;
    }
    .detail-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        height: 100%;
    }
    .detail-item {
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .detail-label {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .detail-value {
        color: #1e293b;
        font-weight: 600;
        font-size: 16px;
    }
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    .status-active {
        background: #dcfce7;
        color: #166534;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-expired {
        background: #fee2e2;
        color: #991b1b;
    }
    .payment-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        border: none;
        padding: 15px;
    }
    .payment-table td {
        padding: 15px;
        border-color: #f1f5f9;
    }
    .upgrade-btn {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        display: inline-block;
    }
    .upgrade-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
    }
</style>

<section class="content-body">
<div class="container-fluid py-4">
    <br>
    <h2 class="fw-bold mb-4">My Subscription</h2>

    @if($subscription)
    <div class="subscription-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="plan-badge mb-3 d-inline-block">Current Plan</span>
                <h1 class="fw-bold mb-2" style="font-size: 36px;">{{ $subscription->plan->name }}</h1>
                @if($subscription->status === 'active')
                <span class="status-badge status-active">
                    <i class="fa fa-check-circle me-1"></i> Active
                </span>
                @elseif($subscription->status === 'pending')
                <span class="status-badge status-pending">
                    <i class="fa fa-clock me-1"></i> Pending
                </span>
                @else
                <span class="status-badge status-expired">
                    <i class="fa fa-times-circle me-1"></i> Expired
                </span>
                @endif
            </div>
            <div class="col-md-4 text-md-end">
                <div class="text-white-50 mb-2">Current Plan Price</div>
                <div style="font-size: 42px; font-weight: 700;">
                    @if($subscription->plan->price == 0)
                    Free
                    @else
                    ৳{{ number_format($subscription->plan->price) }}
                    <small style="font-size: 16px; opacity: 0.8;">/ {{ $subscription->plan->billing_cycle }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="detail-card">
                <div class="detail-item">
                    <div class="detail-label">Start Date</div>
                    <div class="detail-value">
                        <i class="fa fa-calendar text-primary me-2"></i>
                        @if($subscription->status === 'pending')
                        <span class="text-warning">Awaiting Approval</span>
                        @elseif($subscription->starts_at)
                        {{ \Carbon\Carbon::parse($subscription->starts_at)->format('d M Y') }}
                        @else
                        Not Started
                        @endif
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">End Date</div>
                    <div class="detail-value">
                        <i class="fa fa-calendar-check text-success me-2"></i>
                        @if($subscription->status === 'pending')
                        <span class="text-warning">Pending Approval</span>
                        @elseif($subscription->ends_at)
                        {{ \Carbon\Carbon::parse($subscription->ends_at)->format('d M Y') }}
                        @else
                        Lifetime
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="detail-card">
                <div class="detail-item">
                    <div class="detail-label">Vehicle Limit</div>
                    <div class="detail-value">
                        <i class="fa fa-car text-info me-2"></i>
                        {{ $subscription->plan->vehicle_limit == 0 ? 'Unlimited' : $subscription->plan->vehicle_limit }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">User Limit</div>
                    <div class="detail-value">
                        <i class="fa fa-users text-warning me-2"></i>
                        {{ $subscription->plan->user_limit == 0 ? 'Unlimited' : $subscription->plan->user_limit }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="detail-card">
                <div class="detail-item">
                    <div class="detail-label">Driver Limit</div>
                    <div class="detail-value">
                        <i class="fa fa-id-card text-secondary me-2"></i>
                        {{ $subscription->plan->driver_limit == 0 ? 'Unlimited' : $subscription->plan->driver_limit }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Payment Method</div>
                    <div class="detail-value text-capitalize">
                        <i class="fa fa-credit-card text-dark me-2"></i>
                        {{ $subscription->payment_method ?? 'Manual' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($subscription->status === 'pending')
    <div class="alert alert-info d-flex align-items-center mb-4" style="border-radius: 12px;">
        <i class="fa fa-hourglass-half fs-4 me-3 text-info"></i>
        <div>
            <strong>Payment Under Review</strong>
            <br><small>Your payment is awaiting admin approval. Once approved, your subscription will be activated and dates will be updated.</small>
        </div>
    </div>
    @elseif($subscription->ends_at && \Carbon\Carbon::parse($subscription->ends_at)->diffInDays(now(), false) <= 30)
    <div class="alert alert-warning d-flex align-items-center mb-4" style="border-radius: 12px;">
        <i class="fa fa-exclamation-triangle fs-4 me-3"></i>
        <div>
            <strong>Your subscription expires on {{ \Carbon\Carbon::parse($subscription->ends_at)->format('d M Y') }}</strong>
            <br><small>Only {{ \Carbon\Carbon::parse($subscription->ends_at)->diffInDays(now(), false) }} days remaining. Renew now to continue service.</small>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Subscription Features</h4>
        <a href="{{ route('pricing') }}" class="upgrade-btn">
            <i class="fa fa-arrow-up me-2"></i>Upgrade Plan
        </a>
    </div>

    <div class="detail-card mb-4">
        <div class="row">
            @if($subscription->plan->features)
            @foreach($subscription->plan->features as $feature)
            <div class="col-md-4 mb-3">
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle text-success me-2"></i>
                    <span>{{ $feature }}</span>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    @if($recentPayments->count() > 0)
    <h4 class="fw-bold mb-4">Recent Payments</h4>
    <div class="detail-card">
        <table class="table payment-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentPayments as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                    <td>{{ $payment->plan->name ?? 'N/A' }}</td>
                    <td>৳{{ number_format($payment->amount) }}</td>
                    <td>
                        @if($payment->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                        @elseif($payment->status === 'pending')
                        <span class="badge bg-warning">Pending</span>
                        @else
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('invoice.download', $payment->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-download"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @else
    <div class="text-center py-5">
        <i class="fa fa-credit-card text-muted fs-1 mb-3"></i>
        <h3 class="fw-bold text-muted">No Active Subscription</h3>
        <p class="text-muted mb-4">You don't have an active subscription yet.</p>
        <a href="{{ route('pricing') }}" class="upgrade-btn">
            <i class="fa fa-rocket me-2"></i>Choose a Plan
        </a>
    </div>
    @endif

</div>
</section>
@endsection