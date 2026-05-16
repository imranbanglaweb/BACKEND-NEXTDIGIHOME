@extends('admin.dashboard.master')

<style>
body { background:#ffffff !important; }
.content-body { padding:20px 25px !important; }
.card { border-radius:12px; }
.table thead th { text-align:center; vertical-align:middle !important; }
.table tbody td { vertical-align:middle !important; }
/* Status badges */
tr.status-in_progress  { background-color:#fff9db !important; }
tr.status-completed { background-color:#e6f7ed !important; }
tr.status-cancelled { background-color:#fdecea !important; }
</style>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>


@section('main_content')
<section role="main" class="content-body" style="background:#ffffff; padding:20px; border-radius:8px;">
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">
            <i class="fa fa-route me-2"></i> Trip Sheet Management
        </h3>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <!-- Filters -->
            <div class="row g-2 align-items-end mb-3 filter-bar">
                <div class="col-md-3">
                    <label class="form-label">Search Trip</label>
                    <input type="text" id="searchBox" class="form-control" placeholder="Trip number, vehicle, driver">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
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
                <div class="col-md-3">
                    <button id="btnFilter" class="btn btn-primary btn-sm">
                        <i class="fa fa-filter me-1"></i> Apply Filters
                    </button>
                    <button id="btnReset" class="btn btn-outline-secondary btn-sm">
                        Reset
                    </button>
                </div>
            </div>
            <hr>

            <!-- Table -->
            <div class="table-responsive">
                <table id="tripSheetTable" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Trip No</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN':'{{ csrf_token() }}' } });

    var table = $('#tripSheetTable').DataTable({
        processing:true,
        serverSide:true,
        responsive:true,
        autoWidth:false,
        searching: false,
        ajax:{
            url:"{{ route('trip-sheets.data') }}",
            data:function(d){
                d.status = $('#filterStatus').val();
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
                d.search_text = $('#searchBox').val();
            }
        },
        columns:[
            {data:'trip_number', name:'trip_number'},
            {data:'vehicle', name:'vehicle'},
            {data:'driver', name:'driver'},
            {data:'start_date', name:'start_date'},
            {data:'end_date', name:'end_date'},
            {data:'status', name:'status', orderable:false, searchable:false},
            {data:'action', name:'action', orderable:false, searchable:false, className:'text-center'}
        ],
        order:[[0,'desc']],
        createdRow:function(row,data){
            let s=(data.status||'').toLowerCase();
            if(s==='in_progress')  $(row).addClass('status-in_progress');
            if(s==='completed') $(row).addClass('status-completed');
            if(s==='cancelled') $(row).addClass('status-cancelled');
        }
    });

    function statusBadge(val){
        if(!val) return '';
        let v=val.toLowerCase(), cls='bg-secondary';
        if(v==='in_progress') cls='bg-warning text-dark';
        if(v==='completed') cls='bg-success';
        if(v==='cancelled') cls='bg-danger';
        return `<span class="badge ${cls}">${val}</span>`;
    }

    $('#btnFilter').click(()=>table.ajax.reload());
    $('#btnReset').click(()=>{
        $('.filter-bar select, .filter-bar input').val('');
        table.ajax.reload();
    });
});
</script>


@endsection
