@extends('admin.dashboard.master')

@section('title', 'Support Categories')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Support Categories</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.categories.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Category
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Icon</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Tickets</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $category->sort_order }}</td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            @if($category->icon)
                                                <i class="fa {{ $category->icon }}"></i> {{ $category->icon }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($category->description, 50) ?: '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $category->tickets_count ?? $category->tickets->count() }}</td>
                                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.support.categories.show', $category) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.support.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.support.categories.toggle-status', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-{{ $category->is_active ? 'secondary' : 'success' }} btn-sm"
                                                        onclick="return confirm('Are you sure you want to {{ $category->is_active ? 'deactivate' : 'activate' }} this category?')">
                                                    <i class="fas fa-{{ $category->is_active ? 'times' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.support.categories.destroy', $category) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No support categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection