@extends('admin.dashboard.master')


@section('main_content')
<section role="" class="content-body" style="background-color: #ffffff">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2><i class="fa fa-plus mr-2"></i> Add Employee</h2>
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
            <h2 class="panel-title"><i class="fa fa-user-plus mr-2"></i> Add Employee</h2>
            <p class="text-muted">Fill in employee details. Required fields are validated via AJAX.</p>
        </div>
        <div>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to list</a>
        </div>
    </header>

    <div class="panel-body">
        {!! Form::open(['route' => ['admin.employees.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'employee_add']) !!}
        @include('admin.dashboard.employee._form')
        {!! Form::close() !!}
    </div>
</section>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- SweetAlert2 Premium Styles -->
<style>
    .swal2-popup.swal2-toast {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    .swal2-popup {
        border-radius: 16px !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2) !important;
    }
    .swal2-title {
        font-family: 'Segoe UI', system-ui, sans-serif !important;
        font-weight: 600 !important;
    }
    .swal2-html-container {
        font-family: 'Segoe UI', system-ui, sans-serif !important;
    }
    .swal2-confirm {
        border-radius: 8px !important;
        padding: 10px 24px !important;
        font-weight: 500 !important;
    }
    .swal2-cancel {
        border-radius: 8px !important;
        padding: 10px 24px !important;
        font-weight: 500 !important;
    }
</style>
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
});


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


// photo preview
$(document).on('change', '#photo-input', function(e){
    const [file] = this.files;
    if (file) {
        const url = URL.createObjectURL(file);
        $('#photo-preview').attr('src', url);
    }
});


    $('#employee_add').submit(function(e) {

        e.preventDefault();

        var $btn = $(this).find('button[type="submit"]');
        var originalBtnText = $btn.html();

    // clear previous validation states
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').addClass('d-none').text('');

    // debug: inspect unit select(s) and value (helps when multiple elements share the same class)
    var $unitByClass = $('.unit_id');
    var $unitByName = $('[name="unit_id"]');
    // Read unit_id from the actual <select name="unit_id"> inside the employee form to avoid Select2 container conflicts
    var unit_id  = $('#employee_add').find('[name="unit_id"]').val() || $unitByClass.val();
    var name  = $('input[name="name"]').val();

        if (unit_id  == '') {
            Swal.fire({
                title: '<span style="color:#856404"><i class="fas fa-exclamation-triangle mr-2"></i>Validation Error</span>',
                html: '<p style="color:#856404; font-size:14px;">Please select a Unit</p>',
                icon: 'warning',
                iconColor: '#f39c12',
                confirmButtonColor: '#f39c12',
                confirmButtonText: '<i class="fas fa-check-circle"></i> OK',
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                },
                allowOutsideClick: false,
                backdrop: `
                    rgba(0,0,0,0.4)
                    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath fill='%23f39c12' d='M30 0C13.4 0 0 13.4 0 30s13.4 30 30 30 30-13.4 30-30S46.6 0 30 0zm0 55c-13.8 0-25-11.2-25-25S16.2 5 30 5s25 11.2 25 25-11.2 25-25 25z'/%3E%3C/svg%3E")
                    left top
                    no-repeat
                `
            })
            return;
        }

        if (name  == '') {
            Swal.fire({
                title: '<span style="color:#856404"><i class="fas fa-exclamation-triangle mr-2"></i>Validation Error</span>',
                html: '<p style="color:#856404; font-size:14px;">Please enter employee name</p>',
                icon: 'warning',
                iconColor: '#f39c12',
                confirmButtonColor: '#f39c12',
                confirmButtonText: '<i class="fas fa-check-circle"></i> OK',
                showClass: {
                    popup: 'animate__animated animate__zoomIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut animate__faster'
                },
                allowOutsideClick: false,
                backdrop: `
                    rgba(0,0,0,0.4)
                    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath fill='%23f39c12' d='M30 0C13.4 0 0 13.4 0 30s13.4 30 30 30 30-13.4 30-30S46.6 0 30 0zm0 55c-13.8 0-25-11.2-25-25S16.2 5 30 5s25 11.2 25 25-11.2 25-25 25z'/%3E%3C/svg%3E")
                    left top
                    no-repeat
                `
            })
            return;
        }

        // Loading state
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        let formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:"{{ route('admin.employees.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                Swal.fire({
                    title: '<span style="color:#155724"><i class="fas fa-check-circle mr-2"></i>Success!</span>',
                    html: '<p style="color:#155724; font-size:14px;">Employee created successfully.</p>',
                    icon: 'success',
                    iconColor: '#28a745',
                    timer: 2000,
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__zoomIn animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut animate__faster'
                    },
                    backdrop: `
                        rgba(40,167,69,0.1)
                        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath fill='%2328a745' d='M30 0C13.4 0 0 13.4 0 30s13.4 30 30 30 30-13.4 30-30S46.6 0 30 0zm0 55c-13.8 0-25-11.2-25-25S16.2 5 30 5s25 11.2 25 25-11.2 25-25 25z'/%3E%3C/svg%3E")
                        left top
                        no-repeat
                    `
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
                        title: '<span style="color:#721c24"><i class="fas fa-times-circle mr-2"></i>Validation Error</span>',
                        html: '<p style="color:#721c24; font-size:14px;">' + errors[firstKey][0] + '</p>',
                        icon: 'error',
                        iconColor: '#dc3545',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '<i class="fas fa-check-circle"></i> OK',
                        showClass: {
                            popup: 'animate__animated animate__shakeX animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__zoomOut animate__faster'
                        },
                        allowOutsideClick: false,
                        backdrop: `
                            rgba(220,53,69,0.1)
                            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath fill='%23dc3545' d='M30 0C13.4 0 0 13.4 0 30s13.4 30 30 30 30-13.4 30-30S46.6 0 30 0zm0 55c-13.8 0-25-11.2-25-25S16.2 5 30 5s25 11.2 25 25-11.2 25-25 25z'/%3E%3C/svg%3E")
                            left top
                            no-repeat
                        `
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
                        title: '<span style="color:#721c24"><i class="fas fa-exclamation-circle mr-2"></i>Error!</span>',
                        html: '<p style="color:#721c24; font-size:14px;">An unexpected error occurred. Please try again.</p>',
                        icon: 'error',
                        iconColor: '#dc3545',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '<i class="fas fa-check-circle"></i> OK',
                        showClass: {
                            popup: 'animate__animated animate__shakeX animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__zoomOut animate__faster'
                        },
                        allowOutsideClick: false,
                        backdrop: `
                            rgba(220,53,69,0.1)
                            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath fill='%23dc3545' d='M30 0C13.4 0 0 13.4 0 30s13.4 30 30 30 30-13.4 30-30S46.6 0 30 0zm0 55c-13.8 0-25-11.2-25-25S16.2 5 30 5s25 11.2 25 25-11.2 25-25 25z'/%3E%3C/svg%3E")
                            left top
                            no-repeat
                        `
                    });
                }
            }
        });
    });

</script>
@endsection