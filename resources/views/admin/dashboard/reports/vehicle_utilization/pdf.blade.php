<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Utilization Report</title>
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
        <h1>Vehicle Utilization Report</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Total Trips</th>
                <th>Total Distance (KM)</th>
                <th>Total Fuel (L)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->vehicle->vehicle_name ?? '-' }} ({{ $r->vehicle->vehicle_number ?? '-' }})</td>
                <td>{{ $r->total_trips }}</td>
                <td>{{ number_format($r->total_distance ?? 0, 2) }}</td>
                <td>{{ number_format($r->total_fuel ?? 0, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total Records: {{ $records->count() }}
    </div>
</body>
</html>
