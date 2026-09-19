@extends('admin.dashboard.master')

@section('title', 'NextDigiHome — Agency Dashboard')

@php
    $user = $user ?? Auth::user();
    $monthLabels = $monthLabels ?? [];
    $monthlyData = $monthlyData ?? [];
    $deptData = collect($deptData ?? []);
    $topUsers = collect($topUsers ?? []);
    $latestPurchases = collect($latestPurchases ?? []);
    $latestProducts = collect($latestProducts ?? []);
    $timeline = collect($timeline ?? []);
    $newInquiries = $newInquiries ?? 0;
    $totalInquiries = $totalInquiries ?? 0;
    $recentInquiries = collect($recentInquiries ?? []);
    $chartMonthLabels = $monthLabels ?: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $chartMonthlyData = $monthlyData ?: [0,0,0,0,0,0,0,0,0,0,0,0];
    $chartCategoryRows = $deptData->values();
    $maxMonthlyValue = max($chartMonthlyData ?: [1]);
    $maxCategoryValue = max($chartCategoryRows->pluck('value')->all() ?: [1]);
@endphp

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page dashboard-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">Agency Dashboard</div>
                <h2>NextDigiHome</h2>
                <p>Welcome back, {{ $user->name }}. Monitor project inquiries, digital marketplace, content, and revenue.</p>
            </div>
            <div class="premium-actions">
                <button type="button" onclick="window.location.reload()" class="btn btn-outline-light">
                    <i class="fas fa-sync-alt"></i><span>Refresh</span>
                </button>
                <a href="{{ route('inquiries.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-paper-plane"></i><span>Inquiries</span>
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i><span>Add Product</span>
                </a>
            </div>
        </div>

        <div class="premium-nav">
            <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-th-large"></i> Overview</a>
            <a href="{{ route('inquiries.index') }}"><i class="fas fa-paper-plane"></i> Inquiries @if($newInquiries > 0)<span class="badge badge-new">{{ $newInquiries }}</span>@endif</a>
            <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Products</a>
            <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a href="{{ route('admin.pages.index') }}"><i class="fas fa-file-alt"></i> Content</a>
            <a href="{{ route('admin.customers.index') }}"><i class="fas fa-users"></i> Customers</a>
            <a href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar"></i> Reports</a>
            <a href="{{ route('admin.settings.general') }}"><i class="fas fa-cog"></i> Settings</a>
        </div>

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('info'))<div class="alert alert-info">{{ session('info') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        <div class="premium-stats-grid">
            <div class="stat-grid-item">
                <a href="{{ route('inquiries.index') }}" class="dashboard-stat-link">
                    <div class="premium-stat">
                        <span class="premium-icon" style="background:#f3e8ff;color:#7c3aed"><i class="fas fa-paper-plane"></i></span>
                        <div>
                            <small>New Project Leads</small>
                            <strong>{{ number_format($newInquiries) }} <span style="font-size:12px;font-weight:400;color:#6b7280">({{ number_format($totalInquiries) }} total)</span></strong>
                        </div>
                    </div>
                </a>
            </div>
            <div class="stat-grid-item">
                <a href="{{ route('admin.products.index') }}" class="dashboard-stat-link">
                    <div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-box"></i></span><div><small>Total Products</small><strong>{{ number_format($totalProducts ?? 0) }}</strong></div></div>
                </a>
            </div>
            <div class="stat-grid-item">
                <a href="{{ route('admin.products.index') }}" class="dashboard-stat-link">
                    <div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-check-circle"></i></span><div><small>Active Items</small><strong>{{ number_format($activeProducts ?? 0) }}</strong></div></div>
                </a>
            </div>
            <div class="stat-grid-item">
                <a href="{{ route('admin.orders.index') }}" class="dashboard-stat-link">
                    <div class="premium-stat"><span class="premium-icon premium-cyan"><i class="fas fa-shopping-cart"></i></span><div><small>Purchases</small><strong>{{ number_format($totalPurchases ?? 0) }}</strong></div></div>
                </a>
            </div>
            <div class="stat-grid-item">
                <a href="{{ route('admin.reports.revenue') }}" class="dashboard-stat-link">
                    <div class="premium-stat"><span class="premium-icon premium-amber"><i class="fas fa-dollar-sign"></i></span><div><small>Revenue</small><strong>${{ number_format($totalRevenue ?? 0, 0) }}</strong></div></div>
                </a>
            </div>
        </div>

        <div class="dashboard-grid-2col">
            <div>
                <div class="premium-card dashboard-chart-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Product Growth</h5>
                            <p>Products created over the last 12 months.</p>
                        </div>
                        <a href="{{ route('admin.reports.products') }}" class="btn btn-sm btn-outline-primary">View Report</a>
                    </div>
                    <div class="dashboard-bar-chart">
                        @foreach($chartMonthLabels as $index => $label)
                            @php
                                $value = (int) ($chartMonthlyData[$index] ?? 0);
                                $height = $maxMonthlyValue > 0 ? max(6, round(($value / $maxMonthlyValue) * 100)) : 6;
                            @endphp
                            <div class="bar-item">
                                <div class="bar-track"><span style="height:{{ $height }}%"></span></div>
                                <small>{{ \Illuminate\Support\Str::limit($label, 6, '') }}</small>
                                <strong>{{ $value }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                <div class="premium-card dashboard-chart-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Category Mix</h5>
                            <p>Top product categories by catalog size.</p>
                        </div>
                    </div>
                    <div class="category-list">
                        @forelse($chartCategoryRows->take(8) as $category)
                            @php
                                $value = (int) ($category->value ?? 0);
                                $width = $maxCategoryValue > 0 ? max(3, round(($value / $maxCategoryValue) * 100)) : 3;
                            @endphp
                            <div class="category-row">
                                <div class="category-row-head">
                                    <span>{{ $category->label ?? 'Category' }}</span>
                                    <strong>{{ number_format($value) }}</strong>
                                </div>
                                <div class="category-track"><span style="width:{{ $width }}%"></span></div>
                            </div>
                        @empty
                            <div class="text-center premium-muted py-4">No category data found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-grid-2col-table">
            <div>
                <div class="premium-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Latest Purchases</h5>
                            <p>Recent customer purchases and product activity.</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">All Orders</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead><tr><th>Product</th><th>Customer</th><th>Date</th><th>Amount</th></tr></thead>
                            <tbody>
                            @forelse($latestPurchases as $purchase)
                                <tr>
                                    <td class="fw-bold">{{ optional($purchase->product)->name ?? 'Digital Product' }}</td>
                                    <td>{{ optional($purchase->user)->name ?? ('Customer #'.$purchase->user_id) }}</td>
                                    <td>{{ optional($purchase->created_at)->diffForHumans() }}</td>
                                    <td class="fw-bold text-success">${{ number_format($purchase->total ?? optional($purchase->product)->price ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                @forelse($latestProducts as $product)
                                    <tr>
                                        <td class="fw-bold">{{ $product->name }}</td>
                                        <td>Catalog item</td>
                                        <td>{{ optional($product->created_at)->diffForHumans() }}</td>
                                        <td class="fw-bold text-success">${{ number_format($product->price ?? 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center premium-muted py-4">No recent activity found.</td></tr>
                                @endforelse
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                <div class="premium-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Top Products</h5>
                            <p>Products with the highest purchase count.</p>
                        </div>
                    </div>
                    <div class="dashboard-ranking">
                        @forelse($topUsers as $item)
                            <div class="ranking-row">
                                <span class="ranking-name">{{ $item['name'] ?? 'Product' }}</span>
                                <span class="ranking-value">{{ number_format($item['total'] ?? 0) }} sales</span>
                            </div>
                        @empty
                            <div class="text-center premium-muted py-4">No product sales yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12">
                <div class="premium-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Recent Inquiries & Leads</h5>
                            <p>Project consultations and inquiries submitted from NextDigiHome website.</p>
                        </div>
                        <a href="{{ route('inquiries.index') }}" class="btn btn-sm btn-outline-primary">View All Inquiries</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead><tr><th>Client / Name</th><th>Email & Phone</th><th>Service Interest</th><th>Budget</th><th>Status</th><th>Submitted</th><th>Action</th></tr></thead>
                            <tbody>
                            @forelse($recentInquiries as $inquiry)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $inquiry->name }}</div>
                                        @if($inquiry->company)<small class="text-muted">{{ $inquiry->company }}</small>@endif
                                    </td>
                                    <td>
                                        <div><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
                                        @if($inquiry->phone)<small class="text-muted">{{ $inquiry->phone }}</small>@endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $inquiry->service_interest ?? 'General' }}</span>
                                    </td>
                                    <td class="text-success fw-bold">{{ $inquiry->budget ?: 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $inquiry->status }}">{{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}</span>
                                    </td>
                                    <td>{{ optional($inquiry->created_at)->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('inquiries.show', $inquiry->id) }}" class="btn btn-xs btn-outline-primary"><i class="fas fa-eye me-1"></i>View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center premium-muted py-4">No inquiries received yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-grid-2col-table">
            <div>
                <div class="premium-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Quick Actions</h5>
                            <p>Common admin workflows for agency operations.</p>
                        </div>
                    </div>
                    <div class="quick-action-grid">
                        <a href="{{ route('admin.products.create') }}"><i class="fas fa-plus"></i><span>Add Product</span></a>
                        <a href="{{ route('admin.orders.index') }}"><i class="fas fa-clipboard-list"></i><span>Manage Orders</span></a>
                        <a href="{{ route('inquiries.index') }}"><i class="fas fa-paper-plane"></i><span>Project Leads</span></a>
                        <a href="{{ route('admin.pages.index') }}"><i class="fas fa-file-alt"></i><span>Page Content</span></a>
                        <a href="{{ route('admin.team-members.index') }}"><i class="fas fa-user-friends"></i><span>Team Members</span></a>
                        <a href="{{ route('admin.testimonials.index') }}"><i class="fas fa-comment-dots"></i><span>Testimonials</span></a>
                        <a href="{{ route('admin.contact-info.index') }}"><i class="fas fa-address-book"></i><span>Contact Info</span></a>
                        <a href="{{ route('admin.marketing.seo') }}"><i class="fas fa-search"></i><span>SEO Settings</span></a>
                        <a href="{{ route('admin.system.info') }}"><i class="fas fa-server"></i><span>System Info</span></a>
                    </div>
                </div>
            </div>
            <div>
                <div class="premium-card">
                    <div class="premium-card-title">
                        <div>
                            <h5>Recent Activity</h5>
                            <p>Latest system log history.</p>
                        </div>
                    </div>
                    <div class="dashboard-timeline">
                        @forelse($timeline->take(6) as $activity)
                            <div class="timeline-item">
                                <span class="timeline-dot"></span>
                                <div>
                                    <div class="timeline-text">{!! $activity->description ?? 'System activity' !!}</div>
                                    <small>{{ $activity->created_at ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : '' }} by {{ $activity->user_name ?? 'System' }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center premium-muted py-4">No recent activity found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .dashboard-page .premium-header { margin-bottom:16px; }
    .premium-stats-grid {
        display: grid !important;
        grid-template-columns: 1.25fr 1fr 1fr 1fr 1fr !important;
        gap: 16px !important;
        margin-bottom: 20px !important;
    }
    .stat-grid-item {
        min-width: 0;
        width: 100%;
    }
    @media (max-width: 1280px) {
        .premium-stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 820px) {
        .premium-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 520px) {
        .premium-stats-grid {
            grid-template-columns: 1fr !important;
        }
    }
    .dashboard-page .row { margin-left:-8px; margin-right:-8px; }
    .dashboard-page .row > [class*="col-"] { padding-left:8px; padding-right:8px; }
    .dashboard-stat-link { display:block; text-decoration:none; }
    .dashboard-stat-link:hover .premium-stat { border-color:#c7d2fe; transform:translateY(-1px); }
    .dashboard-stat-link .premium-stat { transition:border-color .18s ease, transform .18s ease; }
    .dashboard-chart-card { min-height:330px; }
    .dashboard-bar-chart { align-items:end; display:grid; gap:10px; grid-template-columns:repeat(12, minmax(26px, 1fr)); min-height:230px; padding-top:10px; }
    .bar-item { align-items:center; display:flex; flex-direction:column; gap:6px; min-width:0; }
    .bar-track { align-items:end; background:#eef2ff; border-radius:8px; display:flex; height:150px; overflow:hidden; width:100%; }
    .bar-track span { background:#2563eb; border-radius:8px 8px 0 0; display:block; width:100%; }
    .bar-item small { color:#6b7280; font-size:11px; max-width:100%; overflow:hidden; text-align:center; white-space:nowrap; }
    .bar-item strong { color:#111827; font-size:12px; }
    .category-list { display:grid; gap:13px; }
    .category-row-head { align-items:center; display:flex; justify-content:space-between; gap:12px; margin-bottom:7px; }
    .category-row-head span { color:#111827; font-weight:700; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .category-row-head strong { color:#2563eb; font-size:13px; white-space:nowrap; }
    .category-track { background:#eef2ff; border-radius:999px; height:9px; overflow:hidden; }
    .category-track span { background:#16a34a; display:block; height:100%; }
    .dashboard-ranking { display:grid; gap:10px; }
    .ranking-row { align-items:center; background:#f9fafb; border:1px solid #edf0f4; border-radius:8px; display:flex; justify-content:space-between; padding:12px 14px; }
    .ranking-name { color:#111827; font-weight:700; min-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .ranking-value { color:#2563eb; font-size:13px; font-weight:700; margin-left:12px; white-space:nowrap; }
    .quick-action-grid { display:grid; gap:12px; grid-template-columns:repeat(3, minmax(0, 1fr)); }
    .quick-action-grid a { align-items:center; background:#f9fafb; border:1px solid #edf0f4; border-radius:8px; color:#1f2937; display:flex; font-weight:700; gap:10px; min-height:54px; padding:12px; text-decoration:none; }
    .quick-action-grid a:hover { background:#111827; color:#fff; }
    .quick-action-grid i { color:#2563eb; width:20px; }
    .quick-action-grid a:hover i { color:#fff; }
    .dashboard-timeline { display:grid; gap:14px; }
    .timeline-item { display:flex; gap:12px; }
    .timeline-dot { background:#2563eb; border-radius:50%; flex:0 0 10px; height:10px; margin-top:7px; width:10px; }
    .timeline-text { color:#111827; font-weight:600; }
    .timeline-item small { color:#6b7280; }
    @media (max-width:991px) { .quick-action-grid { grid-template-columns:repeat(2, minmax(0, 1fr)); } .dashboard-bar-chart { grid-template-columns:repeat(6, minmax(32px, 1fr)); } }
    @media (max-width:575px) { .quick-action-grid { grid-template-columns:1fr; } .dashboard-bar-chart { grid-template-columns:repeat(3, minmax(44px, 1fr)); } }
</style>

@endsection
