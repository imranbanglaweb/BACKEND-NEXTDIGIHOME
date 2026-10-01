@extends('admin.dashboard.master')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">Users</div>
                <h2>User Management</h2>
                <p>Manage admin, staff, and operational user access from one place.</p>
            </div>
            <div class="premium-actions">
                <a class="btn btn-primary" href="{{ route('admin.users.create') }}"><i class="fa fa-plus me-2"></i>Add User</a>
            </div>
        </div>

        <div class="premium-nav">
            <a href="{{ route('admin.users.index') }}" class="active">Users</a>
            <a href="{{ route('admin.users.create') }}">Add User</a>
            <a href="{{ route('admin.users.activity') }}">Activity</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        <div class="premium-card premium-form mb-3">
            <div class="premium-card-title">
                <div><h5>Filters</h5><p>Narrow the user table by type, role, or account status.</p></div>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label>User Type</label>
                    <select id="user_type_filter" class="form-control select2">
                        <option value="">All User Types</option>
                        @foreach($userTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <label>Role</label>
                    <select id="role_filter" class="form-control select2">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <label>Status</label>
                    <select id="status_filter" class="form-control select2">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button type="button" id="filter_reset" class="btn btn-outline-secondary w-100"><i class="fa fa-refresh"></i></button>
                </div>
            </div>
        </div>

        <div class="premium-card">
            <div class="premium-card-title">
                <div><h5>User List</h5><p>Review identities, roles, status, and profile images.</p></div>
            </div>
            <div class="table-responsive">
                <table class="table premium-table" id="myTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>User Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>


<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>

<!-- Load SweetAlert2 from CDN to ensure it's available -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    console.log('jQuery loaded:', typeof $);
    console.log('Swal loaded:', typeof Swal);
    
    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: 'Select option',
        allowClear: true
    });
    
    // DataTable with advanced filtering
    var table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        search: false,
        dom: 'lrtip',
    
     
        ajax: {
            url: "{{ route('users.getData') }}",
            data: function(d) {
                d.user_type_filter = $('#user_type_filter').val();
                d.role_filter = $('#role_filter').val();
                d.status_filter = $('#status_filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user_name', searchable: false },
            { data: 'name', searchable: false },
            { data: 'email', searchable: false },
            { data: 'user_type' },
            { data: 'roles', searchable: false },
            { data: 'status', searchable: false },
            { data: 'user_image', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Apply filters on change
    $('#user_type_filter, #role_filter, #status_filter').on('change', function() {
        table.draw();
    });
    
    // Reset filters
    $('#filter_reset').on('click', function() {
        $('#user_type_filter').val('').trigger('change');
        $('#role_filter').val('').trigger('change');
        $('#status_filter').val('').trigger('change');
        table.draw();
    });

    // Delete click handler
    $(document).on('click', '.deleteUser', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        console.log('Clicked delete, ID:', id);
        
        if (!id) {
            alert('Error: No user ID found!');
            return;
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be deleted permanently!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.users.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'User has been deleted.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Delete failed', 'error');
                    }
                });
            }
        });
    });
});
</script>

@endsection
