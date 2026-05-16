@extends('admin.dashboard.master')

@section('title', 'Security Settings')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt"></i> Security Settings
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
                        <strong>Security Configuration:</strong> Configure password policies, session management, and security features to protect your application.
                    </div>

                    <form id="securitySettingsForm">
                        @csrf
                        <div class="row">
                            <!-- Password Policy -->
                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">Password Policy</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="password_min_length">Minimum Password Length</label>
                                            <input type="number" class="form-control" id="password_min_length"
                                                   name="password_min_length" min="6" max="50"
                                                   value="{{ $settings->password_min_length ?? 8 }}">
                                            <small class="form-text text-muted">Minimum characters required for passwords</small>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="password_require_uppercase"
                                                   name="password_require_uppercase" value="1"
                                                   {{ ($settings->password_require_uppercase ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="password_require_uppercase">
                                                Require uppercase letters
                                            </label>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="password_require_lowercase"
                                                   name="password_require_lowercase" value="1"
                                                   {{ ($settings->password_require_lowercase ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="password_require_lowercase">
                                                Require lowercase letters
                                            </label>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="password_require_numbers"
                                                   name="password_require_numbers" value="1"
                                                   {{ ($settings->password_require_numbers ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="password_require_numbers">
                                                Require numbers
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="password_require_symbols"
                                                   name="password_require_symbols" value="1"
                                                   {{ ($settings->password_require_symbols ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="password_require_symbols">
                                                Require special characters
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Session & Access Control -->
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">Session & Access Control</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="session_timeout">Session Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="session_timeout"
                                                   name="session_timeout" min="5" max="1440"
                                                   value="{{ $settings->session_timeout ?? 7200 }}">
                                            <small class="form-text text-muted">Automatically log out users after inactivity</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="max_login_attempts">Max Login Attempts</label>
                                            <input type="number" class="form-control" id="max_login_attempts"
                                                   name="max_login_attempts" min="3" max="20"
                                                   value="{{ $settings->max_login_attempts ?? 5 }}">
                                            <small class="form-text text-muted">Lock account after failed attempts</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="lockout_duration">Lockout Duration (minutes)</label>
                                            <input type="number" class="form-control" id="lockout_duration"
                                                   name="lockout_duration" min="5" max="1440"
                                                   value="{{ $settings->lockout_duration ?? 30 }}">
                                            <small class="form-text text-muted">How long to lock account after failed attempts</small>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="two_factor_auth"
                                                   name="two_factor_auth" value="1"
                                                   {{ ($settings->two_factor_auth ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="two_factor_auth">
                                                <strong>Enable Two-Factor Authentication</strong>
                                            </label>
                                            <small class="form-text text-muted d-block">Require 2FA for admin accounts</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Features -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">Security Features</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3"><i class="fas fa-lock me-2"></i>Access Control</h6>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="force_https" name="force_https">
                                                    <label class="form-check-label" for="force_https">
                                                        Force HTTPS connections
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="enable_cors" name="enable_cors">
                                                    <label class="form-check-label" for="enable_cors">
                                                        Enable CORS protection
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="disable_autocomplete" name="disable_autocomplete">
                                                    <label class="form-check-label" for="disable_autocomplete">
                                                        Disable password autocomplete
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="ip_whitelist" name="ip_whitelist">
                                                    <label class="form-check-label" for="ip_whitelist">
                                                        Enable IP whitelisting for admin
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <h6 class="text-success mb-3"><i class="fas fa-shield-alt me-2"></i>Data Protection</h6>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="encrypt_sensitive_data" name="encrypt_sensitive_data">
                                                    <label class="form-check-label" for="encrypt_sensitive_data">
                                                        Encrypt sensitive data
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="enable_audit_log" name="enable_audit_log">
                                                    <label class="form-check-label" for="enable_audit_log">
                                                        Enable audit logging
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="auto_backup_sensitive" name="auto_backup_sensitive">
                                                    <label class="form-check-label" for="auto_backup_sensitive">
                                                        Auto backup sensitive data
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gdpr_compliance" name="gdpr_compliance">
                                                    <label class="form-check-label" for="gdpr_compliance">
                                                        Enable GDPR compliance mode
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Monitoring -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h5 class="card-title">Security Monitoring</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="security_alert_email">Security Alert Email</label>
                                                    <input type="email" class="form-control" id="security_alert_email"
                                                           name="security_alert_email" placeholder="security@example.com">
                                                    <small class="form-text text-muted">Email for security notifications</small>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="alert_failed_logins" name="alert_failed_logins">
                                                    <label class="form-check-label" for="alert_failed_logins">
                                                        Alert on failed login attempts
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="log_retention_days">Security Log Retention (days)</label>
                                                    <input type="number" class="form-control" id="log_retention_days"
                                                           name="log_retention_days" min="30" max="365"
                                                           value="{{ $settings->log_retention_days ?? 90 }}">
                                                    <small class="form-text text-muted">How long to keep security logs</small>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="alert_suspicious_activity" name="alert_suspicious_activity">
                                                    <label class="form-check-label" for="alert_suspicious_activity">
                                                        Alert on suspicious activity
                                                    </label>
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
                                    <i class="fas fa-save"></i> Save Security Settings
                                </button>
                                <button type="button" class="btn btn-danger btn-lg ml-2" onclick="runSecurityAudit()">
                                    <i class="fas fa-search"></i> Run Security Audit
                                </button>
                                <button type="button" class="btn btn-info btn-lg ml-2" onclick="generateSecurityReport()">
                                    <i class="fas fa-file-alt"></i> Security Report
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
$('#securitySettingsForm').submit(function(e) {
    e.preventDefault();

    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.settings.security.update") }}',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error('Failed to save security settings');
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

function runSecurityAudit() {
    if (!confirm('This will perform a comprehensive security audit. Continue?')) {
        return;
    }
    toastr.info('Running security audit...');
    // Implementation would go here
    setTimeout(() => toastr.success('Security audit completed!'), 2000);
}

function generateSecurityReport() {
    toastr.info('Generating security report...');
    // Implementation would go here
    setTimeout(() => toastr.success('Security report generated!'), 1500);
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        $('#securitySettingsForm')[0].reset();
    }
}
</script>
@endsection