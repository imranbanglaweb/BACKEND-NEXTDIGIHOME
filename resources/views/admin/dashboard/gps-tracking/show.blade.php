@extends('admin.dashboard.master')

@section('title', 'Vehicle Tracking - ' . ($vehicle->vehicle_name ?? $vehicle->vehicle_number ?? 'Vehicle'))

@section('main_content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-car mr-2"></i>
                        Vehicle Tracking - {{ $vehicle->vehicle_name ?? $vehicle->vehicle_number ?? 'Vehicle #' . $vehicle->id }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gps-tracking.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Live Tracking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Info -->
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vehicle Name</span>
                    <span class="info-box-number">{{ $vehicle->vehicle_name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-id-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vehicle Number</span>
                    <span class="info-box-number">{{ $vehicle->vehicle_number ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Driver</span>
                    <span class="info-box-number">{{ $vehicle->driver?->name ?? 'Not Assigned' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-tachometer-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Current Speed</span>
                    <span class="info-box-number">{{ $latestTrack?->speed ?? 0 }} km/h</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Location & Map -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Current Location</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($latestTrack)
                                    @if($latestTrack->status == 'moving')
                                    <span class="badge badge-success">Moving</span>
                                    @else
                                    <span class="badge badge-info">Active</span>
                                    @endif
                                @else
                                    <span class="badge badge-secondary">Offline</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Latitude:</strong></td>
                            <td>{{ $latestTrack?->latitude ? number_format($latestTrack->latitude, 6) : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Longitude:</strong></td>
                            <td>{{ $latestTrack?->longitude ? number_format($latestTrack->longitude, 6) : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Speed:</strong></td>
                            <td>{{ $latestTrack?->speed ?? 0 }} km/h</td>
                        </tr>
                        <tr>
                            <td><strong>Heading:</strong></td>
                            <td>{{ $latestTrack?->heading ?? 0 }}°</td>
                        </tr>
                        <tr>
                            <td><strong>Altitude:</strong></td>
                            <td>{{ $latestTrack?->altitude ? number_format($latestTrack->altitude, 1) . ' m' : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Last Updated:</strong></td>
                            <td>{{ $latestTrack?->recorded_at ? $latestTrack->recorded_at->format('Y-m-d H:i:s') : 'Never' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-0">
                    <div id="vehicleMap" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Path -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Today's Path ({{ $todayPath->count() }} points)</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Time</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Speed (km/h)</th>
                                <th>Heading</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayPath as $index => $track)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $track->recorded_at ? $track->recorded_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                <td>{{ number_format($track->latitude, 6) }}</td>
                                <td>{{ number_format($track->longitude, 6) }}</td>
                                <td>{{ $track->speed ?? 0 }}</td>
                                <td>{{ $track->heading ?? 0 }}°</td>
                                <td>
                                    @if($track->status == 'moving')
                                    <span class="badge badge-success">Moving</span>
                                    @else
                                    <span class="badge badge-info">Active</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No GPS data recorded today</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    var latestTrack = @json($latestTrack);
    var todayPath = @json($todayPath);
    
    if (latestTrack && latestTrack.latitude && latestTrack.longitude) {
        // Initialize map with current location
        var map = L.map('vehicleMap').setView([latestTrack.latitude, latestTrack.longitude], 15);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Add current vehicle marker
        var vehicleIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color: #2196F3; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas fa-car" style="color: white; font-size: 14px;"></i></div>',
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });
        
        var marker = L.marker([latestTrack.latitude, latestTrack.longitude], { icon: vehicleIcon }).addTo(map);
        
        var popupContent = '<b>' + (latestTrack.status === 'moving' ? 'Vehicle Moving' : 'Vehicle Active') + '</b><br>' +
            'Speed: ' + (latestTrack.speed || 0) + ' km/h<br>' +
            'Heading: ' + (latestTrack.heading || 0) + '°<br>' +
            'Last Updated: ' + (latestTrack.recorded_at ? new Date(latestTrack.recorded_at).toLocaleString() : 'N/A');
        
        marker.bindPopup(popupContent).openPopup();
        
        // Draw today's path if available
        if (todayPath.length > 1) {
            var pathCoords = todayPath.map(function(track) {
                return [track.latitude, track.longitude];
            });
            
            var pathLine = L.polyline(pathCoords, {
                color: '#2196F3',
                weight: 3,
                opacity: 0.6,
                dashArray: '5, 10'
            }).addTo(map);
            
            // Fit bounds to show entire path
            map.fitBounds(pathLine.getBounds(), { padding: [50, 50] });
        }
    } else {
        // Default view if no location data
        var map = L.map('vehicleMap').setView([23.8103, 90.4125], 10); // Dhaka default
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        document.getElementById('vehicleMap').innerHTML = '<div style="height: 100%; display: flex; align-items: center; justify-content: center; background: #f8f9fa; color: #6c757d;">No GPS location data available for this vehicle</div>';
    }
});
</script>
@endpush