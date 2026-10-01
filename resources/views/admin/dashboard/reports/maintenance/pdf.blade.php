<!DOCTYPE<head>
    <meta charset="utf html>
<html>
-8">
    <title>Maintenance Report</title>
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
        <h1>Maintenance Report</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Type</th>
                <th>Service Title</th>
                <th>Date</th>
                <th>Vendor</th>
                <th>Total Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r->vehicle->vehicle_name ?? '-' }} ({{ $r->vehicle->vehicle_number ?? '-' }})</td>
                <td>{{ $r->maintenanceType->name ?? '-' }}</td>
                <td>{{ $r->service_title ?? '-' }}</td>
                <td>{{ $r->maintenance_date ? $r->maintenance_date->format('d M Y') : '-' }}</td>
                <td>{{ $r->vendor->name ?? '-' }}</td>
                <td>{{ number_format($r->total_cost ?? 0, 2) }}</td>
                <td>{{ $r->status ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total Records: {{ $records->count() }}
    </div>
</body>
</html>
