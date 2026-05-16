@extends('admin.dashboard.master')

@section('main_content')



<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>



<section role="main" class="content-body" style="background-color:#fff;">

<div class="d-flex justify-content-between">
	<br>
    <h3>Drivers Manage</h3>
    <div>
        @can('driver-manage')
        <a href="{{ route('drivers.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create Driver </a>
        @endcan
       
    </div>
</div>
<br>
<hr>

<table class="table table-striped" id="drivers-table">
    <thead>
        <tr>
            <th>SL</th>
            <th>Photo</th>
			<th>Driver Name</th>
			<th>Employee Code</th>
			<th>Unit</th>
			<th>Department</th>
			<th>License Number</th>
			<th>License Type</th>
			<th>Mobile</th>
			<th width="8%">Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

</section>



<script>
$(function(){

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        }
    });

    var table = $('#drivers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('drivers.data') }}",
        columns:[
             { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
    { data: 'photo', name: 'photo', orderable:false, searchable:false },
    { data: 'driver_name', name: 'driver_name' },
    { data: 'employee_code', name: 'employee_code' },
    { data: 'unit_name', name: 'unit_name' },
    { data: 'department_name', name: 'department_name' },
    { data: 'license_number', name: 'license_number' },
    { data: 'license_type_name', name: 'license_type_name' },
    { data: 'mobile', name: 'mobile' },
    { data: 'action', name: 'action', orderable:false, searchable:false }
        ],
        order:[[1, 'asc']],
        responsive:true,
        pageLength:10
    });

    $('#refresh-table').click(()=> table.ajax.reload(null,false));
    $('#table-search').keyup(function(){ table.search(this.value).draw(); });

    // DELETE — WITH SWEETALERT2
    $(document).on('click','.deleteUser', function(){
        let id = $(this).data('did');

        Swal.fire({
            title:"Are you sure?",
            text:"This driver will be deleted.",
            icon:"warning",
            showCancelButton:true,
            confirmButtonText:"Yes, Delete"
        }).then(result=>{
            if(result.isConfirmed){
                $.ajax({
                    url: "{{ route('drivers.index') }}/" + id,
                    type:"POST",
                    data:{ _method:'DELETE' }
                })
                .done(res=>{
                    showToast("Driver deleted","success");
                    table.ajax.reload(null,false);
                })
                .fail(()=>{
                    showToast("Delete failed","error");
                });
            }
        });
    });

    // Toast helper
    function showToast(message, type="success"){
        const Toast = Swal.mixin({
            toast:true, position:'top-end', timer:3000, showConfirmButton:false
        });
        Toast.fire({ icon:type, title:message });
    }

});
</script>


@endsection
