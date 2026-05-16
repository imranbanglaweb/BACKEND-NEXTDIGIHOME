@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff; padding: 10px">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
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
        <form id="usertForm" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Company -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_id"><strong>Select Company <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <select name="company_id" id="company_id" class="form-control select2">
                                <option value="">Please Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Employee -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="employee_id"><strong>Select Employee <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-badge"></i></span>
                            </div>
                            <select name="employee_id" class="form-control select2 employee_id">
                                <option value="">Please Select</option>
                                @foreach($employees as $list)
                                    <option value="{{ $list->id}}">{{ $list->name }} -- {{  $list->employee_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- User Type -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_type"><strong>Select User Type <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-users-cog"></i></span>
                            </div>
                            <select name="user_type" class="form-control select2 user_type">
                                <option value="">Please Select</option>
                                <option value="normal_user">Normal User</option>
                                <option value="super_user">Super User</option>
                                <option value="admin">Admin</option>
                                <option value="department_head">Department Head</option>
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_name"><strong>Name <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User name" autocomplete="username">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_email"><strong>Email <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" id="user_email" name="email" placeholder="Enter User Email" autocomplete="email">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_phone"><strong>Phone Number <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" id="user_phone" name="phone" placeholder="Enter phone" autocomplete="tel">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_password"><strong>Password <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="user_password" name="password" placeholder="Enter Password" autocomplete="new-password">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_cpassword"><strong>Confirm Password <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="user_cpassword" name="confirm-password" placeholder="Enter Confirm Password" autocomplete="new-password">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="roles"><strong>Role <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-tag"></i></span>
                            </div>
                            <select name="roles" class="form-control select2 roles">
                                <option value="">Please Select</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0 text-dark"><i class="fa fa-upload"></i> User Image Upload</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-2">
                                <img id="previewImg" src="{{ asset('admin_resource/assets/images/default.png') }}" 
                                     class="img-thumbnail rounded-circle" width="100" height="100" 
                                     onerror="this.src='{{ asset('admin_resource/assets/images/default.png') }}';">
                            </div>
                            <div class="form-group mb-0 text-left">
                                <label>Image File</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="user_image" name="user_image" onchange="previewFile(this);">
                                    <label class="custom-file-label" for="user_image">Choose file</label>
                                </div>
                                <small class="form-text text-muted">
                                    Allowed files: PDF, DOC, DOCX, XLS, XLSX (Max size: 5MB)
                                </small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                        <i class="fa fa-save"></i> Save User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</section>
<script type="text/javascript">
$(document).ready(function () {

    
    $("#usertForm").validate({
        rules: {
            company_id: { required: true },
            employee_id: { required: true },
            user_type: { required: true },
            user_name: { required: true },
            email: { required: true, email: true },
            phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
            password: { required: true, minlength: 6 },
            "confirm-password": { required: true, equalTo: "#user_password" },
            roles: { required: true },
            user_image: { 
                required: false,
                extension: "jpg|jpeg|png",
                filesize: 5 * 1024 * 1024 // 5MB in bytes
            }
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
            user_image: {
                required: "Please upload an image.",
                extension: "Only JPG, JPEG, and PNG files are allowed.",
                filesize: "File size must be less than 5MB."
            }
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".invalid-feedback").html(error);
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function (form) {
            let formData = new FormData(form);
            $.ajax({
                url: $(form).attr("action"),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("button[type='submit']").prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                },
                success: function (response) {
                    Swal.fire("Success!", "User added successfully.", "success");
                    form.reset();
                    $('.select2').val(null).trigger('change');
                    $('#previewImg').attr('src', "{{ asset('admin_resource/assets/images/default.png') }}");
                    $('.custom-file-label').html('Choose file');
                    $(".is-invalid").removeClass("is-invalid");
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`[name="${field}"]`).closest(".form-group").find(".invalid-feedback").html(errors[field][0]);
                        $(`[name="${field}"]`).addClass("is-invalid");
                    }
                },
                complete: function () {
                    $("button[type='submit']").prop("disabled", false).html('<i class="fa fa-save"></i> Save User');
                }
            });
        }
    });

    // Custom file validation
    $.validator.addMethod("filesize", function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    });
});

function previewFile(input){
    var file = $("input[type=file]").get(0).files[0];
    if(file){
        var reader = new FileReader();
        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
        $(input).next('.custom-file-label').html(file.name);
    }
}
</script>
@endsection