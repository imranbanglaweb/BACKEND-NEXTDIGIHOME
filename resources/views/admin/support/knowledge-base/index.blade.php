@extends('admin.dashboard.master')

@section('title', 'Knowledge Base')

@section('main_content')
@include('admin.partials.premium-ui')
@php $visible = $articles->getCollection(); @endphp
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div><div class="premium-eyebrow">Support</div><h2>Knowledge Base</h2><p>Manage customer help articles, publishing state, and article visibility.</p></div>
            <div class="premium-actions"><a href="{{ route('admin.support.knowledge-base.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>New Article</a></div>
        </div>
        <div class="premium-nav">
            <a href="{{ route('admin.support.tickets.index') }}">Tickets</a>
            <a href="{{ route('admin.support.categories.index') }}">Categories</a>
            <a href="{{ route('admin.support.knowledge-base.index') }}" class="active">Knowledge Base</a>
        </div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-book-open"></i></span><div><small>Total Articles</small><strong>{{ number_format($articles->total()) }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-eye"></i></span><div><small>Published Visible</small><strong>{{ number_format($visible->where('is_published', true)->count()) }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-amber"><i class="fas fa-edit"></i></span><div><small>Draft Visible</small><strong>{{ number_format($visible->where('is_published', false)->count()) }}</strong></div></div></div>
        </div>
        <div class="premium-card">
            <div class="premium-card-title"><div><h5>Article Library</h5><p>Publish practical answers for repeated customer questions.</p></div></div>
            <div class="table-responsive">
                <table class="table premium-table">
                    <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Views</th><th>Tags</th><th>Created</th><th>Actions</th></tr></thead>
                    <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td><strong>{{ $article->title }}</strong><br><small class="premium-muted">{{ $article->slug }}</small></td>
                            <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                            <td><span class="badge bg-{{ $article->is_published ? 'success' : 'warning' }}">{{ $article->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td>{{ number_format($article->view_count) }}</td>
                            <td>@if($article->tags) @foreach($article->tags as $tag)<span class="badge bg-light text-dark">{{ $tag }}</span> @endforeach @else - @endif</td>
                            <td>{{ $article->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.support.knowledge-base.show', $article) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.support.knowledge-base.edit', $article) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.support.knowledge-base.toggle-published', $article) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button type="submit" class="btn btn-{{ $article->is_published ? 'warning' : 'success' }} btn-sm"><i class="fas fa-{{ $article->is_published ? 'eye-slash' : 'eye' }}"></i></button></form>
                                <form action="{{ route('admin.support.knowledge-base.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center premium-muted py-4">No knowledge base articles found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($articles->hasPages())<div class="d-flex justify-content-center mt-3">{{ $articles->links() }}</div>@endif
        </div>
    </div>
</section>
@endsection
