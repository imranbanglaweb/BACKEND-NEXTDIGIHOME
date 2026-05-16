@extends('admin.dashboard.master')

@section('title', 'Add New GPS Device')

@section('main_content')
<section role="main" class="content-body" style="background:#fff">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="page-title"><i class="fas fa-microchip me-2"></i>Add New GPS Device</h4>
                            <p class="text-muted">Register a new GPS tracking device.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-1"></i> Back to Devices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="gpsDeviceForm" method="POST" action="{{ route('admin.gps-devices.store') }}">
            @csrf
            @include('admin.dashboard.gps-device.form')
        </form>
    </div>
</section>
@endsection
