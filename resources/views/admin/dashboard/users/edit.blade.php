@extends('admin.dashboard.master')

@section('main_content')
<br><br>

<section role="main" class="content-body" style="background-color: #fff">
<div class="row">
    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h2>Edit User</h2>
            <a class="btn btn-primary" href="{{ route('users.index') }}"> <i class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-lg mt-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0" style="padding: 10px;"><i class="fa fa-user-edit"></i> Edit User Form</h4>
        </div>
        <div class="card-body">
            <form id="userForm" action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">

                    {{-- Employee --}}
                    <div class="col-md-6">
                        <label for="employee_id" class="form-label"><strong>Select Employee</strong></label>
                        <select name="employee_id" id="employee_id" class="form-control select2 employee_id">
                            <option value="">Please Select</option>
                            @foreach($employees as $list)
                                <option value="{{ $list->id }}" {{ $user->employee_id == $list->id ? 'selected' : '' }}>
                                    {{ $list->name }} -- {{ $list->employee_code }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Company --}}
                    <div class="col-md-6">
                        <label for="company_id" class="form-label"><strong>Select Company</strong></label>
                        <select name="company_id" id="company_id" class="form-control select2">
                            <option value="">Please Select</option>
                            @php
                                $companies = \App\Models\Company::orderBy('id', 'DESC')->get();
                            @endphp
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-6">
                        <label for="department_id" class="form-label"><strong>Select Department</strong></label>
                        <select name="department_id" id="department_id" class="form-control select2">
                            <option value="">Please Select</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                            
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Unit --}}
                    <div class="col-md-6">
                        <label for="unit_id" class="form-label"><strong>Select Unit</strong></label>
                        <select name="unit_id" id="unit_id" class="form-control select2">
                            <option value="">Please Select</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $user->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Location --}}
                    <div class="col-md-6">
                        <label for="location_id" class="form-label"><strong>Select Location</strong></label>
                        <select name="location_id" id="location_id" class="form-control select2">
                            <option value="">Please Select</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $user->location_id == $location->id ? 'selected' : '' }}>
                                    {{ $location->location_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Subscription Plan --}}
                    <div class="col-md-6">
                        <label for="subscription_plan_id" class="form-label"><strong>Select Subscription Plan</strong></label>
                        <select name="subscription_plan_id" id="subscription_plan_id" class="form-control select2">
                            <option value="">No Plan</option>
                            @forelse($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $user->subscription_plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} (৳{{ number_format($plan->price) }}/{{ $plan->billing_cycle }})
                                </option>
                            @empty
                                <option value="">No plans available</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- User Type --}}
                    <div class="col-md-6">
                        <label for="user_type" class="form-label"><strong>Select User Type <span class="text-danger">*</span></strong></label>
                        <select name="user_type" class="form-control select2 user_type">
                            <option value="">Please Select</option>
                            <option value="normal_user"     {{ $user->user_type = 'normal_user' ? 'selected' : '' }}>Normal User</option>
                            <option value="super_user"      {{ $user->user_type = 'super_user' ? 'selected' : '' }}>Super User</option>
                            <option value="admin"           {{ $user->user_type = 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="department_head" {{ $user->user_type = 'department_head' ? 'selected' : '' }}>Department Head</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Department Head Assignment (show only when Department Head is selected) --}}
                    @php
                        // Get departments where this user is assigned as head
                        $headDepartments = \App\Models\Department::where('head_employee_id', $user->employee_id)->get();
                    @endphp
                    <div class="col-md-6 department-head-section" style="display: {{ $user->user_type == 'department_head' ? 'block' : 'none' }};">
                        <label for="head_department_id" class="form-label"><strong>Select Department to Head <span class="text-danger">*</span></strong></label>
                        <select name="head_department_id" id="head_department_id" class="form-control select2">
                            <option value="">Please Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $headDepartments->contains($department->id) ? 'selected' : '' }}>
                                    {{ $department->department_name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Select the department this user will manage as Department Head</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="user_name" class="form-label"><strong>Name <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $user->name }}" placeholder="Enter User name" autocomplete="username">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="user_email" class="form-label"><strong>Email <span class="text-danger">*</span></strong></label>
                        <input type="email" class="form-control" id="user_email" name="email" value="{{ $user->email }}" placeholder="Enter User Email" autocomplete="email">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label for="user_phone" class="form-label"><strong>Phone Number <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="user_phone" name="phone" value="{{ $user->cell_phone }}" placeholder="Enter phone" autocomplete="tel">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label for="roles" class="form-label"><strong>Role <span class="text-danger">*</span></strong></label>
                        <select name="roles" class="form-control select2 roles">
                            <option value="">Please Select</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 position-relative">
                        <label for="user_password" class="form-label"><strong>New Password <small>(Optional)</small></strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="user_password" name="password" placeholder="Enter new password to change, leave empty to keep current" autocomplete="new-password">
                            <span class="input-group-text toggle-password" data-target="#user_password" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <small class="text-muted">Leave blank to keep current password unchanged</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 position-relative">
                        <label for="user_cpassword" class="form-label"><strong>Confirm New Password</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="user_cpassword" name="confirm-password" placeholder="Re-enter new password" autocomplete="new-password">
                            <span class="input-group-text toggle-password" data-target="#user_cpassword" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-6">
                        <label class="form-label"><strong>User Image Upload</strong></label>
                        <div class="text-center mb-3">
                            @php
                                $imagePath = public_path('admin_resource/assets/images/user_image/' . $user->user_image);
                                $imageUrl = asset('public/admin_resource/assets/images/user_image/default.png');
                                if (!empty($user->user_image) && file_exists($imagePath)) {
                                    $imageUrl = asset('public/admin_resource/assets/images/user_image/' . $user->user_image);
                                }
                            @endphp
                            <img id="previewImg" src="{{ $imageUrl }}" class="img-thumbnail rounded-circle" width="100" height="100" onerror="this.onerror=null;this.src='{{ asset('public/admin_resource/assets/images/user_image/default.png') }}'">
                        </div>
                        <input type="file" class="form-control" id="user_image" name="user_image" onchange="previewFile(this);">
                        <small class="form-text text-muted">
                            Allowed files: JPG, JPEG, PNG (Max size: 5MB)
                        </small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                            <i class="fa fa-save"></i> Update User
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>

{{-- Scripts --}}
{{-- Toastr for notifications --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" defer></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.addEventListener('load', function() {

    // Style invalid feedback in red
    $('head').append('<style>.invalid-feedback { display: block !important; color: #dc3545 !important; font-size: 13px; margin-top: 5px; }</style>');

    // Initialize Select2
    if ($('.select2').length) {
        $('.select2').select2({ 
            width: '100%',
            allowClear: true,
            placeholder: 'Please Select'
        });
    }

    // Custom server-side message map (fieldName -> custom message)
    const customServerMessages = {
        employee_id: 'Please select an employee.',
        company_id: 'Please choose a company.',
        user_type: 'Please choose a user type.',
        head_department_id: 'Please select department to assign as head.',
        user_name: 'Please enter the user name.',
        email: 'Please provide a valid email address.',
        phone: 'Please enter a valid phone number.',
        password: 'Password is required and must meet the criteria.',
        'confirm-password': 'Passwords must match.',
        roles: 'Please pick a role for this user.',
        user_image: 'Please upload a valid image (JPG/PNG, max 5MB).'
    };

    // Show/hide department head assignment section based on user type
    $('.user_type').on('change', function() {
        if ($(this).val() === 'department_head') {
            $('.department-head-section').show();
            $('#head_department_id').attr('required', true);
        } else {
            $('.department-head-section').hide();
            $('#head_department_id').removeAttr('required');
        }
    });

    // Initialize on page load if user_type is department_head
    $(document).ready(function() {
        if ($('.user_type').val() === 'department_head') {
            $('.department-head-section').show();
            $('#head_department_id').attr('required', true);
        }
    });

    // Toggle password visibility
    $(document).on('click', '.toggle-password', function () {
        const input = $($(this).data('target'));
        const icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Auto-populate fields when employee is selected
    $('#employee_id').on('change', function() {
        const employeeId = $(this).val();
        
        if (employeeId) {
            // Show loading indicator
            $('#company_id, #department_id, #unit_id, #location_id').next('.select2-container').find('.select2-selection').css('opacity', '0.6');
            
            // Make fields readonly while loading
            $('#company_id, #department_id, #unit_id, #location_id').prop('disabled', true);
            
            // Fetch employee details via AJAX
            fetch('{{ route('users.get-employee-details', ':employeeId') }}'.replace(':employeeId', employeeId))
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const employee = data.employee;
                        
                        // Auto-populate name, email, phone
                        $('#user_name').val(employee.name || '');
                        $('#user_email').val(employee.email || '');
                        $('#user_phone').val(employee.phone || '');
                        
                        // Auto-populate company (readonly)
                        if (employee.company_id) {
                            $('#company_id').val(employee.company_id).trigger('change');
                        }
                        $('#company_id').prop('disabled', true).addClass('bg-light');
                        
                        // Auto-populate department
                        if (employee.department_id) {
                            $('#department_id').val(employee.department_id).trigger('change');
                        }
                        $('#department_id').prop('disabled', true).addClass('bg-light');
                        
                        // Auto-populate unit
                        if (employee.unit_id) {
                            $('#unit_id').val(employee.unit_id).trigger('change');
                        }
                        $('#unit_id').prop('disabled', true).addClass('bg-light');
                        
                        // Auto-populate location
                        if (employee.location_id) {
                            $('#location_id').val(employee.location_id).trigger('change');
                        }
                        $('#location_id').prop('disabled', true).addClass('bg-light');
                    }
                })
                .catch(error => {
                    console.error('Error fetching employee details:', error);
                })
                .finally(() => {
                    $('#company_id, #department_id, #unit_id, #location_id').next('.select2-container').find('.select2-selection').css('opacity', '1');
                });
        } else {
            // Clear fields when no employee selected
            $('#user_name').val('');
            $('#user_email').val('');
            $('#user_phone').val('');
            $('#company_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
            $('#department_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
            $('#unit_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
            $('#location_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
        }
    });
    
    // Custom file size validation
    if ($.validator) {
        $.validator.addMethod("filesize", function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, "File size must be less than 5MB.");
    }

    // AJAX submission function (used by validator or fallback)
    function ajaxSubmit(form){
        let formData = new FormData(form);
        $.ajax({
            url: $(form).attr("action"),
            type: "POST", // Method spoofing handled by _method field
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("button[type='submit']").prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');
                $(".invalid-feedback").html(''); // clear old errors
                $(".is-invalid").removeClass("is-invalid");
            },
            success: function(response) {
                Swal.fire({
                    html: '<div class="text-center"><i class="fa fa-check-circle" style="font-size:56px;color:#28a745"></i><h3 style="margin-top:8px;margin-bottom:6px;">Success!</h3><div>User updated successfully.</div></div>',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    customClass: { popup: 'shadow-lg rounded-3' }
                });
            },
            error: function(xhr) {
                if(xhr.status === 422){ // Laravel validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages){
                        const baseField = field.split('.')[0];
                        const displayMsg = (customServerMessages[baseField] || customServerMessages[field]) ? (customServerMessages[baseField] || customServerMessages[field]) : messages[0];

                        // Find input element by baseField
                        let input = $(`[name="${baseField}"]`);

                        // If still not found, try exact field name
                        if (!input.length) {
                            input = $(`[name="${field}"]`);
                        }

                        // Mark invalid for select2-visible element
                        if (input.hasClass('select2-hidden-accessible')) {
                            const sel = input.next('.select2-container').find('.select2-selection');
                            sel.addClass('is-invalid');
                        } else {
                            input.addClass('is-invalid');
                        }

                        // Show error message in the nearest invalid-feedback container
                        const feedbackEl = input.closest('.col-md-6, .col-12').find('.invalid-feedback');
                        feedbackEl.html(displayMsg);

                        // Auto-hide inline error after 5 seconds
                        (function(inp, fb){
                            setTimeout(function(){
                                if (inp.hasClass('select2-hidden-accessible')) {
                                    inp.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                                } else {
                                    inp.removeClass('is-invalid');
                                }
                                fb.fadeOut(200, function(){ $(this).html('').show(); });
                            }, 5000);
                        })(input, feedbackEl);
                    });
                } else {
                    toastr.error("Something went wrong! Please try again.");
                }
            },
            complete: function() {
                $("button[type='submit']").prop("disabled", false).html('<i class="fa fa-save"></i> Update User');
            }
        });
    }

    // Initialize jQuery Validation
    if (typeof $.fn.validate === 'function') {
        $("#userForm").validate({
        ignore: [],
        rules: {
            // employee_id: { required: true }, // Disabled field
            user_type: { required: true },
            head_department_id: { required: function() { return $('.user_type').val() === 'department_head'; } },
            user_name: { required: true },
            email: { required: true, email: true },
            phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
            password: { required: false, minlength: 6 }, // Optional on edit
            "confirm-password": { equalTo: "#user_password" },
            roles: { required: true },
            user_image: { extension: "jpg|jpeg|png", filesize: 5*1024*1024 }
        },
        messages: {
            user_type: "Please select a user type.",
            user_name: "Please enter a name.",
            email: "Please enter a valid email address.",
            phone: "Please enter a valid phone number.",
            password: "Password must be at least 6 characters.",
            "confirm-password": "Passwords do not match.",
            roles: "Please select a role.",
            user_image: { extension: "Only JPG, JPEG, PNG allowed.", filesize: "Max size 5MB." }
        },
        errorPlacement: function(error, element) {
            element.closest('.col-md-6, .col-12').find('.invalid-feedback').html(error);
        },
        highlight: function(element) {
            var elem = $(element);
            if (elem.hasClass('select2-hidden-accessible')) {
                elem.next('.select2-container').find('.select2-selection').addClass('is-invalid');
            } else {
                elem.addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            var elem = $(element);
            if (elem.hasClass('select2-hidden-accessible')) {
                elem.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            } else {
                elem.removeClass('is-invalid');
            }
        },

        // AJAX submission on valid form
        submitHandler: ajaxSubmit
    });
    } else {
        // Fallback: prevent default submit and use AJAX when validator not present
        $("#userForm").on('submit', function(e){
            e.preventDefault();
            ajaxSubmit(this);
        });
    }
});

// Preview image
function previewFile(input){
    const file = input.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){ $("#previewImg").attr("src", e.target.result); }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
