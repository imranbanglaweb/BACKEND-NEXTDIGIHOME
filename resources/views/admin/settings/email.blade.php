@extends('admin.dashboard.master')

@section('title', 'Email Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope"></i> Email Settings
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
                        <strong>Email Configuration:</strong> Configure SMTP settings for sending emails from your application.
                    </div>

                    <form id="emailSettingsForm">
                        @csrf
                        <div class="row">
                            <!-- Mail Configuration -->
                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">Mail Configuration</h5>
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
                                                   value="{{ $settings->mail_host ?? 'smtp.gmail.com' }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_port">SMTP Port *</label>
                                            <input type="number" class="form-control" id="mail_port" name="mail_port"
                                                   value="{{ $settings->mail_port ?? 587 }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_encryption">Encryption</label>
                                            <select class="form-control" id="mail_encryption" name="mail_encryption">
                                                <option value="tls" {{ ($settings->mail_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ ($settings->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                                <option value="" {{ ($settings->mail_encryption ?? '') == '' ? 'selected' : '' }}>None</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Authentication & Sender -->
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">Authentication & Sender</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="mail_username">SMTP Username</label>
                                            <input type="text" class="form-control" id="mail_username" name="mail_username"
                                                   value="{{ $settings->mail_username ?? '' }}">
                                            <small class="form-text text-muted">Your email address</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_password">SMTP Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="mail_password" name="mail_password"
                                                       value="{{ $settings->mail_password ?? '' }}">
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
                                                   value="{{ $settings->mail_from_address ?? '' }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="mail_from_name">From Name *</label>
                                            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                                   value="{{ $settings->mail_from_name ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email Testing -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">Email Testing</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="test_email">Test Email Address</label>
                                                    <input type="email" class="form-control" id="test_email" placeholder="test@example.com">
                                                    <small class="form-text text-muted">Enter an email address to send a test message</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-info btn-block" onclick="sendTestEmail()">
                                                        <i class="fas fa-paper-plane"></i> Send Test Email
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <strong>Important:</strong> Save your email settings before testing. The test email will use the current configuration.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
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
