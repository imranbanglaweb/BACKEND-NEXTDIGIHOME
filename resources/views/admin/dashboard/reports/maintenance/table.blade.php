<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="bg-light">#</th>
                <th>Vehicle</th>
                <th>Type</th>
                <th>Vendor</th>
                <th>Date</th>
                <th>Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr>
                <td class="text-muted">{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                <td class="fw-medium">{{ $r->vehicle->vehicle_name ?? '-' }}</td>
                <td>{{ $r->maintenanceType->name ?? '-' }}</td>
                <td>{{ $r->vendor->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($r->maintenance_date)->format('d M Y') }}</td>
                <td class="text-success fw-bold">{{ number_format($r->total_cost ?? 0, 2) }}</td>
                <td>
                    @switch($r->status)
                        @case('pending')<span class="badge bg-warning text-dark">Pending</span>@break
                        @case('in_progress')<span class="badge bg-info">In Progress</span>@break
                        @case('completed')<span class="badge bg-success">Completed</span>@break
                        @case('cancelled')<span class="badge bg-danger">Cancelled</span>@break
                        @default<span class="badge bg-secondary">{{ $r->status }}</span>
                    @endswitch
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($records->hasPages())
<div class="p-3 border-top d-flex justify-content-between align-items-center">
    <span class="text-muted small">Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }}</span>
    <nav><ul class="pagination pagination-sm mb-0">
        @if ($records->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $records->previousPageUrl() }}">&laquo;</a></li>
        @endif
        @foreach ($records->links()->elements[0] as $page => $url)
            @if ($page == $records->currentPage())
                <li class="page-item active"><span class="page-link bg-primary">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach
        @if ($records->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $records->nextPageUrl() }}">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul></nav>
</div>
@endif
