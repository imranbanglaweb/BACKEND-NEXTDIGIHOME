@extends('admin.dashboard.master')

@section('title','Subscription Plans')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #f8f9fa;">
<div class="container-fluid">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            <i class="fa fa-credit-card text-primary me-2"></i>
            Subscription Plans
        </h3>
        <p class="text-muted mb-0">Manage your pricing plans and quotas</p>
    </div>
    <a href="{{ route('admin.dashboard.plans.create') }}" class="btn btn-primary btn-lg">
        <i class="fa fa-plus"></i> Add New Plan
    </a>
</div>
<br>
<!-- Plans Grid -->
<style>
.premium-plan-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}
.premium-plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}
.premium-plan-card .plan-header {
    padding: 20px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    min-height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.premium-plan-card .plan-header span {
    display: inline-block;
}
.premium-plan-card.popular .plan-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.premium-plan-card.trial .plan-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
.premium-plan-card .plan-body {
    padding: 24px;
}
.premium-plan-card .limit-box {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px 8px;
    text-align: center;
}
.premium-plan-card .limit-box h5 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}
.premium-plan-card .limit-box small {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.premium-plan-card .feature-item {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    font-size: 1.1rem;
}
.premium-plan-card .feature-item:last-child {
    border-bottom: none;
}
.premium-plan-card .price-tag {
    font-size: 2.5rem;
    font-weight: 800;
    color: #333;
}
.premium-plan-card .price-period {
    font-size: 1rem;
    color: #666;
}
.plan-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.plan-title {
    font-size: 2.2rem !important;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.2;
}
.plan-recommended {
    font-size: 1.1rem;
    color: #6c757d;
    font-weight: 500;
}
.plan-last-updated {
    font-size: 0.9rem;
    color: #adb5bd;
}
.premium-plan-card .btn-lg {
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.premium-plan-card .btn-outline-info:hover {
    background: #0dcaf0;
    color: #fff;
}
.premium-plan-card .btn-warning:hover {
    background: #f59e0b !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
}
</style>
<div class="row">
@foreach($plans as $plan)
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 mb-4">
        <div class="premium-plan-card {{ $plan->is_popular ? 'popular' : '' }} {{ $plan->is_trial ? 'trial' : '' }}">
            @if($plan->is_popular)
            <div class="plan-header text-center py-3">
                <span class="plan-badge" style="background: #fff; color: #e91e63; font-size: 0.85rem; font-weight: 700;">
                    <i class="fa fa-star me-1"></i> Most Popular
                </span>
            </div>
            @elseif($plan->is_trial)
            <div class="plan-header text-center py-3">
                <span class="plan-badge" style="background: #fff; color: #00bcd4; font-size: 0.85rem; font-weight: 700;">
                    <i class="fa fa-gift me-1"></i> {{ $plan->trial_days ?? 7 }} Days Free Trial
                </span>
            </div>
            @else
            <div class="plan-header text-center py-3" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;">
                <span style="color: #fff; font-size: 1rem; font-weight: 600;">
                    <i class="fa fa-check-circle me-2"></i>Regular Plan
                </span>
            </div>
            @endif
            <div class="plan-body">
                <!-- Plan Name - Always Visible -->
                <div class="text-center mb-4">
                    <h4 class="fw-bold plan-title">{{ $plan->name }}</h4>
                    <div class="plan-recommended mb-2">
                        <i class="fa fa-bullseye me-1"></i>{{ $plan->recommended_for ?? 'All business sizes' }}
                    </div>
                    <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }} px-3 py-2" style="font-size: 0.9rem; border-radius: 20px;">
                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($plan->last_updated_at)
                    <div class="plan-last-updated mt-2">
                        <i class="fa fa-clock-o me-1"></i>Updated: {{ $plan->last_updated_at->diffForHumans() }}
                    </div>
                    @endif
                </div>

                <div class="text-center mb-4">
                    <div class="price-tag">
                        @if($plan->price == 0)
                            Custom
                        @else
                            ৳{{ number_format($plan->price) }}
                        @endif
                    </div>
                    <div class="price-period">per {{ $plan->billing_cycle }}</div>
                </div>

                <!-- Limits -->
                <div class="mb-4">
                    <h6 class="fw-bold text-muted mb-3" style="font-size: 0.9rem;">
                        <i class="fa fa-chart-bar me-1"></i> Resource Limits
                    </h6>
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="limit-box">
                                <h5>{{ $plan->vehicle_limit == 0 ? '∞' : ($plan->vehicle_limit ?? '∞') }}</h5>
                                <small class="text-muted">Vehicles</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="limit-box">
                                <h5>{{ $plan->user_limit == 0 ? '∞' : ($plan->user_limit ?? '∞') }}</h5>
                                <small class="text-muted">Users</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="limit-box">
                                <h5>{{ $plan->driver_limit == 0 ? '∞' : ($plan->driver_limit ?? '∞') }}</h5>
                                <small class="text-muted">Drivers</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="mb-3">
                    <h6 class="fw-bold text-muted mb-2" style="font-size: 0.9rem;">
                        <i class="fa fa-star me-1"></i> Features
                    </h6>
                    @php $features = is_array($plan->features) ? $plan->features : []; @endphp
                    @if(count($features) > 0)
                        @foreach(array_slice($features, 0, 4) as $feature)
                        <div class="feature-item">
                            <i class="fa fa-check-circle text-success me-2"></i>{{ $feature }}
                        </div>
                        @endforeach
                        @if(count($features) > 4)
                        <div class="text-muted small py-2">
                            +{{ count($features) - 4 }} more features
                        </div>
                        @endif
                    @else
                        <div class="text-muted small">No features defined</div>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-white border-0 p-3 text-center">
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('admin.dashboard.plans.show', $plan->id) }}" class="btn btn-outline-info btn-lg flex-fill" style="min-width: 120px;">
                        <i class="fa fa-eye me-2"></i>View
                    </a>
                    <a href="{{ route('admin.dashboard.plans.edit', $plan->id) }}" class="btn btn-warning btn-lg flex-fill text-white" style="min-width: 120px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
                        <i class="fa fa-edit me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>

<!-- Empty State -->
@if($plans->isEmpty())
<div class="text-center py-5">
    <i class="fa fa-credit-card text-muted" style="font-size: 4rem;"></i>
    <h4 class="mt-3 text-muted">No Plans Created</h4>
    <p class="text-muted">Create your first subscription plan to get started.</p>
    <a href="{{ route('admin.dashboard.plans.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create Plan
    </a>
</div>
@endif

</div>
</section>
@endsection
