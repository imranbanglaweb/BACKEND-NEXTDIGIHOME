@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">

<div class="container-fluid">

{{-- HEADER --}}
<div class="sticky-top bg-body py-3 mb-3 border-bottom" style="z-index: 1000;">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">
            Edit Role
            <span class="badge badge-success ml-2" id="permissionCount">
                {{ count($rolePermissions) }} Selected
            </span>
        </h3>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary"><i class="fa fa-arrow-left me-1"></i>Back</a>
    </div>

    {{-- Search --}}
    <input type="text" id="permissionSearch" class="form-control mt-3"
           placeholder="🔍 Search permissions...">
</div>

{{-- FORM --}}
<form id="roleEditForm">
@csrf
@method('PATCH')

<div class="card shadow-sm border-0">
<div class="card-body">

{{-- ROLE NAME --}}
<div class="form-group">
    <label class="font-weight-bold">Role Name</label>
    <input type="text"
           name="name"
           value="{{ $role->name }}"
           class="form-control"
           placeholder="e.g. Admin, Manager">
</div>

<hr>

{{-- GLOBAL SELECT --}}
<div class="mb-3">
    <label class="font-weight-bold">
        <input type="checkbox" id="selectAllGlobal">
        Select All Permissions
    </label>
</div>

{{-- GENERAL PERMISSIONS --}}
<h5 class="text-primary mb-3">General Permissions</h5>
<div class="row permission-wrapper">
@foreach($groupedPermissions as $group => $permissions)
@if($group === 'general')
    @foreach($permissions as $permission)
    <div class="col-md-3 mb-2 permission-item">
        <label class="permission-box">
            <input type="checkbox"
                   name="permissions[]"
                   value="{{ $permission->id }}"
                   class="permission-checkbox"
                   {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
            {{ $permission->name }}
        </label>
    </div>
    @endforeach
@endif
@endforeach
</div>

<hr>

{{-- MODULE PERMISSIONS --}}
<h5 class="text-primary mb-3">Module Permissions</h5>

@foreach($groupedPermissions as $group => $permissions)
@if($group !== 'general')
<div class="card mb-3 permission-group">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <strong class="text-uppercase">{{ ucwords($group) }}</strong>
        <label class="mb-0">
            <input type="checkbox" class="group-select">
            Select All
        </label>
    </div>

    <div class="card-body">
        <div class="row permission-wrapper">
            @foreach($permissions as $permission)
            <div class="col-md-3 mb-2 permission-item">
                <label class="permission-box">
                    <input type="checkbox"
                           name="permissions[]"
                           value="{{ $permission->id }}"
                           class="permission-checkbox"
                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                    {{ $permission->name }}
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endforeach

</div>

<div class="card-footer text-center">
    <button type="submit" class="btn btn-success btn-lg px-5">
        Update Role
    </button>
</div>
</div>
</form>

</div>

{{-- SAME DARK MODE + UI --}}
<style>
:root {
    --bg: #ffffff;
    --text: #212529;
    --card: #ffffff;
}
@media (prefers-color-scheme: dark) {
    :root {
        --bg: #0f172a;
        --text: #e5e7eb;
        --card: #1e293b;
    }
}
body { background: var(--bg); color: var(--text); }
.card, .card-header { background: var(--card); }

.permission-box {
    display: block;
    padding: 10px;
    border-radius: 8px;
    background: rgba(0,0,0,.03);
    cursor: pointer;
    transition: .2s;
}
.permission-box:hover { background: rgba(0,0,0,.08); }
.permission-box input { margin-right: 6px; }
</style>

{{-- JS --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    function updateCount() {
        let count = $('.permission-checkbox:checked').length;
        $('#permissionCount').text(count + ' Selected');
    }

    updateCount();

    // GLOBAL SELECT
    $('#selectAllGlobal').on('change', function () {
        $('.permission-checkbox').prop('checked', this.checked);
        updateCount();
    });

    // GROUP SELECT
    $('.group-select').on('change', function () {
        $(this).closest('.permission-group')
            .find('.permission-checkbox')
            .prop('checked', this.checked);
        updateCount();
    });

    $('.permission-checkbox').on('change', updateCount);

    // SEARCH
    $('#permissionSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $('.permission-item').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // AJAX UPDATE with validation and proper alerts
    $('#roleEditForm').submit(function (e) {
        e.preventDefault();
        
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: "{{ route('admin.roles.update', $role->id) }}",
            method: "POST",
            data: $(this).serialize(),
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: res.message || 'Role updated successfully.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('admin.roles.index') }}";
                });
            },
            error: function (xhr) {
                var errorMessage = 'Validation failed. Please check your input.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Build error message from validation errors
                    var errors = xhr.responseJSON.errors;
                    errorMessage = '';
                    for (var key in errors) {
                        errorMessage += errors[key][0] + '\n';
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

});
</script>

</section>
@endsection
