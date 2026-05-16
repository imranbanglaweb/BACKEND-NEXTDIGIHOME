@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #f8f9fa; padding: 20px;">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white py-3 px-4 rounded shadow-sm">
                    
                    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}" class="text-decoration-none"><i class="fa fa-shield-alt"></i> Permissions</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-plus-circle"></i> Create New</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 font-weight-bold text-primary mb-0">
                        <i class="fa fa-shield-alt me-2"></i>Create New Permission
                    </h2>
                    <p class="text-strong mb-0" style="font-size:16px;color:green">Add a new permission to the system</p>
                </div>
                <div>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-light btn-lg border">
                        <i class="fa fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-edit me-2"></i> Permission Details
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form id="createPermissionForm" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Name Field -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Enter permission name"
                                           value="{{ old('name') }}"
                                           >
                                    <label for="name" class="form-label">
                                        <i class="fa fa-key me-2"></i> Permission Name *
                                    </label>
                                    <div class="form-text">Enter a unique permission name (e.g., user-create, post-delete)</div>
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>
                            </div>

                            <!-- Key Field -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('key') is-invalid @enderror" 
                                           id="key" 
                                           name="key" 
                                           placeholder="Enter key"
                                           value="{{ old('key') }}">
                                    <label for="key" class="form-label">
                                        <i class="fa fa-code me-2"></i> Key
                                    </label>
                                    <div class="form-text">Optional: Internal reference key</div>
                                    <div class="invalid-feedback" id="key-error"></div>
                                </div>
                            </div>

                            <!-- Table Name Field -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control @error('table_name') is-invalid @enderror" 
                                           id="table_name" 
                                           name="table_name" 
                                           placeholder="Enter table name"
                                           value="{{ old('table_name') }}">
                                    <label for="table_name" class="form-label">
                                        <i class="fa fa-table me-2"></i>Table Name
                                    </label>
                                    <div class="form-text">Related database table name</div>
                                    <div class="invalid-feedback" id="table_name-error"></div>
                                </div>
                            </div>

                            <!-- Is User Defined Field -->
                            <div class="col-md-12 mb-4">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <i class="fa fa-user-cog me-2"></i>User Defined Setting
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   role="switch" 
                                                   id="is_user_defined" 
                                                   name="is_user_defined" 
                                                   value="1"
                                                   {{ old('is_user_defined') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_user_defined">
                                                <strong>Is User Defined</strong>
                                                <span class="badge bg-info ms-2">Optional</span>
                                            </label>
                                            <div class="form-text">Check if this permission can be modified by users</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Field -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control" 
                                              id="description" 
                                              name="description" 
                                              placeholder="Enter description"
                                              rows="3"
                                              style="height: 100px">{{ old('description') }}</textarea>
                                    <label for="description" class="form-label">
                                        <i class="fa fa-align-left me-2"></i>Description
                                    </label>
                                    <div class="form-text">Brief description about this permission</div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-light btn-lg me-2" onclick="resetForm()">
                                        <i class="fa fa-redo me-2"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                        <i class="fa fa-save me-2"></i>
                                        <span id="submitText">Create Permission</span>
                                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-lg mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-info-circle me-2"></i> Guidelines
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0">
                        <h6 class="alert-heading">
                            <i class="fa fa-lightbulb me-2"></i>Best Practices
                        </h6>
                        <hr>
                        <ul class="mb-0 ps-3 guidlines-list">
                            <li class="mb-2">Use lowercase with hyphens (e.g., user-create)</li>
                            <li class="mb-2">Follow naming convention: resource-action</li>
                            <li class="mb-2">Keep names descriptive and clear</li>
                            <li class="mb-2">Avoid special characters</li>
                            <li>Make names unique across the system</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-exclamation-triangle me-2"></i> Quick Tips
                    </h5>
                </div>
                <br>
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon-shape bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fa fa-bolt text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Common Actions</h6>
                            <p class="small mb-0">create, read, update, delete, list, view</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fa fa-cube text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Common Resources</h6>
                            <p class="small mb-0">user, role, permission, post, category</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start">
                        <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fa fa-check-circle text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Example Format</h6>
                            <p class="small mb-0">user-create, post-update, role-delete</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 bg-success text-white">
                <h5 class="modal-title">
                    <i class="fa fa-check-circle me-2"></i>Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-5">
                <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-4 mb-4 d-inline-block">
                    <i class="fa fa-check fa-3x text-success"></i>
                </div>
                <h4 class="mb-3">Permission Created Successfully!</h4>
                <p class="text-muted" id="successMessage"></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary me-2" onclick="createAnother()">
                    <i class="fa fa-plus me-2"></i>Create Another
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-success">
                    <i class="fa fa-list me-2"></i>View All Permissions
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .card {
        border: none;
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .form-floating > .form-control:focus,
    .form-floating > .form-control:not(:placeholder-shown) {
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
    }
    
 
    .form-floating > label {
    padding: 1rem 2.75rem;
    font-size: 16px;
    color: #000;
}
.guidlines-list li{
    font-size: 15px;
    color: #000;

}

.card-body p{
    font-size: 15px;
    color: #165e26ff!imnportant;
}
    .form-text {
    font-size: 15px;
    color: #000;
    padding: 5px;
}
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .breadcrumb {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 5px;
    color: #fff;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add SweetAlert2 for better notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // AJAX Form Submission
    $('#createPermissionForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = $('#submitBtn');
        const submitText = $('#submitText');
        const loadingSpinner = $('#loadingSpinner');
        
        submitBtn.prop('disabled', true);
        submitText.text('Creating...');
        loadingSpinner.removeClass('d-none');
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Get form data
        const formData = new FormData(this);
        
        // Send AJAX request
        $.ajax({
            url: "{{ route('admin.permissions.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Show success modal
                $('#successMessage').text(response.message || 'Permission created successfully!');
                $('#successModal').modal('show');
                
                // Reset form
                resetForm();
            },
            error: function(xhr) {
                // Handle validation errors
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    
                    // Display field errors
                    $.each(errors, function(field, messages) {
                        const inputField = $('#' + field);
                        const errorDiv = $('#' + field + '-error');
                        
                        inputField.addClass('is-invalid');
                        errorDiv.text(messages[0]);
                    });
                    
                    // Show error using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fix the errors in the form.',
                        confirmButtonColor: '#3085d6',
                    });
                } else {
                    // Show general error using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false);
                submitText.text('Create Permission');
                loadingSpinner.addClass('d-none');
            }
        });
    });
    
    // Real-time validation for permission name
    $('#name').on('blur', function() {
        const name = $(this).val().trim();
        if (name) {
            validatePermissionName(name);
        }
    });
});

// Function to show alert using SweetAlert2
function showAlert(message, type = 'info', title = '') {
    const iconMap = {
        'success': 'success',
        'danger': 'error',
        'warning': 'warning',
        'info': 'info'
    };
    
    Swal.fire({
        icon: iconMap[type] || 'info',
        title: title || getDefaultTitle(type),
        text: message,
        confirmButtonColor: '#3085d6',
        timer: type === 'success' ? 3000 : null,
        timerProgressBar: type === 'success',
        showConfirmButton: type !== 'success'
    });
}

function getDefaultTitle(type) {
    const titles = {
        'success': 'Success!',
        'danger': 'Error!',
        'warning': 'Warning!',
        'info': 'Info'
    };
    return titles[type] || 'Notification';
}

// Function to validate permission name
function validatePermissionName(name) {
    $.ajax({
        url: "{{ route('admin.permissions.validate') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            name: name
        },
        success: function(response) {
            if (!response.valid) {
                $('#name').addClass('is-invalid');
                $('#name-error').text(response.message);
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                });
            } else {
                $('#name').removeClass('is-invalid');
                $('#name-error').text('');
            }
        },
        error: function() {
            // Don't show error for validation API failure
            $('#name').removeClass('is-invalid');
            $('#name-error').text('');
        }
    });
}

// Function to reset form
function resetForm() {
    $('#createPermissionForm')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    $('#name').focus();
}

// Function to create another permission
function createAnother() {
    $('#successModal').modal('hide');
    resetForm();
    
    // Show a small success message
    Swal.fire({
        icon: 'success',
        title: 'Ready for Next',
        text: 'Form has been reset. You can create another permission.',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });
    
    $('html, body').animate({
        scrollTop: $('#name').offset().top - 100
    }, 500);
}

// Add input validation styling
$('input, textarea').on('input', function() {
    if ($(this).hasClass('is-invalid')) {
        $(this).removeClass('is-invalid');
        const fieldName = $(this).attr('id');
        $('#' + fieldName + '-error').text('');
    }
});

// Add keyboard shortcut for reset (Ctrl + R)
$(document).keydown(function(e) {
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        resetForm();
        Swal.fire({
            icon: 'info',
            title: 'Form Reset',
            text: 'Form has been reset to default values.',
            timer: 1500,
            showConfirmButton: false
        });
    }
});

// Add tooltips to form labels
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

// Auto-focus name field on page load
$(window).on('load', function() {
    $('#name').focus();
});
</script>

@endsection