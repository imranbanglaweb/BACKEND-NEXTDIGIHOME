@extends('admin.dashboard.master')

@section('title', 'Support Tickets')

@section('main_content')
@include('admin.partials.premium-ui')
@php
    $pageTitle = request()->routeIs('admin.support.tickets.open') ? 'Open Tickets' : (request()->routeIs('admin.support.tickets.pending') ? 'Pending Tickets' : (request()->routeIs('admin.support.tickets.closed') ? 'Closed Tickets' : 'Support Tickets'));
    $visible = $tickets->getCollection();
@endphp
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">Support</div>
                <h2>{{ $pageTitle }}</h2>
                <p>Track customer issues, assignment, priority, and response activity.</p>
            </div>
            <div class="premium-actions">
                <a href="{{ route('admin.support.tickets.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>New Ticket</a>
            </div>
        </div>

        <div class="premium-nav">
            <a href="{{ route('admin.support.tickets.index') }}" class="{{ request()->routeIs('admin.support.tickets.index') ? 'active' : '' }}">Tickets</a>
            <a href="{{ route('admin.support.tickets.open') }}" class="{{ request()->routeIs('admin.support.tickets.open') ? 'active' : '' }}">Open</a>
            <a href="{{ route('admin.support.tickets.pending') }}" class="{{ request()->routeIs('admin.support.tickets.pending') ? 'active' : '' }}">Pending</a>
            <a href="{{ route('admin.support.tickets.closed') }}" class="{{ request()->routeIs('admin.support.tickets.closed') ? 'active' : '' }}">Closed</a>
            <a href="{{ route('admin.support.categories.index') }}">Categories</a>
            <a href="{{ route('admin.support.knowledge-base.index') }}">Knowledge Base</a>
        </div>

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-ticket-alt"></i></span><div><small>Total Results</small><strong>{{ number_format($tickets->total()) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-door-open"></i></span><div><small>Open Visible</small><strong>{{ number_format($visible->where('status', 'open')->count()) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-amber"><i class="fas fa-clock"></i></span><div><small>Pending Visible</small><strong>{{ number_format($visible->where('status', 'pending')->count()) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-red"><i class="fas fa-exclamation"></i></span><div><small>Urgent Visible</small><strong>{{ number_format($visible->where('priority', 'urgent')->count()) }}</strong></div></div></div>
        </div>

        <div class="premium-card">
            <div class="premium-card-title">
                <div><h5>Ticket Queue</h5><p>Use the action buttons to review, assign, edit, or respond.</p></div>
            </div>
            <div class="table-responsive">
                <table class="table premium-table">
                    <thead>
                        <tr>
                            <th>Ticket</th><th>Subject</th><th>Customer</th><th>Category</th><th>Status</th><th>Priority</th><th>Assigned</th><th>Last Reply</th><th>Created</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="fw-bold">{{ $ticket->ticket_number }}</td>
                            <td><a href="{{ route('admin.support.tickets.show', $ticket) }}" class="fw-bold">{{ Str::limit($ticket->subject, 50) }}</a></td>
                            <td>{{ $ticket->customer->name ?? 'Unknown' }}<br><small class="premium-muted">{{ $ticket->customer->email ?? '' }}</small></td>
                            <td>{{ $ticket->category->name ?? 'Uncategorized' }}</td>
                            <td><span class="badge bg-{{ $ticket->status === 'open' ? 'success' : ($ticket->status === 'pending' ? 'warning' : ($ticket->status === 'closed' ? 'secondary' : 'info')) }}">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span></td>
                            <td><span class="badge bg-{{ $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'medium' ? 'info' : 'secondary')) }}">{{ ucfirst($ticket->priority) }}</span></td>
                            <td>{{ $ticket->assignedUser->name ?? 'Unassigned' }}</td>
                            <td>{{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : 'Never' }}</td>
                            <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.support.tickets.show', $ticket) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.support.tickets.edit', $ticket) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center premium-muted py-4">No support tickets found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($tickets->hasPages())<div class="d-flex justify-content-center mt-3">{{ $tickets->links() }}</div>@endif
        </div>
    </div>
</section>
@endsection
