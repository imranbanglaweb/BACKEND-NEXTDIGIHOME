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
        display: block;
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
    .card {
        background-color: #fff;
        padding: 20px;
    }
    .form-label {
        color: #000;
        font-size: 15px;
    }
    .form-control, .form-select {
        font-size: 1.2em;
    }
    .input-group-text {
        width: 38px;
        justify-content: center;
    }
    .row > [class*="col-"] {
        margin-bottom: 8px;
    }
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-store"></i> {{ isset($vendor) ? 'Edit Vendor' : 'Add New Vendor' }}
        </h4>
        <a href="{{ route('vendors.index') }}" class="btn btn-primary btn-lg pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mx-auto">
        <div class="card-body p-4 bg-light">
            <form id="vendorForm" action="{{ isset($vendor) ? route('vendors.update', $vendor->id) : route('vendors.store') }}" method="POST">
                @csrf
                @if(isset($vendor))
                    @method('PUT')
                @endif

                <div class="row gy-3 gx-4 align-items-center">
                    <!-- Name -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Vendor Name *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-store text-secondary"></i></span>
                            <input type="text" name="name" value="{{ old('name', $vendor->name ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter Vendor Name">
                        </div>
                        <small class="text-danger error-text name_error"></small>
                    </div>

                    <!-- Contact Person -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Contact Person *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-user-tie text-secondary"></i></span>
                            <input type="text" name="contact_person" value="{{ old('contact_person', $vendor->contact_person ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter Contact Person">
                        </div>
                        <small class="text-danger error-text contact_person_error"></small>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Contact Number *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-phone text-secondary"></i></span>
                            <input type="text" name="contact_number" value="{{ old('contact_number', $vendor->contact_number ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter Contact Number">
                        </div>
                        <small class="text-danger error-text contact_number_error"></small>
                    </div>

                    <!-- Email -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Email</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-envelope text-secondary"></i></span>
                            <input type="email" name="email" value="{{ old('email', $vendor->email ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter Email">
                        </div>
                        <small class="text-danger error-text email_error"></small>
                    </div>

                    <!-- Address -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Address</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-map-marker-alt text-secondary"></i></span>
                            <input type="text" name="address" value="{{ old('address', $vendor->address ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter Address">
                        </div>
                        <small class="text-danger error-text address_error"></small>
                    </div>

                    <!-- City -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">City</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-city text-secondary"></i></span>
                            <input type="text" name="city" value="{{ old('city', $vendor->city ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter City">
                        </div>
                        <small class="text-danger error-text city_error"></small>
                    </div>

                    <!-- Country -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Country</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-globe text-secondary"></i></span>
                            <input type="text" name="country" value="{{ old('country', $vendor->country ?? '') }}" class="form-control border-start-0 py-2" placeholder="Enter Country">
                        </div>
                        <small class="text-danger error-text country_error"></small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Status *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-toggle-on text-secondary"></i></span>
                            <select name="status" class="form-select border-start-0 py-2">
                                <option value="Active" {{ (old('status', $vendor->status ?? '') == 'Active') ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ (old('status', $vendor->status ?? '') == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <small class="text-danger error-text status_error"></small>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary px-4 py-2 me-2">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-4 py-2" id="submitBtn">
                        <span id="btn_text"><i class="fa fa-save"></i> {{ isset($vendor) ? 'Update Vendor' : 'Save Vendor' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<script>
$(function() {
    // Clear validation errors on input change
    $('#vendorForm input, #vendorForm select').on('input change', function() {
        $(this).removeClass('is-invalid');
        const errorElement = $('#' + $(this).attr('name') + '_error');
        if (errorElement.length) {
            errorElement.text('');
        }
    });

    $('#vendorForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = form.find('input[name="_method"]').val() || 'POST';
        let formData = form.serialize();

        $('.error-text').text('');
        $('.is-invalid').removeClass('is-invalid');
        
        const submitBtn = $('#submitBtn');
        submitBtn.addClass('btn-loading');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function (response) {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.href = "{{ route('vendors.index') }}";
                        }
                    });
                }
            },
            error: function (xhr) {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        const input = $('input[name="' + key + '"], select[name="' + key + '"]');
                        if (input.length) {
                            input.addClass('is-invalid');
                        }
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
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
