@extends('admin.dashboard.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .table th, .table td { vertical-align: middle !important; font-size: 14px; }
</style>
@endpush

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid py-4">
        <h4 class="fw-bold mb-4">
            <i class="fa-solid fa-users text-primary"></i> Registered Users (API)
        </h4>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table id="usersTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Joined</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(function () {
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.api-payments.users') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'company' },
            { data: 'joined_at' },
            { data: 'status', orderable: false }
        ]
    });
});
</script>
@endpush