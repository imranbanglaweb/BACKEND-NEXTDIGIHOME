@if ($requisitions->hasPages())
    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
        <div class="mb-2 mb-md-0">
            <p class="small text-muted mb-0">
                Showing 
                <span class="fw-semibold">{{ $requisitions->firstItem() }}</span>
                to 
                <span class="fw-semibold">{{ $requisitions->lastItem() }}</span>
                of
                <span class="fw-semibold">{{ $requisitions->total() }}</span>
                results
            </p>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                {{-- First Page Link --}}
                <li class="page-item {{ $requisitions->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $requisitions->url(1) }}" aria-label="First">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                </li>

                {{-- Previous Page Link --}}
                <li class="page-item {{ $requisitions->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $requisitions->previousPageUrl() }}" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>

                {{-- Pagination Elements --}}
                @php
                    $current = $requisitions->currentPage();
                    $last = $requisitions->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if($start > 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    <li class="page-item {{ $page == $current ? 'active' : '' }}">
                        <a class="page-link" href="{{ $requisitions->url($page) }}">{{ $page }}</a>
                    </li>
                @endfor

                @if($end < $last)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                {{-- Next Page Link --}}
                <li class="page-item {{ !$requisitions->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $requisitions->nextPageUrl() }}" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>

                {{-- Last Page Link --}}
                <li class="page-item {{ !$requisitions->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $requisitions->url($last) }}" aria-label="Last">
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@else
    <div class="text-muted small">
        Showing all {{ $requisitions->count() }} results
    </div>
@endif