@extends('admin.dashboard.master')

@section('title', 'Edit Team Member')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">Agency Team</div>
                <h2>Edit Team Member</h2>
                <p>Update profile details for: <strong>{{ $teamMember->name }}</strong></p>
            </div>
            <div class="premium-actions">
                <a href="{{ route('admin.team-members.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to Team List
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
                    <form action="{{ route('admin.team-members.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data" class="premium-form">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $teamMember->name) }}" placeholder="e.g. Alex Rivera" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="position" class="form-label">Position / Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position', $teamMember->position) }}" placeholder="e.g. Head of AI Systems" required>
                                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="bio" class="form-label">Bio / Overview (Optional)</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $teamMember->bio) }}</textarea>
                                @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label">Profile Photo</label>
                                @if($teamMember->image)
                                    <div class="mb-2 d-flex align-items-center gap-3">
                                        <img src="{{ asset($teamMember->image) }}" alt="{{ $teamMember->name }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e5e7eb;">
                                        <small class="text-muted">Current photo: {{ basename($teamMember->image) }} (upload a new file to replace)</small>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="linkedin_url" class="form-label">LinkedIn Profile URL</label>
                                <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $teamMember->linkedin_url) }}" placeholder="https://linkedin.com/in/username">
                                @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="twitter_url" class="form-label">Twitter / X Profile URL</label>
                                <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $teamMember->twitter_url) }}" placeholder="https://x.com/username">
                                @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $teamMember->sort_order ?? 0) }}" min="0">
                                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 d-flex align-items-center pt-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 fw-bold" for="is_active">Active & Featured on Team Page</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Team Member
                            </button>
                            <a href="{{ route('admin.team-members.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
