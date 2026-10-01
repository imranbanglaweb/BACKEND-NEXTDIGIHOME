@extends('admin.dashboard.master')

@section('title','View Plan')

@section('main_content')
<section class="content-body py-4" style="background:#fff">
<div class="container-fluid">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fa fa-eye text-info"></i>
        View Subscription Plan
    </h2>
    <a href="{{ route('admin.dashboard.plans.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back to Plans
    </a>
</div>

<div class="row">
    <!-- LEFT COLUMN - Basic Info -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-primary bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-info-circle"></i> Basic Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Name</label>
                        <p class="form-control-plaintext fs-5">{{ $plan->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug</label>
                        <p class="form-control-plaintext fs-5"><code>{{ $plan->slug }}</code></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (৳)</label>
                        <p class="form-control-plaintext fs-4 fw-bold text-success">
                            {{ $plan->price == 0 ? 'Custom Pricing' : '৳' . number_format($plan->price) }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Billing Cycle</label>
                        <p class="form-control-plaintext fs-5">{{ ucfirst($plan->billing_cycle) }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Driver Limit</label>
                        <p class="form-control-plaintext fs-5">{{ $plan->driver_limit ?? 'Unlimited' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Monthly Reports</label>
                        <p class="form-control-plaintext fs-5">{{ $plan->monthly_reports ?? 'Unlimited' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Monthly Alerts</label>
                        <p class="form-control-plaintext fs-5">{{ $plan->monthly_alerts ?? 'Unlimited' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-success bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-star"></i> Plan Features</h5>
            </div>
            <div class="card-body p-4">
                @if(count($plan->features) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($plan->features as $feature)
                        <li class="list-group-item px-0">
                            <i class="fa fa-check-circle text-success me-2"></i>{{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No features defined</p>
                @endif
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN - Settings -->
    <div class="col-lg-4">
        <!-- Plan Status -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-dark bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-cog"></i> Plan Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <p>
                        @if($plan->is_active)
                        <span class="badge bg-success fs-6"><i class="fa fa-check"></i> Active</span>
                        @else
                        <span class="badge bg-secondary fs-6"><i class="fa fa-times"></i> Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Popular Plan</label>
                    <p>
                        @if($plan->is_popular)
                        <span class="badge bg-warning text-dark fs-6"><i class="fa fa-star"></i> Most Popular</span>
                        @else
                        <span class="badge bg-secondary fs-6">No</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Trial Available</label>
                    <p>
                        @if($plan->is_trial)
                        <span class="badge bg-info fs-6"><i class="fa fa-gift"></i> {{ $plan->trial_days ?? 7 }} Days Trial</span>
                        @else
                        <span class="badge bg-secondary fs-6">No</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Limits Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-warning bg-gradient text-dark rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-chart-bar"></i> Resource Limits</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Vehicle Limit</label>
                    <p class="fs-5">{{ $plan->vehicle_limit == 0 ? 'Unlimited' : ($plan->vehicle_limit ?? 'Unlimited') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">User Limit</label>
                    <p class="fs-5">{{ $plan->user_limit == 0 ? 'Unlimited' : ($plan->user_limit ?? 'Unlimited') }}</p>
                </div>
            </div>
        </div>

        <!-- Comparison Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-info bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-balance-scale"></i> Comparison Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Recommended For</label>
                    <p class="fs-5">{{ $plan->recommended_for ?? 'Not specified' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Display Order</label>
                    <p class="fs-5">{{ $plan->display_order ?? 0 }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Last Updated</label>
                    <p class="fs-6 text-muted">
                        @if($plan->last_updated_at)
                        {{ $plan->last_updated_at->format('M d, Y h:i A') }}
                        @else
                        Not updated yet
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <a href="{{ route('admin.dashboard.plans.edit', $plan->id) }}" class="btn btn-warning btn-lg w-100 shadow text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
            <i class="fa fa-edit me-2"></i> Edit This Plan
        </a>

        <a href="{{ route('admin.dashboard.plans.index') }}" class="btn btn-outline-secondary w-100 mt-2">
            <i class="fa fa-arrow-left me-2"></i> Back to Plans
        </a>
    </div>
</div>

</div>
</section>
@endsection