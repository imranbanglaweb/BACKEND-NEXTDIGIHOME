@extends('admin.dashboard.master')

<style>
body { background:#ffffff !important; }
.content-body { padding:20px 25px !important; }
.card { border-radius:12px; }
.filter-bar .form-control, .filter-bar .form-select { height:40px; font-size:14px; }
.table thead th { text-align:center; vertical-align:middle !important; }
.table tbody td { vertical-align:middle !important; }
table.dataTable tbody tr:hover { filter: brightness(0.97); }
</style>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@section('main_content')
<section role="main" class="content-body">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">
            <i class="fa-solid fa-wrench me-2"></i> Maintenance Approval Panel
        </h3>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <!-- Filter Bar -->
            <div class="row g-2 align-items-end mb-3 filter-bar">
                <div class="col-md-3">
                    <label class="form-label">Search Requisition</label>
                    <input type="text" id="searchBox" class="form-control" placeholder="Enter requisition number or service title">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Priority</label>
                    <select id="filterPriority" class="form-select">
                        <option value="">All</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select id="filterType" class="form-select">
                        <option value="">All</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="emergency">Emergency</option>
                        <option value="routine">Routine</option>
                        <option value="insurance">Insurance</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" id="dateFrom" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" id="dateTo" class="form-control">
                </div>

                <div class="col-md-1">
                    <button id="btnFilter" class="btn btn-primary w-100">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>

            <hr>

            <!-- Table -->
            <div class="table-responsive">
                <table id="maintenanceApprovalTable" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Req No</th>
                            <th>Vehicle</th>
                            <th>Requested By</th>
                            <th>Type</th>
                            <th>Priority</th>
                            <th>Total Cost</th>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
$(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var table = $('#maintenanceApprovalTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        searching: false,

        ajax: {
            url: "{{ route('maintenance_approvals.ajax') }}",
            data: function(d) {
                d.priority = $('#filterPriority').val();
                d.type = $('#filterType').val();
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
                d.search_text = $('#searchBox').val();
            }
        },

        columns: [
            { data: 'requisition_no', name: 'requisition_no' },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'employee', name: 'employee' },
            { data: 'type', name: 'type' },
            { data: 'priority', name: 'priority', orderable: false },
            { data: 'total_cost', name: 'total_cost' },
            { data: 'status_badge', name: 'status', orderable: false, searchable: false },
            // { data: 'created_at', render: function(d) { return d ? moment(d).format('DD MMM Y, hh:mm A') : ''; }},
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],

        order: [[7, 'desc']]
    });

    $('#btnFilter').click(function() {
        table.ajax.reload();
    });

    $('#btnReset').click(function() {
        $('.filter-bar select, .filter-bar input').val('');
        table.ajax.reload();
    });
});
</script>
@endsection
