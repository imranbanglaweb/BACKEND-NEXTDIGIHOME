@extends('admin.dashboard.master')

@section('title', 'Ticket: ' . $ticket->ticket_number)

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Ticket #{{ $ticket->ticket_number }}: {{ $ticket->subject }}
                    </h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.tickets.edit', $ticket) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.support.tickets.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Tickets
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Ticket Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $ticket->status === 'open' ? 'success' : ($ticket->status === 'pending' ? 'warning' : ($ticket->status === 'closed' ? 'secondary' : 'info')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Priority:</th>
                                    <td>
                                        <span class="badge badge-{{ $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'medium' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $ticket->category->name ?? 'Uncategorized' }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $ticket->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Customer:</th>
                                    <td>
                                        {{ $ticket->customer->name ?? 'Unknown' }}
                                        <br>
                                        <small class="text-muted">{{ $ticket->customer->email ?? '' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Assigned To:</th>
                                    <td>{{ $ticket->assignedUser->name ?? 'Unassigned' }}</td>
                                </tr>
                                <tr>
                                    <th>Last Reply:</th>
                                    <td>
                                        @if($ticket->last_reply_at)
                                            {{ $ticket->last_reply_at->diffForHumans() }}
                                        @else
                                            Never
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tags:</th>
                                    <td>
                                        @if($ticket->tags)
                                            @foreach($ticket->tags as $tag)
                                                <span class="badge badge-light">{{ $tag }}</span>
                                            @endforeach
                                        @else
                                            None
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Ticket Description -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Description</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $ticket->description }}</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Update Status</h6>
                                </div>
                                <div class="card-body">
                                    <form id="statusForm" class="form-inline">
                                        @csrf
                                        <div class="form-group mr-2">
                                            <select name="status" class="form-control form-control-sm" id="statusSelect">
                                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                                <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="updateStatus()">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Assign Ticket</h6>
                                </div>
                                <div class="card-body">
                                    <form id="assignForm" class="form-inline">
                                        @csrf
                                        <div class="form-group mr-2">
                                            <select name="assigned_to" class="form-control form-control-sm" id="assignSelect">
                                                <option value="">Unassigned</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>
                                                        {{ $admin->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="assignTicket()">Assign</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Replies ({{ $ticket->replies->count() }})</h5>
                        </div>
                        <div class="card-body">
                            <div id="repliesContainer">
                                @forelse($ticket->replies as $reply)
                                    <div class="reply-item mb-3 {{ $reply->is_internal ? 'border-left-primary' : 'border-left-secondary' }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $reply->creator->name }}</strong>
                                                @if($reply->is_internal)
                                                    <span class="badge badge-primary">Internal Note</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="mt-2">
                                            {{ $reply->message }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No replies yet.</p>
                                @endforelse
                            </div>

                            <!-- Add Reply Form -->
                            <div class="mt-4">
                                <h6>Add Reply</h6>
                                <form id="replyForm">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" rows="4" placeholder="Type your reply here..." required></textarea>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="is_internal" name="is_internal">
                                        <label class="form-check-label" for="is_internal">Internal note (not visible to customer)</label>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="addReply()">Add Reply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus() {
    const status = $('#statusSelect').val();
    const url = '{{ route("admin.support.tickets.status", $ticket) }}';

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            alert('Error updating status');
        }
    });
}

function assignTicket() {
    const assignedTo = $('#assignSelect').val();
    const url = '{{ route("admin.support.tickets.assign", $ticket) }}';

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            assigned_to: assignedTo,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            alert('Error assigning ticket');
        }
    });
}

function addReply() {
    const message = $('textarea[name=message]').val();
    const isInternal = $('#is_internal').is(':checked');
    const url = '{{ route("admin.support.tickets.reply", $ticket) }}';

    if (!message.trim()) {
        alert('Please enter a reply message');
        return;
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            message: message,
            is_internal: isInternal,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            alert('Error adding reply');
        }
    });
}
</script>

<style>
.reply-item {
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    border-left: 4px solid #6c757d;
}

.border-left-primary {
    border-left-color: #007bff !important;
}

.border-left-secondary {
    border-left-color: #6c757d !important;
}
</style>
@endsection