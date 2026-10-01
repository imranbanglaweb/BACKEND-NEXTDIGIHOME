<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="bg-light">#</th>
                <th>Req No</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Unit</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requisitions as $req)
            <tr>
                <td class="text-muted">{{ $loop->iteration + ($requisitions->currentPage() - 1) * $requisitions->perPage() }}</td>
                <td class="fw-medium text-primary">{{ $req->requisition_number }}</td>
                <td>{{ $req->requestedBy->name ?? '-' }}</td>
                <td>{{ $req->department->department_name ?? '-' }}</td>
                <td>{{ $req->unit->unit_name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($req->travel_date)->format('d M Y') }}</td>
                <td>
                    @switch($req->status)
                        @case('pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @break
                        @case('approved')
                            <span class="badge bg-success">Approved</span>
                            @break
                        @case('rejected')
                            <span class="badge bg-danger">Rejected</span>
                            @break
                        @default
                            <span class="badge bg-secondary">{{ $req->status }}</span>
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

<!-- Pagination -->
@if($requisitions->hasPages())
<div class="p-3 border-top d-flex justify-content-between align-items-center">
    <span class="text-muted small">Showing {{ $requisitions->firstItem() }} to {{ $requisitions->lastItem() }} of {{ $requisitions->total() }}</span>
    <nav>
        <ul class="pagination pagination-sm mb-0">
            @if ($requisitions->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $requisitions->previousPageUrl() }}">&laquo;</a></li>
            @endif

            @foreach ($requisitions->links()->elements[0] as $page => $url)
                @if ($page == $requisitions->currentPage())
                    <li class="page-item active"><span class="page-link bg-primary">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($requisitions->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $requisitions->nextPageUrl() }}">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
</div>
@endif
