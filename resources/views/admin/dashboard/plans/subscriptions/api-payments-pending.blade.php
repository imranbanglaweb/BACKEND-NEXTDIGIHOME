@extends('admin.dashboard.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .table th, .table td { vertical-align: middle !important; font-size: 14px; }
    .premium-modal .modal-content { border-radius: 15px; border: none; }
</style>
@endpush

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid py-4">
        <h4 class="fw-bold mb-4">
            <i class="fa-solid fa-clock text-warning"></i> Pending API Payments
        </h4>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table id="paymentsTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Company</th>
                            <th>Customer</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Transaction ID</th>
                            <th>Sender</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- APPROVE MODAL -->
<div class="modal" id="approveModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-check-circle text-success"></i> Approve Payment</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Confirm payment approval. This will activate the subscription.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="confirmApprove">Approve</button>
            </div>
        </div>
    </div>
</div>

<!-- REJECT MODAL -->
<div class="modal" id="rejectModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fa fa-times-circle"></i> Reject Payment</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to reject this payment?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" id="confirmReject">Reject</button>
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
        ajax: "{{ route('admin.api-payments.pending') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company' },
            { data: 'customer', orderable: false },
            { data: 'plan' },
            { data: 'amount' },
            { data: 'method', orderable: false },
            { data: 'transaction_id' },
            { data: 'sender_number' },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});

$(document).on('click', '.approveBtn', function() {
    paymentId = $(this).data('id');
    $('#approveModal').modal('show');
});

$('#confirmApprove').click(function() {
    $.post("{{ url('admin/api-payments/approve') }}/" + paymentId, {
        _token: '{{ csrf_token() }}'
    }, function(response) {
        if(response.success) {
            $('#approveModal').modal('hide');
            $('#paymentsTable').DataTable().ajax.reload(null, false);
            alert('Payment approved successfully!');
        }
    });
});

$(document).on('click', '.rejectBtn', function() {
    paymentId = $(this).data('id');
    $('#rejectModal').modal('show');
});

$('#confirmReject').click(function() {
    $.post("{{ url('admin/api-payments/reject') }}/" + paymentId, {
        _token: '{{ csrf_token() }}'
    }, function(response) {
        if(response.success) {
            $('#rejectModal').modal('hide');
            $('#paymentsTable').DataTable().ajax.reload(null, false);
            alert('Payment rejected successfully!');
        }
    });
});
</script>
@endpush