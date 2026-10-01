@extends('admin.dashboard.master')

@section('main_content')
@php
    $pageIcon = 'fas fa-ticket-alt';
    $pageTitle = 'Coupons';
    $pageSubtitle = 'Create voucher codes, set usage limits, and monitor coupon performance.';
    $primaryAction = 'New Coupon';
    $modalId = 'createCouponModal';
    $modalTitle = 'Create Coupon';
    $modalSubmit = 'Create Coupon';
    $tableTitle = 'Coupon Library';
    $tableSubtitle = 'Track active codes, redemption limits, and expiration dates.';
    $searchPlaceholder = 'Search coupons...';
    $filters = ['All Status', 'Active', 'Expired', 'Disabled'];
    $stats = [
        ['label' => 'Active Coupons', 'value' => '15', 'icon' => 'fas fa-ticket-alt', 'tone' => 'stat-green'],
        ['label' => 'Redemptions', 'value' => '3,247', 'icon' => 'fas fa-check-circle', 'tone' => 'stat-cyan'],
        ['label' => 'Savings', 'value' => '$12,456', 'icon' => 'fas fa-dollar-sign', 'tone' => 'stat-amber'],
        ['label' => 'Expired', 'value' => '5', 'icon' => 'fas fa-times-circle', 'tone' => 'stat-red'],
    ];
    $columns = ['Coupon', 'Type', 'Discount', 'Usage Limit', 'Used', 'Status', 'Expires'];
    $actions = [
        ['title' => 'Edit', 'icon' => 'fas fa-edit', 'class' => 'btn-outline-primary'],
        ['title' => 'View Usage', 'icon' => 'fas fa-chart-bar', 'class' => 'btn-outline-success'],
        ['title' => 'Duplicate', 'icon' => 'fas fa-copy', 'class' => 'btn-outline-info'],
        ['title' => 'Disable', 'icon' => 'fas fa-ban', 'class' => 'btn-outline-warning'],
        ['title' => 'Delete', 'icon' => 'fas fa-trash', 'class' => 'btn-outline-danger'],
    ];
    $rows = [
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-blue"><i class="fas fa-ticket-alt"></i></span><div><h6>WELCOME2026</h6><small>New customer welcome</small></div></div>',
                '<span class="badge badge-soft-green">Fixed Amount</span>',
                '$25.00',
                'Unlimited',
                '1,247',
                '<span class="badge badge-soft-green">Active</span>',
                '31 Dec 2026',
            ],
            'actions' => $actions,
        ],
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-green"><i class="fas fa-percent"></i></span><div><h6>SAVE50</h6><small>Flash sale discount</small></div></div>',
                '<span class="badge badge-soft-blue">Percentage</span>',
                '50%',
                '500',
                '387',
                '<span class="badge badge-soft-green">Active</span>',
                '20 Jan 2026',
            ],
            'actions' => $actions,
        ],
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-amber"><i class="fas fa-gift"></i></span><div><h6>BDAY30</h6><small>Birthday special offer</small></div></div>',
                '<span class="badge badge-soft-blue">Percentage</span>',
                '30%',
                '1 per customer',
                '89',
                '<span class="badge badge-soft-green">Active</span>',
                '31 Dec 2026',
            ],
            'actions' => $actions,
        ],
    ];
    $modalBody = '
        <form>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Coupon Code</label><input type="text" class="form-control" placeholder="Enter coupon code"></div>
                <div class="col-md-6"><label class="form-label">Discount Type</label><select class="form-select"><option>Fixed Amount</option><option>Percentage</option><option>Free Shipping</option></select></div>
                <div class="col-md-6"><label class="form-label">Discount Value</label><input type="number" class="form-control" placeholder="Enter discount value"></div>
                <div class="col-md-6"><label class="form-label">Minimum Purchase</label><input type="number" class="form-control" placeholder="Enter minimum amount"></div>
                <div class="col-md-6"><label class="form-label">Usage Limit</label><input type="number" class="form-control" placeholder="Enter usage limit"></div>
                <div class="col-md-6"><label class="form-label">Per Customer Limit</label><input type="number" class="form-control" placeholder="Uses per customer"></div>
                <div class="col-md-6"><label class="form-label">Start Date</label><input type="datetime-local" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Expiry Date</label><input type="datetime-local" class="form-control"></div>
                <div class="col-12"><label class="form-label">Applicable Products</label><select class="form-select" multiple><option>All Products</option><option>Digital Products</option><option>Subscriptions</option><option>Featured Products</option></select></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" rows="3" placeholder="Coupon description"></textarea></div>
            </div>
        </form>';
@endphp

@include('admin.marketing.partials.resource-page')
@endsection
