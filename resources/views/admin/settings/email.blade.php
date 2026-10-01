@extends('admin.dashboard.master')

@section('title', 'Email Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<style>
    .email-settings-page {
        color: #111827;
        font-family: "Inter", "Segoe UI", Arial, sans-serif;
    }
    .email-settings-page .card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .08) !important;
    }
    .email-settings-page > .container-fluid > .row > .col-12 > .card > .card-header {
        background: linear-gradient(135deg, #111827 0%, #1d4ed8 100%) !important;
        border-bottom: 0 !important;
        border-radius: 8px 8px 0 0 !important;
        min-height: 76px;
        padding: 18px 22px;
    }
    .email-settings-page > .container-fluid > .row > .col-12 > .card > .card-header .card-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 0;
    }
    .email-settings-page > .container-fluid > .row > .col-12 > .card > .card-header .card-title i {
        color: #bfdbfe;
        margin-right: 8px;
    }
    .email-settings-page .card-tools .btn-tool {
        color: #ffffff;
    }
    .email-settings-page .email-action-link {
        background: #ffffff;
        border: 1px solid rgba(255,255,255,.35);
        color: #1d4ed8;
        font-weight: 800;
        padding: 8px 12px;
    }
    .email-settings-page .email-action-link:hover {
        background: #eff6ff;
        color: #1e40af;
    }
    .email-settings-page .email-info-alert {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-left: 5px solid #2563eb;
        border-radius: 8px;
        color: #1e3a8a;
        font-size: 14px;
        margin-bottom: 20px;
        padding: 14px 16px;
    }
    .email-settings-page .email-panel {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        box-shadow: none !important;
        height: 100%;
        overflow: hidden;
    }
    .email-settings-page .email-panel .card-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 15px 18px;
    }
    .email-settings-page .email-panel .card-title {
        color: #111827;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }
    .email-settings-page .email-panel .card-title i {
        color: #2563eb;
        margin-right: 7px;
    }
    .email-settings-page label {
        color: #1f2937;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0;
        margin-bottom: 8px;
    }
    .email-settings-page .form-control {
        background: #ffffff;
        border: 1px solid #94a3b8;
        border-radius: 7px;
        color: #111827;
        font-size: 14px;
        font-weight: 650;
        min-height: 46px;
        padding: 10px 13px;
    }
    .email-settings-page .form-control::placeholder {
        color: #475569;
        font-weight: 650;
        opacity: 1;
    }
    .email-settings-page select.form-control {
        color: #111827;
        font-weight: 750;
    }
    .email-settings-page .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .16);
    }
    .email-settings-page .form-text {
        color: #64748b !important;
        font-size: 12px;
        font-weight: 650;
        margin-top: 7px;
    }
    .email-settings-page .input-group-append .btn {
        border-color: #94a3b8;
        border-radius: 0 7px 7px 0;
        min-height: 46px;
    }
    .email-settings-page .email-warning {
        background: #fffbeb;
        border: 1px solid #fbbf24;
        border-left: 5px solid #d97706;
        border-radius: 8px;
        color: #78350f;
        font-size: 13px;
        margin-bottom: 0;
    }
    .email-settings-page .email-actions {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        padding: 16px;
    }
    .email-settings-page .email-actions .btn,
    .email-settings-page .email-test-btn {
        border-radius: 7px;
        font-weight: 800;
        min-height: 44px;
        padding-left: 16px;
        padding-right: 16px;
    }
    .email-settings-page .btn-primary {
        background: #2563eb;
        border-color: #2563eb;
    }
    .email-settings-page .btn-info {
        background: #0891b2;
        border-color: #0891b2;
        color: #ffffff;
    }
    .email-settings-page .btn-warning {
        background: #d97706;
        border-color: #d97706;
        color: #ffffff;
    }
    @media (max-width: 767px) {
        .email-settings-page > .container-fluid > .row > .col-12 > .card > .card-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .email-settings-page .card-tools {
            margin-top: 12px;
        }
        .email-settings-page .email-actions .btn {
            width: 100%;
        }
    }
</style>
<section role="main" class="content-body premium-page premium-form email-settings-page">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope"></i> Email Settings
                    </h3>
                    <div class="card-tools">
                        @if(Route::has('email-templates.index'))
                            <a href="{{ route('email-templates.index') }}" class="btn btn-sm email-action-link mr-2">
                                <i class="fas fa-envelope-open-text"></i> Email Templates
                            </a>
                        @endif
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="email-info-alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>Email Configuration:</strong> Configure SMTP delivery, sender identity, and test outbound mail for your digital product store.
                    </div>

                    <form id="emailSettingsForm">
                        @csrf
                        <div class="row">
                            <!-- Mail Configuration -->
                            <div class="col-md-6">
                                <div class="card card-outline card-primary email-panel">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-server"></i> Mail Configuration</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="mail_mailer">Mail Driver *</label>
                                            <select class="form-control" id="mail_mailer" name="mail_mailer" required>
                                                <option value="smtp" {{ ($settings->mail_mailer ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                                <option value="sendmail" {{ ($settings->mail_mailer ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                                <option value="log" {{ ($settings->mail_mailer ?? '') == 'log' ? 'selected' : '' }}>Log (for testing)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_host">SMTP Host *</label>
                                            <input type="text" class="form-control" id="mail_host" name="mail_host"
                                                   value="{{ $settings->mail_host ?? 'smtp.gmail.com' }}" placeholder="smtp.gmail.com" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_port">SMTP Port *</label>
                                            <input type="number" class="form-control" id="mail_port" name="mail_port"
                                                   value="{{ $settings->mail_port ?? 587 }}" placeholder="587" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_encryption">Encryption</label>
                                            @php($mailEncryption = $settings->mail_encryption ?? null)
                                            <select class="form-control" id="mail_encryption" name="mail_encryption">
                                                <option value="tls" {{ $mailEncryption === 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ $mailEncryption === 'ssl' ? 'selected' : '' }}>SSL</option>
                                                <option value="none" {{ empty($mailEncryption) ? 'selected' : '' }}>None</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Authentication & Sender -->
                            <div class="col-md-6">
                                <div class="card card-outline card-success email-panel">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-user-shield"></i> Authentication & Sender</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="mail_username">SMTP Username</label>
                                            <input type="text" class="form-control" id="mail_username" name="mail_username"
                                                   value="{{ $settings->mail_username ?? '' }}" placeholder="your-email@gmail.com">
                                            <small class="form-text text-muted">Usually your SMTP account email address.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_password">SMTP Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="mail_password" name="mail_password"
                                                       value="{{ $settings->mail_password ?? '' }}" placeholder="App password or SMTP secret">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('mail_password')">
                                                        <i class="fas fa-eye" id="mail_password_toggle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">For Gmail, use App Password</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_from_address">From Email Address *</label>
                                            <input type="email" class="form-control" id="mail_from_address" name="mail_from_address"
                                                   value="{{ $settings->mail_from_address ?? '' }}" placeholder="noreply@nextdigihome.com" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_from_name">From Name *</label>
                                            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                                   value="{{ $settings->mail_from_name ?? '' }}" placeholder="Next Digi Home" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Testing -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-info email-panel">
                                    <div class="card-header">
                                        <h5 class="card-title"><i class="fas fa-paper-plane"></i> Email Testing</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="test_email">Test Email Address</label>
                                                    <input type="email" class="form-control" id="test_email" placeholder="customer@example.com">
                                                    <small class="form-text text-muted">Enter an email address to send a test message</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-info btn-block email-test-btn" onclick="sendTestEmail()">
                                                        <i class="fas fa-paper-plane"></i> Send Test Email
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert email-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <strong>Important:</strong> Save your email settings before testing. The test email will use the current configuration.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-3">
                            <div class="col-12 email-actions">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save Email Settings
                                </button>
                                <button type="button" class="btn btn-warning btn-lg ml-2" onclick="clearMailCache()">
                                    <i class="fas fa-broom"></i> Clear Mail Cache
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
$('#emailSettingsForm').submit(function(e) {
    e.preventDefault();

    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.settings.email.update") }}',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error('Failed to save email settings');
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

function togglePassword(inputId) {
    const input = $('#' + inputId);
    const toggle = $('#' + inputId + '_toggle');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        toggle.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        toggle.removeClass('fa-eye-slash').addClass('fa-eye');
    }
}

function sendTestEmail() {
    const testEmail = $('#test_email').val();
    if (!testEmail) {
        toastr.error('Please enter a test email address');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.email.test.send") }}',
        data: {
            _token: '{{ csrf_token() }}',
            email: testEmail
        },
        success: function(response) {
            toastr.success('Test email sent successfully!');
        },
        error: function() {
            toastr.error('Failed to send test email');
        }
    });
}

function clearMailCache() {
    if (!confirm('Are you sure you want to clear the mail configuration cache?')) {
        return;
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.mail.clear-cache") }}',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            toastr.success('Mail cache cleared successfully');
        },
        error: function() {
            toastr.error('Failed to clear mail cache');
        }
    });
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        $('#emailSettingsForm')[0].reset();
    }
}
</script>
</section>
@endsection
