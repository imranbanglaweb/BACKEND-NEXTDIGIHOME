@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add Company</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('company.index') }}"> Back</a>
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

{!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'company_add')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Company Name <span class="text-danger">*</span>:</strong>
            {!! Form::text('company_name', null, array('placeholder' => 'Company Name','class' => 'company_name form-control', 'required')) !!}
            <small class="text-danger error-company_name" style="display: none;"></small>
        </div>
        <div class="form-group">
            <strong>Company Code <span class="text-danger">*</span>:</strong>
            {!! Form::text('company_code', null, array('placeholder' => 'Company Code','class' => 'form-control company_code', 'required')) !!}
            <small class="text-danger error-company_code" style="display: none;"></small>
        </div>
        <div class="form-group">
            <strong>Unit Name:</strong>
           <select class="form-control select2" name="unit_id">
             <option value="">Select Unit Name</option>
             @foreach($units as $unit)
             <option value="{{ $unit->id}}">{{ $unit->unit_name}}</option>
             @endforeach
           </select>
        </div>
        <div class="form-group">
            <strong>Company Description:</strong>
            {!! Form::text('remarks', null, array('placeholder' => 'Company Description','class' => 'form-control remarks')) !!}
        </div>
        <div class="form-group">
            <strong>Company Status:</strong>
           <select name="status" class="form-control">
               <option value="active">Active</option>
               <option value="suspended">In Active</option>
           </select>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#company_add').submit(function(e) {
    e.preventDefault();

    // Clear previous errors
    $('.text-danger').text('').hide();
    $('.form-control').removeClass('is-invalid');

    var company_name = $('.company_name').val();
    var company_code = $('.company_code').val();
    var hasError = false;

    // Validate company name
    if (company_name == '') {
        $('.error-company_name').text('Company name is required').show();
        $('.company_name').addClass('is-invalid');
        hasError = true;
    }

    // Validate company code
    if (company_code == '') {
        $('.error-company_code').text('Company code is required').show();
        $('.company_code').addClass('is-invalid');
        hasError = true;
    }

    if (hasError) {
        Swal.fire({
            type: 'warning',
            title: 'Validation Error',
            text: 'Please fill in all required fields',
            icon: 'warning',
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
        return false;
    }

    let formData = new FormData(this);

    $.ajax({
        type:'POST',
        url:"{{ route('company.store') }}",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                html: '<span style="color:green">Company Added Successfully</span>',
                icon: 'success',
                type: 'success',
                title: 'Success!',
                focusConfirm: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((data) => {
                if (data) {
                    window.location.href = "{{ route('company.index') }}";
                }
            });
        },
        error: function(xhr){
            console.log(xhr.responseJSON);
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;
                for (var field in errors) {
                    var errorField = '.error-' + field;
                    var inputField = '.' + field;
                    $(errorField).text(errors[field][0]).show();
                    $(inputField).addClass('is-invalid');
                }
                
                Swal.fire({
                    type: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form for errors',
                    icon: 'error',
                });
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.message,
                    icon: 'error',
                });
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                });
            }
        }
    });
});
</script>
@endsection
