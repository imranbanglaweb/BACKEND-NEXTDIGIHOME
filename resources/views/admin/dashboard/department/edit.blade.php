@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Department Edit</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('departments.index') }}"><i class="fa fa-arrow-left"></i>  Back</a>
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


{!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'department_edit')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

      <div class="form-group">
            <strong>Department Name:</strong>
            {!! Form::text('department_name', $department_edit->department_name, array('placeholder' => 'Department Name','class' => 'form-control department_name ','focus'=>'focus')) !!}
            <input type="hidden" name="id" value="{{ $department_edit->id }}">
        </div>
        
        <div class="form-group">
            <strong>Department Description:</strong>
            {!! Form::textarea('remarks', $department_edit->remarks, array('placeholder' => 'Department Remarks','class' => 'form-control remarks ','focus'=>'focus')) !!}
        </div>

        {{-- Department Head Selection --}}
        <div class="form-group">
            <strong>Department Head:</strong>
            @php
                // Get employees in this department for dropdown
                $departmentEmployees = \App\Models\Employee::where('department_id', $department_edit->id)
                    ->where('status', 'Active')
                    ->orderBy('name')
                    ->get();
            @endphp
            <select name="head_employee_id" class="form-control select2">
                <option value="">Select Department Head</option>
                @foreach($departmentEmployees as $employee)
                    <option value="{{ $employee->id }}" {{ $department_edit->head_employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }} - {{ $employee->designation ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
            @if($department_edit->headEmployee)
                <small class="text-success">Current Head: {{ $department_edit->headEmployee->name }} ({{ $department_edit->headEmployee->email }})</small>
            @endif
        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

{!! Form::close() !!}

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      CKEDITOR.replace( 'textarea' );
  </script>
<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.service_select2').select2();
});
</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


   $('#department_edit').submit(function(e) {

       e.preventDefault();

       // alert(unit_name);

       var department_name  = $('.department_name').val();
       // alert(company_name);


      if (department_name  == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Department Name',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }
       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
            url:"{{ route('departments.store') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

             Swal.fire({
            html: '<span style="color:green">Department Updated</span>',
            icon: 'success',
             type: 'success',
              title: 'Department Updated',
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

</script>

@endsection