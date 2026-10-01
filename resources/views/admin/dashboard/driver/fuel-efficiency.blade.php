@extends('admin.dashboard.master')
@section('main_content')
<style>
    .page-header { background: #000; padding: 0 25px; border-bottom: 1px solid var(--border-color); }
    .page-header h2 { color: white; margin: 0; font-weight: 700; font-size: 22px; display: flex; align-items: center; gap: 12px; }
    .right-wrapper { color: white; }
    .breadcrumbs { color: rgba(255,255,255,0.9); margin: 0; padding: 0; list-style: none; display: flex; gap: 5px; }
    .breadcrumbs li { display: flex; align-items: center; }
    .breadcrumbs li + li::before { content: "/"; margin: 0 8px; opacity: 0.7; }
    .breadcrumbs a { color: rgba(255,255,255,0.9); text-decoration: none; }
    .breadcrumbs span { color: rgba(255,255,255,0.7); }
    .vehicle-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
    .vehicle-card h4 { margin: 0 0 10px; color: #2d3748; font-size: 18px; font-weight: 600; }
    .vehicle-card .info { color: #718096; font-size: 14px; }
    .badge-success { background: #10b981; color: white; padding: 3px 10px; border-radius: 12px; font-size: 12px; }
    .badge-warning { background: #f59e0b; color: white; padding: 3px 10px; border-radius: 12px; font-size: 12px; }
    .badge-danger { background: #ef4444; color: white; padding: 3px 10px; border-radius: 12px; font-size: 12px; }
</style>
<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-tachometer-alt mr-2"></i>Vehicle Fuel Efficiency</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
                <li><span>Fuel Management</span></li>
                <li><span>Fuel Efficiency</span></li>
            </ol>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            @forelse($vehicles as $vehicle)
            <div class="col-md-6">
                <div class="vehicle-card">
                    <h4>{{ $vehicle->vehicle_name }} ({{ $vehicle->vehicle_number }})</h4>
                    <div class="info">
                        <p><strong>Type:</strong> {{ $vehicle->vehicle_type }}</p>
                        <p><strong>Driver:</strong> {{ $vehicle->driver->name ?? 'Not Assigned' }}</p>
                        <p><strong>Status:</strong> 
                            @if($vehicle->availability_status == 'available')
                            <span class="badge-success">Available</span>
                            @elseif($vehicle->availability_status == 'in_use')
                            <span class="badge-warning">In Use</span>
                            @else
                            <span class="badge-danger">Unavailable</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <p class="text-center">No vehicles found</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection