@extends('admin.dashboard.master')

@section('title', 'Payment Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card"></i> Payment Settings
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
                        <strong>Payment Configuration:</strong> Configure payment gateways and billing settings for your application.
                    </div>

                    <form id="paymentSettingsForm">
                        @csrf
                        <div class="row">
                            <!-- Payment Mode -->
                            <div class="col-md-12 mb-3">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">Payment Mode</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="payment_mode">Environment</label>
                                            <select class="form-control" id="payment_mode" name="payment_mode">
                                                <option value="sandbox" {{ ($settings->payment_mode ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox/Test Mode</option>
                                                <option value="live" {{ ($settings->payment_mode ?? '') == 'live' ? 'selected' : '' }}>Live/Production Mode</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Use sandbox mode for testing, live mode for production payments
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="payment_currency">Default Currency</label>
                                            <select class="form-control" id="payment_currency" name="payment_currency">
                                                <option value="USD" {{ ($settings->payment_currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                                <option value="EUR" {{ ($settings->payment_currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                                <option value="GBP" {{ ($settings->payment_currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                                <option value="JPY" {{ ($settings->payment_currency ?? '') == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                                                <option value="CAD" {{ ($settings->payment_currency ?? '') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                                <option value="AUD" {{ ($settings->payment_currency ?? '') == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Stripe Settings -->
                            <div class="col-md-6">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fab fa-stripe text-primary"></i> Stripe Configuration
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Keep your Stripe keys secure and never expose them in client-side code.
                                        </div>

                                        <div class="form-group">
                                            <label for="stripe_publishable_key">Stripe Publishable Key</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="stripe_publishable_key"
                                                       name="stripe_publishable_key"
                                                       value="{{ $settings->stripe_publishable_key ?? '' }}"
                                                       placeholder="pk_test_... or pk_live_...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleKey('stripe_publishable_key')">
                                                        <i class="fas fa-eye" id="stripe_publishable_key_toggle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Starts with pk_test_ (sandbox) or pk_live_ (live)</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="stripe_secret_key">Stripe Secret Key</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="stripe_secret_key"
                                                       name="stripe_secret_key"
                                                       value="{{ $settings->stripe_secret_key ?? '' }}"
                                                       placeholder="sk_test_... or sk_live_...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleKey('stripe_secret_key')">
                                                        <i class="fas fa-eye" id="stripe_secret_key_toggle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Starts with sk_test_ (sandbox) or sk_live_ (live)</small>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="stripe_webhook_verify" name="stripe_webhook_verify">
                                            <label class="form-check-label" for="stripe_webhook_verify">
                                                Enable webhook signature verification
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PayPal Settings -->
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fab fa-paypal text-info"></i> PayPal Configuration
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            PayPal integration requires proper API credentials and webhook setup.
                                        </div>

                                        <div class="form-group">
                                            <label for="paypal_client_id">PayPal Client ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="paypal_client_id"
                                                       name="paypal_client_id"
                                                       value="{{ $settings->paypal_client_id ?? '' }}"
                                                       placeholder="Your PayPal Client ID">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleKey('paypal_client_id')">
                                                        <i class="fas fa-eye" id="paypal_client_id_toggle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="paypal_client_secret">PayPal Client Secret</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="paypal_client_secret"
                                                       name="paypal_client_secret"
                                                       value="{{ $settings->paypal_client_secret ?? '' }}"
                                                       placeholder="Your PayPal Client Secret">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleKey('paypal_client_secret')">
                                                        <i class="fas fa-eye" id="paypal_client_secret_toggle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="paypal_sandbox" name="paypal_sandbox">
                                            <label class="form-check-label" for="paypal_sandbox">
                                                Use PayPal Sandbox (for testing)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Payment Settings -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h5 class="card-title">Additional Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="min_payment_amount">Minimum Payment Amount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" class="form-control" id="min_payment_amount"
                                                               name="min_payment_amount" step="0.01" min="0"
                                                               value="{{ $settings->min_payment_amount ?? '1.00' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="max_payment_amount">Maximum Payment Amount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" class="form-control" id="max_payment_amount"
                                                               name="max_payment_amount" step="0.01" min="0"
                                                               value="{{ $settings->max_payment_amount ?? '10000.00' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_timeout">Payment Timeout (minutes)</label>
                                                    <input type="number" class="form-control" id="payment_timeout"
                                                           name="payment_timeout" min="1" max="1440"
                                                           value="{{ $settings->payment_timeout ?? '30' }}">
                                                    <small class="form-text text-muted">Time before payment links expire</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="enable_refunds" name="enable_refunds">
                                                    <label class="form-check-label" for="enable_refunds">
                                                        Enable automatic refunds
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="require_billing_address" name="require_billing_address">
                                                    <label class="form-check-label" for="require_billing_address">
                                                        Require billing address for payments
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="enable_payment_logs" name="enable_payment_logs">
                                                    <label class="form-check-label" for="enable_payment_logs">
                                                        Enable detailed payment logging
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="send_payment_receipts" name="send_payment_receipts">
                                                    <label class="form-check-label" for="send_payment_receipts">
                                                        Automatically send payment receipts
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
                                    <i class="fas fa-save"></i> Save Payment Settings
                                </button>
                                <button type="button" class="btn btn-info btn-lg ml-2" onclick="testPaymentGateway()">
                                    <i class="fas fa-vial"></i> Test Gateway
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
$('#paymentSettingsForm').submit(function(e) {
    e.preventDefault();

    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.settings.payments.update") }}',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error('Failed to save payment settings');
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

function toggleKey(inputId) {
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

function testPaymentGateway() {
    toastr.info('Payment gateway testing feature coming soon');
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        $('#paymentSettingsForm')[0].reset();
    }
}

// Initialize password fields to be hidden by default
$(document).ready(function() {
    $('.form-control[type="password"]').each(function() {
        const inputId = $(this).attr('id');
        const toggle = $('#' + inputId + '_toggle');
        toggle.removeClass('fa-eye-slash').addClass('fa-eye');
    });
});
</script>
</section>
@endsection
