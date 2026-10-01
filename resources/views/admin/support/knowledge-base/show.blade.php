@extends('admin.dashboard.master')

@section('title', 'Knowledge Base Article')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $article->title }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.knowledge-base.edit', $article) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.support.knowledge-base.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Articles
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Article Content -->
                            <div class="article-content">
                                {!! $article->content !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Article Meta -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Article Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th width="80">Status:</th>
                                            <td>
                                                <span class="badge badge-{{ $article->is_published ? 'success' : 'warning' }}">
                                                    {{ $article->is_published ? 'Published' : 'Draft' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Category:</th>
                                            <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Views:</th>
                                            <td>{{ $article->view_count }}</td>
                                        </tr>
                                        <tr>
                                            <th>Slug:</th>
                                            <td><code>{{ $article->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Created:</th>
                                            <td>{{ $article->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated:</th>
                                            <td>{{ $article->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    </table>

                                    @if($article->tags)
                                        <div class="mt-3">
                                            <strong>Tags:</strong><br>
                                            @foreach($article->tags as $tag)
                                                <span class="badge badge-light">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.article-content {
    line-height: 1.6;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.article-content code {
    background: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}

.article-content pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    overflow-x: auto;
    margin-bottom: 1rem;
}

.article-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin-left: 0;
    font-style: italic;
    color: #666;
}
</style>
@endsection