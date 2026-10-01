@extends('admin.dashboard.master')

@section('title','Confirm Subscription')

@section('main_content')

<style>
/* ================= PREMIUM UI ================= */
body { background:#fff !important; }

.toggle-box {
    background:#f8fafc;
    border-radius:16px;
    padding:14px;
}

.switch-btn {
    cursor:pointer;
    padding:14px 15px;
    border-radius:30px;
    font-weight:700;
    font-size:14px;
    border:2px solid #e5e7eb;
    transition:.2s;
    animation: switchInactive .3s forwards;
}

.switch-active {
    background:#2563eb;
    color:#fff;
}

.price-big {
    font-size:35px;
    font-weight:900;
    color:orange;
}

.payment-box {
    border:2px solid #e5e7eb;
    border-radius:16px;
    padding:10px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
}

.payment-box.active {
    border-color:#16a34a;
    background:#f0fdf4;
}

.feature-list li {
    font-size:15px;
    margin-bottom:10px;
}
</style>

<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid py-5">

<div class="row justify-content-center">
<div class="col-xl-10">

<div class="card shadow-lg border-0 rounded-4">

<!-- HEADER -->
<div class="p-4 text-white rounded-top"
     style="background:linear-gradient(135deg,#2563eb,#0ea5e9);color:#fff;padding:10px;">
    <h2>
        <i class="fa fa-arrow-right"></i> Upgrade Checkout Flow
    </h2>
    <small>Secure billing • Flexible plans • Instant activation</small>
</div>

<div class="card-body p-5">

<div class="row g-5">

<!-- LEFT COLUMN -->
<div class="col-lg-5 border-end">

    <h3 class="fw-bold" style="color:#2563eb;"><strong>Plan Name: {{ $plan->name }}</strong></h3>

    <!-- BILLING TOGGLE -->
    <div class="toggle-box d-flex justify-content-between mt-4 mb-4">
        <div class="switch-btn switch-active" id="monthlyBtn">
            Monthly
        </div>
        <div class="switch-btn" id="yearlyBtn">
            Yearly <span class="badge bg-success ms-1">30% OFF</span>
        </div>
    </div>

    <div class="price-big mb-2" id="priceDisplay">
        ৳{{ number_format($plan->price,2) }}
    </div>
<br>
    <p id="durationText">
       <strong> Billed monthly • Cancel anytime</strong>
    </p>

    <!-- PAYMENT METHOD -->
    <h5 class="fw-bold mb-3">
        <i class="fa fa-credit-card me-2"></i> 
        <strong>
            Payment Method
        </strong>
    </h5>
<br>
    {{-- Stripe payment temporarily disabled --}}
    {{-- 
    <div class="payment-box  mb-3" data-method="stripe">
        <i class="fa fa-card fa-lg text-primary me-2"></i>
        Pay with Card (Stripe)
    </div>
    --}}

    <div class="payment-box active" data-method="manual">
        <i class="fa fa-university fa-lg text-secondary me-2"></i>
        Manual Bank / Mobile Payment
    </div>

</div>

<!-- RIGHT COLUMN -->
<div class="col-lg-7">

    <h4 class="fw-bold mb-3">
        <i class="fa fa-star text-warning me-2"></i> Features Included
    </h4>

    <ul class="feature-list list-unstyled mb-4">
        @php
            $features = is_array($plan->features) ? $plan->features : (is_string($plan->features) ? json_decode($plan->features, true) : []);
        @endphp
        @foreach($features as $feature)
            <li>
                <i class="fa fa-check-circle text-success me-2"></i>
                {{ $feature }}
            </li>
        @endforeach
    </ul>

    <!-- ACTION FORM -->
    <form method="POST" action="{{ route('subscription.store') }}">
        @csrf

        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <input type="hidden" name="billing_type" id="billingType" value="monthly">
        <input type="hidden" name="payment_method" id="paymentMethod" value="manual">
        <input type="hidden" name="final_price" id="finalPrice" value="{{ $plan->price }}">

        <!-- <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
            <i class="fa fa-lock me-2"></i> Confirm & Continue
        </button> -->
        <button type="button"
                onclick="goToNextStep()"
                class="btn btn-success btn-lg w-100 mb-3">
            <i class="fa fa-arrow-right me-2"></i>
            Continue to Payment
        </button>

    </form>

    <button class="btn btn-outline-primary w-100"
            data-bs-toggle="modal"
            data-bs-target="#invoiceModal">
        <i class="fa fa-file-invoice me-2"></i> Preview Invoice
    </button>

</div>

</div>
</div>
</div>
</div>
</div>
</section>

<!-- INVOICE PREVIEW MODAL -->
<div class="modal" id="invoiceModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content rounded-4">

<div class="modal-header">
    <h5 class="fw-bold">Invoice Preview</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body fs-5">
    <p><strong>Plan:</strong> {{ $plan->name }}</p>
    <p><strong>Billing:</strong> <span id="invoiceBilling">MONTHLY</span></p>
    <p><strong>Amount:</strong> ৳<span id="invoiceAmount">{{ number_format($plan->price,2) }}</span></p>
    <hr>
    <p class="text-muted">
        Invoice will be generated after successful payment confirmation.
    </p>
</div>

</div>
</div>
</div>

<!-- JS -->
<script>
     window.paymentRoutes = {
        manual: "{{ route('payment.manual', ['plan' => $plan->id]) }}"
    };
let basePrice = {{ (float)$plan->price }};
const monthlyBtn = document.getElementById('monthlyBtn');
const yearlyBtn = document.getElementById('yearlyBtn');

monthlyBtn.onclick = () => updateBilling('monthly');
yearlyBtn.onclick = () => updateBilling('yearly');

function updateBilling(type) {
    document.querySelectorAll('.switch-btn').forEach(b => b.classList.remove('switch-active'));
    (type === 'monthly' ? monthlyBtn : yearlyBtn).classList.add('switch-active');

    let price = type === 'monthly'
        ? basePrice
        : (basePrice * 12 * 0.7);

    document.getElementById('priceDisplay').innerText = '৳' + price.toFixed(2);
    document.getElementById('finalPrice').value = price.toFixed(2);
    document.getElementById('billingType').value = type;

    document.getElementById('invoiceBilling').innerText = type.toUpperCase();
    document.getElementById('invoiceAmount').innerText = price.toFixed(2);
}

document.querySelectorAll('.payment-box').forEach(box => {
    box.addEventListener('click', () => {
        document.querySelectorAll('.payment-box').forEach(b => b.classList.remove('active'));
        box.classList.add('active');
        document.getElementById('paymentMethod').value = box.dataset.method;
    });
});


function goToNextStep() {
    let billing = document.getElementById('billingType').value;
    let price   = document.getElementById('finalPrice').value;
    let planId  = {{ $plan->id }};

    let baseUrl = window.paymentRoutes.manual;

    let params = new URLSearchParams({
        plan: planId,
        billing: billing,
        price: price
    });

    window.location.href = baseUrl + '?' + params.toString();
}
</script>

@endsection
