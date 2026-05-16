@extends('admin.dashboard.master')

@section('main_content')
<style>
    .stats-card { border-radius: 8px; padding: 20px; color: white; position: relative; overflow: hidden; margin-bottom: 20px; }
    .stats-card h3 { font-size: 28px; margin: 0; }
    .stats-card p { margin: 5px 0 0; opacity: 0.9; }
    .stats-card .icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 40px; opacity: 0.5; }
    .bg-info { background: #17a2b8; }
    .bg-success { background: #28a745; }
    .bg-warning { background: #ffc107; color: #000; }
    .bg-danger { background: #dc3545; }
    #map { height: 450px; width: 100%; border-radius: 0 0 8px 8px; z-index: 1; }
    .vehicle-table { width: 100%; border-collapse: collapse; }
    .vehicle-table th, .vehicle-table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    .vehicle-table th { background: #f8f9fa; font-weight: 600; font-size: 12px; color: #666; }
    .vehicle-table tr:hover { background: #f8f9fa; cursor: pointer; }
    .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
    .badge-success { background: #28a745; color: white; }
    .badge-info { background: #17a2b8; color: white; }
    .badge-secondary { background: #6c757d; color: white; }
    .info-box { display: flex; align-items: center; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 10px; }
    .info-box-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: white; font-size: 18px; }
    .info-box-content { margin-left: 12px; }
    .info-box-text { font-size: 12px; color: #666; }
    .info-box-number { font-size: 14px; font-weight: bold; color: #333; }
    .vehicle-details { padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .vehicle-details h4 { margin-bottom: 15px; color: #333; }
    .text-muted { color: #999; }
    .custom-marker { background: transparent; border: none; }
    .leaflet-popup-content-wrapper { border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); }
    .leaflet-popup-content { margin: 10px; font-family: 'Segoe UI', Arial, sans-serif; }
    .stats-card:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: all 0.3s; }
    .panel-body { padding: 0 !important; }
</style>

<section role="main" class="content-body" style="background-color: #fff;">
    <script>
        var companyId = {{ auth()->user()->company_id ?? 'null' }};
        var userRoles = @json(auth()->user()->getRoleNames()->toArray() ?? []);
        var isAdmin = userRoles.includes('Super Admin') || userRoles.includes('Admin');
    </script>
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header shadow-sm bg-white rounded-3 px-3 py-3 mb-4">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle flex-shrink-0" style="width:44px;height:44px;font-size:1.6rem;"><i class="fas fa-map-marker-alt"></i></span>
                    <div class="min-width-0">
                        <h2 class="fw-bold mb-1 text-truncate" style="font-size:1.6rem;letter-spacing:-0.5px;">Live GPS Tracking</h2>
                        <div class="text-muted small text-truncate" style="max-width:350px;">Monitor all vehicles in real time on the map</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="stats-card bg-info"><h3 id="total-vehicles">0</h3><p>Total Vehicles</p><div class="icon"><i class="fas fa-car"></i></div></div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-success"><h3 id="active-vehicles">0</h3><p>Active</p><div class="icon"><i class="fas fa-check-circle"></i></div></div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-warning"><h3 id="moving-vehicles">0</h3><p>Moving</p><div class="icon"><i class="fas fa-route"></i></div></div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-danger"><h3 id="offline-vehicles">0</h3><p>Offline</p><div class="icon"><i class="fas fa-power-off"></i></div></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <section class="panel">
                <header class="panel-heading">
                    <h3><i class="fas fa-map"></i> Live Map</h3>
                    <button class="btn btn-primary btn-sm" onclick="refreshMap()"><i class="fas fa-sync-alt"></i> Refresh</button>
                </header>
                <div class="panel-body"><div id="map"></div></div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel">
                <header class="panel-heading"><h3><i class="fas fa-list"></i> Vehicle List</h3></header>
                <div class="panel-body" style="max-height: 400px; overflow-y: auto;">
                    <table class="vehicle-table">
                        <thead><tr><th>Vehicle</th><th>Status</th><th>Speed</th></tr></thead>
                        <tbody id="vehicle-list"><tr><td colspan="3" style="text-align: center; color: #999;">Loading...</td></tr></tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading"><h3><i class="fas fa-info-circle"></i> Vehicle Details</h3></header>
                <div class="panel-body" id="vehicle-details"><p class="text-muted">Click on a vehicle marker to see details</p></div>
            </section>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var map;
var markers = {};
var vehicleData = [];
var selectedVehicle = null;

function initMap() {
    map = L.map('map').setView([23.8103, 90.4125], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);
    loadVehicleData();
}

function loadVehicleData() {
    var url = '{{ url("/api/gps/live") }}';
    if (!isAdmin && companyId) {
        url += '?company_id=' + companyId;
    }
    fetch(url)
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                vehicleData = data.data;
                updateStats();
                updateVehicleList();
                updateMarkers();
            }
        })
        .catch(function(error) { console.error('Error:', error); });
}

function updateStats() {
    document.getElementById('total-vehicles').textContent = vehicleData.length;
    document.getElementById('active-vehicles').textContent = vehicleData.filter(function(v) { return v.status === 'active'; }).length;
    document.getElementById('moving-vehicles').textContent = vehicleData.filter(function(v) { return v.status === 'moving'; }).length;
    document.getElementById('offline-vehicles').textContent = vehicleData.filter(function(v) { return !v.latitude || v.status === 'offline'; }).length;
}

function updateVehicleList() {
    var tbody = document.getElementById('vehicle-list');
    tbody.innerHTML = '';
    if (vehicleData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" style="text-align: center; color: #999;">No vehicles found</td></tr>';
        return;
    }
    vehicleData.forEach(function(vehicle) {
        var isMoving = vehicle.status === 'moving';
        var statusColor = isMoving ? '#28a745' : (vehicle.status === 'active' ? '#17a2b8' : '#6c757d');
        var iconClass = isMoving ? 'fa-route' : 'fa-parking';
        var html = '<tr onclick="selectVehicle(' + vehicle.vehicle_id + ')" style="cursor:pointer;">';
        html += '<td><div style="display:flex;align-items:center;"><div style="width:35px;height:35px;background:' + statusColor + ';border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;margin-right:10px;"><i class="fas fa-car"></i></div><div><strong>' + (vehicle.vehicle_name || 'Unknown') + '</strong><br><small style="color:#666;">' + (vehicle.vehicle_number || 'N/A') + '</small></div></div></td>';
        html += '<td><span class="badge" style="background:' + statusColor + ';color:white;padding:4px 10px;border-radius:12px;font-size:11px;"><i class="fas fa-' + iconClass + '"></i> ' + (vehicle.status || 'offline') + '</span></td>';
        html += '<td><i class="fas fa-tachometer-alt" style="color:#666;margin-right:5px;"></i> ' + (vehicle.speed ? vehicle.speed + ' km/h' : '-') + '</td>';
        html += '</tr>';
        tbody.innerHTML += html;
    });
}

function updateMarkers() {
    Object.values(markers).forEach(function(marker) { map.removeLayer(marker); });
    markers = {};
    vehicleData.forEach(function(vehicle) {
        if (vehicle.latitude && vehicle.longitude) {
            var isMoving = vehicle.status === 'moving';
            var iconColor = isMoving ? '#28a745' : '#17a2b8';
            var iconHtml = '<div style="width:36px;height:36px;background:' + iconColor + ';border-radius:50%;border:3px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;color:white;font-size:16px;"><i class="fas fa-car"></i></div>';
            var icon = L.divIcon({ className: 'custom-marker', html: iconHtml, iconSize: [36, 36], iconAnchor: [18, 18] });
            var popupContent = '<div style="min-width:180px;padding:5px;">';
            popupContent += '<h5 style="margin:0 0 8px 0;color:#1e3a5f;border-bottom:2px solid #1e3a5f;padding-bottom:5px;"><i class="fas fa-car"></i> ' + (vehicle.vehicle_name || 'Unknown') + '</h5>';
            popupContent += '<p style="margin:5px 0;"><strong>Number:</strong> ' + (vehicle.vehicle_number || 'N/A') + '</p>';
            popupContent += '<p style="margin:5px 0;"><strong>Driver:</strong> ' + (vehicle.driver_name || 'Not assigned') + '</p>';
            popupContent += '<p style="margin:5px 0;"><strong>Speed:</strong> ' + (vehicle.speed || 0) + ' km/h</p>';
            popupContent += '<p style="margin:5px 0;"><strong>Status:</strong> ' + (vehicle.status || 'offline') + '</p>';
            popupContent += '<p style="margin:5px 0;font-size:11px;color:#666;">' + (vehicle.latitude || '') + ', ' + (vehicle.longitude || '') + '</p>';
            popupContent += '</div>';
            var marker = L.marker([vehicle.latitude, vehicle.longitude], { icon: icon }).addTo(map).bindPopup(popupContent);
            marker.on('click', function() { selectVehicle(vehicle.vehicle_id); });
            markers[vehicle.vehicle_id] = marker;
        }
    });
    var validVehicles = vehicleData.filter(function(v) { return v.latitude && v.longitude; });
    if (validVehicles.length > 0) {
        var group = L.featureGroup(Object.values(markers));
        map.fitBounds(group.getBounds(), { padding: [50, 50] });
    }
}

function selectVehicle(vehicleId) {
    var vehicle = vehicleData.find(function(v) { return v.vehicle_id === vehicleId; });
    selectedVehicle = vehicle;
    var details = document.getElementById('vehicle-details');
    if (vehicle) {
        var isMoving = vehicle.status === 'moving';
        var statusColor = isMoving ? '#28a745' : (vehicle.status === 'active' ? '#17a2b8' : '#6c757d');
        var html = '<div style="padding:15px;">';
        html += '<h4 style="margin:0 0 15px 0;color:#1e3a5f;border-bottom:2px solid #1e3a5f;padding-bottom:10px;"><i class="fas fa-car"></i> ' + (vehicle.vehicle_name || 'Unknown Vehicle') + ' <span style="font-size:14px;color:#666;">(' + (vehicle.vehicle_number || 'N/A') + ')</span></h4>';
        html += '<div class="row">';
        html += '<div class="col-md-3"><div class="info-box" style="margin-bottom:10px;"><div class="info-box-icon" style="background:#17a2b8;"><i class="fas fa-tag"></i></div><div class="info-box-content"><div class="info-box-text">Vehicle Type</div><div class="info-box-number">' + (vehicle.vehicle_type || 'N/A') + '</div></div></div></div>';
        html += '<div class="col-md-3"><div class="info-box" style="margin-bottom:10px;"><div class="info-box-icon" style="background:#28a745;"><i class="fas fa-user"></i></div><div class="info-box-content"><div class="info-box-text">Driver</div><div class="info-box-number">' + (vehicle.driver_name || 'Not assigned') + '</div></div></div></div>';
        html += '<div class="col-md-3"><div class="info-box" style="margin-bottom:10px;"><div class="info-box-icon" style="background:#ffc107;"><i class="fas fa-tachometer-alt"></i></div><div class="info-box-content"><div class="info-box-text">Speed</div><div class="info-box-number">' + (vehicle.speed || 0) + ' km/h</div></div></div></div>';
        html += '<div class="col-md-3"><div class="info-box" style="margin-bottom:10px;"><div class="info-box-icon" style="background:' + statusColor + ';"><i class="fas fa-circle"></i></div><div class="info-box-content"><div class="info-box-text">Status</div><div class="info-box-number">' + (vehicle.status || 'offline') + '</div></div></div></div>';
        html += '</div>';
        html += '<div style="margin-top:15px;padding:10px;background:#f8f9fa;border-radius:8px;">';
        html += '<p style="margin:5px 0;"><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> ' + (vehicle.latitude ? vehicle.latitude + ', ' + vehicle.longitude : 'N/A') + '</p>';
        html += '<p style="margin:5px 0;"><strong><i class="fas fa-clock"></i> Last Updated:</strong> ' + (vehicle.last_updated ? new Date(vehicle.last_updated).toLocaleString() : 'N/A') + '</p>';
        html += '<p style="margin:5px 0;"><strong><i class="fas fa-mobile-alt"></i> Device ID:</strong> ' + (vehicle.device_id || 'N/A') + '</p>';
        html += '</div></div>';
        details.innerHTML = html;
    }
    if (markers[vehicleId] && vehicle.latitude) {
        map.setView([vehicle.latitude, vehicle.longitude], 15);
        markers[vehicleId].openPopup();
    }
}

function refreshMap() { loadVehicleData(); }
setInterval(loadVehicleData, 7000);
document.addEventListener('DOMContentLoaded', initMap);
</script>
@endsection