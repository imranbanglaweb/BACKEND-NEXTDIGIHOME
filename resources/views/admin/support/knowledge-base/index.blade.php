@extends('admin.dashboard.master')

@section('title', 'Knowledge Base')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); min-height: 100vh; padding: 30px 0;">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Knowledge Base Articles</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.knowledge-base.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Article
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
                                <a class="nav-link {{ request()->routeIs('admin.support.knowledge-base.index') ? 'active' : '' }}"
                                   href="{{ route('admin.support.knowledge-base.index') }}">
                                    All Articles ({{ $articles->total() }})
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Tags</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($articles as $article)
                                    <tr>
                                        <td>
                                            <strong>{{ $article->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $article->slug }}</small>
                                        </td>
                                        <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $article->is_published ? 'success' : 'warning' }}">
                                                {{ $article->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>{{ $article->view_count }}</td>
                                        <td>
                                            @if($article->tags)
                                                @foreach($article->tags as $tag)
                                                    <span class="badge badge-light">{{ $tag }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $article->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.support.knowledge-base.show', $article) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.support.knowledge-base.edit', $article) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.support.knowledge-base.toggle-published', $article) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-{{ $article->is_published ? 'warning' : 'success' }} btn-sm"
                                                        onclick="return confirm('Are you sure you want to {{ $article->is_published ? 'unpublish' : 'publish' }} this article?')">
                                                    <i class="fas fa-{{ $article->is_published ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.support.knowledge-base.destroy', $article) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')">
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
                                        <td colspan="7" class="text-center">No knowledge base articles found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($articles->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $articles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection