@php
$isPending = ($r->department_status === 'Pending');
@endphp

@if(!empty($isPending))
<a href="{{ route('department.approvals.show', $r->id) }}" class="btn btn-primary btn-sm">
    <i class="fa fa-check me-1"></i> Review
</a>
@else
<button disabled class="btn btn-secondary btn-sm">
    <i class="fa fa-eye me-1"></i> View
</button>
@endif
