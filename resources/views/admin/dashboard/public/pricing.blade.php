@extends('admin.dashboard.master')

@section('title','Pricing')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<section class="pricing-dark">

<!-- HERO -->
<div class="container text-center">
    <h1 class="display-5">
        Flexible Pricing for Every Business
    </h1>
    <p class="fs-4 text-muted mb-4">
        Scale your fleet with confidence
    </p>

    <!-- VIEW TOGGLE -->
    <div class="view-toggle mb-4">
        <button class="view-btn active" data-view="cards" onclick="switchView('cards')">
            <i class="fa fa-th-large"></i> Cards
        </button>
        <button class="view-btn" data-view="compare" onclick="switchView('compare')">
            <i class="fa fa-columns"></i> Compare
        </button>
    </div>

    <!-- TOGGLE -->
    <div class="billing-toggle">
        <span class="toggle-label active" data-type="monthly">Monthly</span>
        <div class="toggle-switch" id="billingToggle"></div>
        <span class="toggle-label" data-type="yearly">
            Yearly <small>(Save 20%)</small>
        </span>
    </div>
</div>

<!-- PRICING -->
<div class="container" id="pricingCards">
<div class="row g-4 justify-content-center">
    @foreach($plans as $plan)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="pricing-card dark {{ $plan->is_popular ? 'popular' : '' }}">
            @if($plan->is_popular)
            <span class="badge-popular">MOST POPULAR</span>
            @elseif($plan->slug == 'free-trial')
            <span class="badge-trial">7 DAYS FREE TRIAL</span>
            @elseif($plan->slug == 'enterprise')
            <span class="badge-enterprise">CUSTOM PRICING</span>
            @endif

            <h5 class="plan-name">{{ $plan->name }}</h5>

            <div class="price" 
                 data-monthly="{{ $plan->billing_cycle == 'monthly' ? $plan->price : 0 }}"
                 data-yearly="{{ $plan->billing_cycle == 'yearly' ? $plan->price : $plan->price * 12 }}">
                @if($plan->slug == 'enterprise')
                    <span>Custom</span>
                @elseif($plan->price == 0)
                    <span>Free</span>
                @else
                    {{ $plan->price ? '৳' : '' }}<span>{{ $plan->price }}</span>
                @endif
            </div>
            <div class="billing-text">
                @if($plan->slug == 'enterprise')
                    Contact for Pricing
                @elseif($plan->slug == 'free-trial')
                    7 Days Free Trial
                @elseif($plan->price)
                    per {{ $plan->billing_cycle }}
                @else
                    Let's Talk
                @endif
            </div>

            <ul class="features">
                @if($plan->features)
                    @foreach((array) $plan->features as $feature)
                        <li>✔ {{ $feature }}</li>
                    @endforeach
                @endif

                @if($plan->vehicle_limit)
                    <li>✔ Up to {{ $plan->vehicle_limit }} Vehicles</li>
                @endif
                @if($plan->user_limit)
                    <li>✔ {{ $plan->user_limit }} Users</li>
                @endif
            </ul>

            <div class="d-flex gap-2 mt-auto">
                <a href="{{ route('subscription.select', $plan->slug) }}" 
                   class="btn btn-{{ $plan->is_popular ? 'primary' : 'outline-light' }} flex-fill">
                    <i class="fa fa-user-plus"></i>&nbsp;
                    @if($plan->slug == 'enterprise')
                    Contact Sales
                    @elseif($plan->slug == 'free-trial')
                    Start Trial
                    @elseif($plan->is_popular)
                    Get Started
                    @else
                    Start Trial
                    @endif
                </a>
                @if($plan->slug != 'enterprise')
                <a href="{{ route('subscription.select', $plan->slug) }}" class="btn btn-warning flex-fill">
                <i class="fa fa-check-circle"></i>&nbsp; Subscribe
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>


</section>
</section>

<!-- COMPARISON TABLE -->
<div class="comparison-section" id="comparisonTable" style="display: none;">
    <div class="container">
        <div class="table-responsive">
            <table class="table table-dark table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 25%;">Features</th>
                        @foreach($plans as $plan)
                        <th style="min-width: 150px;">
                            {{ $plan->name }}
                            @if($plan->is_popular)
                            <span class="badge bg-primary d-block mt-1">Most Popular</span>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">Best For</td>
                        @foreach($plans as $plan)
                        <td>{{ $plan->recommended_for ?? '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Price</td>
                        @foreach($plans as $plan)
                        <td>
                            @if($plan->slug == 'enterprise')
                                <strong>Custom</strong>
                            @elseif($plan->price == 0)
                                <strong>Free</strong>
                            @else
                                <strong>৳{{ number_format($plan->price) }}</strong>
                            @endif
                            @if($plan->slug != 'enterprise' && $plan->price > 0)
                                <small class="text-muted">/ {{ $plan->billing_cycle }}</small>
                            @elseif($plan->is_trial && $plan->trial_days)
                                <small class="text-success d-block">{{ $plan->trial_days }} Days Trial</small>
                            @elseif($plan->slug == 'enterprise')
                                <small class="text-muted d-block">Contact for pricing</small>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Vehicles</td>
                        @foreach($plans as $plan)
                        <td>{{ $plan->vehicle_limit ? $plan->vehicle_limit : 'Unlimited' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Users</td>
                        @foreach($plans as $plan)
                        <td>{{ $plan->user_limit ? $plan->user_limit : 'Unlimited' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Drivers</td>
                        @foreach($plans as $plan)
                        <td>{{ $plan->driver_limit ? $plan->driver_limit : 'Unlimited' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Monthly Reports</td>
                        @foreach($plans as $plan)
                        <td>{{ $plan->monthly_reports ? $plan->monthly_reports : 'Unlimited' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Monthly Alerts</td>
                        @foreach($plans as $plan)
                        <td>{{ $plan->monthly_alerts ? $plan->monthly_alerts : 'Unlimited' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start">Features</td>
                        @foreach($plans as $plan)
                        <td>
                            @if($plan->features)
                            <ul class="list-unstyled small mb-0">
                                @foreach((array)$plan->features as $feature)
                                <li>✔ {{ $feature }}</li>
                                @endforeach
                            </ul>
                            @else
                            -
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-start"></td>
                        @foreach($plans as $plan)
                        <td>
                            @if($plan->slug == 'enterprise')
                            <a href="mailto:support@vms.com?subject=Enterprise%20Plan%20Inquiry" class="btn btn-outline-warning w-100">
                                <i class="fa fa-envelope"></i> Contact Sales
                            </a>
                            @else
                            <a href="{{ route('subscription.select', $plan->slug) }}" 
                               class="btn btn-{{ $plan->is_popular ? 'primary' : 'outline-light' }} w-100">
                                {{ $plan->is_popular ? 'Get Started' : 'Start Trial' }}
                            </a>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
.pricing-dark {
    background: radial-gradient(circle at top, #111827, #020617);
    color: #fff;
    min-height: 100vh;
        margin-left: -30px;
}

.view-toggle {
    display: inline-flex;
    gap: 10px;
}

.view-btn {
    background: transparent;
    border: 1px solid #1e293b;
    color: #94a3b8;
    padding: 8px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: .3s;
}

.view-btn.active {
    background: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}

.comparison-section {
    padding: 40px 0;
}

.comparison-section .table {
    background: #020617;
    border-color: #1e293b;
}

.comparison-section .table th {
    background: #0f172a;
    vertical-align: middle;
}

.billing-toggle {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: #020617;
    padding: 10px 20px;
    border-radius: 50px;
    border: 1px solid #1e293b;
}

.toggle-label {
    font-size: 1.1rem;
    cursor: pointer;
    color: #94a3b8;
}

.toggle-label.active {
    color: #fff;
    font-weight: 600;
}

.toggle-switch {
    width: 50px;
    height: 26px;
    background: #1e293b;
    border-radius: 20px;
    position: relative;
    cursor: pointer;
}

.toggle-switch::after {
    content: '';
    width: 20px;
    height: 20px;
    background: #0d6efd;
    border-radius: 50%;
    position: absolute;
    top: 3px;
    left: 4px;
    transition: .3s;
}

.toggle-switch.yearly::after {
    transform: translateX(22px);
}

.pricing-card.dark {
    background: linear-gradient(180deg, #020617, #020617);
    border: 1px solid #1e293b;
    border-radius: 18px;
    padding: 40px;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 0 40px rgba(13,110,253,.15);
}

.pricing-card.popular {
    border: 2px solid #0d6efd;
    transform: scale(1.05);
}

.badge-popular {
    background: linear-gradient(90deg,#0d6efd,#6610f2);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .85rem;
    display: inline-block;
    margin-bottom: 15px;
}

.badge-trial {
    background: linear-gradient(90deg,#10b981,#059669);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .85rem;
    display: inline-block;
    margin-bottom: 15px;
}

.badge-enterprise {
    background: linear-gradient(90deg,#f59e0b,#d97706);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .85rem;
    display: inline-block;
    margin-bottom: 15px;
}

.plan-name {
    font-size: 1.3rem;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.price {
    font-size: 3.2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.billing-text {
    color: #94a3b8;
    margin-bottom: 25px;
}

.features {
    list-style: none;
    padding: 0;
    text-align: left;
    font-size: 1.1rem;
}

.features li {
    margin-bottom: 12px;
}

.features .muted {
    color: #64748b;
}

.d-flex.gap-2 {
    gap: 10px !important;
}

.d-flex.gap-2 .btn {
    padding: 10px 12px;
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- SCRIPT -->
<script>
const toggle = document.getElementById('billingToggle');
const prices = document.querySelectorAll('.price');
const labels = document.querySelectorAll('.toggle-label');
let yearly = false;

toggle.addEventListener('click', () => {
    yearly = !yearly;
    toggle.classList.toggle('yearly');

    labels.forEach(l => l.classList.remove('active'));
    document.querySelector(`[data-type="${yearly ? 'yearly' : 'monthly'}"]`).classList.add('active');

    prices.forEach(p => {
        if (!p.dataset.monthly) return;
        p.querySelector('span').innerText = yearly ? p.dataset.yearly : p.dataset.monthly;
        p.nextElementSibling.innerText = yearly ? 'per year' : 'per month';
    });
});

function switchView(view) {
    document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
    document.querySelector(`[data-view="${view}"]`).classList.add('active');
    
    if (view === 'compare') {
        document.getElementById('pricingCards').style.display = 'none';
        document.getElementById('comparisonTable').style.display = 'block';
    } else {
        document.getElementById('pricingCards').style.display = 'flex';
        document.getElementById('comparisonTable').style.display = 'none';
    }
}
</script>

@endsection
