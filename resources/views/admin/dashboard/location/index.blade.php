@extends('admin.dashboard.master')

@section('main_content')

<style>
/* Premium modal and validation tweaks */
.modal-modern .modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
.invalid-feedback i { margin-right:6px; color: #c0392b; }
.ajax-success { color: #27ae60; }
.ajax-error { color: #c0392b; }
.action-btns .btn { margin-right:4px; }
.modal-header .close { font-size: 1.4rem; color: #000; opacity: 1; }
.toast-custom {
    position: fixed; right: 20px; top: 20px; z-index: 1060; min-width: 220px;
}
</style>

<section role="main" class="content-body" style="background-color: #ffffff; padding-top: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
<div class="row mb-2">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2>Location Management</h2>
        <div class="pull-right">
            @can('unit-create')
            <button id="openCreateModal" class="btn btn-success"><i class="fa fa-plus"></i> Create Location</button>
            @endcan
         
        </div>
    </div>
  
</div>

<div class="row mt-3">
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="card-body">
        <table class="table table-hover table-striped" id="locations-table" style="width:100%">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>Location Name</th>
              <th>Unit</th>
              <th>Address</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Create/Edit Modal --}}

<div id="locationModal" class="modal modal-modern" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="locationModalTitle">Create Location</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="locationForm">
        <div class="modal-body">
          <div id="formAlert" role="alert" style="display:none;"></div>
          <input type="hidden" name="id" id="location_id">
          <div class="form-group">
            <label>Location Name</label>
            <input type="text" class="form-control" id="location_name" name="location_name">
            <div class="invalid-feedback" id="err_location_name"></div>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" id="address" name="address">
            <div class="invalid-feedback" id="err_address"></div>
          </div>
          <div class="form-group">
            <label>Unit</label>
            <select id="unit_id" name="unit_id" class="form-control">
              <option value="">-- Select Unit --</option>
              @if(!empty($units))
                @foreach($units as $u)
                  <option value="{{ $u->id }}">{{ $u->unit_name }}</option>
                @endforeach
              @endif
            </select>
            <div class="invalid-feedback" id="err_unit_id"></div>
          </div>
        </div>
        <div class="modal-footer border-top-0 justify-content-between">
          <!-- <button type="button" class="btn btn-outline-secondary close" data-dismiss="modal">Close</button> -->
          <button type="submit" id="saveLocationBtn" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<style>
.modal-backdrop { background-color: rgba(0, 0, 0, 0.5); opacity: 1; }
</style>

<style> 
#locations-table thead th { font-weight:600; } 
.table th, .table td {
    vertical-align: middle !important;
    font-size: 15px;
}
</style>


<script>
$(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'X-Requested-With': 'XMLHttpRequest' } });

    var table = $('#locations-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.locations.data') !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'location_name', name: 'location_name' },
            { data: 'unit_name', name: 'unit_name' },
            { data: 'address', name: 'address' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ],
        order: [[1, 'asc']],
        responsive: true,
        lengthChange: true,
        pageLength: 10
    });
 $('.modal .close').on('click', function () {
    $(this).closest('.modal').modal('hide');
});
    $('#table-search').on('keyup change', function(){ table.search(this.value).draw(); });
    $('#refresh-table').on('click', function(){ table.ajax.reload(null,false); });

    function clearForm(){ $('#locationForm')[0].reset(); $('#location_id').val(''); clearErrors(); $('#formAlert').hide().empty(); }
    function clearErrors(){ $('.invalid-feedback').empty().hide(); $('.form-control').removeClass('is-invalid'); }
    
    function showToast(title,message,type){
        var cls = (type==='success')? 'alert-success':'alert-danger';
        var $el = $('<div class="alert '+cls+' toast-custom"><strong>'+title+'</strong><div>'+message+'</div></div>');
        $('body').append($el);
        setTimeout(()=>{$el.fadeOut(400,()=>{$el.remove();});},3000);
    }

    $('#openCreateModal').click(function(){ clearForm(); $('#locationModalTitle').text('Create Location'); $('#locationModal').modal('show'); });

    $(document).on('click', '.editLocation', function(){
        clearForm();
        var id=$(this).data('id'), name=$(this).data('name'), address=$(this).data('address'), unit=$(this).data('unit');
        $('#location_id').val(id); $('#location_name').val(name); $('#address').val(address);
        if(unit){ $('#unit_id option').filter(function(){ return $(this).text()===unit; }).prop('selected',true);}
        $('#locationModalTitle').text('Edit Location'); $('#locationModal').modal('show');
    });

    $('#locationForm').on('submit', function(e){
        e.preventDefault(); clearErrors();
        var data={ id:$('#location_id').val(), unit_id:$('#unit_id').val(), location_name:$('#location_name').val(), address:$('#address').val() };
        $('#saveLocationBtn').prop('disabled',true).html('<i class="fa fa-spinner fa-spin"></i> Saving');

        $.ajax({
            url:'{!! route('admin.locations.store') !!}', type:'POST', data:data,
            success:function(res){
                $('#locationModal').modal('hide');
                $('#saveLocationBtn').prop('disabled',false).html('<i class="fa fa-save"></i> Save');
                showToast('Saved','Location saved successfully','success');
                table.ajax.reload(null,false);
            },
            error:function(xhr){
                $('#saveLocationBtn').prop('disabled',false).html('<i class="fa fa-save"></i> Save');
                if(xhr.status===422 || xhr.status===400){
                    var json=xhr.responseJSON; var errors=json.errors||json;
                    if(Array.isArray(errors)){
                        $('#formAlert').html('<div class="alert alert-danger"><i class="fa fa-times-circle"></i> '+errors.join('<br>')+'</div>').show();
                    }else{
                        $.each(errors,function(key,val){
                            var msg=Array.isArray(val)? val.join('<br>'):val;
                            $('#err_'+key).html('<i class="fa fa-times-circle"></i> '+msg).show();
                            $('#'+key).addClass('is-invalid');
                        });
                    }
                }else{
                    $('#formAlert').html('<div class="alert alert-danger"><i class="fa fa-times-circle"></i> Unexpected server error</div>').show();
                }
            }
        });
    });

    // SweetAlert2 delete
    $(document).on('click','.deleteUser',function(){
        var lid=$(this).data('lid');
        var deleteUrl='{{ route('admin.locations.destroy', ':id') }}'.replace(':id', lid);
        var csrfToken=$('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title:'Are you sure?',
            text:"You won't be able to revert this!",
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#d33',
            cancelButtonColor:'#6c757d',
            confirmButtonText:'Yes, delete it!',
            reverseButtons:true,
            focusCancel:true
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url:deleteUrl,type:'POST',
                    data:{ _method:'DELETE', _token:csrfToken },
                    success:function(res){
                        Swal.fire('Deleted!', res.message || 'Location deleted successfully.','success');
                        table.ajax.reload(null,false);
                    },
                    error:function(xhr){
                        var msg='Delete failed!';
                        if(xhr && xhr.responseJSON && xhr.responseJSON.message) msg=xhr.responseJSON.message;
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });

});
</script>


@endsection
