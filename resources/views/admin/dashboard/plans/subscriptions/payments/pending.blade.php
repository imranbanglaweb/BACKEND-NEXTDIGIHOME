@extends('admin.dashboard.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
    
    /* Custom Modal Styles - Premium Look */
    .premium-modal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }
    
    .premium-modal .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 25px;
    }
    
    .premium-modal .modal-body {
        padding: 30px 25px;
    }
    
    .premium-modal .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 15px 25px;
    }
    
    .modal-backdrop {
        background-color: #fff !important;
    }
    
    .modal-backdrop.show {
        opacity: 0.8 !important;
    }
</style>
@endpush

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid py-4">

<h4 class="fw-bold mb-4">
    <i class="fa-solid fa-clock text-warning"></i> Pending Manual Payments
</h4>

<div class="card border-0 shadow-sm">
<div class="card-body">

<table id="paymentsTable" class="table table-hover align-middle w-100">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Company</th>
            <th>Plan</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Requested At</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
</table>

</div>
</div>

</div>
</section>

<!-- APPROVE MODAL -->
<div class="modal premium-modal" id="approveModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">
            <i class="fa fa-check-circle text-success me-2"></i>Approve Payment
        </h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body text-center py-4">
        <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
            <i class="fa fa-check text-success" style="font-size:36px;"></i>
        </div>
        <h5 class="fw-bold mb-2">Confirm Payment Approval</h5>
        <p class="text-muted">This will activate the subscription for this company.</p>
    </div>
    <div class="modal-footer bg-light">
        <button class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
        <button class="btn btn-success px-4" id="confirmApprove">
            <i class="fa fa-check me-2"></i>Approve
        </button>
    </div>
</div>
</div>
</div>

<!-- REJECT CONFIRM MODAL -->
<div class="modal premium-modal" id="rejectModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold text-danger">
            <i class="fa fa-times-circle me-2"></i>Reject Payment
        </h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body text-center py-4">
        <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
            <i class="fa fa-times text-danger" style="font-size:36px;"></i>
        </div>
        <h5 class="fw-bold mb-2">Reject This Payment?</h5>
        <p class="text-muted">This action cannot be undone.</p>
    </div>
    <div class="modal-footer bg-light">
        <button class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
        <button class="btn btn-danger px-4" id="confirmReject">
            <i class="fa fa-times me-2"></i>Reject
        </button>
    </div>
</div>
</div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal premium-modal" id="successModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-body text-center py-5">
        <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, #10b981 0%, #059669 100%); margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
            <i class="fa fa-check text-white" style="font-size:40px;"></i>
        </div>
        <h5 class="fw-bold">Payment Approved!</h5>
        <p class="text-muted mb-4">
            The subscription has been activated successfully.
        </p>
        <button class="btn btn-success px-4" data-bs-dismiss="modal">
            OK
        </button>
    </div>
</div>
</div>
</div>

<!-- REJECT SUCCESS MODAL -->
<div class="modal premium-modal" id="rejectSuccessModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-body text-center py-5">
        <div style="width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%); margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
            <i class="fa fa-times text-white" style="font-size:40px;"></i>
        </div>
        <h5 class="fw-bold">Payment Rejected</h5>
        <p class="text-muted">The payment has been rejected successfully.</p>
        <button class="btn btn-danger px-4" data-bs-dismiss="modal">
            OK
        </button>
    </div>
</div>
</div>
</div>

@endsection

@push('scripts')
<script>
let paymentId = null;

$(function () {
    $('#paymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payments.pending') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'company' },
            { data: 'plan', orderable:false },
            { data: 'amount' },
            { data: 'method', orderable:false },
            { data: 'created_at' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });
});

// Approve button click
$(document).on('click','.approveBtn',function(){
    paymentId = $(this).data('id');
    $('#approveModal').modal('show');
});

$('#confirmApprove').click(function(){
    $.post("{{ url('admin/payments/approve') }}/" + paymentId, {
        _token: '{{ csrf_token() }}'
    }, function () {

        // Close confirm modal
        $('#approveModal').modal('hide');

        // Reload table
        $('#paymentsTable').DataTable().ajax.reload(null, false);

        // Show success modal
        setTimeout(function(){
            $('#successModal').modal('show');
        }, 300);
    });
});

$('#successModal').on('shown.bs.modal', function () {
    setTimeout(() => {
        $('#successModal').modal('hide');
    }, 2000);
});

// reject route
$(document).on('click','.rejectBtn',function(){
    rejectPaymentId = $(this).data('id');
    $('#rejectModal').modal('show');
});

$('#confirmReject').click(function(){
    $.post("{{ route('admin.payments.reject','') }}/" + rejectPaymentId, {
        _token:'{{ csrf_token() }}'
    }, function () {

        $('#rejectModal').modal('hide');
        $('#paymentsTable').DataTable().ajax.reload(null,false);

        setTimeout(function(){
            $('#rejectSuccessModal').modal('show');
        }, 300);
    });
});
</script>
@endpush
