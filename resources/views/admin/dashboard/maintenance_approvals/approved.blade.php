@extends('admin.dashboard.master')

<style>
body { background:#ffffff !important; }
.content-body { padding:20px 25px !important; }
.card { border-radius:12px; }
</style>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@section('main_content')
<section role="main" class="content-body">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">
            <i class="fa-solid fa-check-circle me-2 text-success"></i> Approved Maintenance Requisitions
        </h3>
        <a href="{{ route('maintenance_approvals.index') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to Pending Approvals
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="approvedTable" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Req No</th>
                            <th>Vehicle</th>
                            <th>Requested By</th>
                            <th>Total Cost</th>
                            <th>Approved At</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</section>

<script>
$(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var table = $('#approvedTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        searching: false,

        ajax: {
            url: "{{ route('maintenance_approvals.approved.ajax') }}",
            data: function(d) {
                d.search_text = $('#searchBox').val();
            }
        },

        columns: [
            { data: 'requisition_no', name: 'requisition_no' },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'employee', name: 'employee' },
            { data: 'total_cost', name: 'total_cost' },
            { data: 'approved_at', name: 'approved_at' },
            { data: 'status_badge', name: 'status', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],

        order: [[4, 'desc']]
    });

    $('#btnFilter').click(function() {
        table.ajax.reload();
    });
});
</script>
@endsection
