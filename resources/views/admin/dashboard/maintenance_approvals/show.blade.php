@extends('admin.dashboard.master')

<style>
    body { background:#ffffff !important; }
    .content-body { padding:20px 25px !important; }
    .card { border-radius:12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07); }
    .info-card { background: #f8f9fa; border-radius: 8px; padding: 15px; border: 1px solid #e9ecef; }
    .badge-lg { font-size: 14px; padding: 8px 12px; font-weight: 500; }
    .table th { background: #f1f3f5; font-weight: 600; }
    .table td { vertical-align: middle; }
    
    /* Premium Card Headers */
    .card-header {
        padding: 2px 10px;
        font-size: 15px;
        letter-spacing: 0.3px;
    }
    
    /* Premium Buttons */
    .btn-lg {
        padding: 5px 14px;
        font-size: 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1aa179 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.4);
    }
    
    /* Modal Styling */
    .modal-content {
        border-radius: 12px;
        border: none;
    }
    
    .modal-header {
        border-radius: 12px 12px 0 0;
        padding: 20px 15px;
    }
    
    .modal-body {
        padding: 15px;
    }
    
    .modal-footer {
        padding: 15px 25px 20px;
    }
    
    /* Form Controls */
    .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 12px 5px;
    }
    
    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    /* Alert Styling */
    .alert {
        border-radius: 8px;
        padding: 15px 20px;
    }
    
    /* Page Title */
    h3.fw-bold {
        font-size: 16px;
        letter-spacing: 0.5px;
        color: #212529;
    }
    
    /* Card Title */
    h5.mb-0 {
        font-size: 16px;
        font-weight: 600;
    }
</style>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@section('main_content')
<section role="main" class="content-body"  style=background:#fff !important;>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h3 class="mb-0 fw-bold text-dark">
            <i class="fa-solid fa-clipboard-check me-2 text-primary"></i> Maintenance Approval: <span class="text-primary">{{ $requisition->requisition_no }}
        </h3>
        <a href="{{ route('maintenance_approvals.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <!-- Requisition Details -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-wrench me-2"></i> Requisition Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Service Title</label>
                                <h6 class="mb-0">{{ $requisition->service_title }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card">
                                <label class="text-muted small">Type</label>
                                <h6 class="mb-0 text-capitalize">{{ $requisition->requisition_type }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card">
                                <label class="text-muted small">Priority</label>
                                @php
                                    $priorityClass = match($requisition->priority) {
                                        'Low' => 'success',
                                        'Medium' => 'warning',
                                        'High' => 'danger',
                                        'Urgent' => 'dark',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $priorityClass }} badge-lg">{{ $requisition->priority }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Vehicle</label>
                                <h6 class="mb-0">
                                    {{ $requisition->vehicle->vehicle_name ?? 'N/A' }}
                                    @if($requisition->vehicle)
                                        <small class="text-muted">({{ $requisition->vehicle->vehicle_no }})</small>
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Maintenance Date</label>
                                <h6 class="mb-0">{{ date('d M, Y', strtotime($requisition->maintenance_date)) }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Requested By</label>
                                <h6 class="mb-0">{{ $requisition->employee->name ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Maintenance Type</label>
                                <h6 class="mb-0">{{ $requisition->maintenanceType->type_name ?? 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="info-card">
                                <label class="text-muted small">Charge Bear By</label>
                                <h6 class="mb-0">{{ $requisition->charge_bear_by ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <label class="text-muted small">Charge Amount</label>
                                <h6 class="mb-0">${{ number_format($requisition->charge_amount ?? 0, 2) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <label class="text-muted small">Total Cost</label>
                                <h6 class="mb-0 fw-bold">${{ number_format($requisition->total_cost ?? 0, 2) }}</h6>
                            </div>
                        </div>
                    </div>

                    @if($requisition->vendor)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="info-card">
                                <label class="text-muted small">Vendor</label>
                                <h6 class="mb-0">{{ $requisition->vendor->vendor_name }}</h6>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($requisition->remarks)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-card">
                                <label class="text-muted small">Remarks</label>
                                <p class="mb-0">{{ $requisition->remarks }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approval Actions -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-dark text-white d-flex align-items-center">
                    <i class="fa-solid fa-gavel me-2"></i>
                    <h5 class="mb-0">Approval Actions</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Status</label>
                        <div class="d-block">
                            <span class="badge bg-warning badge-lg">{{ $requisition->status }}</span>
                        </div>
                    </div>
<hr>
                    @if($requisition->status == 'Pending Approval')
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-sm fw-bold" onclick="approveRequisition({{ $requisition->id }})">
                            <i class="fa fa-check-circle me-2"></i> Approve Requisition
                        </button>
                        <button type="button" class="btn btn-danger btn-sm fw-bold" onclick="rejectRequisition({{ $requisition->id }})">
                            <i class="fa fa-times-circle me-2"></i> Reject Requisition
                        </button>
                    </div>
                    @elseif($requisition->status == 'Approved')
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle me-1"></i> This requisition has been approved.
                        @if($requisition->approvedBy)
                            <br><small class="text-muted">By: {{ $requisition->approvedBy->name }}</small>
                        @endif
                        @if($requisition->approved_at)
                            <br><small class="text-muted">On: {{ date('d M, Y H:i', strtotime($requisition->approved_at)) }}</small>
                        @endif
                    </div>
                    @elseif($requisition->status == 'Rejected')
                    <div class="alert alert-danger">
                        <i class="fa fa-times-circle me-1"></i> This requisition has been rejected.
                    </div>
                    @endif
                </div>
            </div>
<br>
            @if($requisition->items->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-list me-2"></i> Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisition->items as $item)
                            <tr>
                                <td>{{ $item->category->category_name ?? 'N/A' }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Parts Cost:</strong></td>
                                <td><strong>${{ number_format($requisition->total_parts_cost ?? 0, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</section>

<!-- Reject Modal -->
<div class="modal" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="rejectModalLabel">
                    <i class="fa fa-times-circle me-2"></i>Reject Requisition
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rejection Remarks <span class="text-danger">*</span></label>
                        <textarea name="remarks" class="form-control" rows="4" required placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-check me-1"></i> Confirm Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="approveModalLabel">
                    <i class="fa fa-check-circle me-2"></i>Approve Requisition
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approveForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Approval Remarks (Optional)</label>
                        <textarea name="remarks" class="form-control" rows="4" placeholder="Add any notes for approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check me-1"></i> Confirm Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
var maintenanceApprovalBaseUrl = '{{ route('maintenance_approvals.index') }}';
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Approve button click (modal form)
    $('#approveForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to approve this maintenance requisition?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            backdrop: 'rgba(0, 0, 0, 0.5)',
            customClass: {
                confirmButton: 'btn btn-success px-4',
                cancelButton: 'btn btn-secondary px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('maintenance_approvals.approve', $requisition->id) }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Approved!', response.message, 'success')
                                .then(() => window.location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
        
        return false;
    });

    // Reject button click (modal form)
    $('#rejectForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to reject this maintenance requisition?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it!',
            cancelButtonText: 'No, keep it',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            backdrop: 'rgba(0, 0, 0, 0.5)',
            customClass: {
                confirmButton: 'btn btn-danger px-4',
                cancelButton: 'btn btn-secondary px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('maintenance_approvals.reject', $requisition->id) }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Rejected!', response.message, 'success')
                                .then(() => window.location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
        
        return false;
    });
});

// Global function for approve with SweetAlert (from action buttons)
function approveRequisition(id) {
    Swal.fire({
        title: 'Confirm Approval',
        text: 'Are you sure you want to approve this maintenance requisition?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Approve',
        cancelButtonText: 'No, Cancel',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        backdrop: 'rgba(0, 0, 0, 0.5)',
        customClass: {
            confirmButton: 'btn btn-success px-4',
            cancelButton: 'btn btn-secondary px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: maintenanceApprovalBaseUrl + '/' + id + '/approve',
                method: 'POST',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Approved!', response.message, 'success')
                            .then(() => window.location.reload());
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            });
        }
    });
}

// Global function for reject with SweetAlert input (from action buttons)
function rejectRequisition(id) {
    Swal.fire({
        title: 'Reject Requisition',
        text: 'Please provide a reason for rejection:',
        icon: 'warning',
        input: 'textarea',
        inputLabel: 'Rejection Remarks',
        inputPlaceholder: 'Enter your rejection reason here...',
        inputAttributes: {
            'required': 'true',
            'rows': '3'
        },
        showCancelButton: true,
        confirmButtonText: 'Yes, Reject',
        cancelButtonText: 'No, Keep',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        backdrop: 'rgba(0, 0, 0, 0.5)',
        customClass: {
            confirmButton: 'btn btn-danger px-4',
            cancelButton: 'btn btn-secondary px-4',
            input: 'form-control'
        },
        preConfirm: (remarks) => {
            if (!remarks || remarks.trim() === '') {
                Swal.showValidationMessage('<i class="fa fa-exclamation-circle"></i> Please provide rejection remarks');
                return false;
            }
            return remarks;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: maintenanceApprovalBaseUrl + '/' + id + '/reject',
                method: 'POST',
                data: { remarks: result.value },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Rejected!', response.message, 'success')
                            .then(() => window.location.reload());
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            });
        }
    });
}

function approveRequisitionWithModal(id) {
    $('#approveModal').modal('show');
}

function showRejectModal() {
    $('#rejectModal').modal('show');
}
</script>
@endsection
