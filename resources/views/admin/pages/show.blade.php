@extends('admin.dashboard.master')

@section('title', 'Page Content Details')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1"><i class="fas fa-eye me-3"></i>Page Content Details</h2>
                        <p class="text-white-50 mb-0">{{ ucfirst($pageContent->page) }} / {{ ucfirst($pageContent->section) }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.pages.edit', $pageContent) }}" class="btn btn-light">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Pages
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-md-3">Page</dt>
                    <dd class="col-md-9">{{ $pageContent->page }}</dd>

                    <dt class="col-md-3">Section</dt>
                    <dd class="col-md-9">{{ $pageContent->section }}</dd>

                    <dt class="col-md-3">Title</dt>
                    <dd class="col-md-9">{{ $pageContent->title ?: 'No title' }}</dd>

                    <dt class="col-md-3">Subtitle</dt>
                    <dd class="col-md-9">{{ $pageContent->subtitle ?: 'No subtitle' }}</dd>

                    <dt class="col-md-3">Content</dt>
                    <dd class="col-md-9">{!! $pageContent->content ?: '<span class="text-muted">No content</span>' !!}</dd>

                    <dt class="col-md-3">Image</dt>
                    <dd class="col-md-9">
                        @if($pageContent->image)
                            <img src="{{ asset($pageContent->image) }}" alt="{{ $pageContent->title ?: 'Page content image' }}" class="img-fluid rounded mb-2" style="max-height: 220px;">
                            <div class="text-muted small">{{ $pageContent->image }}</div>
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </dd>

                    <dt class="col-md-3">Link</dt>
                    <dd class="col-md-9">
                        @if($pageContent->link_url)
                            <a href="{{ $pageContent->link_url }}" target="_blank" rel="noopener">{{ $pageContent->link_text ?: $pageContent->link_url }}</a>
                        @else
                            <span class="text-muted">No link</span>
                        @endif
                    </dd>

                    <dt class="col-md-3">Sort Order</dt>
                    <dd class="col-md-9">{{ $pageContent->sort_order }}</dd>

                    <dt class="col-md-3">Status</dt>
                    <dd class="col-md-9">
                        <span class="badge bg-{{ $pageContent->is_active ? 'success' : 'secondary' }}">{{ $pageContent->is_active ? 'Active' : 'Inactive' }}</span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</section>
@endsection
