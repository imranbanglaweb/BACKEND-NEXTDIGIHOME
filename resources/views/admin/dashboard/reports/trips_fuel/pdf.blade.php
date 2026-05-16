<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trip & Fuel Consumption Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #4a90d9;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-success { color: #28a745; }
        .text-warning { color: #ffc107; }
        .text-danger { color: #dc3545; }
        .text-bold { font-weight: bold; }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Trip & Fuel Consumption Report</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>Trip Date</th>
                <th>Distance (KM)</th>
                <th>Fuel (L)</th>
                <th>Efficiency</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->vehicle->vehicle_name ?? '-' }} ({{ $r->vehicle->vehicle_number ?? '-' }})</td>
                <td>{{ $r->driver->driver_name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($r->trip_start_date)->format('d M Y') }}</td>
                <td>{{ number_format($r->distance_km, 2) }}</td>
                <td>{{ number_format($r->fuel_liter, 2) }}</td>
                <td>
                    @php 
                        $eff = $r->fuel_liter > 0 ? $r->distance_km / $r->fuel_liter : 0;
                        $effClass = $eff > 10 ? 'text-success' : ($eff > 5 ? 'text-warning' : 'text-danger');
                    @endphp
                    <span class="{{ $effClass }} text-bold">
                        {{ $eff > 0 ? number_format($eff, 2) : 'N/A' }} km/L
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total Records: {{ $records->count() }}
    </div>
</body>
</html>
