@extends('admin.dashboard.master')

@section('title', 'Order Details')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-shopping-cart me-3"></i>Order Details
                        </h2>
                        <p class="text-white-50 mb-0">Complete order information and management</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                        @if(in_array($order->status, ['pending', 'payment_submitted'], true))
                            <button class="btn btn-success approveBtn" data-id="{{ $order->id }}">
                                <i class="fas fa-check me-2"></i>Approve Order
                            </button>
                            <button class="btn btn-danger rejectBtn" data-id="{{ $order->id }}">
                                <i class="fas fa-times me-2"></i>Reject Order
                            </button>
                        @elseif(in_array($order->status, ['processing', 'shipped']))
                            <button class="btn btn-warning editStatusBtn" data-id="{{ $order->id }}">
                                <i class="fas fa-edit me-2"></i>Update Status
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-2">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
                                <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'payment_submitted' => 'warning',
                                        'processing' => 'primary',
                                        'shipped' => 'info',
                                        'delivered' => 'success',
                                        'completed' => 'success',
                                        'failed' => 'danger',
                                        'cancelled' => 'danger',
                                        'refunded' => 'secondary'
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }} px-4 py-2 fs-6">
                                    <i class="fas fa-circle me-2"></i>{{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Order Details -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Order Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Product Details</h6>
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-light rounded p-2 me-3">
                                        <i class="fas fa-box fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $order->product->name ?? 'Product Not Found' }}</h6>
                                        <p class="text-muted mb-1">Quantity: {{ $order->quantity }}</p>
                                        <p class="text-muted mb-0">Unit Price: ${{ number_format($order->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Payment Information</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Total Amount:</strong></p>
                                        <h4 class="text-success mb-0">${{ number_format($order->total, 2) }}</h4>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Payment Method:</strong></p>
                                        <p class="mb-0">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</p>
                                    </div>
                                </div>
                                @if($order->transaction_id)
                                <div class="mt-3">
                                    <p class="mb-1"><strong>Transaction ID:</strong></p>
                                    <code class="bg-light px-2 py-1 rounded">{{ $order->transaction_id }}</code>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="border-top pt-3">
                            <h6 class="text-muted mb-2">Order Notes</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-user me-2"></i>Customer Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $customerName = $order->user->name ?? $order->customer_name ?? 'N/A';
                            $customerEmail = $order->user->email ?? $order->customer_email ?? 'N/A';
                        @endphp

                        <div class="text-center mb-4">
                            <div class="avatar avatar-xl mx-auto mb-3">
                                <div class="avatar-initial rounded-circle bg-primary text-white">
                                    {{ substr($customerName, 0, 1) }}
                                </div>
                            </div>
                            <h6 class="mb-1">{{ $customerName }}</h6>
                            <p class="text-muted mb-0">{{ $customerEmail }}</p>
                        </div>

                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1">{{ $order->user ? \App\Models\ProductPurchase::where('user_id', $order->user->id)->count() : 1 }}</h4>
                                    <p class="text-muted mb-0 small">Total Orders</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-1">${{ number_format(\App\Models\ProductPurchase::where('user_id', $order->user->id ?? 0)->sum('total'), 2) }}</h4>
                                <p class="text-muted mb-0 small">Total Spent</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-history me-2"></i>Order Timeline
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Placed</h6>
                                    <p class="timeline-text">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>

                            @if($order->paid_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Payment Confirmed</h6>
                                    <p class="timeline-text">{{ $order->paid_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if(in_array($order->status, ['processing', 'shipped', 'delivered', 'completed']))
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Processing</h6>
                                    <p class="timeline-text">Order is being prepared for delivery</p>
                                </div>
                            </div>
                            @endif

                            @if(in_array($order->status, ['shipped', 'delivered', 'completed']))
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Shipped</h6>
                                    <p class="timeline-text">Order has been shipped and is on the way</p>
                                </div>
                            </div>
                            @endif

                            @if(in_array($order->status, ['delivered', 'completed']))
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Delivered</h6>
                                    <p class="timeline-text">Order has been successfully delivered</p>
                                </div>
                            </div>
                            @endif

                            @if($order->status === 'completed')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Completed</h6>
                                    <p class="timeline-text">Order has been completed successfully</p>
                                </div>
                            </div>
                            @endif

                            @if($order->status === 'failed')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Failed</h6>
                                    <p class="timeline-text">Order has been cancelled or failed</p>
                                </div>
                            </div>
                            @endif

                            @if($order->status === 'refunded')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Order Refunded</h6>
                                    <p class="timeline-text">Order has been refunded to the customer</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <div class="modal-header bg-gradient-warning text-white" style="border-radius: 15px 15px 0 0; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h5 class="modal-title" id="editStatusModalLabel">
                    <i class="fas fa-edit me-2"></i>Update Order Status
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editStatusForm">
                    @csrf
                    <input type="hidden" id="editOrderId" name="order_id">
                    <div class="mb-3">
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
                    <div class="mb-3">
                        <label for="editNotes" class="form-label fw-bold">Notes</label>
                        <textarea class="form-control" id="editNotes" name="notes" rows="3" placeholder="Add any notes..."></textarea>
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
        box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
    }

    .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 24px;
    }

    .avatar-xl {
        width: 80px;
        height: 80px;
        font-size: 32px;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 0;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 3px solid #fff;
        z-index: 1;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .timeline-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: #495057;
    }

    .timeline-text {
        margin: 0;
        color: #6c757d;
        font-size: 14px;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .badge {
        font-size: 0.8em;
    }
</style>

<script>
$(document).ready(function() {
    // Set current status in modal
    $('.editStatusBtn').on('click', function() {
        const orderId = $(this).data('id');
        $('#editOrderId').val(orderId);
        $('#editStatus').val('{{ $order->status }}');
        $('#editNotes').val('{{ $order->notes }}');
        $('#editStatusModal').modal('show');
    });

    // Submit Edit Status Form
    $('#editStatusForm').on('submit', function(e) {
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
            type: 'POST',
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
                }).then(() => {
                    location.reload();
                });
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
    $('.approveBtn').on('click', function() {
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
                        }).then(() => {
                            location.reload();
                        });
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
    $('.rejectBtn').on('click', function() {
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
                        }).then(() => {
                            location.reload();
                        });
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
});
</script>
@endsection
