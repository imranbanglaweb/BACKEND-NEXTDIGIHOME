<style>
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
table th, table td {
    border: 1px solid #333;
    padding: 6px;
}
table th {
    background: #eee;
}
</style>

<h2>Requisition Report</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Vehicle</th>
            <th>Driver</th>
            <th>Travel Date</th>
            <th>Return Date</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($requisitions as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->requestedBy->name ?? '' }}</td>
            <td>{{ $r->department->department_name ?? '' }}</td>
            <td>{{ $r->vehicle->vehicle_name ?? '' }}</td>
            <td>{{ $r->driver->name ?? $r->driver->driver_name ?? '' }}</td>
            <td>{{ $r->travel_date }}</td>
            <td>{{ $r->return_date }}</td>
            <td>{{ $r->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
