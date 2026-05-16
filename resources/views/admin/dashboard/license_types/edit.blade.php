@extends('admin.dashboard.master')
@section('main_content')
<section class="content-body">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-8">
                <h3>Edit License Type</h3>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('license-types.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                {!! Form::model($licnese_type, ['route' => ['license-types.update', $licnese_type->id], 'method' => 'PUT']) !!}
                @include('admin.dashboard.license_types._form')
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
