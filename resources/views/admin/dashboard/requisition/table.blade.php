@forelse($requisitions as $requisition)
<tr>
    <td class="text-center table-serial">{{ $loop->iteration + ($requisitions->currentPage() - 1) * $requisitions->perPage() }}</td>
    <td>
        <a href="{{ route('requisitions.show', $requisition->id) }}" class="text-primary fw-semibold text-decoration-none table-link">
            {{ $requisition->requisition_number ?? 'N/A' }}
        </a>
    </td>
    @if(!auth()->user()->hasRole('Employee'))
    <td>
        <span class="fw-semibold text-dark">{{ $requisition->employee->name ?? 'Unknown' }}</span>
        @if($requisition->employee->employee_code)
            <small class="text-muted d-block">{{ $requisition->employee->employee_code }}</small>
        @endif
    </td>
    <td>
        <span class="text-dark">{{ $requisition->department->department_name ?? 'N/A' }}</span>
    </td>
    @endif
    <td>
        <div class="d-flex align-items-center">
            <div class="text-end">
                <div class="fw-semibold location-text">{{ $requisition->from_location }}</div>
                <div class="text-muted location-arrow"><i class="fa fa-arrow-down fa-xs mx-1"></i>{{ $requisition->to_location }}</div>
            </div>
        </div>
    </td>
    <td class="table-date">
        <div class="fw-semibold">{{ $requisition->travel_date ? $requisition->travel_date->format('M d, Y') : 'N/A' }}</div>
        @if($requisition->travel_time)
            <small class="text-muted">{{ $requisition->travel_time->format('h:i A') }}</small>
        @endif
    </td>
    <td class="table-date">
        {{ $requisition->return_date ? $requisition->return_date->format('M d, Y') : 'N/A' }}
    </td>
    <td class="table-vehicle">
        @if($requisition->vehicle)
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fa fa-car text-muted me-2"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $requisition->vehicle->vehicle_name }}</div>
                    <small class="text-muted">{{ $requisition->vehicle->license_plate }}</small>
                </div>
            </div>
        @else
            <span class="text-muted">Not Assigned</span>
        @endif
    </td>
    <td class="table-approval">
        {{-- Department Status --}}
        @if($requisition->department_status == 'Pending')
            <span class="badge" style="background-color: #fff3cd; color: #856404; border: 1px solid #ffc107;">Dept: Pending</span>
        @elseif($requisition->department_status == 'Approved')
            <span class="badge" style="background-color: #d1ecf1; color: #0c5460; border: 1px solid #17a2b8;">Dept: Approved</span>
        @elseif($requisition->department_status == 'Rejected')
            <span class="badge" style="background-color: #f8d7da; color: #721c24; border: 1px solid #dc3545;">Dept: Rejected</span>
        @else
            <span class="badge bg-secondary">{{ $requisition->department_status ?? 'N/A' }}</span>
        @endif
        
        {{-- Transport Status --}}
        @if($requisition->transport_status)
            <div class="mt-1">
                @if($requisition->transport_status == 'Pending')
                    <span class="badge" style="background-color: #ffeeba; color: #856404; border: 1px solid #fd7e14;">Trans: Pending</span>
                @elseif($requisition->transport_status == 'Approved')
                    <span class="badge" style="background-color: #d4edda; color: #155724; border: 1px solid #28a745;">Trans: Approved</span>
                @elseif($requisition->transport_status == 'Rejected')
                    <span class="badge" style="background-color: #e2d5f1; color: #553c7a; border: 1px solid #6f42c1;">Trans: Rejected</span>
                @else
                    <span class="badge bg-secondary">{{ $requisition->transport_status }}</span>
                @endif
            </div>
        @endif
    </td>
    <td class="table-status">
        @if($requisition->status == 'Pending')
            <span class="badge bg-warning text-dark">Pending</span>
        @elseif($requisition->status == 'Approved')
            <span class="badge bg-success">Approved</span>
        @elseif($requisition->status == 'Rejected')
            <span class="badge bg-danger">Rejected</span>
        @elseif($requisition->status == 'Completed')
            <span class="badge bg-dark">Completed</span>
        @else
            <span class="badge bg-secondary">{{ $requisition->status ?? 'Unknown' }}</span>
        @endif
    </td>
    <td class="text-center">
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('requisitions.show', $requisition->id) }}" class="btn btn-info text-white" title="View Details" style="background: #17a2b8; border-color: #17a2b8;">
                <i class="fa fa-eye"></i>
            </a>
            
            @if(!in_array($requisition->status, ['Approved', 'Completed']))
            <a href="{{ route('requisitions.edit', $requisition->id) }}" class="btn btn-primary text-white" title="Edit" style="background: #007bff; border-color: #007bff;">
                <i class="fa fa-edit"></i>
            </a>
            @endif
            
            @can('requisition-delete')
            @if(!in_array($requisition->status, ['Approved', 'Completed']))
            <button class="btn btn-danger text-white deleteItem" 
                    data-id="{{ $requisition->id }}"
                    data-req-number="{{ $requisition->requisition_number }}"
                    title="Delete"
                    style="background: #dc3545; border-color: #dc3545;">
                <i class="fa fa-trash"></i>
            </button>
            @endif
            @endcan
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="{{ auth()->user()->hasRole('Employee') ? '9' : '11' }}" class="text-center py-5">
        <div class="text-muted">
            <div class="mb-3">
                <i class="fa fa-inbox fa-4x text-secondary opacity-25"></i>
            </div>
            <h5 class="fw-semibold mb-2 empty-title">No requisitions found</h5>
            <p class="mb-3 empty-text">No requisitions match your search criteria.</p>
            <a href="{{ route('requisitions.create') }}" class="btn btn-primary">
                <i class="fa fa-plus-circle me-1"></i>Create New Requisition
            </a>
        </div>
    </td>
</tr>
@endforelse
