@extends('admin.dashboard.master')

@section('main_content')
@php
    $pageIcon = 'fas fa-mail-bulk';
    $pageTitle = 'Email Campaigns';
    $pageSubtitle = 'Create, schedule, and measure email campaigns for customer lifecycle marketing.';
    $primaryAction = 'New Campaign';
    $modalId = 'createCampaignModal';
    $modalTitle = 'Create Email Campaign';
    $modalSubmit = 'Create Campaign';
    $modalSize = 'modal-xl';
    $tableTitle = 'Campaign Pipeline';
    $tableSubtitle = 'Review delivery status, audience size, and engagement performance.';
    $searchPlaceholder = 'Search campaigns...';
    $filters = ['All Status', 'Draft', 'Scheduled', 'Sending', 'Sent', 'Paused'];
    $stats = [
        ['label' => 'Active Campaigns', 'value' => '12', 'icon' => 'fas fa-paper-plane', 'tone' => 'stat-blue'],
        ['label' => 'Recipients', 'value' => '45,231', 'icon' => 'fas fa-users', 'tone' => 'stat-green'],
        ['label' => 'Open Rate', 'value' => '23.4%', 'icon' => 'fas fa-eye', 'tone' => 'stat-cyan'],
        ['label' => 'Click Rate', 'value' => '8.7%', 'icon' => 'fas fa-mouse-pointer', 'tone' => 'stat-amber'],
    ];
    $columns = ['Campaign', 'Subject', 'Recipients', 'Status', 'Send Date', 'Open Rate', 'Click Rate'];
    $defaultActions = [
        ['title' => 'View Report', 'icon' => 'fas fa-chart-bar', 'class' => 'btn-outline-primary'],
        ['title' => 'Duplicate', 'icon' => 'fas fa-copy', 'class' => 'btn-outline-success'],
        ['title' => 'Edit', 'icon' => 'fas fa-edit', 'class' => 'btn-outline-info'],
        ['title' => 'Delete', 'icon' => 'fas fa-trash', 'class' => 'btn-outline-danger'],
    ];
    $rows = [
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-blue"><i class="fas fa-mail-bulk"></i></span><div><h6>Winter Sale 2026</h6><small>Promotional campaign</small></div></div>',
                'Hot Winter Deals - Up to 50% Off',
                '12,456',
                '<span class="badge badge-soft-green">Sent</span>',
                '15 Jan 2026',
                '28.5%',
                '12.3%',
            ],
            'actions' => $defaultActions,
        ],
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-green"><i class="fas fa-newspaper"></i></span><div><h6>Monthly Newsletter</h6><small>Product updates and tips</small></div></div>',
                'January Product Updates',
                '8,932',
                '<span class="badge badge-soft-amber">Scheduled</span>',
                '20 Jan 2026',
                '-',
                '-',
            ],
            'actions' => $defaultActions,
        ],
        [
            'cells' => [
                '<div class="marketing-title-cell"><span class="row-icon stat-cyan"><i class="fas fa-bolt"></i></span><div><h6>Customer Anniversary</h6><small>Automated lifecycle campaign</small></div></div>',
                'Thanks for Staying With Us',
                '2,341',
                '<span class="badge badge-soft-blue">Sending</span>',
                'In Progress',
                '18.2%',
                '5.7%',
            ],
            'actions' => [
                ['title' => 'Pause', 'icon' => 'fas fa-pause', 'class' => 'btn-outline-warning'],
                ['title' => 'Edit', 'icon' => 'fas fa-edit', 'class' => 'btn-outline-info'],
                ['title' => 'Delete', 'icon' => 'fas fa-trash', 'class' => 'btn-outline-danger'],
            ],
        ],
    ];
    $modalBody = '
        <form>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Campaign Name</label><input type="text" class="form-control" placeholder="Enter campaign name"></div>
                <div class="col-md-6"><label class="form-label">Campaign Type</label><select class="form-select"><option>Promotional</option><option>Newsletter</option><option>Transactional</option><option>Re-engagement</option></select></div>
                <div class="col-12"><label class="form-label">Subject Line</label><input type="text" class="form-control" placeholder="Enter email subject"></div>
                <div class="col-md-6"><label class="form-label">Email Template</label><select class="form-select"><option>Select a template...</option><option>Welcome Email</option><option>Newsletter Template</option><option>Promotional Template</option></select></div>
                <div class="col-md-6"><label class="form-label">Target Audience</label><select class="form-select"><option>All Subscribers</option><option>Active Customers</option><option>Inactive Users</option><option>Custom Segment</option></select></div>
                <div class="col-md-6"><label class="form-label">Schedule</label><input type="datetime-local" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Goal</label><select class="form-select"><option>Sales Conversion</option><option>Product Education</option><option>Customer Retention</option></select></div>
            </div>
        </form>';
@endphp

@include('admin.marketing.partials.resource-page')
@endsection
