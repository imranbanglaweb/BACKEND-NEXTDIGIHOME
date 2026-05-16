@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary"><i class="fa fa-plus-circle"></i> Add Vehicle Type</h3>
        <a href="{{ route('vehicle-type.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    @include('admin.dashboard.vehicletypes.form', ['action' => route('vehicle-type.store'), 'method' => 'POST'])
</div>
</section>
@endsection
