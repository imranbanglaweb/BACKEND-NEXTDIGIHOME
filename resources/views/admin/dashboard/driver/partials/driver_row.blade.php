<tr>
    <td>{{ $driver->id }}</td>
    <td>{{ $driver->driver_name }}</td>
    <td>{{ $d->unit->unit_name ?? 'N/A' }}</td>

    <td>{{ $d->department->department_name ?? 'N/A' }}</td>

    <td>{{ $d->employee_code ?? '---' }}</td>
    <td>{{ $driver->license_number }}</td>
    <td>{{ $driver->mobile }}</td>
    <td>{{ $driver->department->name ?? '' }}</td>
    <td>{{ $driver->unit->name ?? '' }}</td>
</tr>
