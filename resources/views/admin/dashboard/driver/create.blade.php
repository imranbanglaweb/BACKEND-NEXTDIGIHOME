@extends('admin.dashboard.master')

@section('main_content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #fff !important;
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .card-body {
        padding: 1.8rem;
    }

    label.form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.4rem;
    }

    .input-group-text {
        background-color: #eef1f5;
        border-right: 0;
    }

    .form-control, .form-select {
        border-left: 0;
        height: 42px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.15);
    }

    h5.section-title {
        color: #0d6efd;
        font-weight: 600;
        font-size: 1rem;
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
        margin-bottom: 1rem;
        margin-top: 1.5rem;
    }

    .btn-success {
        font-weight: 600;
        border-radius: 6px;
    }

    .btn-outline-primary {
        border-radius: 6px;
    }
</style>

<section role="main" class="content-body" style="background:#fff">
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h3 class="fw-bold text-primary mb-0"><i class="bi bi-person-plus-fill me-2"></i>Add New Driver</h3>
        <a class="btn btn-primary btn-lg px-3 pull-right" href="{{ route('drivers.index') }}">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <form id="driver_add" method="POST" enctype="multipart/form-data">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <!-- Organizational Info -->
            <h5 class="section-title"><i class="bi bi-building me-1"></i> Organizational Info</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Unit</label><br>
                    <select class="form-select select2" name="unit_id" id="unit_id">
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Department</label><br>
                    <select class="form-select select2" name="department_id" id="department_id">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                         <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Employee ID</label><br>
                    <select class="form-select select2" name="employee_id" id="employee_id">
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">
                                {{ $emp->name }} ({{ $emp->employee_code ?? $emp->id }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Driver Details -->
            <h5 class="section-title"><i class="bi bi-person-vcard me-1"></i> Driver Details</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Driver Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="driver_name" id="driver_name" class="form-control" placeholder="Enter Driver Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">License Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" name="license_number" class="form-control" placeholder="License Number">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">License Type
                        <button type="button" id="add-license-type-btn" class="btn btn-sm btn-outline-secondary ms-2" title="Add license type">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-gear-fill"></i></span>
                        <select name="license_type_id" class="form-select" id="license_type_id">
                            <option value="">Select License Type</option>
                            @if(!empty($licenseTypes) && $licenseTypes->count())
                                @foreach($licenseTypes as $lt)
                                    <option value="{{ $lt->id }}">{{ $lt->type_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">License Issue Date</label>
                    <input type="date" name="license_issue_date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="joining_date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
            </div>

            <!-- Address & Contact -->
            <h5 class="section-title"><i class="bi bi-geo-alt-fill me-1"></i> Address & Contact</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">NID</label>
                    <input type="text" name="nid" id="nid" class="form-control" placeholder="National ID">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Present Address</label>
                    <input type="text" name="present_address" id="present_address" class="form-control" placeholder="Present Address">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Permanent Address</label>
                    <input type="text" name="permanent_address" id="permanent_address" class="form-control" placeholder="Permanent Address">
                </div>
            </div>

            <!-- Work Information -->
            <h5 class="section-title"><i class="bi bi-clock-history me-1"></i> Work Information</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Working Time Slot</label>
                    <input type="text" name="working_time_slot" class="form-control" placeholder="e.g. 9am - 6pm">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Leave Status</label>
                    <select name="leave_status" class="form-select">
                        <option value="0">Active</option>
                        <option value="1">On Leave</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Photograph</label>
                    <input type="file" name="photograph" class="form-control">
                </div>
            </div>

            <div class="text-center mt-4">
               <button type="submit" class="btn btn-success btn-lg px-4">
                    <i class="bi bi-check-circle-fill me-2"></i> Save Driver
                </button>
            </div>
        </div>
    </div>
    </form>
</div>
</section>

<!-- Modal: Add License Type -->
<div class="modal" id="licenseTypeModal" tabindex="-1" aria-labelledby="licenseTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="licenseTypeModalLabel">Add License Type</h5>
                <button type="button" class="btn-close" data--dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="licenseTypeForm">
                    <div class="mb-3">
                        <label class="form-label">Type Name</label>
                        <input type="text" name="type_name" class="form-control" required />
                        <div class="invalid-feedback d-none" id="lt-type-name-error"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="licenseTypeSaveBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Required Scripts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    .modal-backdrop.fade {
        opacity: 0.5 !important;
    }
    .modal {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    // Initialize Select2
    $(document).ready(function() {
        $('.select2').select2();
    });

    // Setup CSRF Token
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

  

    // Employee auto-fill (use the selected code value correctly)
    $('#employee_id').on('change', function () {
        var empId = $(this).val();
        if (!empId) return;

        $.get("{{ route('getEmployeeInfo') }}", { employee_id: empId }, function (data) {
            if (!data || data.error) {
                console.warn('Employee info not found', data);
                return;
            }
            $('#driver_name').val(data.name || '');
            $('#nid').val(data.nid || '');
            $('#mobile').val(data.mobile || '');
            // populate joining date and date of birth if available
            $('input[name="joining_date"]').val(data.joining_date || '');
            $('input[name="date_of_birth"]').val(data.date_of_birth || '');
            $('#present_address').val(data.present_address || '');
            $('#permanent_address').val(data.permanent_address || '');
        }).fail(function(xhr){
            console.error('Failed to fetch employee info', xhr);
        });
    });

    // Remove errors on input/change
    $(document).on('input change', 'input, select', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.text-danger').fadeOut(200, function () {
            $(this).remove();
        });
    });

    // ✅ AJAX Form Submit
    $(document).on('submit', '#driver_add', function (e) {
        e.preventDefault(); // Prevent default form submission
        e.stopImmediatePropagation(); // Stop other handlers (fixes double submit)

        let formData = new FormData(this);

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').remove();

        $.ajax({
            type: 'POST',
            url: "{{ route('drivers.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('button[type=submit]').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Saving...');
            },
            success: function (response) {
                $('button[type=submit]').prop('disabled', false).html('<i class="bi bi-check-circle-fill me-2"></i> Save Driver');
                Swal.fire({
                    icon: 'success',
                    title: 'Driver Added Successfully!',
                    text: 'New driver has been saved successfully.',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location.href = "{{ route('drivers.index') }}";
                });
            },
            error: function (xhr) {
                $('button[type=submit]').prop('disabled', false).html('<i class="bi bi-check-circle-fill me-2"></i> Save Driver');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, val) {
                        let input = $('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        if (input.next('.text-danger').length === 0) {
                            input.after('<div class="text-danger mt-1 small">' + val[0] + '</div>');
                        }
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error!',
                        text: 'Please correct the highlighted fields.',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error!',
                        text: 'Something went wrong. Please try again later.',
                        confirmButtonColor: '#d33'
                    });
                }
            }
        });
    });

    // Inline license-type modal handling
    $('#add-license-type-btn').on('click', function(){
        // reset form
        $('#licenseTypeForm')[0].reset();
        $('#lt-type-name-error').addClass('d-none').text('');
        $('#licenseTypeModal').modal('show');
    });

    $('#licenseTypeSaveBtn').on('click', function(){
        var $btn = $(this);
        $btn.prop('disabled', true).text('Saving...');
        $('#lt-type-name-error').addClass('d-none').text('');
        var formData = {
            type_name: $('#licenseTypeForm [name="type_name"]').val(),
            description: $('#licenseTypeForm [name="description"]').val(),
            status: $('#licenseTypeForm [name="status"]').val(),
        };

        $.ajax({
            url: "{{ route('license-types.store') }}",
            method: 'POST',
            data: formData,
            success: function(res){
                // expected to return JSON with type.id and type.type_name
                var type = res.data || res.type || res;
                if (type && type.id) {
                    // add option to select and select it
                    var $select = $('#license_type_id');
                    // append new option
                    $select.append($('<option>', { value: type.id, text: type.type_name }));
                    // set selected
                    $select.val(type.id).trigger('change');
                    // close modal
                    $('#licenseTypeModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message || 'License type added successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
                $btn.prop('disabled', false).text('Save');
            },
            error: function(xhr){
                $btn.prop('disabled', false).text('Save');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.type_name) {
                        $('#lt-type-name-error').removeClass('d-none').text(errors.type_name[0]);
                        $('#licenseTypeForm [name="type_name"]').addClass('is-invalid');
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Unable to save license type.' });
                }
            }
        });
    });
</script>
@endsection
