@extends('admin.dashboard.master')

@section('title', 'General Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs"></i> General Settings
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>General Settings:</strong> Configure basic application settings including site title, description, and branding.
                    </div>

                    <form id="generalSettingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Site Information -->
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">Site Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="admin_title">Site Title *</label>
                                            <input type="text" class="form-control" id="admin_title" name="admin_title"
                                                   value="{{ $settings->admin_title ?? '' }}" required>
                                            <small class="form-text text-muted">The main title of your application</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="admin_description">Site Description</label>
                                            <textarea class="form-control" id="admin_description" name="admin_description"
                                                      rows="3">{{ $settings->admin_description ?? '' }}</textarea>
                                            <small class="form-text text-muted">A brief description of your application</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Branding -->
                            <div class="col-md-4">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">Branding</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="form-group">
                                            <label for="admin_logo">Admin Logo</label>
                                            <div class="mb-3">
                                                @if(!empty($settings->admin_logo))
                                                    <img src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}"
                                                         alt="Current Logo" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                                @else
                                                    <div class="text-muted">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>No logo uploaded</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" class="form-control-file" id="admin_logo" name="admin_logo"
                                                   accept="image/*">
                                            <small class="form-text text-muted">Recommended: PNG, JPG, SVG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Application Settings -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h5 class="card-title">Application Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="timezone">Timezone</label>
                                                    <select class="form-control" id="timezone" name="timezone">
                                                        <option value="UTC">UTC</option>
                                                        <option value="America/New_York">Eastern Time</option>
                                                        <option value="America/Chicago">Central Time</option>
                                                        <option value="America/Denver">Mountain Time</option>
                                                        <option value="America/Los_Angeles">Pacific Time</option>
                                                        <option value="Europe/London">London</option>
                                                        <option value="Europe/Paris">Paris</option>
                                                        <option value="Asia/Tokyo">Tokyo</option>
                                                        <option value="Asia/Kolkata">India</option>
                                                        <option value="Australia/Sydney">Sydney</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date_format">Date Format</label>
                                                    <select class="form-control" id="date_format" name="date_format">
                                                        <option value="Y-m-d">YYYY-MM-DD</option>
                                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                                        <option value="d-m-Y">DD-MM-YYYY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save General Settings
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg ml-2" onclick="resetForm()">
                                    <i class="fas fa-undo"></i> Reset Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#generalSettingsForm').submit(function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.settings.general.update") }}',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                toastr.error('Failed to save settings');
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON?.errors || ['An error occurred'];
            errors.forEach(error => toastr.error(error));
        },
        complete: function() {
            submitBtn.prop('disabled', false).html(originalText);
        }
    });
});

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        $('#generalSettingsForm')[0].reset();
    }
}

// Preview logo before upload
$('#admin_logo').change(function() {
    let file = this.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            // Could add preview functionality here
        };
        reader.readAsDataURL(file);
    }
});
</script>
</section>
@endsection
