@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Unit Edit</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('units.index') }}"><i class="fa fa-arrow-left"></i>  Back</a>
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


{!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'unit_edit')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">
            <strong>Unit Name:</strong>
            {!! Form::text('unit_name', $unit_edit->unit_name, array('placeholder' => 'Unit Name','class' => 'form-control unit_name ','focus'=>'focus')) !!}
            <input type="hidden" name="id" value="{{ $unit_edit->id }}">
        </div>
        <div class="form-group">
            <strong>Unit Code:</strong>
            {!! Form::text('unit_code', $unit_edit->unit_code, array('placeholder' => 'Unit Code','class' => 'form-control unit_code ','focus'=>'focus')) !!}
            <input type="hidden" name="id" value="{{ $unit_edit->id }}">
        </div>
        <div class="form-group">
            <strong>Unit Description:</strong>
            {!! Form::textarea('description', $unit_edit->description, array('placeholder' => 'Unit description','class' => 'form-control','id'=>'description', 'rows'=>3)) !!}
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
      CKEDITOR.replace( 'description' );
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

   $('#unit_edit').submit(function(e) {

       e.preventDefault();

       // Update CKEditor instance to ensure data is in the textarea
       for (instance in CKEDITOR.instances) {
           CKEDITOR.instances[instance].updateElement();
       }

       var unit_name  = $('.unit_name').val();
       // alert(unit_name);

       if (unit_name  == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Unit Name',
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
            url:"{{ route('units.store') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

             Swal.fire({
            html: '<span style="color:green">Unit Updated</span>',
            icon: 'success',
             type: 'success',
              title: 'Unit Updated',
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