@extends('admin.dashboard.master')
@section('main_content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<style>
    :root {
        --primary-dark: #1a1a2e;
        --secondary-dark: #16213e;
        --accent-blue: #0f3460;
    }
    
    .tracking-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 25px;
    }
    
    .tracking-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .tracking-header h3 { margin: 0; font-size: 18px; font-weight: 600; }
    
    .trip-info-bar {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .trip-info-bar .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .trip-info-bar .info-item i { font-size: 18px; }
    .trip-info-bar .info-label { font-size: 12px; opacity: 0.85; }
    .trip-info-bar .info-value { font-weight: 600; font-size: 14px; }
    
    #map {
        height: 450px;
        width: 100%;
        z-index: 1;
    }
    
    .leaflet-control-attribution {
        display: none;
    }
    
    /* Animated Vehicle Marker */
    .animated-marker {
        position: relative;
    }
    
    .vehicle-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.5);
        animation: pulse 2s ease-in-out infinite, moveCar 1s ease-in-out infinite;
    }
    
    .vehicle-icon i {
        transform: rotate(45deg);
        color: white;
        font-size: 22px;
    }
    
    .vehicle-icon.active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.6);
    }
    
    .vehicle-icon.idle {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
    }
    
    @keyframes pulse {
        0%, 100% { transform: rotate(-45deg) scale(1); }
        50% { transform: rotate(-45deg) scale(1.1); }
    }
    
    @keyframes moveCar {
        0%, 100% { margin-left: 0; }
        25% { margin-left: -2px; }
        75% { margin-left: 2px; }
    }
    
    /* GPS Trail Effect */
    .gps-trail {
        stroke-dasharray: 5, 5;
        animation: dash 0.5s linear infinite;
    }
    
    @keyframes dash {
        to { stroke-dashoffset: -10; }
    }
    
    /* Location Status */
    .location-status {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 1000;
    }
    
    .location-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #10b981;
        animation: blink 1s ease-in-out infinite;
    }
    
    .location-dot.error { background: #dc3545; }
    .location-dot.updating { background: #ffc107; }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    
    /* Route Info Panel */
    .route-panel {
        background: #f8f9fa;
        padding: 15px;
        border-top: 1px solid #e9ecef;
    }
    
    .route-panel h5 { margin: 0 0 10px 0; font-size: 14px; color: #495057; }
    
    .route-point {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
    }
    
    .route-point .point-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: white;
    }
    
    .route-point .point-icon.start { background: #28a745; }
    .route-point .point-icon.end { background: #dc3545; }
    
    .route-point .point-info .point-name { font-weight: 600; font-size: 14px; }
    .route-point .point-info .point-address { font-size: 12px; color: #6c757d; }
    
    .route-line {
        width: 2px;
        height: 30px;
        background: #dee2e6;
        margin-left: 14px;
    }
    
    /* Stats Cards */
    .stats-row {
        display: flex;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
    }
    
    .stat-item {
        flex: 1;
        text-align: center;
        padding: 10px;
        background: white;
        border-radius: 8px;
    }
    
    .stat-item .stat-value { font-size: 20px; font-weight: 700; color: var(--primary-dark); }
    .stat-item .stat-label { font-size: 11px; color: #6c757d; }
</style>

<section role="main" class="content-body">
    <div class="tracking-container">
        <div class="tracking-header">
            <h3><i class="fa fa-satellite-dish mr-2"></i>Live Trip Tracking</h3>
            <span id="liveStatus" class="badge bg-success">LIVE</span>
        </div>
        
        @if(isset($activeTrip) && $activeTrip)
        <div class="trip-info-bar">
            <div class="info-item">
                <i class="fa fa-hashtag"></i>
                <div>
                    <div class="info-label">Trip ID</div>
                    <div class="info-value">#{{ $activeTrip->requisition_number ?? $activeTrip->id }}</div>
                </div>
            </div>
            <div class="info-item">
                <i class="fa fa-calendar"></i>
                <div>
                    <div class="info-label">Date</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($activeTrip->travel_date)->format('d M Y') }}</div>
                </div>
            </div>
            <div class="info-item">
                <i class="fa fa-car"></i>
                <div>
                    <div class="info-label">Vehicle</div>
                    <div class="info-value">{{ $activeTrip->assignedVehicle->vehicle_name ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="info-item">
                <i class="fa fa-route"></i>
                <div>
                    <div class="info-label">Destination</div>
                    <div class="info-value">{{ $activeTrip->to_location ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="info-item">
                <i class="fa fa-tachometer-alt"></i>
                <div>
                    <div class="info-label">Speed</div>
                    <div class="info-value" id="currentSpeed">-- km/h</div>
                </div>
            </div>
        </div>
        @endif
        
        <div id="map">
            <div class="location-status">
                <div class="location-dot" id="gpsDot"></div>
                <div>
                    <div style="font-weight: 600; font-size: 13px;" id="gpsStatus">Connecting...</div>
                    <div style="font-size: 11px; color: #6c757d;" id="gpsCoords">--</div>
                </div>
            </div>
        </div>
        
        <div class="route-panel">
            <h5><i class="fa fa-map-marker-alt mr-1"></i> Route</h5>
            @if(isset($activeTrip) && $activeTrip)
            <div class="route-point">
                <div class="point-icon start"><i class="fa fa-play"></i></div>
                <div class="point-info">
                    <div class="point-name">{{ $activeTrip->from_location ?? 'Starting Point' }}</div>
                    <div class="point-address">{{ $activeTrip->from_location ?? 'Departure location' }}</div>
                </div>
            </div>
            <div class="route-line"></div>
            <div class="route-point">
                <div class="point-icon end"><i class="fa fa-flag-checkered"></i></div>
                <div class="point-info">
                    <div class="point-name">{{ $activeTrip->to_location ?? 'Destination' }}</div>
                    <div class="point-address">{{ $activeTrip->to_location ?? 'Arrival location' }}</div>
                </div>
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="fa fa-map-pin" style="font-size: 32px; opacity: 0.3;"></i>
                <p class="mb-0 mt-2">No active trip to track</p>
            </div>
            @endif
        </div>
        
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-value" id="tripDuration">00:00</div>
                <div class="stat-label">Duration</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="tripDistance">0 km</div>
                <div class="stat-label">Distance</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="tripSpeed">0</div>
                <div class="stat-label">Avg Speed (km/h)</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" id="lastUpdate">--</div>
                <div class="stat-label">Last Update</div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Initialize map with default location (Dhaka, Bangladesh)
    var map = L.map('map').setView([23.8103, 90.4125], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);
    
    // Custom vehicle icon
    var vehicleIcon = L.divIcon({
        className: 'animated-marker',
        html: '<div class="vehicle-icon active"><i class="fa fa-truck"></i></div>',
        iconSize: [50, 50],
        iconAnchor: [25, 25]
    });
    
    var marker = null;
    var pathLine = null;
    var gpsTrail = [];
    
    // Function to update location
    function updateLocation(lat, lng, speed) {
        $('#gpsDot').removeClass('error updating').addClass('updating');
        $('#gpsStatus').text('GPS Active');
        $('#gpsCoords').text(lat.toFixed(6) + ', ' + lng.toFixed(6));
        $('#currentSpeed').text(speed + ' km/h');
        $('#lastUpdate').text(new Date().toLocaleTimeString());
        
        var newPoint = [lat, lng];
        gpsTrail.push(newPoint);
        
        if (marker) {
            marker.setLatLng(newPoint);
        } else {
            marker = L.marker(newPoint, { icon: vehicleIcon }).addTo(map);
        }
        
        if (gpsTrail.length > 1) {
            if (pathLine) {
                map.removeLayer(pathLine);
            }
            pathLine = L.polyline(gpsTrail, {
                color: '#4f46e5',
                weight: 4,
                opacity: 0.8,
                className: 'gps-trail'
            }).addTo(map);
        }
        
        map.panTo(newPoint);
        
        setTimeout(() => {
            $('#gpsDot').removeClass('updating');
        }, 500);
    }
    
    // Simulated GPS update (replace with real API call)
    @if(isset($activeTrip) && $activeTrip)
    var tripStartTime = new Date();
    var startLat = 23.8103;
    var startLng = 90.4125;
    var currentLat = startLat;
    var currentLng = startLng;
    var totalDistance = 0;
    var speed = 0;
    
    function simulateGPSUpdate() {
        // Simulate movement
        currentLat += (Math.random() - 0.5) * 0.002;
        currentLng += (Math.random() - 0.5) * 0.002;
        speed = Math.floor(Math.random() * 40) + 20;
        totalDistance += speed * 0.001;
        
        updateLocation(currentLat, currentLng, speed);
        
        // Update stats
        var now = new Date();
        var diff = Math.floor((now - tripStartTime) / 1000);
        var hours = Math.floor(diff / 3600);
        var minutes = Math.floor((diff % 3600) / 60);
        var seconds = diff % 60;
        $('#tripDuration').text(
            (hours > 0 ? hours + ':' : '') + 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0')
        );
        $('#tripDistance').text(totalDistance.toFixed(1) + ' km');
        $('#tripSpeed').text(Math.floor(speed * 0.8));
    }
    
    // Start simulation
    updateLocation(startLat, startLng, 0);
    setInterval(simulateGPSUpdate, 3000);
    @endif
    
    // No active trip message
    @if(!isset($activeTrip) || !$activeTrip)
    $('#gpsStatus').text('No Active Trip');
    $('#gpsCoords').text('Start a trip to track location');
    $('#gpsDot').addClass('error');
    @endif
});
</script>
@endsection