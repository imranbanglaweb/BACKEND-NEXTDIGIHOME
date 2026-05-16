@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff">
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h2>Create New User</h2>
            <a class="btn btn-primary" href="{{ route('users.index') }}"><i class="fa fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>
<br>
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
            <h4 class="mb-0"><i class="fa fa-user-plus"></i> User Registration Form</h4>
        </div>
        <div class="card-body">
            <div id="formAlert"></div>
            <form id="userForm" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Subscription Plan --}}
                    <div class="col-md-6">
                        <label for="subscription_plan_id" class="form-label"><strong>Select Subscription Plan</strong></label>
                        <select name="subscription_plan_id" id="subscription_plan_id" class="form-control select2">
                            <option value="">No Plan</option>
                            @forelse($plans as $plan)
                                <option value="{{ $plan->id }}">
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
                            <option value="normal_user">Normal User</option>
                            <option value="super_user">Super User</option>
                            <option value="admin">Admin</option>
                            <option value="department_head">Department Head</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Department Head Assignment (show only when Department Head is selected) --}}
                    <div class="col-md-6 department-head-section" style="display: none;">
                        <label for="head_department_id" class="form-label"><strong>Select Department to Head <span class="text-danger">*</span></strong></label>
                        <select name="head_department_id" id="head_department_id" class="form-control select2">
                            <option value="">Please Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Select the department this user will manage as Department Head</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="user_name" class="form-label"><strong>Name <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User name" autocomplete="username">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="user_email" class="form-label"><strong>Email <span class="text-danger">*</span></strong></label>
                        <input type="email" class="form-control" id="user_email" name="email" placeholder="Enter User Email" autocomplete="email">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label for="user_phone" class="form-label"><strong>Phone Number <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="user_phone" name="phone" placeholder="Enter phone" autocomplete="tel">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 position-relative">
                        <label for="user_password" class="form-label"><strong>Password <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="user_password" name="password" placeholder="Enter Password" autocomplete="new-password">
                            <span class="input-group-text toggle-password" data-target="#user_password" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 position-relative">
                        <label for="user_cpassword" class="form-label"><strong>Confirm Password <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="user_cpassword" name="confirm-password" placeholder="Confirm Password" autocomplete="new-password">
                            <span class="input-group-text toggle-password" data-target="#user_cpassword" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label for="roles" class="form-label"><strong>Role <span class="text-danger">*</span></strong></label>
                        <select name="roles" class="form-control select2 roles">
                            <option value="">Please Select</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-6">
                        <label class="form-label"><strong>User Image Upload</strong></label>
                        <div class="text-center mb-3">
                            <img id="previewImg" src="{{ asset('public/admin_resource/assets/images/user_image/default.jpg') }}" class="img-thumbnail rounded-circle" width="100" height="100">
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
                            <i class="fa fa-save"></i> Save User
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    
    // Add CSS for readonly select2
    $('head').append('<style>.readonly-select { pointer-events: none; opacity: 0.8; } .readonly-select .select2-selection { background-color: #e9ecef !important; }</style>');

    // Style invalid feedback in red
    $('head').append('<style>.invalid-feedback { display: block !important; color: #dc3545 !important; font-size: 13px; margin-top: 5px; }</style>');
    if (!$('.select2').hasClass("select2-offscreen")) {
        $('.select2').select2({ width: '100%' });
    }

    // Trigger validation on Select2 change
    $('.select2').on('change', function () {
        if ($.fn.validate) {
            $(this).valid();
        }
    });

    // Custom server-side message map (fieldName -> custom message)
    const customServerMessages = {
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
    $('.employee_id').on('change', function() {
        const employeeId = $(this).val();
        
        if (employeeId) {
            // Show loading indicator
            $('#company_id, #department_id, #unit_id, #location_id').next('.select2-container').find('.select2-selection').css('opacity', '0.6');
            
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
                        $('#company_id').next('.select2-container').addClass('readonly-select');
                        
                        // Auto-populate department (readonly)
                        if (employee.department_id) {
                            $('#department_id').val(employee.department_id).trigger('change');
                        }
                        $('#department_id').prop('disabled', true).addClass('bg-light');
                        $('#department_id').next('.select2-container').addClass('readonly-select');
                        
                        // Auto-populate unit (readonly)
                        if (employee.unit_id) {
                            $('#unit_id').val(employee.unit_id).trigger('change');
                        }
                        $('#unit_id').prop('disabled', true).addClass('bg-light');
                        $('#unit_id').next('.select2-container').addClass('readonly-select');
                        
                        // Auto-populate location (readonly)
                        if (employee.location_id) {
                            $('#location_id').val(employee.location_id).trigger('change');
                        }
                        $('#location_id').prop('disabled', true).addClass('bg-light');
                        $('#location_id').next('.select2-container').addClass('readonly-select');
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
            $('#company_id').next('.select2-container').removeClass('readonly-select');
            $('#department_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
            $('#department_id').next('.select2-container').removeClass('readonly-select');
            $('#unit_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
            $('#unit_id').next('.select2-container').removeClass('readonly-select');
            $('#location_id').val('').trigger('change').prop('disabled', false).removeClass('bg-light');
            $('#location_id').next('.select2-container').removeClass('readonly-select');
        }
    });
    
    // Prevent opening select2 for readonly fields
    $(document).on('select2-opening', '.readonly-select', function(e) {
        e.preventDefault();
    });

    // Custom file size validation
    if ($.validator) {
        $.validator.addMethod("filesize", function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, "File size must be less than 5MB.");
    }

    // AJAX submission function (used by validator or fallback)
    function ajaxSubmit(form){
        // Re-enable disabled fields so they get submitted
        $('#company_id, #department_id, #unit_id, #location_id').prop('disabled', false);

        let formData = new FormData(form);
        $.ajax({
            url: $(form).attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("button[type='submit']").prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                $(".invalid-feedback").html(''); // clear old errors
                $(".is-invalid").removeClass("is-invalid");
                $('#formAlert').hide().empty();
            },
            success: function(response) {
                Swal.fire({
                    html: '<div class="text-center"><i class="fa fa-check-circle" style="font-size:56px;color:#28a745"></i><h3 style="margin-top:8px;margin-bottom:6px;">Success!</h3><div>User added successfully.</div></div>',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    customClass: { popup: 'shadow-lg rounded-3' }
                }).then(() => {
                    form.reset();
                    $('.select2').val(null).trigger('change');
                    $('#previewImg').attr('src', "{{ asset('public/admin_resource/assets/images/user_image/default.png') }}");
                    if (typeof $("#userForm").validate === 'function') {
                        $("#userForm").validate().resetForm();
                    }
                    $('.select2-selection').removeClass('is-invalid');
                });
            },
            error: function(xhr) {
                if(xhr.status === 422){ // Laravel validation errors
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages){
                        const baseField = field.split('.')[0];
                        const displayMsg = (customServerMessages[baseField] || customServerMessages[field]) ? (customServerMessages[baseField] || customServerMessages[field]) : messages[0];

                        // Find input element by baseField (already declared above for custom message)
                        let input = $(`[name="${baseField}"]`);

                        // If still not found, try exact field name (bracket notation, arrays, etc.)
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

                        // Show error message in the nearest invalid-feedback container (use custom message when available)
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
                    $('#formAlert').html('<div class="alert alert-danger"><i class="fa fa-times-circle"></i> Unexpected server error</div>').show();
                    toastr.error("Something went wrong! Please try again.");
                }
            },
            complete: function() {
                $("button[type='submit']").prop("disabled", false).html('<i class="fa fa-save"></i> Save User');
            }
        });
    }

    // Initialize jQuery Validation (or fallback to AJAX submit)
    if (typeof $.fn.validate === 'function') {
        $("#userForm").validate({
        ignore: [],
        rules: {
            company_id: { required: true },
            employee_id: { required: true },
            user_type: { required: true },
            head_department_id: { required: function() { return $('.user_type').val() === 'department_head'; } },
            user_name: { required: true },
            email: { required: true, email: true },
            phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
            password: { required: true, minlength: 6 },
            "confirm-password": { required: true, equalTo: "#user_password" },
            roles: { required: true },
            user_image: { extension: "jpg|jpeg|png", filesize: 5*1024*1024 }
        },
        messages: {
            company_id: "Please select a company.",
            employee_id: "Please select an employee.",
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
