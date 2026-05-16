@extends('admin.dashboard.master')

@section('main_content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
    }
    /* Loader styles */
    .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }
    .btn-loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<section class="content-body" style="background-color:#fff;">
<div class="container">

    <div class="card shadow-sm p-4 mx-auto" style="max-width: 800px;">
        
        <a href="{{ route('vehicle-type.index') }}" class="btn btn-primary btn-lg pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
        <h4 class="fw-bold mb-3 text-primary">
            {{ $vehicleType ? 'Edit Vehicle Type' : 'Add Vehicle Type' }}
        </h4>

        <form id="vehicleTypeForm" action="{{ $action }}" method="POST">
            @csrf
            @if($method == 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Name *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $vehicleType->name ?? '' }}">
                <small class="text-danger error-text name_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $vehicleType->description ?? '' }}</textarea>
                <small class="text-danger error-text description_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="1" {{ isset($vehicleType) && $vehicleType->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ isset($vehicleType) && $vehicleType->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <small class="text-danger error-text status_error"></small>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-success w-100">
                <span id="btn_text">{{ $vehicleType ? 'Update Vehicle Type' : 'Save Vehicle Type' }}</span>
            </button>
        </form>
    </div>

</div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    // Clear validation errors on input change
    $('#vehicleTypeForm input, #vehicleTypeForm select, #vehicleTypeForm textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
        const errorElement = $('#' + $(this).attr('name') + '_error');
        if (errorElement.length) {
            errorElement.text('');
        }
    });

    $('#vehicleTypeForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = form.find('input[name="_method"]').val() || 'POST';

        $('.error-text').text('');
        $('.is-invalid').removeClass('is-invalid');
        
        const submitBtn = $('#submitBtn');
        submitBtn.addClass('btn-loading');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: url,
            type: method,
            data: form.serialize(),
            success: function(response) {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);

                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.href = "{{ route('vehicle-type.index') }}";
                    }
                });
            },
            error: function(xhr) {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        const input = $('input[name="' + key + '"], select[name="' + key + '"], textarea[name="' + key + '"]');
                        if (input.length) {
                            input.addClass('is-invalid');
                        }
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            },
            complete: function() {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush
