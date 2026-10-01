@extends('admin.dashboard.master')

@section('title', 'Add Contact Info')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">Contact Details</div>
                <h2>Add Contact Info</h2>
                <p>Create a new contact channel or office location details.</p>
            </div>
            <div class="premium-actions">
                <a href="{{ route('admin.contact-info.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
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
            <div class="col-lg-8">
                <div class="premium-card">
                    <form action="{{ route('admin.contact-info.store') }}" method="POST" class="premium-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Phone</option>
                                    <option value="whatsapp" {{ old('type') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="address" {{ old('type') == 'address' ? 'selected' : '' }}>Address / Office</option>
                                    <option value="hours" {{ old('type') == 'hours' ? 'selected' : '' }}>Business Hours</option>
                                    <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General Info</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="icon" class="form-label">FontAwesome Icon Class</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', 'fas fa-info-circle') }}" placeholder="e.g. fas fa-envelope, fas fa-phone">
                                @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="title" class="form-label">Label / Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Customer Support, Headquarters" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="value" class="form-label">Contact Value <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" placeholder="e.g. support@nextdigihome.com, +1 (555) 000-0000" required>
                                @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Brief note or instructions for visitors">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 d-flex align-items-center pt-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 fw-bold" for="is_active">Active & Visible on Website</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Contact Info
                            </button>
                            <a href="{{ route('admin.contact-info.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
