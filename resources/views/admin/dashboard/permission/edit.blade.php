@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff; padding: 20px;">

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white py-3 px-4 rounded shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}" class="text-decoration-none"><i class="fa fa-shield-alt"></i> Permissions</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-edit"></i> Edit Permission</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 font-weight-bold text-primary mb-0">
                        <i class="fa fa-shield-alt me-2"></i>Edit Permission
                    </h2>
                    <p class="text-strong mb-0" style="font-size:16px;color:green">Modify permission details below</p>
                </div>
                <div>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-light btn-lg border">
                        <i class="fa fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h4 class="card-title mb-0"><i class="fa fa-edit me-2"></i> Permission Details</h4>
                </div>
                <div class="card-body p-4">
                    <form id="editPermissionForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="permission_id" value="{{ $permission->id }}">

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter permission name" value="{{ old('name', $permission->name) }}">
                                    <label for="name"><i class="fa fa-key me-2"></i> Permission Name *</label>
                                    <div class="form-text">Enter a unique permission name</div>
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>
                            </div>

                            <!-- Key -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="key" name="key" placeholder="Enter key" value="{{ old('key', $permission->key) }}">
                                    <label for="key"><i class="fa fa-code me-2"></i> Key</label>
                                    <div class="form-text">Optional: Internal reference key</div>
                                    <div class="invalid-feedback" id="key-error"></div>
                                </div>
                            </div>

                            <!-- Table Name -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="table_name" name="table_name" placeholder="Enter table name" value="{{ old('table_name', $permission->table_name) }}">
                                    <label for="table_name"><i class="fa fa-table me-2"></i> Table Name</label>
                                    <div class="form-text">Related database table name</div>
                                    <div class="invalid-feedback" id="table_name-error"></div>
                                </div>
                            </div>

                            <!-- User Defined -->
                            <div class="col-md-12 mb-4">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fa fa-user-cog me-2"></i>User Defined Setting</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_user_defined" name="is_user_defined" value="1" {{ $permission->is_user_defined ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_user_defined">Is User Defined <span class="badge bg-info ms-2">Optional</span></label>
                                            <div class="form-text">Check if this permission can be modified by users</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" rows="3" style="height: 100px">{{ old('description', $permission->description) }}</textarea>
                                    <label for="description"><i class="fa fa-align-left me-2"></i>Description</label>
                                    <div class="form-text">Brief description about this permission</div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-light btn-lg me-2" onclick="resetForm()"><i class="fa fa-redo me-2"></i>Reset</button>
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                        <i class="fa fa-save me-2"></i><span id="submitText">Update Permission</span>
                                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-lg mb-4">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="card-title mb-0"><i class="fa fa-info-circle me-2"></i> Guidelines</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0">
                        <h6 class="alert-heading"><i class="fa fa-lightbulb me-2"></i>Best Practices</h6>
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
                    <h5 class="card-title mb-0"><i class="fa fa-exclamation-triangle me-2"></i> Quick Tips</h5>
                </div>
                <br>
                <div class="card-body">
                    <p class="small mb-0">Common Actions: create, read, update, delete, list, view</p>
                    <p class="small mb-0">Common Resources: user, role, permission, post, category</p>
                    <p class="small mb-0">Example Format: user-create, post-update, role-delete</p>
                </div>
            </div>
        </div>

    </div>
</section>

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
@endsection
@push('scripts')
<script>
$(document).ready(function(){
    // Real-time name validation
    $('#name').on('blur', function(){
        const name = $(this).val().trim();
        if(name){
            $.post("{{ route('admin.permissions.validate') }}", {_token: "{{ csrf_token() }}", name: name, id: $('#permission_id').val()}, function(response){
                if(!response.valid){
                    $('#name').addClass('is-invalid');
                    $('#name-error').text(response.message);
                } else {
                    $('#name').removeClass('is-invalid');
                    $('#name-error').text('');
                }
            });
        }
    });

    // AJAX form submission with Premium Toast
    $('#editPermissionForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#permission_id').val();
        const formData = $(this).serialize();
        $('#submitBtn').prop('disabled', true);
        $('#submitText').text('Updating...');
        $('#loadingSpinner').removeClass('d-none');

        $.ajax({
            url: `{{ url('permissions') }}/${id}`,
            type: 'POST',
            data: formData,
            success: function(response){
                showPremiumToast(
                    'success',
                    '<i class="fas fa-check-circle me-2"></i>Updated',
                    response.message || 'Permission updated successfully',
                    5000
                );
            },
            error: function(xhr){
                if(xhr.status === 422){
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages){
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '-error').text(messages[0]);
                    });
                    showPremiumToast(
                        'error',
                        '<i class="fas fa-times-circle me-2"></i>Validation Error',
                        'Please check your input and try again.',
                        5000
                    );
                } else {
                    showPremiumToast(
                        'error',
                        '<i class="fas fa-times-circle me-2"></i>Error',
                        'An error occurred. Please try again.',
                        5000
                    );
                }
            },
            complete: function(){
                $('#submitBtn').prop('disabled', false);
                $('#submitText').text('Update Permission');
                $('#loadingSpinner').addClass('d-none');
            }
        });
    });
});

function resetForm(){
    $('#editPermissionForm')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
}
</script>
@endpush
