@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary"><i class="fa fa-tools me-2"></i> 
                @if(isset($canViewOwnOnly) && $canViewOwnOnly)
                    My Maintenance Requisitions
                @else
                    Maintenance Requisitions
                @endif
            </h3>
            <div class="d-flex gap-2">
                @if(!isset($canViewOwnOnly) || !$canViewOwnOnly)
                <a href="{{ route('maintenance_approvals.index') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-check-circle me-1"></i> Pending Approvals
                </a>
                <a href="{{ route('maintenance_approvals.approved') }}" class="btn btn-info btn-sm">
                    <i class="fa fa-list me-1"></i> Approved List
                </a>
                @endif
                @can('maintenance-create')
                <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i> Create New
                </a>
                @endcan
            </div>
        </div>
<br>
<br>
        {{-- Filters --}}
        <div class="row mb-3">
            <div class="col-md-2">
                <input type="text" id="searchRequisitionNo" class="form-control" placeholder="Requisition No">
            </div>
            <div class="col-md-2">
                <input type="text" id="searchVehicle" class="form-control" placeholder="Search Vehicle">
            </div>
            <div class="col-md-2">
                <input type="text" id="searchEmployee" class="form-control" placeholder="Search Employee">
            </div>
            <div class="col-md-2">
                <select id="searchType" class="form-select form-control">
                    <option value="">All Types</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="breakdown">Breakdown</option>
                    <option value="inspection">Inspection</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="searchPriority" class="form-select form-control">
                    <option value="">All Priorities</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Urgent">Urgent</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" id="resetFilters" class="btn btn-secondary w-100">Reset</button>
            </div>
        </div>
<hr>
        {{-- Requisitions Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="requisitionsTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Requisition No</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Vehicle</th>
                        <th>Employee</th>
                        <th>Maintenance Date</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th style="width: 110px;">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

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

@push('scripts')
<script>
$(document).ready(function() {

    let table = $('#requisitionsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        paging: true,
        searching: false,
        autoWidth: false,

        dom: 'Bfrtip',   // Export buttons
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger btn-sm' },
            { extend: 'print', text: 'Print', className: 'btn btn-secondary btn-sm' },
        ],

        ajax: {
            url: '{{ route("maintenance.index") }}',
            data: function(d) {
                d.requisition_no = $('#searchRequisitionNo').val();
                d.vehicle = $('#searchVehicle').val();
                d.employee = $('#searchEmployee').val();
                d.type = $('#searchType').val();
                d.priority = $('#searchPriority').val();
            }
        },

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },

            { data: 'requisition_no', name: 'requisition_no', className: "text-center" },

            { data: 'requisition_type', name: 'requisition_type', className: "text-center" },

            { data: 'priority', name: 'priority', className: "text-center" },

            { data: 'vehicle', name: 'vehicle' },

            { data: 'employee', name: 'employee.name' },

            { data: 'maintenance_date', name: 'maintenance_date', className: "text-center" },

            { data: 'grand_total', name: 'grand_total', className: "text-end" },

            { data: 'status', name: 'status', className: "text-center" },

            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: "text-center" },
        ]
    });

    // Filter events
    $('#searchRequisitionNo, #searchVehicle, #searchEmployee').on('keyup', function() {
        table.draw();
    });

    $('#searchType, #searchPriority').on('change', function() {
        table.draw();
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
        $('#searchRequisitionNo, #searchVehicle, #searchEmployee').val('');
        $('#searchType, #searchPriority').val('');
        table.draw();
    });

    // Submit for approval button click
    $('#requisitionsTable').on('click', '.submitBtn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Submit for Approval?',
            text: 'This requisition will be sent for approval.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, submit!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/approvals/maintenance/' + id + '/submit',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Submitted!', response.message, 'success')
                                .then(() => table.ajax.reload(null, false));
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
    });

      // Delete button click
    $('#requisitionsTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');

    var urlTemplate = '{{ route("maintenance.destroy", "id") }}';
    var deleteURL = urlTemplate.replace('id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the requisition!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    // url: '/maintenance/' + id,
                    url: deleteURL,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        );
                        table.ajax.reload(null, false); // reload DataTable
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong while deleting.',
                            'error'
                        );
                    }
                });
            }
        });
    });

});
</script>
@endpush

@endsection
