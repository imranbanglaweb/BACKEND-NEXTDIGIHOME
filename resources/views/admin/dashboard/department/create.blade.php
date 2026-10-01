@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add Department</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('departments.index') }}"> Back</a>
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


{!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'department_add')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
       
{{--         <div class="form-group">
            <strong>Unit  Name:</strong>
           <select class="form-control unit_wise_company unit_id" name="unit_id">
             <option value="">Unit Name</option>
             @foreach($units as $unit)
             <option value="{{ $unit->id}}">{{ $unit->unit_name}}</option>
             @endforeach
           </select>
        </div>
        <div class="form-group">
            <strong>Company  Name:</strong>
           <select class="form-control company_name" name="company_id">
       
            
           </select>
        </div> --}}
        <div class="form-group">
            <strong>Department  Name:</strong>
         <input type="text" name="department_name" class="form-control department_name" placeholder="Enter Department Name">
        </div>
        <div class="form-group">
            <strong>Department Description:</strong>
            {!! Form::text('remarks', null, array('placeholder' => 'Company Description','class' => 'form-control remarks')) !!}
        </div>

{{--         <div class="form-group">
            <strong>Department Status</strong>
           <select name="status" class="form-control">
               <option value="1">Active</option>
               <option value="0">In Active</option>
           </select>
        </div> --}}
    </div>
{{--     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div> --}}
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
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


   $('#department_add').submit(function(e) {

       e.preventDefault();

       var unit_id  = $('.unit_id').val();
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

       // else if (department_name  == '') {
       //      Swal.fire({
       //        type: 'warning',
       //        title: 'Please Enter Department Name',
       //        icon: 'warning',
       //        // showCloseButton: true,
       //        // showCancelButton: true,
       //        focusConfirm: false,
       //        allowOutsideClick: false,
       //        allowEscapeKey: false,

       //      })
       // }
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
            html: '<span style="color:green">Department Added</span>',
            icon: 'success',
             type: 'success',
              title: 'Department Added',
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