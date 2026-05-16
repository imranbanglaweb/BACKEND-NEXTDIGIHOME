@extends('admin.dashboard.master')

@section('title', 'Edit GPS Device')

@section('main_content')
<section role="main" class="content-body" style="background:#fff">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="page-title">
                                <i class="fas fa-edit mr-2"></i>
                                Edit GPS Device
                            </h4>
                            <p class="text-muted">Update GPS tracking device configuration</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left mr-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="gpsDeviceForm" method="POST" action="{{ route('admin.gps-devices.update', $gpsDevice->id) }}">
            @csrf
            @method('PUT')
            @include('admin.dashboard.gps-device.form')
        </form>
    </div>
</section>
@endsection
