@php
    $product = $product ?? null;
    $selectedProductKind = old('product_kind', $product->product_kind ?? 'digital_download');
    $selectedPurchaseType = old('purchase_type', $product->purchase_type ?? 'one_time');
    $selectedValidityDays = old('validity_days', $product->validity_days ?? '');
    $selectedValidityLabel = old('validity_label', $product->validity_label ?? '');

    $productKinds = [
        'digital_download' => 'Digital download',
        'website_template' => 'Website template',
        'ecommerce_template' => 'Ecommerce template',
        'saas' => 'SaaS product',
        'course' => 'Course',
        'service' => 'Service',
        'physical' => 'Physical product',
        'other' => 'Other',
    ];

    $purchaseTypes = [
        'one_time' => 'One-time purchase',
        'monthly_subscription' => 'Monthly subscription',
        'yearly_subscription' => 'Yearly subscription',
        'lifetime' => 'Lifetime access',
    ];
@endphp

<div class="row g-3 mb-4">
    <div class="col-12">
        <h6 class="text-primary mb-3"><i class="fa fa-layer-group me-2"></i>Product Business Model</h6>
    </div>

    <div class="col-md-6">
        <label for="product_kind" class="form-label fw-bold">Product Kind <span class="text-danger">*</span></label>
        <select name="product_kind" id="product_kind" class="form-control">
            @foreach($productKinds as $value => $label)
                <option value="{{ $value }}" {{ $selectedProductKind === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <div class="form-text">Use this to separate SaaS, templates, courses, services, and downloads inside a category.</div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="col-md-6">
        <label for="purchase_type" class="form-label fw-bold">Purchase Option <span class="text-danger">*</span></label>
        <select name="purchase_type" id="purchase_type" class="form-control">
            @foreach($purchaseTypes as $value => $label)
                <option value="{{ $value }}" {{ $selectedPurchaseType === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <div class="form-text">Controls how price and access validity are displayed on frontend.</div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="col-md-4">
        <label for="validity_days" class="form-label fw-bold">Validity Days</label>
        <input type="number" min="1" max="36500" class="form-control" id="validity_days" name="validity_days" value="{{ $selectedValidityDays }}" placeholder="Auto">
        <div class="form-text">Leave blank for lifetime or one-time products.</div>
        <div class="invalid-feedback"></div>
    </div>

    <div class="col-md-8">
        <label for="validity_label" class="form-label fw-bold">Frontend Validity Label</label>
        <input type="text" class="form-control" id="validity_label" name="validity_label" value="{{ $selectedValidityLabel }}" placeholder="Example: Valid for 1 year, Lifetime validity">
        <div class="form-text">Optional. If blank, the system generates a label from the purchase option.</div>
        <div class="invalid-feedback"></div>
    </div>
</div>
