@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
            <h3 class="fw-bold text-primary mb-0"><i class="bi bi-plus-square me-2"></i>Create License Type</h3>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('license-types.index') }}">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
        </div>

        {!! Form::open(['route' => 'license-types.store', 'method' => 'POST', 'id' => 'license_type_add']) !!}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @include('admin.dashboard.license_types._form')

                <div class="mt-3 text-end">
                    <button class="btn btn-success" type="submit"><i class="bi bi-check-circle-fill me-1"></i> Create</button>
                    <a href="{{ route('license-types.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</section>

@push('scripts')
<script>
    $(function(){
        // ensure CSRF for AJAX
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        $('#license_type_add').on('submit', function(e){
            e.preventDefault();
            var $form = $(this);
            var $btn = $form.find('button[type=submit]');
            var originalBtnHtml = $btn.html();

            // clear previous errors
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.text-danger.ajax-error').remove();

            // show loader on button
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...');

            $.ajax({
                url: $form.attr('action'),
                method: $form.attr('method') || 'POST',
                data: $form.serialize(),
                success: function(res){
                    $btn.prop('disabled', false).html(originalBtnHtml);
                    // on success, redirect to index or show a success toast
                    if (res && res.redirect) {
                        window.location.href = res.redirect;
                        return;
                    }
                    Swal.fire({ icon: 'success', title: 'Saved', text: 'License type created successfully.' }).then(function(){
                        window.location.href = '{{ route("license-types.index") }}';
                    });
                },
                error: function(xhr){
                    $btn.prop('disabled', false).html(originalBtnHtml);
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        // iterate fields and show messages
                        $.each(errors, function(field, msgs){
                            var $input = $form.find('[name="' + field + '"]');
                            if ($input.length === 0) {
                                // attempt to find by dot notation converted to []
                                var alt = field.replace(/\./g, '\\[') + (field.indexOf('.') !== -1 ? '\\]' : '');
                                $input = $form.find('[name="' + alt + '"]');
                            }
                            if ($input.length) {
                                $input.addClass('is-invalid');
                                // append message if not present
                                if ($input.next('.text-danger.ajax-error').length === 0) {
                                    $input.after('<div class="text-danger ajax-error small mt-1">' + msgs[0] + '</div>');
                                }
                            } else {
                                // fallback: show toastr / swal for global errors
                                console.warn('Validation error for field not in form:', field, msgs);
                                // show first as toast
                                Swal.fire({ icon: 'error', title: 'Validation error', text: msgs[0] });
                            }
                        });
                        // focus first invalid
                        var $firstInvalid = $form.find('.is-invalid').first();
                        if ($firstInvalid.length) { $firstInvalid.focus(); }
                    } else {
                        // generic error
                        Swal.fire({ icon: 'error', title: 'Error', text: 'An unexpected error occurred. Please try again.' });
                    }
                }
            });
        });

        // remove validation UI when user types
        $(document).on('input change', '#license_type_add input, #license_type_add textarea, #license_type_add select', function(){
            $(this).removeClass('is-invalid');
            $(this).next('.text-danger.ajax-error').remove();
        });
    });
</script>
@endpush

@endsection
