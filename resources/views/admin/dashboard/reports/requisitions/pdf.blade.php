<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Requisition Report</title>
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
        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-approved { background-color: #28a745; color: #fff; }
        .status-rejected { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Requisition Report</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Req. No.</th>
                <th>Date</th>
                <th>Department</th>
                <th>Employee</th>
                <th>From</th>
                <th>To</th>
                <th>Vehicle Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $requisition)
            <tr>
                <td>{{ $requisition->requisition_number }}</td>
                <td>{{ $requisition->travel_date }}</td>
                <td>{{ $requisition->department->department_name ?? '-' }}</td>
                <td>{{ $requisition->requestedBy->name ?? '-' }}</td>
                <td>{{ $requisition->from_location }}</td>
                <td>{{ $requisition->to_location }}</td>
                <td>{{ $requisition->vehicleType->name ?? '-' }}</td>
                <td>
                    @if($requisition->status == 'Pending')
                        <span class="status status-pending">Pending</span>
                    @elseif($requisition->status == 'Approved')
                        <span class="status status-approved">Approved</span>
                    @elseif($requisition->status == 'Rejected')
                        <span class="status status-rejected">Rejected</span>
                    @else
                        {{ $requisition->status }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
