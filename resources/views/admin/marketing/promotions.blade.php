@extends('admin.dashboard.master')

@section('main_content')
@php
    $pageIcon = 'fas fa-percent';
    $pageTitle = 'Promotions';
    $pageSubtitle = 'Plan promotional offers, control discount windows, and track redemption performance.';
    $primaryAction = 'New Promotion';
    $modalId = 'createPromotionModal';
    $modalTitle = 'Create Promotion';
    $modalSubmit = 'Create Promotion';
    $tableTitle = 'Promotion Calendar';
    $tableSubtitle = 'Manage campaign timing, discount value, and usage trends.';
    $searchPlaceholder = 'Search promotions...';
    $filters = ['All Status', 'Active', 'Scheduled', 'Expired', 'Draft'];
    $stats = [
        ['label' => 'Active Promotions', 'value' => '8', 'icon' => 'fas fa-percent', 'tone' => 'stat-green'],
        ['label' => 'Scheduled', 'value' => '3', 'icon' => 'fas fa-clock', 'tone' => 'stat-amber'],
        ['label' => 'Redemptions', 'value' => '12,456', 'icon' => 'fas fa-shopping-cart', 'tone' => 'stat-cyan'],
        ['label' => 'Revenue', 'value' => '$45,231', 'icon' => 'fas fa-dollar-sign', 'tone' => 'stat-blue'],
    ];
    $columns = ['Promotion', 'Type', 'Discount', 'Status', 'Start Date', 'End Date', 'Redemptions'];
    $actions = [
        ['title' => 'Edit', 'icon' => 'fas fa-edit', 'class' => 'btn-outline-primary'],
        ['title' => 'View Report', 'icon' => 'fas fa-chart-bar', 'class' => 'btn-outline-success'],
        ['title' => 'Duplicate', 'icon' => 'fas fa-copy', 'class' => 'btn-outline-info'],
        ['title' => 'Pause', 'icon' => 'fas fa-pause', 'class' => 'btn-outline-warning'],
        ['title' => 'Delete', 'icon' => 'fas fa-trash', 'class' => 'btn-outline-danger'],
    ];
    $rows = [
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-green"><i class="fas fa-percent"></i></span><div><h6>Winter Sale 2026</h6><small>Seasonal discount campaign</small></div></div>',
                '<span class="badge badge-soft-blue">Percentage</span>',
                '50% Off',
                '<span class="badge badge-soft-green">Active</span>',
                '01 Jan 2026',
                '31 Jan 2026',
                '2,341',
            ],
            'actions' => $actions,
        ],
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-cyan"><i class="fas fa-tag"></i></span><div><h6>New Customer Welcome</h6><small>First-time buyer discount</small></div></div>',
                '<span class="badge badge-soft-green">Fixed Amount</span>',
                '$25 Off',
                '<span class="badge badge-soft-green">Active</span>',
                '01 Jan 2026',
                '31 Dec 2026',
                '8,932',
            ],
            'actions' => $actions,
        ],
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-amber"><i class="fas fa-gift"></i></span><div><h6>Birthday Special</h6><small>Birthday month celebration</small></div></div>',
                '<span class="badge badge-soft-blue">Percentage</span>',
                '30% Off',
                '<span class="badge badge-soft-amber">Scheduled</span>',
                '01 Feb 2026',
                '28 Feb 2026',
                '0',
            ],
            'actions' => $actions,
        ],
    ];
    $modalBody = '
        <form>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Promotion Name</label><input type="text" class="form-control" placeholder="Enter promotion name"></div>
                <div class="col-md-6"><label class="form-label">Promotion Type</label><select class="form-select"><option>Percentage Discount</option><option>Fixed Amount</option><option>Buy One Get One</option><option>Free Shipping</option></select></div>
                <div class="col-md-6"><label class="form-label">Discount Value</label><input type="number" class="form-control" placeholder="Enter discount value"></div>
                <div class="col-md-6"><label class="form-label">Minimum Purchase</label><input type="number" class="form-control" placeholder="Enter minimum amount"></div>
                <div class="col-md-6"><label class="form-label">Start Date</label><input type="datetime-local" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">End Date</label><input type="datetime-local" class="form-control"></div>
                <div class="col-12"><label class="form-label">Applicable Products</label><select class="form-select" multiple><option>All Products</option><option>Digital Products</option><option>Subscriptions</option><option>Featured Products</option></select></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" rows="3" placeholder="Promotion description"></textarea></div>
            </div>
        </form>';
@endphp

@include('admin.marketing.partials.resource-page')
@endsection
