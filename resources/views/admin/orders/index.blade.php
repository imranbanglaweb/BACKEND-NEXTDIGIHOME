@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-shopping-cart me-3"></i>All Orders Management
                        </h2>
                        <p class="text-white-50 mb-0">Comprehensive order management and tracking system</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-shopping-cart text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">1,247</h3>
                        <p class="text-muted mb-0">Total Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-dollar-sign text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">$45,678</h3>
                        <p class="text-muted mb-0">Total Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">23</h3>
                        <p class="text-muted mb-0">Pending Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-truck text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">89</h3>
                        <p class="text-muted mb-0">Shipped Today</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>All Orders
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm" id="exportBtn">
                                    <i class="fas fa-download me-2"></i>Export
                                </button>
                                <button class="btn btn-info btn-sm" id="filterBtn">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                                <button class="btn btn-warning btn-sm" id="refreshBtn">
                                    <i class="fas fa-sync-alt me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="ordersTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">#</th>
                                        <th class="border-0 px-4 py-3">Order ID</th>
                                        <th class="border-0 px-4 py-3">Customer</th>
                                        <th class="border-0 px-4 py-3">Product</th>
                                        <th class="border-0 px-4 py-3">Qty</th>
                                        <th class="border-0 px-4 py-3">Amount</th>
                                        <th class="border-0 px-4 py-3">Payment</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Date</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div class="modal-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title" id="viewOrderModalLabel">
                    <i class="fas fa-eye me-2"></i>Order Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="viewOrderContent">
                <!-- Order details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div class="modal-header bg-gradient-warning text-white" style="border-radius: 15px 15px 0 0; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h5 class="modal-title" id="editOrderModalLabel">
                    <i class="fas fa-edit me-2"></i>Update Order Status
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editOrderForm">
                    @csrf
                    <input type="hidden" id="editOrderId" name="order_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="editStatus" class="form-label fw-bold">Order Status</label>
                                <select class="form-select" id="editStatus" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="editNotes" class="form-label fw-bold">Notes</label>
                                <textarea class="form-control" id="editNotes" name="notes" rows="3" placeholder="Add any notes..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .badge-primary {
        background-color: #007bff;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 16px;
    }

    .avatar-initial {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .btn-group .btn {
        border-radius: 8px !important;
        margin: 0 1px;
    }

    .modal-content {
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const ordersTable = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.orders.data") }}',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'order_id', className: 'fw-bold' },
            { data: 'customer', orderable: false },
            { data: 'product_name' },
            { data: 'quantity', className: 'text-center' },
            { data: 'amount', className: 'text-right' },
            { data: 'payment_method', className: 'text-center' },
            { data: 'status', className: 'text-center' },
            { data: 'created_at', className: 'text-center' },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        pageLength: 15,
        responsive: true,
        language: {
            processing: '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>',
            search: "Search orders:",
            lengthMenu: "Show _MENU_ orders per page",
            info: "Showing _START_ to _END_ of _TOTAL_ orders",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        drawCallback: function() {
            // Reinitialize tooltips after table draw
            $('[title]').tooltip();
        }
    });

    // View Order Details
    $(document).on('click', '.viewBtn', function() {
        const orderId = $(this).data('id');

        // Show loading modal
        $('#viewOrderModal').modal('show');
        $('#viewOrderContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading order details...</p>
            </div>
        `);

        // Fetch order details
        $.ajax({
            url: `{{ url('/admin/orders') }}/${orderId}`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const order = response.order;
                    const product = order.product || {};
                    const user = order.user || {};

                    $('#viewOrderContent').html(`
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-shopping-cart me-2"></i>Order Information</h6>
                                <table class="table table-sm">
                                    <tr><td class="fw-bold">Order ID:</td><td>${order.id}</td></tr>
                                    <tr><td class="fw-bold">Product:</td><td>${product.name || 'N/A'}</td></tr>
                                    <tr><td class="fw-bold">Quantity:</td><td>${order.quantity}</td></tr>
                                    <tr><td class="fw-bold">Total:</td><td class="text-success fw-bold">$ ${parseFloat(order.total).toFixed(2)}</td></tr>
                                    <tr><td class="fw-bold">Status:</td><td><span class="badge bg-${getStatusColor(order.status)}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Customer Information</h6>
                                <table class="table table-sm">
                                    <tr><td class="fw-bold">Name:</td><td>${user.name || order.customer_name || 'N/A'}</td></tr>
                                    <tr><td class="fw-bold">Email:</td><td>${user.email || order.customer_email || 'N/A'}</td></tr>
                                    <tr><td class="fw-bold">Payment:</td><td>${order.payment_method ? order.payment_method.charAt(0).toUpperCase() + order.payment_method.slice(1).replace('_', ' ') : 'N/A'}</td></tr>
                                    <tr><td class="fw-bold">Date:</td><td>${new Date(order.created_at).toLocaleString()}</td></tr>
                                </table>
                            </div>
                        </div>
                        ${order.notes ? `<div class="row mt-3"><div class="col-12"><h6 class="text-primary"><i class="fas fa-sticky-note me-2"></i>Notes</h6><p class="text-muted">${order.notes}</p></div></div>` : ''}
                    `);
                } else {
                    $('#viewOrderContent').html('<div class="alert alert-danger">Failed to load order details.</div>');
                }
            },
            error: function() {
                $('#viewOrderContent').html('<div class="alert alert-danger">Error loading order details.</div>');
            }
        });
    });

    // Edit Order Status
    $(document).on('click', '.editBtn', function() {
        const orderId = $(this).data('id');

        // Fetch current order data
        $.ajax({
            url: `{{ url('/admin/orders') }}/${orderId}`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const order = response.order;
                    $('#editOrderId').val(order.id);
                    $('#editStatus').val(order.status);
                    $('#editNotes').val(order.notes || '');
                    $('#editOrderModal').modal('show');
                }
            }
        });
    });

    // Submit Edit Order Form
    $('#editOrderForm').on('submit', function(e) {
        e.preventDefault();

        const orderId = $('#editOrderId').val();
        const formData = new FormData(this);

        Swal.fire({
            title: 'Updating Order...',
            text: 'Please wait while we update the order status.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `{{ url('/admin/orders') }}/${orderId}`,
            type: 'PUT',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#editOrderModal').modal('hide');
                ordersTable.ajax.reload();
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'An error occurred while updating the order.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg
                });
            }
        });
    });

    // Approve Order
    $(document).on('click', '.approveBtn', function() {
        const orderId = $(this).data('id');

        Swal.fire({
            title: 'Approve Order?',
            text: 'This will mark the order as completed and send a delivery email to the customer.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Approving order and sending email...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `{{ route("admin.orders.approve", ":id") }}`.replace(':id', orderId),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Approved!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        ordersTable.ajax.reload();
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Failed to approve order.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMsg
                        });
                    }
                });
            }
        });
    });

    // Reject Order
    $(document).on('click', '.rejectBtn', function() {
        const orderId = $(this).data('id');

        Swal.fire({
            title: 'Reject Order?',
            text: 'This will mark the order as failed. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Rejecting order...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: `{{ route("admin.orders.reject", ":id") }}`.replace(':id', orderId),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Rejected!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        ordersTable.ajax.reload();
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Failed to reject order.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMsg
                        });
                    }
                });
            }
        });
    });

    // Refresh Table
    $('#refreshBtn').on('click', function() {
        ordersTable.ajax.reload();
        $(this).find('i').addClass('fa-spin');
        setTimeout(() => {
            $(this).find('i').removeClass('fa-spin');
        }, 1000);
    });

    // Export functionality (placeholder)
    $('#exportBtn').on('click', function() {
        Swal.fire({
            icon: 'info',
            title: 'Export Feature',
            text: 'Export functionality will be implemented soon.',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Filter functionality (placeholder)
    $('#filterBtn').on('click', function() {
        Swal.fire({
            icon: 'info',
            title: 'Filter Feature',
            text: 'Advanced filtering will be implemented soon.',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // Helper function for status colors
    function getStatusColor(status) {
        const colors = {
            'pending': 'warning',
            'processing': 'primary',
            'shipped': 'info',
            'delivered': 'success',
            'completed': 'success',
            'failed': 'danger',
            'refunded': 'secondary'
        };
        return colors[status] || 'secondary';
    }
});
</script>
@endsection