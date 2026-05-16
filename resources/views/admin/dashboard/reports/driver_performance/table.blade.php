<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="bg-light">#</th>
                <th>Driver</th>
                <th>Total Trips</th>
                <th>Total KM</th>
                <th>Fuel (L)</th>
                <th>Delayed</th>
                <th>Incidents</th>
                <th>Efficiency</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr>
                <td class="text-muted">{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                <td class="fw-medium">{{ $r->driver->driver_name ?? '-' }}</td>
                <td>{{ $r->total_trips }}</td>
                <td>{{ number_format($r->total_distance, 2) }}</td>
                <td>{{ number_format($r->total_fuel, 2) }}</td>
                <td>{{ $r->delayed_trips }}</td>
                <td>{{ $r->incidents }}</td>
                <td>
                    @php $eff = $r->total_fuel > 0 ? $r->total_distance / $r->total_fuel : 0; @endphp
                    <span class="{{ $eff > 10 ? 'text-success' : ($eff > 5 ? 'text-warning' : 'text-danger') }} fw-bold">
                        {{ $eff > 0 ? number_format($eff, 2) : 'N/A' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">No data found</td>
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
