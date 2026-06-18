@extends('admin.dashboard.master')

@section('title', 'General Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<style>
    .general-settings-page {
        color: #111827;
        font-family: "Inter", "Segoe UI", Arial, sans-serif;
    }
    .general-settings-page .card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .08) !important;
    }
    .general-settings-page > .container-fluid > .row > .col-12 > .card > .card-header {
        background: linear-gradient(135deg, #111827 0%, #047857 100%) !important;
        border-bottom: 0 !important;
        border-radius: 8px 8px 0 0 !important;
        min-height: 76px;
        padding: 18px 22px;
    }
    .general-settings-page > .container-fluid > .row > .col-12 > .card > .card-header .card-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 0;
    }
    .general-settings-page > .container-fluid > .row > .col-12 > .card > .card-header .card-title i {
        color: #bbf7d0;
        margin-right: 8px;
    }
    .general-settings-page .card-tools .btn-tool {
        color: #ffffff;
    }
    .general-settings-page .settings-info-alert {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-left: 5px solid #059669;
        border-radius: 8px;
        color: #064e3b;
        font-size: 14px;
        margin-bottom: 20px;
        padding: 14px 16px;
    }
    .general-settings-page .settings-panel {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: none !important;
        height: 100%;
        overflow: hidden;
    }
    .general-settings-page .settings-panel .card-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 15px 18px;
    }
    .general-settings-page .settings-panel .card-title {
        color: #111827;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }
    .general-settings-page .settings-panel .card-title i {
        color: #059669;
        margin-right: 7px;
    }
    .general-settings-page label {
        color: #1f2937;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: 8px;
    }
    .general-settings-page .form-control,
    .general-settings-page .form-control-file {
        background: #ffffff;
        border: 1px solid #94a3b8;
        border-radius: 7px;
        color: #111827;
        font-size: 14px;
        font-weight: 650;
        min-height: 46px;
        padding: 10px 13px;
    }
    .general-settings-page textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    .general-settings-page .form-control::placeholder {
        color: #475569;
        font-weight: 650;
        opacity: 1;
    }
    .general-settings-page .form-control:focus,
    .general-settings-page .form-control-file:focus {
        border-color: #059669;
        box-shadow: 0 0 0 .2rem rgba(5, 150, 105, .16);
    }
    .general-settings-page .form-text {
        color: #64748b !important;
        font-size: 12px;
        font-weight: 650;
        margin-top: 7px;
    }
    .general-settings-page .logo-preview-box {
        align-items: center;
        background: #f8fafc;
        border: 1px dashed #94a3b8;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        min-height: 170px;
        padding: 18px;
    }
    .general-settings-page .logo-preview-box img {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        max-height: 135px;
        max-width: 190px;
        object-fit: contain;
        padding: 10px;
    }
    .general-settings-page .logo-empty-state {
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .general-settings-page .logo-empty-state i {
        color: #059669;
        display: block;
        margin-bottom: 10px;
    }
    .general-settings-page .settings-actions {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        padding: 16px;
    }
    .general-settings-page .settings-actions .btn {
        border-radius: 7px;
        font-weight: 800;
        min-height: 44px;
        padding-left: 16px;
        padding-right: 16px;
    }
    .general-settings-page .btn-primary {
        background: #059669;
        border-color: #059669;
    }
    @media (max-width: 767px) {
        .general-settings-page > .container-fluid > .row > .col-12 > .card > .card-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .general-settings-page .settings-actions .btn {
            width: 100%;
        }
    }
</style>
<section role="main" class="content-body premium-page premium-form general-settings-page">
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
                    <div class="settings-info-alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>General Settings:</strong> Configure your store identity, public admin title, brand description, and dashboard logo.
                    </div>

                    <form id="generalSettingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Site Information -->
                            <div class="col-md-8">
                                <div class="card card-outline card-primary settings-panel">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-store"></i> Site Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="admin_title">Site Title *</label>
                                            <input type="text" class="form-control" id="admin_title" name="admin_title"
                                                   value="{{ $settings->admin_title ?? '' }}" placeholder="Next Digi Home" required>
                                            <small class="form-text text-muted">The main title shown in admin, email templates, and brand surfaces.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="admin_description">Site Description</label>
                                            <textarea class="form-control" id="admin_description" name="admin_description"
                                                      rows="3" placeholder="Bangladesh largest digital products marketplace for premium products">{{ $settings->admin_description ?? '' }}</textarea>
                                            <small class="form-text text-muted">A short brand description used across admin screens and email branding.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Branding -->
                            <div class="col-md-4">
                                <div class="card card-outline card-success settings-panel">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-image"></i> Branding</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="form-group">
                                            <label for="admin_logo">Admin Logo</label>
                                            <div class="logo-preview-box mb-3" id="logoPreviewBox">
                                                @if(!empty($settings->admin_logo))
                                                    <img id="adminLogoPreview" src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}"
                                                         alt="Current Logo">
                                                @else
                                                    <div class="logo-empty-state" id="logoEmptyState">
                                                        <i class="fas fa-image fa-3x"></i>
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

                        <!-- Action Buttons -->
                        <div class="row mt-3">
                            <div class="col-12 settings-actions">
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
            $('#logoEmptyState').remove();
            if ($('#adminLogoPreview').length) {
                $('#adminLogoPreview').attr('src', e.target.result);
            } else {
                $('#logoPreviewBox').html('<img id="adminLogoPreview" src="' + e.target.result + '" alt="Selected Logo">');
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
</section>
@endsection
