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
    .stats-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
    .stats-card h4 { margin: 0; color: #718096; font-size: 14px; font-weight: 600; }
    .stats-card .value { font-size: 28px; font-weight: 700; color: #2d3748; margin-top: 5px; }
    .table-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
    .table-card .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 25px; }
    .table-card .card-body { padding: 0; }
    .table { margin: 0; }
    .table thead th { background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #4a5568; font-weight: 600; padding: 15px; }
    .table tbody td { padding: 15px; border-bottom: 1px solid #e2e8f0; color: #4a5568; }
    .table tbody tr:hover { background: #f8fafc; }
</style>
<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-shopping-cart mr-2"></i>Fuel Purchase Log</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
                <li><span>Fuel Management</span></li>
                <li><span>Fuel Purchase Log</span></li>
            </ol>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="stats-card">
                    <h4>Total Fuel Cost (BDT)</h4>
                    <div class="value">{{ number_format($totalCost ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card">
                    <h4>Total Liters</h4>
                    <div class="value">{{ number_format($totalLiters ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-list mr-2"></i>All Fuel Purchases</h3>
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
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fuelLogs as $log)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($log->fuel_date)) }}</td>
                                    <td>{{ $log->driver->name ?? 'N/A' }}</td>
                                    <td>{{ $log->vehicle->vehicle_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($log->quantity, 2) }}</td>
                                    <td>{{ number_format($log->cost, 2) }}</td>
                                    <td>{{ $log->location ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">No records found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $fuelLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection