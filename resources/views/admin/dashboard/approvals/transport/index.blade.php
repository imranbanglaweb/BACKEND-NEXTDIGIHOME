@extends('admin.dashboard.master')

<style>
body { background:#ffffff !important; }

.content-body { padding:20px 25px !important; }

.card { border-radius:12px; }

/* Filter alignment */
.filter-bar .form-control,
.filter-bar .form-select {
    height:40px;
    font-size:14px;
}

/* Table styling */
.table thead th {
    text-align:center;
    vertical-align:middle !important;
}
.table tbody td {
    vertical-align:middle !important;
}

table.dataTable tbody tr:hover {
    filter: brightness(0.97);
}

/* 🎨 Row colors by Transport Status */
tr.status-pending  { background-color:#fff9db !important; }
tr.status-busy     { background-color:#e7f1ff !important; }
tr.status-assigned { background-color:#f1f3f5 !important; }
tr.status-approved { background-color:#e6f7ed !important; }
tr.status-rejected { background-color:#fdecea !important; }
</style>


<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>


@section('main_content')
<section role="main" class="content-body">
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">
            <i class="fa-solid fa-truck-moving me-2"></i> Transport Approval Panel
        </h3>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">

            <!-- 🔍 FILTER BAR -->
            <div class="row g-2 align-items-end mb-3 filter-bar">

                <div class="col-md-2">
                    <label class="form-label">Search Requisition</label>
                    <input type="text" id="searchBox" class="form-control" placeholder="Enter requisition number">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Department</label>
                    <select id="filterDepartment" class="form-select">
                        <option value="">All</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Transport Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Assigned">Assigned</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <div class="d-flex gap-2">
                        <input type="date" id="dateFrom" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <div class="d-flex gap-2">
                        <input type="date" id="dateTo" class="form-control">
                    </div>
                </div>

               
            </div>
  <div class="col-12 mt-2">
                    <button id="btnFilter" class="btn btn-primary btn-sm">
                        <i class="fa fa-filter me-1"></i> Apply Filters
                    </button>
                    <button id="btnReset" class="btn btn-outline-secondary btn-sm">
                        Reset
                    </button>
                </div>
            <hr>

            <!-- 📋 FULL WIDTH TABLE -->
            <div class="table-responsive">
                <table id="transportTable" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Req No</th>
                            <th>Requested By</th>
                            <th>Department</th>
                            <th>Passengers</th>
                            <th>Dept Status</th>
                            <th>Transport Status</th>
                            <th>Created At</th>
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

    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN':'{{ csrf_token() }}' } });

    var table = $('#transportTable').DataTable({
        processing:true,
        serverSide:true,
        responsive:true,
        autoWidth:false,
        searching: false, 

        ajax:{
            url:"{{ route('transport.approvals.ajax') }}",
            data:function(d){
                d.department_id = $('#filterDepartment').val();
                d.status = $('#filterStatus').val();
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
                d.search_text = $('#searchBox').val();
            }
        },

        columns:[
            {data:'requisition_number'},
            {data:'requested_by'},
            {data:'department'},
            {data:'number_of_passenger', render:d=>`<span class="badge bg-success">${d||0}</span>`},
            {data:'department_status', render:d=>statusBadge(d)},
            {data:'transport_status', render:d=>statusBadge(d)},
            {data:'created_at', render:function(d){ return d ? moment(d).format('DD MMM Y, hh:mm A') : ''; }},
            { data: 'action', orderable:false, searchable:false, className:'text-center' }
        ],

        order:[[6,'desc']],

        createdRow:function(row,data){
            let s=(data.transport_status||'').toLowerCase();
            if(s==='pending')  $(row).addClass('status-pending');
            if(s==='busy')     $(row).addClass('status-busy');
            if(s==='assigned') $(row).addClass('status-assigned');
            if(s==='approved') $(row).addClass('status-approved');
            if(s==='rejected') $(row).addClass('status-rejected');
        }
    });

    function statusBadge(val){
        if(!val) return '';
        let v=val.toLowerCase(), cls='bg-secondary';
        if(v==='pending') cls='bg-warning text-dark';
        if(v==='busy') cls='bg-info text-dark';
        if(v==='assigned') cls='bg-secondary';
        if(v==='approved') cls='bg-success';
        if(v==='rejected') cls='bg-danger';
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
