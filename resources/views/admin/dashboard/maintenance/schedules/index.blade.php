@extends('admin.dashboard.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>
@endpush

@section('main_content')
<section role="main" class="content-body" style="background-color:#f8f9fa;">
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">
            <i class="fa fa-tools me-2"></i> Maintenance Schedules
        </h4>
        <a href="{{ route('maintenance.schedules.create') }}" class="btn btn-primary btn-sm shadow">
            <i class="fa fa-plus"></i> Add New
        </a>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label fw-bold">Vehicle</label>
                    <select id="filter_vehicle" class="form-control select2">
                        <option value="">All Vehicles</option>
                        @foreach($vehicles as $v)
                            <option value="{{ $v->id }}">{{ $v->vehicle_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Maintenance Type</label>
                    <select id="filter_type" class="form-control select2">
                        <option value="">All Types</option>
                        @foreach($types as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select id="filter_status" class="form-control">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button id="filterBtn" class="btn btn-dark w-100 shadow">
                        <i class="fa fa-search"></i> Apply Filters
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="scheduleTable" class="table table-striped table-bordered w-100 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Vehicle</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Scheduled</th>
                        <th>Next Due</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
</section>

@push('scripts')
<script>
$(document).ready(function() {

    let table = $('#scheduleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('maintenance.schedules.server') }}",
            data: function (d) {
                d.vehicle_id = $('#filter_vehicle').val();
                d.maintenance_type_id = $('#filter_type').val();
                d.status = $('#filter_status').val();
            }
        },
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'title', name: 'title' },
            { data: 'type', name: 'type' },
            { data: 'scheduled_at', name: 'scheduled_at' },
            { data: 'next_due_date', name: 'next_due_date' },
            { data: 'active_status', name: 'active_status', orderable:false, searchable:false },
            { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'text-end' }
        ]
    });

    // Reload table on filter
    $("#filterBtn").click(function() {
        table.ajax.reload();
    });

    // SweetAlert Delete Action
    $(document).on('click', '.deleteBtn', function(){
        let id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "This record will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, Delete!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/maintenance-schedules/${id}`,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function() {
                        Swal.fire("Deleted!", "Record removed successfully.", "success");
                        table.ajax.reload();
                    }
                });
            }
        });
    });

});
</script>
@endpush

@endsection
