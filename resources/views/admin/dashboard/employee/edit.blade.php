@extends('admin.dashboard.master')

@section('main_content')
<section role="" class="content-body" style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2><i class="fa fa-edit mr-2"></i> Edit Employee</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.employees.index') }}"><i class="fa fa-arrow-left mr-2"></i> Back</a>
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


<!-- Include the professional form partial -->
<section class="panel">
    <header class="panel-heading d-flex align-items-center justify-content-between">
        <div>
            <h2 class="panel-title"><i class="fa fa-user-edit mr-2"></i> Edit Employee</h2>
            <p class="text-muted">Update employee details. Required fields are validated via AJAX.</p>
        </div>
        <div>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to list</a>
        </div>
    </header>

    <div class="panel-body">
        {!! Form::model($employee_edit, ['route' => ['admin.employees.update', $employee_edit->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'employee_edit']) !!}
        @include('admin.dashboard.employee._form')
        {!! Form::close() !!}
    </div>
</section>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();

    // Show existing photo if available
    var photoPath = "{{ $employee_edit->photo }}";
    var photoUrl = "{{ $employee_edit->photo ? asset('public/'.$employee_edit->photo) : '' }}";
    if(photoPath) {
         $('.mb-2').html('<img id="photo-preview" src="'+photoUrl+'" alt="preview" style="max-width:100%; height:150px; object-fit:cover; border-radius: 4px;" />');
    }
});
</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// unit wise company (populate companies and departments when unit changes)
$(document).ready(function() {
    $(document).on('change', '.unit_wise_company', function () {
        var unit_id = $(this).val();

        // populate departments
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.unit-wise-department')}}",
            data: { unit_id: unit_id},
            dataType: 'json',
            success: function (data) {
                console.log('unit-wise-department response:', data);
                // If department was previously initialized with Select2, destroy it to update options reliably
                if ($('.department_name').data('select2')) {
                    try { $('.department_name').select2('destroy'); } catch(e) { console.warn('select2 destroy failed', e); }
                }

                // preserve existing selection (useful in edit form)
                var previous = $('.department_name').val();

                $(".department_name").empty();
                $('.department_name').append("<option value=''>Please Select</option>");
                $.each(data['department_list'] || [], function (key, department_list) {
                    $('.department_name').append("<option value='" + department_list.id + "'>" + department_list.department_name +"</option>");
                });

                // trigger normal change so any listeners update
                $('.department_name').trigger('change');
            },
            error: function (xhr, status, err) {
                console.error('Error loading departments for unit', unit_id, status, err);
            }
        });
    });
});

// photo preview
$(document).on('change', '#photo-input', function(e){
    const [file] = this.files;
    if (file) {
        const url = URL.createObjectURL(file);
        // Check if img exists, if not replace icon
        if($('#photo-preview').length === 0) {
             $('.mb-2').html('<img id="photo-preview" src="" alt="preview" style="max-width:100%; height:150px; object-fit:cover;" />');
        }
        $('#photo-preview').attr('src', url);
    }
});


    $('#employee_edit').submit(function(e) {

        e.preventDefault();

        var $btn = $(this).find('button[type="submit"]');
        var originalBtnText = $btn.html();

    // clear previous validation states
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').addClass('d-none').text('');

    var $unitByClass = $('.unit_id');
    var unit_id  = $('#employee_edit').find('[name="unit_id"]').val() || $unitByClass.val();
    var name  = $('input[name="name"]').val();

        if (unit_id  == '') {
            Swal.fire({
                title: 'Validation Error',
                text: 'Please select a Unit',
                icon: 'warning',
                focusConfirm: true,
                confirmButtonColor: '#f39c12',
            })
            return;
        }

        if (name  == '') {
            Swal.fire({
                title: 'Validation Error',
                text: 'Please enter employee name',
                icon: 'warning',
                focusConfirm: true,
                confirmButtonColor: '#f39c12',
            })
            return;
        }

        // Loading state
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

        let formData = new FormData(this);
        // Add _method PUT for Laravel
        // formData.append('_method', 'PUT'); // Form::model with method PUT already adds this hidden field

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                Swal.fire({
                    title: 'Success!',
                    text: 'Employee updated successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.href = "{{ route('admin.employees.index') }}";
                });
            },
            error: function(response){
                $btn.prop('disabled', false).html(originalBtnText);

                if (response.status === 422 && response.responseJSON && response.responseJSON.errors) {
                    const errors = response.responseJSON.errors;
                    // show a summary alert
                    const firstKey = Object.keys(errors)[0];
                    Swal.fire({
                        title: 'Validation Error', 
                        text: errors[firstKey][0], 
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });

                    // mark fields and show inline messages
                    Object.keys(errors).forEach(function(field){
                        const messages = errors[field];
                        // try to find matching input/select/textarea
                        const $el = $('[name="'+field+'"]');
                        if ($el.length) {
                            $el.addClass('is-invalid');
                            // find invalid-feedback with matching data-field
                            const $fb = $('.invalid-feedback[data-field="'+field+'"]');
                            if ($fb.length) {
                                $fb.removeClass('d-none').text(messages[0]);
                            } else {
                                // append a feedback element
                                $el.after('<div class="invalid-feedback d-block">'+messages[0]+'</div>');
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!', 
                        text: 'An unexpected error occurred. Please try again.', 
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            }
        });
    });

</script>
@endsection