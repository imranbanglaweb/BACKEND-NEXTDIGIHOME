@extends('admin.dashboard.master')

@section('title', 'Support Category Details')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Category Details: {{ $category->name }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.support.categories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Name:</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td>{{ $category->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Icon:</th>
                                    <td>
                                        @if($category->icon)
                                            <i class="fa {{ $category->icon }}"></i> {{ $category->icon }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge badge-{{ $category->is_active ? 'success' : 'secondary' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order:</th>
                                    <td>{{ $category->sort_order }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Total Tickets:</th>
                                    <td>{{ $category->tickets->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Open Tickets:</th>
                                    <td>{{ $category->tickets->where('status', 'open')->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Closed Tickets:</th>
                                    <td>{{ $category->tickets->where('status', 'closed')->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($category->description)
                        <div class="mt-3">
                            <h6>Description:</h6>
                            <p>{{ $category->description }}</p>
                        </div>
                    @endif

                    @if($category->tickets->count() > 0)
                        <div class="mt-4">
                            <h5>Recent Tickets in this Category</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Ticket #</th>
                                            <th>Subject</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->tickets->take(10) as $ticket)
                                            <tr>
                                                <td>{{ $ticket->ticket_number }}</td>
                                                <td>{{ Str::limit($ticket->subject, 40) }}</td>
                                                <td>{{ $ticket->customer->name ?? 'Unknown' }}</td>
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
                                                <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.support.tickets.show', $ticket) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($category->tickets->count() > 10)
                                <div class="text-center mt-2">
                                    <a href="{{ route('admin.support.tickets.index') }}?category={{ $category->id }}" class="btn btn-primary btn-sm">
                                        View All {{ $category->tickets->count() }} Tickets
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection