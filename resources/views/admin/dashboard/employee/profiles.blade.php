@extends('admin.dashboard.master')

@section('main_content')

<style>
.badge-hod {
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
}
</style>

<section role="main" class="content-body" style="background-color: #fff;">

<div class="row">
<div class="col-lg-12">

<div class="pull-left">
  <br>
  <h2>Employee Profiles</h2>
</div>

<section class="panel">
  <header class="panel-heading"></header>

  <div class="panel-body">
    <table class="table table-bordered table-striped" id="profilesTable" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Photo</th>
          <th>Employee Code</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Unit</th>
          <th>Department</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $key => $employee)
        <tr>
          <td>{{ $key + 1 }}</td>
          <td>
            @if($employee->photo)
              <img src="{{ asset($employee->photo) }}" alt="{{ $employee->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @else
              <img src="{{ asset('public/admin_resource/img/avatar.png') }}" alt="No Photo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            @endif
          </td>
          <td>{{ $employee->employee_code ?? '-' }}</td>
          <td>{{ $employee->name }}</td>
          <td>{{ $employee->email ?? '-' }}</td>
          <td>{{ $employee->phone ?? '-' }}</td>
          <td>{{ $employee->unit->unit_name ?? '-' }}</td>
          <td>{{ $employee->department->department_name ?? '-' }}</td>
          <td>
            @if($employee->status == 'Active')
              <span class="badge bg-success">Active</span>
            @else
              <span class="badge bg-danger">Inactive</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>

</div>
</div>
</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script>
$(function () {
    $('#profilesTable').DataTable({
      "responsive": true,
      "dom": 'Bfrtip',
      "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>
@endpush

@endsection