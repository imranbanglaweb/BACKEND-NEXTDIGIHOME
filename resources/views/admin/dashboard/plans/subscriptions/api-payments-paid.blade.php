@extends('admin.dashboard.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .table th, .table td { vertical-align: middle !important; font-size: 14px; }
</style>
@endpush

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid py-4">
        <h4 class="fw-bold mb-4">
            <i class="fa-solid fa-check-circle text-success"></i> Paid API Payments
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
                            <th>Paid At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(function () {
    $('#paymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.api-payments.paid') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'company' },
            { data: 'customer', orderable: false },
            { data: 'plan' },
            { data: 'amount' },
            { data: 'method', orderable: false },
            { data: 'transaction_id' },
            { data: 'paid_at' }
        ]
    });
});
</script>
@endpush