@extends('admin.dashboard.master')

@section('title', 'Notifications Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bell"></i> Notification Settings
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
                        <strong>Notification Configuration:</strong> Configure how and when notifications are sent to users and administrators.
                    </div>

                    <form id="notificationSettingsForm">
                        @csrf
                        <div class="row">
                            <!-- Notification Types -->
                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">Notification Types</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="email_notifications"
                                                   name="email_notifications" value="1"
                                                   {{ ($settings->email_notifications ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="email_notifications">
                                                <i class="fas fa-envelope text-primary me-2"></i>
                                                <strong>Email Notifications</strong>
                                            </label>
                                            <small class="form-text text-muted d-block">Send notifications via email</small>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="push_notifications"
                                                   name="push_notifications" value="1"
                                                   {{ ($settings->push_notifications ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="push_notifications">
                                                <i class="fas fa-mobile-alt text-success me-2"></i>
                                                <strong>Push Notifications</strong>
                                            </label>
                                            <small class="form-text text-muted d-block">Send browser push notifications</small>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="sms_notifications"
                                                   name="sms_notifications" value="1"
                                                   {{ ($settings->sms_notifications ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sms_notifications">
                                                <i class="fas fa-sms text-info me-2"></i>
                                                <strong>SMS Notifications</strong>
                                            </label>
                                            <small class="form-text text-muted d-block">Send text message notifications</small>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="in_app_notifications"
                                                   name="in_app_notifications" value="1"
                                                   {{ ($settings->in_app_notifications ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="in_app_notifications">
                                                <i class="fas fa-bell text-warning me-2"></i>
                                                <strong>In-App Notifications</strong>
                                            </label>
                                            <small class="form-text text-muted d-block">Show notifications within the application</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Settings -->
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">Notification Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="notification_email">Admin Notification Email</label>
                                            <input type="email" class="form-control" id="notification_email"
                                                   name="notification_email"
                                                   value="{{ $settings->notification_email ?? '' }}"
                                                   placeholder="admin@example.com">
                                            <small class="form-text text-muted">Email address for system notifications</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="notification_frequency">Notification Frequency</label>
                                            <select class="form-control" id="notification_frequency" name="notification_frequency">
                                                <option value="immediate" {{ ($settings->notification_frequency ?? 'immediate') == 'immediate' ? 'selected' : '' }}>Immediate</option>
                                                <option value="hourly" {{ ($settings->notification_frequency ?? '') == 'hourly' ? 'selected' : '' }}>Hourly Digest</option>
                                                <option value="daily" {{ ($settings->notification_frequency ?? '') == 'daily' ? 'selected' : '' }}>Daily Digest</option>
                                                <option value="weekly" {{ ($settings->notification_frequency ?? '') == 'weekly' ? 'selected' : '' }}>Weekly Digest</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="max_notifications">Max Notifications per Hour</label>
                                            <input type="number" class="form-control" id="max_notifications"
                                                   name="max_notifications" min="1" max="1000"
                                                   value="{{ $settings->max_notifications ?? 100 }}">
                                            <small class="form-text text-muted">Limit notifications to prevent spam</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Event Notifications -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">Event Notifications</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3"><i class="fas fa-user-plus me-2"></i>User Events</h6>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="notify_user_registration" name="notify_user_registration">
                                                    <label class="form-check-label" for="notify_user_registration">
                                                        New user registrations
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="notify_user_login" name="notify_user_login">
                                                    <label class="form-check-label" for="notify_user_login">
                                                        User login attempts
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="notify_password_reset" name="notify_password_reset">
                                                    <label class="form-check-label" for="notify_password_reset">
                                                        Password reset requests
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <h6 class="text-success mb-3"><i class="fas fa-shopping-cart me-2"></i>Business Events</h6>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="notify_new_orders" name="notify_new_orders">
                                                    <label class="form-check-label" for="notify_new_orders">
                                                        New orders
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="notify_payment_received" name="notify_payment_received">
                                                    <label class="form-check-label" for="notify_payment_received">
                                                        Payment received
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="notify_system_errors" name="notify_system_errors">
                                                    <label class="form-check-label" for="notify_system_errors">
                                                        System errors
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification Templates -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h5 class="card-title">Notification Templates</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-3">Configure email templates for different notification types.</p>
                                        @php
                                            $emailTemplatesRoute = null;

                                            if (Route::has('admin.email-templates.index')) {
                                                $emailTemplatesRoute = route('admin.email-templates.index');
                                            } elseif (Route::has('email-templates.index')) {
                                                $emailTemplatesRoute = route('email-templates.index');
                                            }
                                        @endphp
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($emailTemplatesRoute)
                                                <a href="{{ $emailTemplatesRoute }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-envelope"></i> Email Templates
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-outline-info" onclick="testNotification()">
                                                <i class="fas fa-paper-plane"></i> Send Test Notification
                                            </button>
                                            <button type="button" class="btn btn-outline-success" onclick="viewNotificationLogs()">
                                                <i class="fas fa-history"></i> View Notification Logs
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save Notification Settings
                                </button>
                                <button type="button" class="btn btn-info btn-lg ml-2" onclick="testAllNotifications()">
                                    <i class="fas fa-vial"></i> Test All Notifications
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
$('#notificationSettingsForm').submit(function(e) {
    e.preventDefault();

    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.settings.notifications.update") }}',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error('Failed to save notification settings');
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

function testNotification() {
    const email = prompt('Enter test email address:');
    if (email) {
        // Send test notification
        toastr.info('Sending test notification...');
        // AJAX call would go here
        setTimeout(() => toastr.success('Test notification sent!'), 1000);
    }
}

function testAllNotifications() {
    if (!confirm('This will send test notifications through all enabled channels. Continue?')) {
        return;
    }
    toastr.info('Testing all notification channels...');
    // Implementation would go here
}

function viewNotificationLogs() {
    // Redirect to notification logs or open modal
    toastr.info('Notification logs feature coming soon');
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        $('#notificationSettingsForm')[0].reset();
    }
}
</script>
</section>
@endsection
