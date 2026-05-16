@extends('admin.dashboard.master')

@section('title', 'Edit Knowledge Base Article')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Article: {{ $article->title }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.support.knowledge-base.show', $article) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <a href="{{ route('admin.support.knowledge-base.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Articles
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.support.knowledge-base.update', $article) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Article Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $article->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                           id="slug" name="slug" value="{{ old('slug', $article->slug) }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">URL-friendly identifier</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                           id="tags" name="tags" value="{{ old('tags') ? implode(',', old('tags')) : ($article->tags ? implode(',', $article->tags) : '') }}"
                                           placeholder="Enter tags separated by commas">
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Separate multiple tags with commas</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="12" required>{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Use HTML for formatting if needed</small>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
                                       {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publish Article (visible to customers)
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Article
                            </button>
                            <a href="{{ route('admin.support.knowledge-base.show', $article) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate slug from article title (only if slug field is empty)
$('#title').on('input', function() {
    if (!$('#slug').val()) {
        var title = $(this).val();
        var slug = title.toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        $('#slug').val(slug);
    }
});

// Convert tags input to array for form submission
$('#tags').on('change', function() {
    const tags = $(this).val().split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
    // This will be handled by Laravel's array casting in the model
});
</script>
@endsection