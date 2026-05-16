<a href="{{ route('maintenance_approvals.show', $r->id) }}" class="btn btn-info btn-sm" title="View Details">
    <i class="fa fa-eye"></i>
</a>
@if($r->status == 'Pending Approval')
<button class="btn btn-success btn-sm" onclick="event.preventDefault(); approveRequisition({{ $r->id }});" title="Approve">
    <i class="fa fa-check"></i>
</button>
<button class="btn btn-danger btn-sm" onclick="event.preventDefault(); rejectRequisition({{ $r->id }});" title="Reject">
    <i class="fa fa-times"></i>
</button>
@endif
