<tbody>
@forelse($devices as $device)
<tr>
    <td class="fw-bold align-middle">
        <span class="d-flex align-items-center gap-2">
            <i class="fas fa-microchip text-primary"></i>
            {{ $device->device_name }}
        </span>
    </td>
    <td class="align-middle">
        <span class="badge badge-info">{{ $device->device_type ?? 'N/A' }}</span>
    </td>
    <td class="align-middle">
        <code class="bg-light px-2 py-1 rounded d-block text-nowrap">{{ $device->imei_number }}</code>
    </td>
    <td class="align-middle">{{ $device->sim_number ?? '-' }}</td>
    <td class="align-middle">
        <span class="badge badge-info">{{ $device->protocol }}</span>
    </td>
    <td class="align-middle">
        @if($device->vehicle)
            <span class="badge badge-warning">{{ $device->vehicle->vehicle_name }}</span>
        @else
            <span class="badge bg-secondary text-white">Not Assigned</span>
        @endif
    </td>
    <td class="align-middle">
        @if(!$device->is_active)
            <span class="badge bg-secondary text-white">Inactive</span>
        @elseif($device->isOnline())
            <span class="badge" style="background-color: #28a745; color: white;"><i class="fas fa-circle-notch fa-spin"></i> Online</span>
        @else
            <span class="badge" style="background-color: #ffc107; color: #212529;">Offline</span>
        @endif
    </td>
    <td class="align-middle">
        @if($device->latestLocation)
            <small>{{ number_format($device->latestLocation->latitude, 4) }}, {{ number_format($device->latestLocation->longitude, 4) }}</small>
        @else
            <span class="text-muted">No Data</span>
        @endif
    </td>
    <td class="text-center align-middle">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.gps-devices.show', $device->id) }}" class="btn btn-sm btn-info" title="View" data-toggle="tooltip"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admin.gps-devices.edit', $device->id) }}" class="btn btn-sm btn-primary" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-sm btn-danger delete-device" data-id="{{ $device->id }}" data-name="{{ $device->device_name }}" title="Delete" data-toggle="tooltip">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <form id="delete-form-{{ $device->id }}" action="{{ route('admin.gps-devices.destroy', $device->id) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center text-muted py-5">
        <i class="fas fa-inbox fa-2x mb-3"></i>
        <p>No GPS devices found</p>
    </td>
</tr>
@endforelse
</tbody>
