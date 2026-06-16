@extends('admin.dashboard.master')

@section('main_content')
@php
    $pageStatus = $pageStatus ?? '';
    $pageTitle = $pageTitle ?? 'Order List';
    $pageDescription = $pageDescription ?? 'Track orders, verify payments, update fulfillment status, and export filtered data.';
@endphp
<section role="main" class="content-body orders-page">
    <div class="container-fluid">
        <div class="orders-header">
            <div>
                <div class="orders-eyebrow">Commerce</div>
                <h2>{{ $pageTitle }}</h2>
                <p>{{ $pageDescription }}</p>
            </div>
            <div class="orders-header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <button type="button" class="btn btn-primary" id="exportBtn">
                    <i class="fas fa-download me-2"></i>Export CSV
                </button>
            </div>
        </div>

        <div class="orders-nav mb-3">
            <a href="{{ route('admin.orders.index') }}" class="{{ $pageStatus === '' ? 'active' : '' }}">All</a>
            <a href="{{ route('admin.orders.pending') }}" class="{{ $pageStatus === 'pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('admin.orders.processing') }}" class="{{ $pageStatus === 'processing' ? 'active' : '' }}">Processing</a>
            <a href="{{ route('admin.orders.shipped') }}" class="{{ $pageStatus === 'shipped' ? 'active' : '' }}">Shipped</a>
            <a href="{{ route('admin.orders.delivered') }}" class="{{ $pageStatus === 'delivered' ? 'active' : '' }}">Delivered</a>
            <a href="{{ route('admin.orders.refunds') }}" class="{{ $pageStatus === 'refunded' ? 'active' : '' }}">Refunds</a>
            <a href="{{ route('admin.orders.exports') }}">Exports</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="order-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-shopping-bag"></i></span>
                    <div>
                        <small>Total Orders</small>
                        <strong>{{ number_format($stats['total'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="order-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-dollar-sign"></i></span>
                    <div>
                        <small>Paid Revenue</small>
                        <strong>$ {{ number_format($stats['revenue'] ?? 0, 2) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="order-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-clock"></i></span>
                    <div>
                        <small>Pending Review</small>
                        <strong>{{ number_format($stats['pending'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="order-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-truck"></i></span>
                    <div>
                        <small>Shipped Today</small>
                        <strong>{{ number_format($stats['shipped_today'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="orders-panel mb-3">
            <div class="orders-panel-title">
                <div>
                    <h5>Filters</h5>
                    <p>Use filters to narrow the list and export exactly what is visible.</p>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFiltersBtn">
                    <i class="fas fa-undo me-1"></i>Reset
                </button>
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-control" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ $pageStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $pageStatus === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $pageStatus === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $pageStatus === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="completed" {{ $pageStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ $pageStatus === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ $pageStatus === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Payment</label>
                    <select class="form-control" id="paymentFilter">
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
                <div class="col-lg-2 col-md-6">
                    <label class="form-label">From</label>
                    <input type="date" class="form-control" id="dateFromFilter">
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label">To</label>
                    <input type="date" class="form-control" id="dateToFilter">
                </div>
                <div class="col-lg-2 col-md-12 d-flex align-items-end">
                    <button type="button" class="btn btn-dark w-100" id="applyFiltersBtn">
                        <i class="fas fa-filter me-2"></i>Apply
                    </button>
                </div>
            </div>
        </div>

        <div class="orders-panel">
            <div class="orders-panel-title">
                <div>
                    <h5>Orders</h5>
                    <p>Review customer, payment, status, and fulfillment details.</p>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="refreshBtn">
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
            </div>
            <div class="table-responsive">
                <table class="table order-table" id="ordersTable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center order-actions-col">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal order-premium-modal" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content order-modal">
            <div class="modal-header">
                <div class="order-modal-title">
                    <span class="order-modal-icon"><i class="fas fa-receipt"></i></span>
                    <div>
                        <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                        <small>Customer, payment, and product information</small>
                    </div>
                </div>
                <button type="button" class="close order-modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewOrderContent"></div>
        </div>
    </div>
</div>

<div class="modal order-premium-modal" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content order-modal">
            <div class="modal-header">
                <div class="order-modal-title">
                    <span class="order-modal-icon order-modal-icon-edit"><i class="fas fa-pen"></i></span>
                    <div>
                        <h5 class="modal-title" id="editOrderModalLabel">Update Order</h5>
                        <small>Change fulfillment status and internal notes</small>
                    </div>
                </div>
                <button type="button" class="close order-modal-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="order-form-preloader" id="editOrderPreloader">
                    <div class="order-loader"></div>
                    <strong>Loading order</strong>
                    <span>Please wait while details are prepared.</span>
                </div>
                <form id="editOrderForm">
                    @csrf
                    <input type="hidden" id="editOrderId" name="order_id">
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="editNotes" name="notes" rows="4" placeholder="Add internal notes for this order"></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveOrderBtn">
                            <span class="btn-ready"><i class="fas fa-save me-2"></i>Save Changes</span>
                            <span class="btn-loading"><i class="fas fa-spinner fa-spin me-2"></i>Saving</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .orders-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
        padding: 24px;
    }

    .orders-header {
        align-items: center;
        background: #111827;
        border-radius: 8px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        padding: 22px 24px;
    }

    .orders-header h2 {
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .orders-header p,
    .orders-panel-title p {
        color: #6b7280;
        margin: 0;
    }

    .orders-header p {
        color: rgba(255, 255, 255, 0.72);
    }

    .orders-eyebrow {
        color: #60a5fa;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0;
        margin-bottom: 3px;
        text-transform: uppercase;
    }

    .orders-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .orders-nav {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: flex;
        flex-wrap: wrap;
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

    .order-stat-card,
    .orders-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .order-stat-card {
        align-items: center;
        display: flex;
        gap: 14px;
        min-height: 102px;
        padding: 18px;
    }

    .order-stat-card small {
        color: #6b7280;
        display: block;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .order-stat-card strong {
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
    .stat-cyan { background: #cffafe; color: #0e7490; }

    .orders-panel {
        padding: 18px;
    }

    .orders-panel-title {
        align-items: center;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 16px;
    }

    .orders-panel-title h5 {
        color: #111827;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 3px;
    }

    .orders-page .form-label {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .orders-page .form-control {
        border-color: #d1d5db;
        border-radius: 6px;
        min-height: 38px;
    }

    .order-table {
        margin-bottom: 0 !important;
    }

    .order-table thead th {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0;
        padding: 13px 12px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .order-table tbody td {
        border-top: 1px solid #edf0f4;
        color: #1f2937;
        padding: 13px 12px;
        vertical-align: middle;
    }

    .avatar,
    .avatar-initial {
        align-items: center;
        display: flex;
        height: 34px;
        justify-content: center;
        width: 34px;
    }

    .avatar-initial {
        background: #2563eb !important;
        font-size: 13px;
        font-weight: 700;
    }

    .order-table .order-actions-col {
        background: #fff;
        box-shadow: -8px 0 14px rgba(15, 23, 42, 0.04);
        min-width: 210px;
        position: sticky;
        right: 0;
        z-index: 2;
    }

    .order-table thead .order-actions-col {
        background: #f9fafb;
        z-index: 3;
    }

    .order-action-buttons {
        display: inline-flex;
        flex-wrap: nowrap;
        gap: 6px;
        justify-content: center;
        white-space: nowrap;
    }

    .order-table .order-action-buttons .btn {
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 32px;
        height: 32px;
        margin: 0 !important;
        width: 32px;
    }

    body.modal-open {
        background: #f6f8fb !important;
    }

    .modal-backdrop.show,
    .modal-backdrop.in {
        background: #0f172a !important;
        opacity: 0.48 !important;
    }

    .order-premium-modal {
        background: transparent !important;
    }

    .order-premium-modal.fade .modal-dialog {
        transform: translateY(18px) scale(0.98);
        transition: transform 0.22s ease-out;
    }

    .order-premium-modal.show .modal-dialog,
    .order-premium-modal.in .modal-dialog {
        transform: translateY(0) scale(1);
    }

    .order-modal {
        background: #ffffff;
        border: 0;
        border-radius: 12px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, 0.28);
        overflow: hidden;
    }

    .order-modal .modal-header {
        align-items: center;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        padding: 18px 20px;
    }

    .order-modal-title {
        align-items: center;
        display: flex;
        gap: 12px;
    }

    .order-modal-title h5 {
        color: #111827;
        font-size: 18px;
        font-weight: 800;
        margin: 0;
    }

    .order-modal-title small {
        color: #64748b;
        display: block;
        font-size: 12px;
        margin-top: 2px;
    }

    .order-modal-icon {
        align-items: center;
        background: #dbeafe;
        border-radius: 10px;
        color: #1d4ed8;
        display: inline-flex;
        height: 42px;
        justify-content: center;
        width: 42px;
    }

    .order-modal-icon-edit {
        background: #dcfce7;
        color: #15803d;
    }

    .order-modal-close {
        align-items: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #475569;
        display: inline-flex;
        font-size: 22px;
        height: 36px;
        justify-content: center;
        line-height: 1;
        opacity: 1;
        padding: 0;
        text-shadow: none;
        width: 36px;
    }

    .order-modal-close:hover {
        background: #fee2e2;
        border-color: #fecaca;
        color: #b91c1c;
        opacity: 1;
    }

    .order-modal .modal-body {
        padding: 20px;
        position: relative;
    }

    .order-detail-grid {
        display: grid;
        gap: 14px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .detail-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px;
    }

    .detail-box span {
        color: #6b7280;
        display: block;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .detail-box strong {
        color: #111827;
        font-size: 15px;
    }

    .order-loading-state,
    .order-form-preloader {
        align-items: center;
        color: #64748b;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 230px;
        text-align: center;
    }

    .order-form-preloader {
        background: rgba(255, 255, 255, 0.88);
        inset: 0;
        min-height: 100%;
        position: absolute;
        z-index: 5;
    }

    .order-form-preloader.is-hidden {
        display: none;
    }

    .order-loading-state strong,
    .order-form-preloader strong {
        color: #111827;
        font-size: 16px;
        margin-top: 14px;
    }

    .order-loading-state span,
    .order-form-preloader span {
        font-size: 13px;
        margin-top: 4px;
    }

    .order-loader {
        animation: orderSpin 0.9s linear infinite;
        border: 3px solid #e5e7eb;
        border-top-color: #2563eb;
        border-radius: 50%;
        height: 44px;
        width: 44px;
    }

    #saveOrderBtn .btn-loading {
        display: none;
    }

    #saveOrderBtn.is-loading .btn-ready {
        display: none;
    }

    #saveOrderBtn.is-loading .btn-loading {
        display: inline;
    }

    .order-swal-popup {
        border-radius: 12px !important;
        box-shadow: 0 28px 80px rgba(15, 23, 42, 0.24) !important;
        padding: 22px !important;
    }

    .order-swal-popup .swal2-title {
        color: #111827 !important;
        font-size: 22px !important;
        font-weight: 800 !important;
    }

    .order-swal-popup .swal2-html-container,
    .order-swal-popup .swal2-content {
        color: #64748b !important;
        font-size: 14px !important;
    }

    .order-swal-confirm,
    .order-swal-cancel {
        border-radius: 8px !important;
        font-weight: 700 !important;
        padding: 10px 18px !important;
    }

    @keyframes orderSpin {
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 767px) {
        .orders-page {
            padding: 14px;
        }

        .orders-header,
        .orders-panel-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .orders-header-actions,
        .orders-header-actions .btn {
            width: 100%;
        }

        .order-detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
$(document).ready(function() {
    const csrfToken = '{{ csrf_token() }}';
    const showUrlTemplate = '{{ route("admin.orders.show", ":id") }}';
    const updateUrlTemplate = '{{ route("admin.orders.update", ":id") }}';
    const deleteUrlTemplate = '{{ route("admin.orders.destroy", ":id") }}';
    const approveUrlTemplate = '{{ route("admin.orders.approve", ":id") }}';
    const rejectUrlTemplate = '{{ route("admin.orders.reject", ":id") }}';
    const exportUrl = '{{ route("admin.orders.export.csv") }}';
    const pageStatus = @json($pageStatus);

    function buildUrl(template, id) {
        return template.replace(':id', id);
    }

    function modalLoadingState(title, message) {
        return `
            <div class="order-loading-state">
                <div class="order-loader"></div>
                <strong>${escapeHtml(title)}</strong>
                <span>${escapeHtml(message)}</span>
            </div>
        `;
    }

    function showOrderModal(selector) {
        $(selector).modal({
            backdrop: true,
            keyboard: true,
            show: true
        });
    }

    function hideOrderModal(selector) {
        $(selector).modal('hide');
    }

    function cleanupOrderModalState() {
        setTimeout(function() {
            if (!$('.modal.show, .modal.in').length) {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css({
                    overflow: '',
                    paddingRight: '',
                    backgroundColor: ''
                });
            }
        }, 180);
    }

    function activeFilters() {
        return {
            status: $('#statusFilter').val(),
            payment_method: $('#paymentFilter').val(),
            date_from: $('#dateFromFilter').val(),
            date_to: $('#dateToFilter').val()
        };
    }

    const ordersTable = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 15,
        order: [[8, 'desc']],
        ajax: {
            url: '{{ route("admin.orders.data") }}',
            type: 'GET',
            data: function(data) {
                return $.extend(data, activeFilters());
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'order_id', name: 'id', className: 'fw-bold text-nowrap' },
            { data: 'customer', orderable: false },
            { data: 'product_name', orderable: false },
            { data: 'quantity', name: 'quantity', className: 'text-center' },
            { data: 'amount', name: 'total', className: 'text-nowrap' },
            { data: 'payment_method', name: 'payment_method', className: 'text-nowrap' },
            { data: 'status', name: 'status', className: 'text-center text-nowrap' },
            { data: 'created_at', name: 'created_at', className: 'text-nowrap' },
            { data: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap order-actions-col' }
        ],
        language: {
            processing: '<div class="py-4 text-center"><div class="spinner-border text-primary" role="status"></div><div class="mt-2 text-muted">Loading orders...</div></div>',
            search: 'Search',
            lengthMenu: 'Show _MENU_',
            info: 'Showing _START_ to _END_ of _TOTAL_ orders',
            emptyTable: 'No orders found',
            zeroRecords: 'No matching orders found'
        },
        drawCallback: function() {
            if ($.fn.tooltip) {
                $('[title]').tooltip();
            }
        }
    });

    $('#applyFiltersBtn').on('click', function() {
        ordersTable.ajax.reload();
    });

    $('#statusFilter, #paymentFilter, #dateFromFilter, #dateToFilter').on('change', function() {
        ordersTable.ajax.reload();
    });

    $('#resetFiltersBtn').on('click', function() {
        $('#statusFilter, #paymentFilter, #dateFromFilter, #dateToFilter').val('');
        if (pageStatus) {
            $('#statusFilter').val(pageStatus);
        }
        ordersTable.ajax.reload();
    });

    $('#refreshBtn').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('fa-spin');
        ordersTable.ajax.reload(function() {
            icon.removeClass('fa-spin');
        }, false);
    });

    $('#exportBtn').on('click', function() {
        const params = $.param(activeFilters());
        window.location.href = exportUrl + (params ? '?' + params : '');
    });

    $('.order-premium-modal').on('hidden.bs.modal', cleanupOrderModalState);

    $(document).on('click', '.order-modal-close, [data-dismiss="modal"]', function() {
        hideOrderModal($(this).closest('.modal'));
    });

    $(document).on('click', '.viewBtn', function() {
        const orderId = $(this).data('id');
        $('#viewOrderContent').html(modalLoadingState('Loading order details', 'Customer and payment data are being prepared.'));
        showOrderModal('#viewOrderModal');

        $.get(buildUrl(showUrlTemplate, orderId))
            .done(function(response) {
                const order = response.order || {};
                const product = order.product || {};
                const user = order.user || {};
                const customerName = user.name || order.customer_name || 'Guest Customer';
                const customerEmail = user.email || order.customer_email || 'No email';
                const total = Number(order.total || 0).toFixed(2);
                const createdAt = order.created_at ? new Date(order.created_at).toLocaleString() : 'N/A';

                $('#viewOrderContent').html(`
                    <div class="order-detail-grid">
                        <div class="detail-box"><span>Order ID</span><strong>#ORD-${String(order.id).padStart(4, '0')}</strong></div>
                        <div class="detail-box"><span>Status</span><strong>${formatText(order.status || 'N/A')}</strong></div>
                        <div class="detail-box"><span>Customer</span><strong>${escapeHtml(customerName)}</strong></div>
                        <div class="detail-box"><span>Email</span><strong>${escapeHtml(customerEmail)}</strong></div>
                        <div class="detail-box"><span>Product</span><strong>${escapeHtml(product.name || 'N/A')}</strong></div>
                        <div class="detail-box"><span>Quantity</span><strong>${order.quantity || 0}</strong></div>
                        <div class="detail-box"><span>Total</span><strong>$ ${total}</strong></div>
                        <div class="detail-box"><span>Payment</span><strong>${formatText(order.payment_method || 'N/A')}</strong></div>
                        <div class="detail-box"><span>Created</span><strong>${createdAt}</strong></div>
                        <div class="detail-box"><span>Transaction ID</span><strong>${escapeHtml(order.transaction_id || 'N/A')}</strong></div>
                    </div>
                    ${order.notes ? `<div class="detail-box mt-3"><span>Notes</span><strong>${escapeHtml(order.notes)}</strong></div>` : ''}
                `);
            })
            .fail(function() {
                $('#viewOrderContent').html('<div class="alert alert-danger mb-0">Unable to load order details.</div>');
            });
    });

    $(document).on('click', '.editBtn', function() {
        const orderId = $(this).data('id');
        $('#editOrderForm')[0].reset();
        $('#editOrderId').val('');
        $('#editOrderPreloader').removeClass('is-hidden');
        $('#saveOrderBtn').prop('disabled', true).removeClass('is-loading');
        showOrderModal('#editOrderModal');

        $.get(buildUrl(showUrlTemplate, orderId))
            .done(function(response) {
                const order = response.order || {};
                $('#editOrderId').val(order.id);
                $('#editStatus').val(order.status);
                $('#editNotes').val(order.notes || '');
                $('#editOrderPreloader').addClass('is-hidden');
                $('#saveOrderBtn').prop('disabled', false);
            })
            .fail(function() {
                hideOrderModal('#editOrderModal');
                showAlert('error', 'Unable to load order for editing.');
            });
    });

    $('#editOrderForm').on('submit', function(event) {
        event.preventDefault();
        const orderId = $('#editOrderId').val();
        const saveBtn = $('#saveOrderBtn');

        saveBtn.prop('disabled', true).addClass('is-loading');

        $.ajax({
            url: buildUrl(updateUrlTemplate, orderId),
            type: 'POST',
            data: $(this).serialize() + '&_method=PUT',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                hideOrderModal('#editOrderModal');
                showAlert('success', response.message || 'Order updated successfully.');
                ordersTable.ajax.reload(null, false);
            },
            error: function(xhr) {
                showAlert('error', xhr.responseJSON?.message || 'Failed to update order.');
            },
            complete: function() {
                saveBtn.prop('disabled', false).removeClass('is-loading');
            }
        });
    });

    $(document).on('click', '.approveBtn', function() {
        const orderId = $(this).data('id');
        const actionButton = $(this);
        confirmAction('Approve order?', 'This will mark the order as completed and send delivery email.', 'Approve', function() {
            postOrderAction(buildUrl(approveUrlTemplate, orderId), 'Order approved successfully.', actionButton);
        });
    });

    $(document).on('click', '.rejectBtn', function() {
        const orderId = $(this).data('id');
        const actionButton = $(this);
        confirmAction('Reject order?', 'This will mark the order as failed.', 'Reject', function() {
            postOrderAction(buildUrl(rejectUrlTemplate, orderId), 'Order rejected successfully.', actionButton);
        });
    });

    $(document).on('click', '.deleteBtn', function() {
        const orderId = $(this).data('id');
        const actionButton = $(this);
        confirmAction('Delete order?', 'This will permanently delete the order and any uploaded payment proof.', 'Delete', function() {
            postOrderAction(buildUrl(deleteUrlTemplate, orderId), 'Order deleted successfully.', actionButton, 'DELETE');
        }, 'danger');
    });

    function postOrderAction(url, fallbackMessage, triggerButton, method = 'POST') {
        const originalHtml = triggerButton ? triggerButton.html() : '';

        if (triggerButton) {
            triggerButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Processing order',
                text: 'Please wait while the order is updated.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });
        }

        $.ajax({
            url: url,
            type: method,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                if (typeof Swal !== 'undefined') {
                    Swal.close();
                }
                showAlert('success', response.message || fallbackMessage);
                ordersTable.ajax.reload(null, false);
            },
            error: function(xhr) {
                if (typeof Swal !== 'undefined') {
                    Swal.close();
                }
                showAlert('error', xhr.responseJSON?.message || 'Order action failed.');
            },
            complete: function() {
                if (triggerButton) {
                    triggerButton.prop('disabled', false).html(originalHtml);
                }
            }
        });
    }

    function confirmAction(title, text, confirmText, onConfirm, variant = 'default') {
        if (typeof Swal === 'undefined') {
            if (confirm(title)) {
                onConfirm();
            }
            return;
        }

        const isDanger = variant === 'danger';

        Swal.fire({
            title: title,
            text: text,
            icon: isDanger ? 'error' : 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancel',
            confirmButtonColor: isDanger ? '#dc2626' : '#111827',
            cancelButtonColor: '#64748b',
            customClass: {
                popup: 'order-swal-popup',
                confirmButton: 'order-swal-confirm',
                cancelButton: 'order-swal-cancel'
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                onConfirm();
            }
        });
    }

    function showAlert(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Success' : 'Error',
                text: message,
                timer: type === 'success' ? 1800 : undefined,
                showConfirmButton: type !== 'success'
            });
            return;
        }

        alert(message);
    }

    function formatText(value) {
        return escapeHtml(String(value).replace(/_/g, ' ').replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        }));
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
</script>
@endsection
