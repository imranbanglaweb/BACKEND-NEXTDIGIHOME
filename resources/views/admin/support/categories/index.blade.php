@extends('admin.dashboard.master')

@section('title', 'Support Categories')

@section('main_content')
@include('admin.partials.premium-ui')
@php
    $activeCount = $categories->where('is_active', true)->count();
    $ticketCount = $categories->sum(fn($category) => $category->tickets_count ?? $category->tickets->count());
@endphp
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div><div class="premium-eyebrow">Support</div><h2>Support Categories</h2><p>Organize tickets by customer issue type and routing priority.</p></div>
            <div class="premium-actions"><a href="{{ route('admin.support.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Category</a></div>
        </div>
        <div class="premium-nav">
            <a href="{{ route('admin.support.tickets.index') }}">Tickets</a>
            <a href="{{ route('admin.support.categories.index') }}" class="active">Categories</a>
            <a href="{{ route('admin.support.knowledge-base.index') }}">Knowledge Base</a>
        </div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-layer-group"></i></span><div><small>Total Categories</small><strong>{{ number_format($categories->count()) }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-check"></i></span><div><small>Active</small><strong>{{ number_format($activeCount) }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-cyan"><i class="fas fa-ticket-alt"></i></span><div><small>Linked Tickets</small><strong>{{ number_format($ticketCount) }}</strong></div></div></div>
        </div>
        <div class="premium-card">
            <div class="premium-card-title"><div><h5>Category List</h5><p>Keep active categories clear and easy for customers to choose.</p></div></div>
            <div class="table-responsive">
                <table class="table premium-table">
                    <thead><tr><th>Order</th><th>Name</th><th>Slug</th><th>Icon</th><th>Description</th><th>Status</th><th>Tickets</th><th>Created</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->sort_order }}</td><td class="fw-bold">{{ $category->name }}</td><td>{{ $category->slug }}</td>
                            <td>@if($category->icon)<i class="fa {{ $category->icon }}"></i> {{ $category->icon }}@else - @endif</td>
                            <td>{{ Str::limit($category->description, 50) ?: '-' }}</td>
                            <td><span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td>{{ $category->tickets_count ?? $category->tickets->count() }}</td><td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.support.categories.show', $category) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.support.categories.edit', $category) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.support.categories.toggle-status', $category) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button type="submit" class="btn btn-{{ $category->is_active ? 'secondary' : 'success' }} btn-sm"><i class="fas fa-{{ $category->is_active ? 'times' : 'check' }}"></i></button></form>
                                <form action="{{ route('admin.support.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center premium-muted py-4">No support categories found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
