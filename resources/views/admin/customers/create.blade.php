@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-user-plus me-3"></i>Add New Customer
                        </h2>
                        <p class="text-white-50 mb-0">Create a new customer account and profile</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
                            <i class="fas fa-users me-2"></i>All Customers
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-plus text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">45</h3>
                        <p class="text-muted mb-0">Customers Added Today</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-envelope text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">89%</h3>
                        <p class="text-muted mb-0">Email Verification Rate</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">2.5 min</h3>
                        <p class="text-muted mb-0">Avg Setup Time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-user-plus me-2"></i>Customer Registration Form
                            </h5>
                            <span class="badge badge-success">Coming Soon</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form id="customerForm" action="{{ route('admin.customers.store') }}" method="POST">
                            @csrf

                            <!-- Personal Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-user me-2"></i>Personal Information
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label fw-bold">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label fw-bold">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                        <option value="prefer_not_to_say">Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Address Information
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address_line_1" class="form-label fw-bold">Address Line 1</label>
                                    <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="Street address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address_line_2" class="form-label fw-bold">Address Line 2</label>
                                    <input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Apartment, suite, etc.">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="city" class="form-label fw-bold">City</label>
                                    <input type="text" class="form-control" id="city" name="city">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="state" class="form-label fw-bold">State/Province</label>
                                    <input type="text" class="form-control" id="state" name="state">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="postal_code" class="form-label fw-bold">Postal Code</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label fw-bold">Country</label>
                                    <select class="form-control" id="country" name="country">
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                        <option value="DE">Germany</option>
                                        <option value="FR">France</option>
                                        <option value="IT">Italy</option>
                                        <option value="ES">Spain</option>
                                        <option value="NL">Netherlands</option>
                                        <option value="SE">Sweden</option>
                                        <option value="NO">Norway</option>
                                        <option value="DK">Denmark</option>
                                        <option value="FI">Finland</option>
                                        <option value="BR">Brazil</option>
                                        <option value="MX">Mexico</option>
                                        <option value="AR">Argentina</option>
                                        <option value="CL">Chile</option>
                                        <option value="CO">Colombia</option>
                                        <option value="PE">Peru</option>
                                        <option value="VE">Venezuela</option>
                                        <option value="EC">Ecuador</option>
                                        <option value="UY">Uruguay</option>
                                        <option value="PY">Paraguay</option>
                                        <option value="BO">Bolivia</option>
                                        <option value="GY">Guyana</option>
                                        <option value="SR">Suriname</option>
                                        <option value="GF">French Guiana</option>
                                        <option value="JM">Jamaica</option>
                                        <option value="TT">Trinidad and Tobago</option>
                                        <option value="BB">Barbados</option>
                                        <option value="LC">Saint Lucia</option>
                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                        <option value="GD">Grenada</option>
                                        <option value="AG">Antigua and Barbuda</option>
                                        <option value="KN">Saint Kitts and Nevis</option>
                                        <option value="DM">Dominica</option>
                                        <option value="BS">Bahamas</option>
                                        <option value="CU">Cuba</option>
                                        <option value="HT">Haiti</option>
                                        <option value="DO">Dominican Republic</option>
                                        <option value="PR">Puerto Rico</option>
                                        <option value="VI">U.S. Virgin Islands</option>
                                        <option value="KY">Cayman Islands</option>
                                        <option value="BM">Bermuda</option>
                                        <option value="GL">Greenland</option>
                                        <option value="IS">Iceland</option>
                                        <option value="PT">Portugal</option>
                                        <option value="IE">Ireland</option>
                                        <option value="BE">Belgium</option>
                                        <option value="LU">Luxembourg</option>
                                        <option value="AT">Austria</option>
                                        <option value="CH">Switzerland</option>
                                        <option value="LI">Liechtenstein</option>
                                        <option value="MT">Malta</option>
                                        <option value="CY">Cyprus</option>
                                        <option value="GR">Greece</option>
                                        <option value="TR">Turkey</option>
                                        <option value="RU">Russia</option>
                                        <option value="UA">Ukraine</option>
                                        <option value="PL">Poland</option>
                                        <option value="CZ">Czech Republic</option>
                                        <option value="SK">Slovakia</option>
                                        <option value="HU">Hungary</option>
                                        <option value="RO">Romania</option>
                                        <option value="BG">Bulgaria</option>
                                        <option value="HR">Croatia</option>
                                        <option value="SI">Slovenia</option>
                                        <option value="BA">Bosnia and Herzegovina</option>
                                        <option value="ME">Montenegro</option>
                                        <option value="RS">Serbia</option>
                                        <option value="MK">North Macedonia</option>
                                        <option value="AL">Albania</option>
                                        <option value="XK">Kosovo</option>
                                        <option value="ME">Montenegro</option>
                                        <option value="IN">India</option>
                                        <option value="CN">China</option>
                                        <option value="JP">Japan</option>
                                        <option value="KR">South Korea</option>
                                        <option value="TW">Taiwan</option>
                                        <option value="HK">Hong Kong</option>
                                        <option value="MO">Macau</option>
                                        <option value="SG">Singapore</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="TH">Thailand</option>
                                        <option value="VN">Vietnam</option>
                                        <option value="PH">Philippines</option>
                                        <option value="ID">Indonesia</option>
                                        <option value="BN">Brunei</option>
                                        <option value="KH">Cambodia</option>
                                        <option value="LA">Laos</option>
                                        <option value="MM">Myanmar</option>
                                        <option value="LK">Sri Lanka</option>
                                        <option value="NP">Nepal</option>
                                        <option value="BT">Bhutan</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="PK">Pakistan</option>
                                        <option value="AF">Afghanistan</option>
                                        <option value="TJ">Tajikistan</option>
                                        <option value="KG">Kyrgyzstan</option>
                                        <option value="UZ">Uzbekistan</option>
                                        <option value="TM">Turkmenistan</option>
                                        <option value="IR">Iran</option>
                                        <option value="IQ">Iraq</option>
                                        <option value="SY">Syria</option>
                                        <option value="LB">Lebanon</option>
                                        <option value="JO">Jordan</option>
                                        <option value="PS">Palestine</option>
                                        <option value="IL">Israel</option>
                                        <option value="SA">Saudi Arabia</option>
                                        <option value="YE">Yemen</option>
                                        <option value="OM">Oman</option>
                                        <option value="AE">United Arab Emirates</option>
                                        <option value="QA">Qatar</option>
                                        <option value="KW">Kuwait</option>
                                        <option value="BH">Bahrain</option>
                                        <option value="EG">Egypt</option>
                                        <option value="LY">Libya</option>
                                        <option value="TN">Tunisia</option>
                                        <option value="DZ">Algeria</option>
                                        <option value="MA">Morocco</option>
                                        <option value="EH">Western Sahara</option>
                                        <option value="MR">Mauritania</option>
                                        <option value="ML">Mali</option>
                                        <option value="SN">Senegal</option>
                                        <option value="GM">Gambia</option>
                                        <option value="GN">Guinea</option>
                                        <option value="SL">Sierra Leone</option>
                                        <option value="LR">Liberia</option>
                                        <option value="CI">Ivory Coast</option>
                                        <option value="GH">Ghana</option>
                                        <option value="TG">Togo</option>
                                        <option value="BJ">Benin</option>
                                        <option value="NE">Niger</option>
                                        <option value="BF">Burkina Faso</option>
                                        <option value="CV">Cape Verde</option>
                                        <option value="NG">Nigeria</option>
                                        <option value="TD">Chad</option>
                                        <option value="CF">Central African Republic</option>
                                        <option value="CM">Cameroon</option>
                                        <option value="GQ">Equatorial Guinea</option>
                                        <option value="GA">Gabon</option>
                                        <option value="CG">Republic of the Congo</option>
                                        <option value="CD">Democratic Republic of the Congo</option>
                                        <option value="AO">Angola</option>
                                        <option value="ZW">Zimbabwe</option>
                                        <option value="ZM">Zambia</option>
                                        <option value="MW">Malawi</option>
                                        <option value="MZ">Mozambique</option>
                                        <option value="BW">Botswana</option>
                                        <option value="ZW">Zimbabwe</option>
                                        <option value="NA">Namibia</option>
                                        <option value="ZA">South Africa</option>
                                        <option value="SZ">Eswatini</option>
                                        <option value="LS">Lesotho</option>
                                        <option value="RW">Rwanda</option>
                                        <option value="BI">Burundi</option>
                                        <option value="TZ">Tanzania</option>
                                        <option value="UG">Uganda</option>
                                        <option value="KE">Kenya</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="SO">Somalia</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SS">South Sudan</option>
                                        <option value="UG">Uganda</option>
                                        <option value="KE">Kenya</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="SO">Somalia</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SS">South Sudan</option>
                                        <option value="UG">Uganda</option>
                                        <option value="KE">Kenya</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="SO">Somalia</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SS">South Sudan</option>
                                        <option value="UG">Uganda</option>
                                        <option value="KE">Kenya</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="SO">Somalia</option>
                                        <option value="DJ">Djibouti</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="SD">Sudan</option>
                                        <option value="SS">South Sudan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Account Settings -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-cog me-2"></i>Account Settings
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <small class="form-text text-muted">Minimum 8 characters</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_group" class="form-label fw-bold">Customer Group</label>
                                    <select class="form-control" id="customer_group" name="customer_group">
                                        <option value="">Select Group</option>
                                        <option value="vip">VIP Customers</option>
                                        <option value="regular">Regular Buyers</option>
                                        <option value="new">New Customers</option>
                                        <option value="wholesale">Wholesale Clients</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label fw-bold">Account Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="suspended">Suspended</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_marketing" name="email_marketing" checked>
                                        <label class="form-check-label" for="email_marketing">
                                            Subscribe to email marketing and newsletters
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications">
                                        <label class="form-check-label" for="sms_notifications">
                                            Receive SMS notifications for orders and updates
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>Create Customer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                            <h4 class="text-primary mb-3">Streamlined Customer Onboarding</h4>
                            <p class="text-muted mb-4">Automated customer registration, profile setup, and welcome email features coming soon.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.customers.index') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-users me-2"></i>All Customers
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .badge-success {
        background-color: #28a745;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>

<script>
$(document).ready(function() {
    // Form validation
    $('#customerForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();

        let isValid = true;

        // Required field validation
        const requiredFields = ['first_name', 'last_name', 'email', 'password', 'password_confirmation'];
        requiredFields.forEach(field => {
            const value = $('#' + field).val().trim();
            if (!value) {
                showError(field, 'This field is required');
                isValid = false;
            }
        });

        // Email validation
        const email = $('#email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            showError('email', 'Please enter a valid email address');
            isValid = false;
        }

        // Password confirmation
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        if (password && confirmPassword && password !== confirmPassword) {
            showError('password_confirmation', 'Passwords do not match');
            isValid = false;
        }

        // Password strength
        if (password && password.length < 8) {
            showError('password', 'Password must be at least 8 characters long');
            isValid = false;
        }

        if (isValid) {
            // Submit form
            this.submit();
        }
    });

    function showError(fieldId, message) {
        const field = $('#' + fieldId);
        field.addClass('is-invalid');
        field.closest('.mb-3').append('<div class="invalid-feedback">' + message + '</div>');
        $('.invalid-feedback').show();
    }

    // Real-time validation
    $('#email').on('blur', function() {
        const email = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        $(this).removeClass('is-invalid is-valid');
        $(this).closest('.mb-3').find('.invalid-feedback').remove();

        if (email && !emailRegex.test(email)) {
            showError('email', 'Please enter a valid email address');
        } else if (email) {
            $(this).addClass('is-valid');
        }
    });

    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();

        $(this).removeClass('is-invalid is-valid');
        $(this).closest('.mb-3').find('.invalid-feedback').remove();

        if (confirmPassword && password !== confirmPassword) {
            showError('password_confirmation', 'Passwords do not match');
        } else if (confirmPassword && password === confirmPassword) {
            $(this).addClass('is-valid');
        }
    });

    // Initialize Select2 for better UX
    $('.form-control').on('focus', function() {
        $(this).removeClass('is-invalid');
        $(this).closest('.mb-3').find('.invalid-feedback').remove();
    });
});
</script>
@endsection