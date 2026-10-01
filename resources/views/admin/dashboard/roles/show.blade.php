@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">

<div class="container-fluid">

{{-- HEADER --}}
<div class="sticky-top bg-body py-3 mb-3 border-bottom" style="z-index: 1000;">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">
            Role Details
            <span class="badge badge-success ml-2">
                {{ count($rolePermissions) }} Permissions
            </span>
        </h3>
        <div>
            @can('role-edit')
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary">✏️ Edit</a>
            @endcan
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">← Back</a>
        </div>
    </div>

    {{-- Search --}}
    <input type="text" id="permissionSearch" class="form-control mt-3"
           placeholder="🔍 Search permissions...">
</div>

<div class="card shadow-sm border-0">
<div class="card-body">

{{-- ROLE NAME --}}
<div class="form-group">
    <label class="font-weight-bold">Role Name</label>
    <input type="text"
           class="form-control"
           value="{{ $role->name }}"
           readonly>
</div>

<hr>

{{-- GENERAL PERMISSIONS --}}
<h5 class="text-primary mb-3">General Permissions</h5>
<div class="row permission-wrapper">
@foreach($groupedPermissions as $group => $permissions)
@if($group === 'general')
    @foreach($permissions as $permission)
    <div class="col-md-3 mb-2 permission-item">
        <div class="permission-box {{ in_array($permission->id, $rolePermissions) ? 'active' : 'inactive' }}">
            {{ $permission->name }}
        </div>
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
    <div class="card-header bg-light">
        <strong class="text-uppercase">{{ ucwords($group) }}</strong>
    </div>

    <div class="card-body">
        <div class="row permission-wrapper">
            @foreach($permissions as $permission)
            <div class="col-md-3 mb-2 permission-item">
                <div class="permission-box {{ in_array($permission->id, $rolePermissions) ? 'active' : 'inactive' }}">
                    {{ $permission->name }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endforeach

</div>
</div>

</div>

{{-- DARK MODE + READ ONLY STYLE --}}
<style>
:root {
    --bg: #ffffff;
    --text: #212529;
    --card: #ffffff;
    --active: #16a34a;
    --inactive: #9ca3af;
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
    padding: 10px;
    border-radius: 8px;
    font-size: 14px;
    transition: .2s;
}

.permission-box.active {
    background: rgba(22,163,74,.15);
    color: var(--active);
    font-weight: 600;
}

.permission-box.inactive {
    background: rgba(0,0,0,.05);
    color: var(--inactive);
}
</style>

{{-- JS --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function () {
    $('#permissionSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $('.permission-item').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>

</section>
@endsection
