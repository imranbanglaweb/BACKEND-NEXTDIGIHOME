@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">

<div class="container-fluid">

{{-- HEADER --}}
<div class="sticky-top bg-body py-3 mb-3 border-bottom" style="z-index: 1000;">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">
            Create New Role
            <span class="badge badge-success ml-2" id="permissionCount">0 Selected</span>
        </h3>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-primary">← Back</a>
    </div>

    {{-- Search --}}
    <input type="text" id="permissionSearch" class="form-control mt-3"
           placeholder="🔍 Search permissions...">
</div>

{{-- FORM --}}
{!! Form::open(['route' => 'admin.roles.store','method'=>'POST']) !!}

<div class="card shadow-sm border-0">
<div class="card-body">

{{-- ROLE NAME --}}
<div class="form-group">
    <label class="font-weight-bold">Role Name</label>
    {!! Form::text('name', old('name'), [
        'class' => 'form-control '.($errors->has('name') ? 'is-invalid' : ''),
        'placeholder' => 'e.g. Admin, Manager'
    ]) !!}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
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
@foreach($permission as $value)
@if(empty($value->table_name))
    <div class="col-md-3 mb-2 permission-item">
        <label class="permission-box">
            <input type="checkbox" name="permissions[]" value="{{ $value->id }}" class="permission-checkbox">
            {{ $value->name }}
        </label>
    </div>
@endif
@endforeach
</div>

<hr>

{{-- MODULE PERMISSIONS --}}
<h5 class="text-primary mb-3">Module Permissions</h5>

@foreach($table_lists as $list)
@if(!empty($list->table_name))
<div class="card mb-3 permission-group">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <strong class="text-uppercase">{{ ucwords($list->table_name) }}</strong>
        <label class="mb-0">
            <input type="checkbox" class="group-select">
            Select All
        </label>
    </div>

    <div class="card-body">
        <div class="row permission-wrapper">
            @foreach($permission as $value)
            @if($value->table_name == $list->table_name)
            <div class="col-md-3 mb-2 permission-item">
                <label class="permission-box">
                    <input type="checkbox"
                           name="permissions[]"
                           value="{{ $value->id }}"
                           class="permission-checkbox">
                    {{ $value->name }}
                </label>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endif
@endforeach

</div>

<div class="card-footer text-center">
    <button type="submit" class="btn btn-success btn-lg px-5">
        Save Role
    </button>
</div>
</div>

{!! Form::close() !!}
</div>

{{-- DARK MODE + PREMIUM UI --}}
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

body {
    background: var(--bg);
    color: var(--text);
}

.card, .card-header {
    background: var(--card);
}

.permission-box {
    display: block;
    padding: 10px;
    border-radius: 8px;
    background: rgba(0,0,0,.03);
    cursor: pointer;
    transition: .2s;
}

.permission-box:hover {
    background: rgba(0,0,0,.08);
}

.permission-box input {
    margin-right: 6px;
}
</style>

{{-- JS --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(function () {

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

    // COUNT BADGE
    $('.permission-checkbox').on('change', updateCount);

    function updateCount() {
        let count = $('.permission-checkbox:checked').length;
        $('#permissionCount').text(count + ' Selected');
    }

    // SEARCH
    $('#permissionSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $('.permission-item').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

});
</script>

{{-- PREMIUM TOAST SUCCESS --}}
@if(session('success'))
<script>
    showPremiumToast(
        'success',
        '<i class="fas fa-check-circle me-2"></i>Success',
        '{{ session('success') }}',
        5000
    );
</script>
@endif

@if(session('error'))
<script>
    showPremiumToast(
        'error',
        '<i class="fas fa-times-circle me-2"></i>Error',
        '{{ session('error') }}',
        5000
    );
</script>
@endif

</section>
@endsection
