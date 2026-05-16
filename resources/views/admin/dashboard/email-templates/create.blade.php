@extends('admin.dashboard.master')

@section('title')
Create Email Template
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
<style>
    .card { border-radius: 8px; }
    .card-header { border-radius: 8px 8px 0 0; }
    .error-message { color: #dc3545; font-size: 12px; margin-top: 4px; display: none; }
    .form-control.is-invalid { border-color: #dc3545; }
</style>
@endpush

@section('main_content')
<section role="main" class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fa fa-envelope"></i> Create Email Template</h4>
                    </div>
                    <div class="card-body">
                        
                        <form id="emailTemplateForm" action="{{ route('email-templates.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Template Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                    <small class="error-message" id="error-name" style="color: #dc3545;"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}">
                                    <small class="error-message" id="error-slug" style="color: #dc3545;"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Template Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select Type</option>
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <small class="error-message" id="error-type" style="color: #dc3545;"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Email Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}">
                                    <small class="error-message" id="error-subject" style="color: #dc3545;"></small>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Email Body <span class="text-danger">*</span></label>
                                    <textarea name="body" id="body" class="form-control" rows="6">{{ old('body') }}</textarea>
                                    <small class="text-muted" style="font-size: 11px;">Use {{ '{' }}{{ '{' }}variable{{ '}' }}{{ '}' }} for dynamic content</small>
                                    <small class="error-message" id="error-body" style="color: #dc3545;"></small>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Variables (JSON)</label>
                                    <textarea name="variables" class="form-control" rows="2">{{ old('variables') }}</textarea>
                                    <small class="error-message" id="error-variables" style="color: #dc3545;"></small>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="fa fa-save"></i> Create Template
                                </button>
                                <a href="{{ route('email-templates.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slug').value = slug;
    });

    // Clear errors on input
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            let errorEl = document.getElementById('error-' + this.name);
            if (errorEl) errorEl.style.display = 'none';
        });
    });

    // Form submission
    document.getElementById('emailTemplateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let form = this;
        let formData = new FormData(form);
        let submitBtn = document.getElementById('submitBtn');
        
        // Clear all previous errors
        document.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-invalid');
        });
        document.querySelectorAll('.error-message').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa fa-save"></i> Create Template';
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Email template created successfully!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect || '{{ route("email-templates.index") }}';
                });
            } else {
                // Show inline errors
                if (data.errors) {
                    for (let key in data.errors) {
                        let input = document.querySelector('[name="' + key + '"]');
                        if (input) {
                            input.classList.add('is-invalid');
                            let errorEl = document.getElementById('error-' + key);
                            if (errorEl) {
                                errorEl.textContent = data.errors[key][0];
                                errorEl.style.display = 'block';
                            }
                        }
                    }
                    
                    // Show summary in SweetAlert
                    let errorCount = Object.keys(data.errors).length;
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please check the form and fix ' + errorCount + ' error(s)'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Something went wrong!'
                    });
                }
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa fa-save"></i> Create Template';
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Network error: ' + error.message
            });
        });
    });
});
</script>
@endpush
