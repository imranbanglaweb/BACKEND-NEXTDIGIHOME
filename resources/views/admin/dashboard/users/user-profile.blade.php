@extends('admin.dashboard.master')

<style>
    .highlight-field {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        border-left: 4px solid #667eea;
    }
    .highlight-value {
        font-weight: bold;
        font-size: 16px;
        color: #2c3e50;
        margin-top: 5px;
    }
    .role-label {
        font-size: 14px;
        padding: 8px 15px;
        font-weight: 600;
    }
</style>


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Update Your Profile</h2>
        </div>
      {{--   <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('menus.index') }}"> Back</a>
        </div> --}}
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



    <!-- start: page -->

                    <div class="row">
                     
                        <div class="col-md-8 col-lg-12">

                            <div class="tabs">
                                <ul class="nav nav-tabs tabs-primary">
                                    <li class="active">
                                        <a href="#overview" data-toggle="tab">Overview</a>
                                    </li>
                                    <li>
                                        <a href="#edit" data-toggle="tab">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#change_password" data-toggle="tab">Change Password</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div id="overview" class="tab-pane active">
                                        <h4 class="mb-md">Profile Status</h4>

                                        <section class="simple-compose-box mb-xlg">
                                            <form method="get" action="/">
                                                <textarea name="message-text" data-plugin-textarea-autosize placeholder="What's on your mind?" rows="1">{{Auth::user()->name}}</textarea>
                                            </form>
                                      
                                        </section>

                                        <!-- Employee Information Section -->
                                        @if($employee)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="mb-xlg">Employee Information</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group highlight-field">
                                                                    <label class="control-label"><strong>Employee Code:</strong></label>
                                                                    <p class="highlight-value">{{ $employee->employee_code ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Designation:</strong></label>
                                                                    <p>{{ $employee->designation ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group highlight-field">
                                                                    <label class="control-label"><strong>Department:</strong></label>
                                                                    <p class="highlight-value">{{ $employee->department->department_name ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Unit:</strong></label>
                                                                    <p>{{ $employee->unit->unit_name ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Company:</strong></label>
                                                                    <p>{{ $employee->company->company_name ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Location:</strong></label>
                                                                    <p>{{ $employee->location->location_name ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Phone:</strong></label>
                                                                    <p>{{ $employee->phone ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Email:</strong></label>
                                                                    <p>{{ $employee->email ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Blood Group:</strong></label>
                                                                    <p>{{ $employee->blood_group ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>NID:</strong></label>
                                                                    <p>{{ $employee->nid ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Join Date:</strong></label>
                                                                    <p>{{ $employee->join_date ? date('d-m-Y', strtotime($employee->join_date)) : 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Status:</strong></label>
                                                                    <p>{{ $employee->status == 1 ? 'Active' : 'Inactive' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Present Address:</strong></label>
                                                                    <p>{{ $employee->present_address ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Permanent Address:</strong></label>
                                                                    <p>{{ $employee->permanent_address ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!-- User Role Section -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="mb-xlg">User Role</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"><strong>Assigned Role:</strong></label>
                                                                    <p style="margin-top: 10px;">
                                                                        @forelse($userRole as $role => $value)
                                                                            <span class="label label-primary role-label">{{ $role }}</span>
                                                                        @empty
                                                                            <span class="label label-default">No Role Assigned</span>
                                                                        @endforelse
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <div id="edit" class="tab-pane">

                                        {!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'profile_update')) !!}
                                            <h4 class="mb-xlg">Personal Information</h4>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileFirstName"> Name</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="profileFirstName" name="user_name" value="{{Auth::user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileLastName">Email</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="profileLastName" name="email" value="{{Auth::user()->email}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileLastName">Photo</label>
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" id="profileLastName" name="user_image" onchange="previewFile(this);">
                                                    </div>

                                                    @php
                                                        $userImage = Auth::user()->user_image;
                                                        $imagePath = public_path('admin_resource/assets/images/user_image/' . $userImage);
                                                        $imageUrl = asset('public/admin_resource/assets/images/default.png');

                                                        if (!empty($userImage) && file_exists($imagePath)) {
                                                            $imageUrl = asset('public/admin_resource/assets/images/user_image/' . $userImage);
                                                        }
                                                    @endphp
                                                     <img id="previewImg" src="{{ $imageUrl }}" width="100" height="100" onerror="this.onerror=null;this.src='{{ asset('public/admin_resource/assets/images/default.png') }}'">
                                                </div>
                                            </fieldset>
                                            
                                            <!-- Employee Information Edit Section -->
                                            @if($employee)
                                            <h4 class="mb-xlg mt-lg">Employee Information</h4>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Employee Photo</label>
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" name="employee_photo" accept="image/*" onchange="previewEmployeePhoto(this);">
                                                        @if($employee->photo)
                                                            <img id="employeePhotoPreview" src="{{ asset('public/uploads/employee/'.$employee->photo) }}" width="100" height="100" style="margin-top:10px;border-radius:50%;object-fit:cover;" onerror="this.onerror=null;this.src='{{ asset('public/admin_resource/assets/images/default.png') }}'">
                                                        @else
                                                            <img id="employeePhotoPreview" src="{{ asset('public/admin_resource/assets/images/default.png') }}" width="100" height="100" style="margin-top:10px;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="employee_code">Employee Code</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="employee_code" name="employee_code" value="{{ $employee->employee_code ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="designation">Designation</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="designation" name="designation" value="{{ $employee->designation ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="company">Company</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="company" value="{{ $employee->company->name ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="department">Department</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="department" value="{{ $employee->department->name ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="unit">Unit</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="unit" value="{{ $employee->unit->name ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="location">Location</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="location" value="{{ $employee->location->name ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="phone">Phone</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="blood_group">Blood Group</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="blood_group" name="blood_group" value="{{ $employee->blood_group ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="nid">NID</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="nid" name="nid" value="{{ $employee->nid ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="present_address">Present Address</label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" id="present_address" name="present_address" rows="3">{{ $employee->present_address ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="permanent_address">Permanent Address</label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" id="permanent_address" name="permanent_address" rows="3">{{ $employee->permanent_address ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            @endif
                                                <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <button  class="btn btn-primary">Submit</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                      {!! Form::close() !!}

                                        </div>

                                    <div id="change_password" class="tab-pane">
                                      {!! Form::open(array('method'=>'POST', 'id'=>'profile_password_update')) !!}
                                            <h4 class="mb-xlg">Change Password</h4>
                                            <fieldset class="mb-xl">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileNewPassword">New Password</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control user_password" id="profileNewPassword" name="password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileNewPasswordRepeat">Repeat New Password</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control user_password_confirm" id="profileNewPasswordRepeat"  name="confirm-password"  autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <button  class="btn btn-primary">Submit</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                     {!! Form::close() !!}


                                    </div>
                                </div>
                            </div>
                        </div>
                    

                    </div>
                    <!-- end: page -->

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


   $('#profile_update').submit(function(e) {

       e.preventDefault();
       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
            url:"{{ route('profile-update') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
              Swal.fire({
            html: '<span style="color:green">Information Updated</span>',
            icon: 'success',
             type: 'success',
              title: 'Setting Edit',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
                allowEscapeKey: false,
             
            }).then((data) => {
                   if(data){
                     // Do Stuff here for success
                     location.reload();
                   }else{
                    // something other stuff
                   }

                })

               $('.saved').html('Saved');
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });


   $('#profile_password_update').submit(function(e) {
       e.preventDefault();

       let user_password = $('.user_password').val();
       let user_password_confirm = $('.user_password_confirm').val();

      if(user_password == ""){
         Swal.fire({
            icon: 'warning',
            type: 'error',
            title: 'Enter Password',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            });
         $('.user_password').focus();



  return false;

}
else if (user_password_confirm == "") {
  Swal.fire({
            icon: 'warning',
            type: 'error',
            title: 'EnterConfirm Password',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            });
    return false;

}

else{
    if (user_password !== user_password_confirm) {

          Swal.fire({
            icon: 'warning',
            type: 'error',
            title: 'Password Doesnt Match',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            });
            return false;

    }
}
       $.ajax({
          type:'POST',
            url:"{{ route('profile-password-update') }}",
            data: $('#profile_password_update').serialize(),

           success: (response) => {
              Swal.fire({
            html: '<span style="color:green">Password Updated</span>',
            icon: 'success',
            type: 'success',
            title: 'Password Edit',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            }).then((data) => {
                   if(data){
                     // Do Stuff here for success
                    //  location.reload();
                     window.location.href = response.redirect;
                   }else{
                    // something other stuff
                   }

                })

               $('.saved').html('Saved');
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
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
        }
    }
    
    function previewEmployeePhoto(input){
        var file = $("input[name='employee_photo']").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#employeePhotoPreview").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }

</script>
@endsection