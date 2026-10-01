@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid">
<br>

<h4 class="fw-bold mb-3 text-success">
    <i class="bi bi-check-circle-fill"></i> Paid Payments
</h4>

<div class="card shadow-sm border-0">
<div class="card-body">

<table class="table table-hover align-middle" id="paymentsTable">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Company</th>
    <th>Plan</th>
    <th>Amount</th>
    <th>Method</th>
    <th>Paid At</th>
    <th>Status</th>
    <th>Invoice</th>
</tr>
</thead>
</table>


</div>
</div>
</div>
</section>
@push('scripts')
<script>
$(function () {
    $('#paymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payments.paid.data') }}",
        order: [[5, 'desc']],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'company', name: 'company.name' },
            { data: 'plan', name: 'plan.name', orderable: false },
            { data: 'amount', name: 'amount' },
            { data: 'method', name: 'method' },
            { data: 'paid_at', name: 'updated_at' },
            { data: 'status', orderable: false, searchable: false },
            { data: 'invoice', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush

@endsection
