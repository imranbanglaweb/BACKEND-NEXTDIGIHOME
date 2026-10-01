@extends('admin.dashboard.master')

@section('title', 'View Category')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $category->category_name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $category->category_name }}</p>
                            <p><strong>Slug:</strong> {{ $category->category_slug }}</p>
                            <p><strong>Status:</strong>
                                @if($category->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </p>
                            <p><strong>Created At:</strong> {{ $category->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Updated At:</strong> {{ $category->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection