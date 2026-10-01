@extends('admin.dashboard.master')
@section('main_content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    body { font-family: 'Inter', sans-serif; }
    
      .page-header {
    background: #fff;
    padding: 0 25px;
    border-bottom: 1px solid var(--border-color);
    /* margin-bottom: 20px; */
    background-color:#000
}
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .right-wrapper {
        color: white;
    }
    
    .breadcrumbs {
        color: rgba(255,255,255,0.9);
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
    }
    
    .breadcrumbs li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumbs li + li::before {
        content: "/";
        margin: 0 8px;
        opacity: 0.7;
    }
    
    .breadcrumbs a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        opacity: 1;
    }
    
    .breadcrumbs span {
        color: rgba(255,255,255,0.7);
    }
    
    .card-premium {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .card-premium .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .card-premium .card-body {
        padding: 25px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4a5568;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .table-card .card-body {
        padding: 0;
    }
    
    .table {
        margin: 0;
    }
    
    .table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #4a5568;
        font-weight: 600;
        padding: 15px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    
    .table tbody td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-success {
        background: #10b981;
        color: white;
    }
    
    .alert-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 20px 25px;
        font-size: 15px;
    }
    
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--card-shadow);
    }
    
    .stats-card h4 {
        margin: 0;
        color: #718096;
        font-size: 14px;
        font-weight: 600;
    }
    
    .stats-card .value {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        margin-top: 5px;
    }
</style>


<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-gas-pump mr-2"></i>Fuel History</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Fuel Management</span></li>
                <li><span>Fuel History</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <!-- Stats Summary -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Total Fuel Entries</h4>
                    <div class="value">{{ $fuelLogs->total() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Total Cost (BDT)</h4>
                    <div class="value">{{ number_format($fuelLogs->sum('cost'), 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Total Liters</h4>
                    <div class="value">{{ number_format($fuelLogs->sum('quantity'), 2) }}</div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                @if(isset($fuelLogs) && $fuelLogs->count() > 0)
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-history mr-2"></i>All Fuel Log Entries</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Driver</th>
                                    <th>Vehicle</th>
                                    <th>Quantity (L)</th>
                                    <th>Cost (BDT)</th>
                                    <th>Odometer</th>
                                    <th>Fuel Station</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fuelLogs as $log)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($log->fuel_date)) }}</td>
                                    <td>{{ $log->driver->name ?? 'N/A' }}</td>
                                    <td>{{ $log->vehicle->vehicle_name ?? 'N/A' }} ({{ $log->vehicle->vehicle_number ?? '' }})</td>
                                    <td>{{ number_format($log->quantity, 2) }}</td>
                                    <td>{{ number_format($log->cost, 2) }}</td>
                                    <td>{{ number_format($log->odometer_reading, 2) }}</td>
                                    <td>{{ $log->location ?? 'N/A' }}</td>
                                    <td>{{ date('d M Y H:i', strtotime($log->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $fuelLogs->links() }}
                    </div>
                </div>
                @else
                <div class="card-premium">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            No fuel log entries found.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection