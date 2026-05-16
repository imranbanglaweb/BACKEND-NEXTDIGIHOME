@extends('admin.dashboard.master')

@section('title', 'Support Tickets')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); min-height: 100vh; padding: 30px 0;">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        @if(request()->routeIs('admin.support.tickets.open'))
                            Open Tickets
                        @elseif(request()->routeIs('admin.support.tickets.pending'))
                            Pending Tickets
                        @elseif(request()->routeIs('admin.support.tickets.closed'))
                            Closed Tickets
                        @else
                            All Support Tickets
                        @endif
                    </h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.tickets.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Ticket
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filter Tabs -->
                    <div class="mb-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.index') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.index') }}">
                                    All Tickets ({{ $tickets->total() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.open') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.open') }}">
                                    Open
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.pending') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.pending') }}">
                                    Pending
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.closed') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.closed') }}">
                                    Closed
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="mb-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.index') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.index') }}">
                                    All Tickets ({{ $tickets->total() }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.open') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.open') }}">
                                    Open
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.pending') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.pending') }}">
                                    Pending
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.support.tickets.closed') ? 'active' : '' }}"
                                   href="{{ route('admin.support.tickets.closed') }}">
                                    Closed
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Subject</th>
                                    <th>Customer</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Assigned To</th>
                                    <th>Last Reply</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <strong>{{ $ticket->ticket_number }}</strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.support.tickets.show', $ticket) }}">
                                                {{ Str::limit($ticket->subject, 50) }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $ticket->customer->name ?? 'Unknown' }}
                                            <br>
                                            <small class="text-muted">{{ $ticket->customer->email ?? '' }}</small>
                                        </td>
                                        <td>{{ $ticket->category->name ?? 'Uncategorized' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $ticket->status === 'open' ? 'success' : ($ticket->status === 'pending' ? 'warning' : ($ticket->status === 'closed' ? 'secondary' : 'info')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $ticket->priority === 'urgent' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'medium' ? 'info' : 'secondary')) }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $ticket->assignedUser->name ?? 'Unassigned' }}
                                        </td>
                                        <td>
                                            @if($ticket->last_reply_at)
                                                {{ $ticket->last_reply_at->diffForHumans() }}
                                            @else
                                                Never
                                            @endif
                                        </td>
                                        <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.support.tickets.show', $ticket) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.support.tickets.edit', $ticket) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No support tickets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tickets->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75em;
    }
</style>