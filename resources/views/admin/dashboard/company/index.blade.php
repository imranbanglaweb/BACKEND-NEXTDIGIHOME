@extends('admin.dashboard.master')

@section('title','Company Management')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #f8f9fa;">
<div class="container-fluid">

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            <i class="fa fa-building text-primary me-2"></i>
            Company Management
        </h3>
        <p class="text-muted mb-0">Manage all tenant companies and their subscriptions</p>
    </div>
    @can('company-manage')
    <button id="openCreateModal" class="btn btn-primary btn-lg">
        <i class="fa fa-plus"></i> Add Company
    </button>
    @endcan
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">Total Companies</h6>
                        <h3 class="mb-0" id="totalCompanies">-</h3>
                    </div>
                    <div style="opacity: 0.5;">
                        <i class="fa fa-building fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">Active</h6>
                        <h3 class="mb-0" id="activeCompanies">-</h3>
                    </div>
                    <div style="opacity: 0.5;">
                        <i class="fa fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">Inactive</h6>
                        <h3 class="mb-0" id="inactiveCompanies">-</h3>
                    </div>
                    <div style="opacity: 0.5;">
                        <i class="fa fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">Total Vehicles</h6>
                        <h3 class="mb-0" id="totalVehicles">-</h3>
                    </div>
                    <div style="opacity: 0.5;">
                        <i class="fa fa-car fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Companies Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white rounded-top-4 py-3">
        <h5 class="mb-0"><i class="fa fa-list me-2"></i>All Companies</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="companies-table" width="100%">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Company Name</th>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Subscription</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Vehicles</th>
                        <th class="px-4 py-3">Created</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

</div>
</section>

{{-- Create/Edit Modal --}}
<div id="companyModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-4">
          <div class="modal-header bg-primary text-white rounded-top-4 py-3">
              <h5 class="modal-title" id="companyModalTitle">Create Company</h5>
              <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <form id="companyForm">
        <div class="modal-body px-4 py-4">
            <div id="formAlert" class="alert alert-danger d-none"></div>
            <input type="hidden" name="id" id="company_id">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Company Name <span class="text-danger">*</span></label>
                        <input type="text" id="company_name" name="company_name" class="form-control form-control-lg" placeholder="Enter company name">
                        <div class="invalid-feedback" id="err_company_name"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Company Code <span class="text-danger">*</span></label>
                        <input type="text" id="company_code" name="company_code" class="form-control form-control-lg" placeholder="Enter company code">
                        <div class="invalid-feedback" id="err_company_code"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-light rounded-bottom-4 px-4 py-3">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" id="saveCompanyBtn" class="btn btn-primary rounded-pill px-4">
                <i class="fa fa-save me-1"></i> Save
            </button>
        </div>
    </form>
      </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
.table th, .table td {
    vertical-align: middle;
    font-size: 14px;
}
.modal-backdrop { background-color: rgba(0, 0, 0, 0.5); }
.action-btns .btn { margin-right: 4px; }
.invalid-feedback i { margin-right:6px; color:#c0392b; }
#companyForm input { height: 50px; font-size: 15px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){

  $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         'X-Requested-With': 'XMLHttpRequest'
     }
  });

  $('.modal .close').on('click', function () {
    $(this).closest('.modal').modal('hide');
  });

  // DataTable
  var table = $('#companies-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('admin.company.data') }}",
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'px-4' },
          { data: 'company_name', name: 'company_name' },
          { data: 'company_code', name: 'company_code' },
          { data: 'subscription', name: 'subscription', searchable: false },
          { data: 'status', name: 'status', searchable: false },
          { data: 'vehicles_count', name: 'vehicles_count', searchable: false },
          { data: 'created_at', name: 'created_at' },
          { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-end px-4' }
      ],
      order: [[1, 'asc']],
      responsive: true,
      pageLength: 10
  });

  // Load stats
  loadStats();

  function loadStats() {
      $.get("{{ route('admin.company.stats') }}", function(res) {
          $('#totalCompanies').text(res.total || 0);
          $('#activeCompanies').text(res.active || 0);
          $('#inactiveCompanies').text(res.inactive || 0);
          $('#totalVehicles').text(res.vehicles || 0);
      });
  }

  // Open Create Modal
  $('#openCreateModal').on('click', function(){
      clearForm();
      $('#companyModalTitle').text('Create Company');
      $('#companyModal').modal('show');
  });

  // Open Edit Modal
  $(document).on('click', '.editCompany', function(){
      clearForm();
      $('#company_id').val($(this).data('id'));
      $('#company_name').val($(this).data('name'));
      $('#company_code').val($(this).data('code'));
      $('#companyModalTitle').text('Edit Company');
      $('#companyModal').modal('show');
  });

  // Save Company
  $('#companyForm').on('submit', function(e){
      e.preventDefault();
      clearErrors();
      var formData = {
          id: $('#company_id').val(),
          company_name: $('#company_name').val(),
          company_code: $('#company_code').val()
      };
      $('#saveCompanyBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving');
      $.ajax({
          url: "{{ route('admin.company.store') }}",
          type: "POST",
          data: formData,
          success: function(res){
              $('#companyModal').modal('hide');
              $('#saveCompanyBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
              Swal.fire({ icon: 'success', title: 'Success', text: 'Company saved successfully', timer: 1800, showConfirmButton: false });
              table.ajax.reload(null, false);
              loadStats();
          },
          error: function(xhr){
              $('#saveCompanyBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
              if(xhr.status === 422){
                  let errors = xhr.responseJSON.errors;
                  $.each(errors, function(key,value){
                      $('#err_'+key).html('<i class="fa fa-times-circle"></i> '+value).show();
                      $('#'+key).addClass('is-invalid');
                  });
              } else {
                  Swal.fire('Error','Something went wrong','error');
              }
          }
      });
  });

  // Delete Company
  $(document).on('click','.deleteCompany', function(){
      let id = $(this).data('id');
      let url = "{{ route('admin.company.destroy', ':id') }}".replace(':id', id);
      Swal.fire({
          title: 'Are you sure?',
          text: 'This company will be permanently deleted!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!'
      }).then((result)=>{
          if(result.isConfirmed){
              $.ajax({
                  url: url,
                  type: "DELETE",
                  success: function(res){
                      Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message || 'Company deleted successfully', timer: 1800, showConfirmButton: false });
                      table.ajax.reload(null, false);
                      loadStats();
                  },
                  error: function(){
                      Swal.fire('Error','Delete failed','error');
                  }
              });
          }
      });
  });

  // Deactivate Company
  $(document).on('click','.deactivateCompany', function(){
      let id = $(this).data('id');
      let url = "{{ route('admin.company.deactivate', ':id') }}".replace(':id', id);
      Swal.fire({
          title: 'Deactivate Company?',
          text: 'This company will be deactivated!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#f39c12',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, deactivate!'
      }).then((result)=>{
          if(result.isConfirmed){
              $.post(url, {_method: 'POST'}, function(res){
                  Swal.fire({ icon: 'success', title: 'Deactivated!', text: res.message, timer: 1800, showConfirmButton: false });
                  table.ajax.reload(null, false);
                  loadStats();
              }).fail(function(){
                  Swal.fire('Error','Action failed','error');
              });
          }
      });
  });

  // Reactivate Company
  $(document).on('click','.reactivateCompany', function(){
      let id = $(this).data('id');
      let url = "{{ route('admin.company.reactivate', ':id') }}".replace(':id', id);
      Swal.fire({
          title: 'Reactivate Company?',
          text: 'This company will be reactivated!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#27ae60',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, reactivate!'
      }).then((result)=>{
          if(result.isConfirmed){
              $.post(url, {_method: 'POST'}, function(res){
                  Swal.fire({ icon: 'success', title: 'Reactivated!', text: res.message, timer: 1800, showConfirmButton: false });
                  table.ajax.reload(null, false);
                  loadStats();
              }).fail(function(){
                  Swal.fire('Error','Action failed','error');
              });
          }
      });
  });

  function clearForm(){
      $('#companyForm')[0].reset();
      $('#company_id').val('');
      clearErrors();
      $('#formAlert').hide().empty();
  }

  function clearErrors(){
      $('.invalid-feedback').hide().empty();
      $('.form-control').removeClass('is-invalid');
  }

});
</script>
@endsection
