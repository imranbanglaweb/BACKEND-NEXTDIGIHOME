@extends('admin.dashboard.master')

@section('title', 'Trip Tracking - GPS Tracking')

@section('main_content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-route mr-2"></i>
                        Trip Tracking - {{ $trip->trip_number ?? 'Trip #' . $trip->id }}
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

    <!-- Trip Info -->
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Vehicle</span>
                    <span class="info-box-number">{{ $trip->vehicle?->vehicle_name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Driver</span>
                    <span class="info-box-number">{{ $trip->driver?->name ?? 'Not Assigned' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Status</span>
                    <span class="info-box-number">{{ $trip->status ?? 'Unknown' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Map -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div id="tripMap" style="height: 500px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trip Path Table -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">GPS Path History</h3>
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
                            @forelse($tracks as $index => $track)
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
                                <td colspan="7" class="text-center text-muted">No GPS data found for this trip</td>
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
    // GPS Path data from controller
    var tracks = @json($tracks);
    
    if (tracks.length > 0) {
        // Initialize map centered on first location
        var firstTrack = tracks[0];
        var map = L.map('tripMap').setView([firstTrack.latitude, firstTrack.longitude], 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Create path coordinates
        var pathCoords = tracks.map(function(track) {
            return [track.latitude, track.longitude];
        });
        
        // Draw path line
        var pathLine = L.polyline(pathCoords, {
            color: '#2196F3',
            weight: 4,
            opacity: 0.8
        }).addTo(map);
        
        // Add start marker (green)
        var startMarker = L.marker(pathCoords[0], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color: #4CAF50; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        }).addTo(map);
        startMarker.bindPopup('<b>Start</b><br>Trip started here');
        
        // Add end marker (red)
        var endMarker = L.marker(pathCoords[pathCoords.length - 1], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background-color: #F44336; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        }).addTo(map);
        endMarker.bindPopup('<b>Current Location</b><br>Vehicle is here');
        
        // Add waypoint markers every 10 points
        tracks.forEach(function(track, index) {
            if (index > 0 && index % 10 === 0) {
                var marker = L.marker([track.latitude, track.longitude], {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: '<div style="background-color: #2196F3; width: 10px; height: 10px; border-radius: 50%;"></div>',
                        iconSize: [10, 10],
                        iconAnchor: [5, 5]
                    })
                }).addTo(map);
                marker.bindPopup('<b>Point #' + index + '</b><br>Speed: ' + (track.speed || 0) + ' km/h<br>Time: ' + (track.recorded_at ? new Date(track.recorded_at).toLocaleString() : 'N/A'));
            }
        });
        
        // Fit map to show entire path
        map.fitBounds(pathLine.getBounds(), { padding: [50, 50] });
    } else {
        // Show message if no data
        document.getElementById('tripMap').innerHTML = '<div style="height: 100%; display: flex; align-items: center; justify-content: center; background: #f8f9fa; color: #6c757d;">No GPS data available for this trip</div>';
    }
});
</script>
@endpush