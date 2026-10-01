@extends('admin.dashboard.master')

@section('title', 'Edit Testimonial')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">Client Feedback</div>
                <h2>Edit Testimonial</h2>
                <p>Update client feedback from: <strong>{{ $testimonial->name }}</strong></p>
            </div>
            <div class="premium-actions">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to Testimonials
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="premium-card">
                    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data" class="premium-form">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label">Client / Reviewer Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $testimonial->name) }}" placeholder="e.g. Sarah Jenkins" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="position" class="form-label">Role / Designation</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $testimonial->position) }}" placeholder="e.g. Chief Marketing Officer">
                                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="company" class="form-label">Company / Organization</label>
                                <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company', $testimonial->company) }}" placeholder="e.g. Apex Global Ventures">
                                @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="content" class="form-label">Testimonial Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" placeholder="Quote or detailed feedback from the client..." required>{{ old('content', $testimonial->content) }}</textarea>
                                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="rating" class="form-label">Star Rating (1 to 5)</label>
                                @php $currentRating = old('rating', $testimonial->rating ?? 5); @endphp
                                <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating">
                                    <option value="5" {{ $currentRating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
                                    <option value="4" {{ $currentRating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars</option>
                                    <option value="3" {{ $currentRating == 3 ? 'selected' : '' }}>⭐⭐⭐ 3 Stars</option>
                                    <option value="2" {{ $currentRating == 2 ? 'selected' : '' }}>⭐⭐ 2 Stars</option>
                                    <option value="1" {{ $currentRating == 1 ? 'selected' : '' }}>⭐ 1 Star</option>
                                </select>
                                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="image" class="form-label">Client Avatar / Photo</label>
                                @if($testimonial->image)
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover; border: 1px solid #e5e7eb;">
                                        <small class="text-muted">Current photo</small>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4">
                                <label for="sort_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0">
                                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 d-flex align-items-center pt-2">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 fw-bold" for="is_active">Active & Visible on Frontend</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Testimonial
                            </button>
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
