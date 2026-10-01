@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body order-export-page">
    <div class="container-fluid">
        <div class="export-header">
            <div>
                <div class="export-eyebrow">Commerce</div>
                <h2>Order Exports</h2>
                <p>Download filtered order records as CSV for reporting, finance, and operations.</p>
            </div>
            <div class="export-header-actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light">
                    <i class="fas fa-list me-2"></i>All Orders
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <div class="orders-nav mb-3">
            <a href="{{ route('admin.orders.index') }}">All</a>
            <a href="{{ route('admin.orders.pending') }}">Pending</a>
            <a href="{{ route('admin.orders.processing') }}">Processing</a>
            <a href="{{ route('admin.orders.shipped') }}">Shipped</a>
            <a href="{{ route('admin.orders.delivered') }}">Delivered</a>
            <a href="{{ route('admin.orders.refunds') }}">Refunds</a>
            <a href="{{ route('admin.orders.exports') }}" class="active">Exports</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-md-6">
                <div class="export-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-database"></i></span>
                    <div>
                        <small>Total Records</small>
                        <strong>{{ number_format($stats['total'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="export-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-calendar-alt"></i></span>
                    <div>
                        <small>This Month</small>
                        <strong>{{ number_format($stats['this_month'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="export-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-dollar-sign"></i></span>
                    <div>
                        <small>Paid Revenue</small>
                        <strong>$ {{ number_format($stats['revenue'] ?? 0, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xl-8">
                <div class="export-panel">
                    <div class="export-panel-title">
                        <div>
                            <h5>Custom CSV Export</h5>
                            <p>Select filters, then download a CSV file generated from current order data.</p>
                        </div>
                    </div>

                    <form id="exportForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="statusFilter">Status</label>
                                <select class="form-control" id="statusFilter" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="paymentFilter">Payment Method</label>
                                <select class="form-control" id="paymentFilter" name="payment_method">
                                    <option value="">All Methods</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="stripe">Stripe</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="bkash">Bkash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="rocket">Rocket</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="dateFromFilter">From Date</label>
                                <input type="date" class="form-control" id="dateFromFilter" name="date_from">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="dateToFilter">To Date</label>
                                <input type="date" class="form-control" id="dateToFilter" name="date_to">
                            </div>
                        </div>

                        <div class="export-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>Download CSV
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="resetExportBtn">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="export-panel">
                    <div class="export-panel-title">
                        <div>
                            <h5>Quick Exports</h5>
                            <p>Common exports with one click.</p>
                        </div>
                    </div>

                    <div class="quick-export-list">
                        <button type="button" class="quick-export" data-status="">
                            <i class="fas fa-list"></i>
                            <span>
                                <strong>All Orders</strong>
                                <small>Full order database</small>
                            </span>
                        </button>
                        <button type="button" class="quick-export" data-status="pending">
                            <i class="fas fa-clock"></i>
                            <span>
                                <strong>Pending Orders</strong>
                                <small>Needs review or approval</small>
                            </span>
                        </button>
                        <button type="button" class="quick-export" data-status="delivered">
                            <i class="fas fa-check-circle"></i>
                            <span>
                                <strong>Delivered Orders</strong>
                                <small>Completed fulfillment</small>
                            </span>
                        </button>
                        <button type="button" class="quick-export" data-status="refunded">
                            <i class="fas fa-undo"></i>
                            <span>
                                <strong>Refunded Orders</strong>
                                <small>Refund and reversal records</small>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .order-export-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
        padding: 24px;
    }

    .export-header {
        align-items: center;
        background: #111827;
        border-radius: 8px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        padding: 22px 24px;
    }

    .export-header h2 {
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .export-header p,
    .export-panel-title p {
        margin: 0;
    }

    .export-header p {
        color: rgba(255, 255, 255, 0.72);
    }

    .export-eyebrow {
        color: #60a5fa;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 3px;
        text-transform: uppercase;
    }

    .export-header-actions,
    .orders-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .orders-nav {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        gap: 8px;
        padding: 10px;
    }

    .orders-nav a {
        border-radius: 6px;
        color: #4b5563;
        font-size: 13px;
        font-weight: 700;
        padding: 8px 12px;
        text-decoration: none;
    }

    .orders-nav a:hover,
    .orders-nav a.active {
        background: #111827;
        color: #fff;
    }

    .export-stat-card,
    .export-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .export-stat-card {
        align-items: center;
        display: flex;
        gap: 14px;
        min-height: 102px;
        padding: 18px;
    }

    .export-stat-card small {
        color: #6b7280;
        display: block;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .export-stat-card strong {
        color: #111827;
        display: block;
        font-size: 24px;
        line-height: 1;
    }

    .stat-icon {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        flex: 0 0 46px;
        height: 46px;
        justify-content: center;
        width: 46px;
    }

    .stat-blue { background: #dbeafe; color: #1d4ed8; }
    .stat-green { background: #dcfce7; color: #15803d; }
    .stat-amber { background: #fef3c7; color: #b45309; }

    .export-panel {
        padding: 18px;
    }

    .export-panel-title {
        margin-bottom: 16px;
    }

    .export-panel-title h5 {
        color: #111827;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 3px;
    }

    .export-panel-title p {
        color: #6b7280;
    }

    .order-export-page .form-label {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .order-export-page .form-control {
        border-color: #d1d5db;
        border-radius: 6px;
        min-height: 38px;
    }

    .export-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
    }

    .quick-export-list {
        display: grid;
        gap: 10px;
    }

    .quick-export {
        align-items: center;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #111827;
        display: flex;
        gap: 12px;
        padding: 12px;
        text-align: left;
        width: 100%;
    }

    .quick-export:hover {
        border-color: #111827;
    }

    .quick-export i {
        align-items: center;
        background: #dbeafe;
        border-radius: 8px;
        color: #1d4ed8;
        display: inline-flex;
        height: 38px;
        justify-content: center;
        width: 38px;
    }

    .quick-export strong,
    .quick-export small {
        display: block;
    }

    .quick-export small {
        color: #6b7280;
    }

    @media (max-width: 767px) {
        .order-export-page {
            padding: 14px;
        }

        .export-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .export-header-actions,
        .export-header-actions .btn,
        .export-actions .btn {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const exportUrl = @json(route('admin.orders.export.csv'));
    const form = document.getElementById('exportForm');

    function downloadWithFilters(statusOverride) {
        const params = new URLSearchParams(new FormData(form));

        if (typeof statusOverride !== 'undefined') {
            params.set('status', statusOverride);
        }

        Array.from(params.keys()).forEach(function(key) {
            if (!params.get(key)) {
                params.delete(key);
            }
        });

        window.location.href = exportUrl + (params.toString() ? '?' + params.toString() : '');
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        downloadWithFilters();
    });

    document.getElementById('resetExportBtn').addEventListener('click', function() {
        form.reset();
    });

    document.querySelectorAll('.quick-export').forEach(function(button) {
        button.addEventListener('click', function() {
            downloadWithFilters(this.dataset.status || '');
        });
    });
});
</script>
@endsection
