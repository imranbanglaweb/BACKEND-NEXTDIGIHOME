@extends('admin.dashboard.master')

@section('main_content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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
        color: #000;
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

<section role="main" class="content-body" style="background-color:#fff;">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h3 class="fw-bold text-primary mb-0"><i class="bi bi-person-plus-fill me-2"></i>Edit Driver</h3>
           <a class="btn btn-primary btn-lg px-3 pull-right" href="{{ route('drivers.index') }}">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form id="driver_edit_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" id="driver_id" name="id" value="{{ $driver->id }}">

                <!-- Organizational Info -->
                <h5 class="section-title"><i class="bi bi-building me-1"></i> Organizational Info</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Unit</label><br>
                        <select class="form-select select2" name="unit_id" id="unit_id">
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $driver->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Department</label><br>
                        <select class="form-select select2" name="department_id" id="department_id">
                            <option value="">Select Department</option>
                            {{-- Options populated via AJAX --}}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Employee ID</label><br>
                        <select class="form-select select2" name="employee_id" id="employee_id">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                @php
                                    $isSelected = false;
                                    if (!empty($driver->employee_id) && $driver->employee_id == $emp->id) {
                                        $isSelected = true;
                                    } elseif (empty($driver->employee_id) && !empty($driver->employee_nid) && $driver->employee_nid == $emp->nid) {
                                        $isSelected = true;
                                    }
                                @endphp
                                <option value="{{ $emp->id }}" {{ $isSelected ? 'selected' : '' }}>
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
                            <input type="text" name="driver_name" id="driver_name" class="form-control" value="{{ $driver->driver_name }}" placeholder="Enter Driver Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">License Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" name="license_number" class="form-control" value="{{ $driver->license_number }}" placeholder="License Number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">License Type</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-gear-fill"></i></span>
                            <select name="license_type_id" class="form-select" id="license_type_id">
                                <option value="">Select License Type</option>
                                @if(!empty($licenseTypes) && $licenseTypes->count())
                                    @foreach($licenseTypes as $lt)
                                        @php
                                            $isLtSelected = false;
                                            if (!empty($driver->license_type_id) && $driver->license_type_id == $lt->id) {
                                                $isLtSelected = true;
                                            } elseif (empty($driver->license_type_id) && !empty($driver->license_type) && $driver->license_type == $lt->type_name) {
                                                $isLtSelected = true;
                                            }
                                        @endphp
                                        <option value="{{ $lt->id }}" {{ $isLtSelected ? 'selected' : '' }}>{{ $lt->type_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">License Issue Date</label>
                        <input type="date" name="license_issue_date" class="form-control" value="{{ $driver->license_issue_date }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Joining Date</label>
                        <input type="date" name="joining_date" class="form-control" value="{{ $driver->joining_date }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ $driver->date_of_birth }}">
                    </div>
                </div>

                <!-- Address & Contact -->
                <h5 class="section-title"><i class="bi bi-geo-alt-fill me-1"></i> Address & Contact</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">NID</label>
                        <input type="text" name="nid" id="nid" class="form-control" value="{{ $driver->nid }}" placeholder="National ID">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $driver->mobile }}" placeholder="Mobile Number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Present Address</label>
                        <input type="text" name="present_address" id="present_address" class="form-control" value="{{ $driver->present_address }}" placeholder="Present Address">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Permanent Address</label>
                        <input type="text" name="permanent_address" id="permanent_address" class="form-control" value="{{ $driver->permanent_address }}" placeholder="Permanent Address">
                    </div>
                </div>

                <!-- Work Information -->
                <h5 class="section-title"><i class="bi bi-clock-history me-1"></i> Work Information</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Working Time Slot</label>
                        <input type="text" name="working_time_slot" class="form-control" value="{{ $driver->working_time_slot }}" placeholder="e.g. 9am - 6pm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Leave Status</label>
                        <select name="leave_status" class="form-select">
                            <option value="0" {{ $driver->leave_status == 0 ? 'selected' : '' }}>Active</option>
                            <option value="1" {{ $driver->leave_status == 1 ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Photograph</label>
                        <input type="file" name="photograph" id="photograph" class="form-control" accept="image/*">
                        <div class="mt-2">
                            <img id="preview_image" src="{{ $driver->photograph ? asset('public/'.$driver->photograph) : asset('public/admin_resource/assets/images/no_image.png') }}" 
                                 alt="Driver Photo" width="100" class="rounded border">
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                   <button type="submit" id="updateDriverBtn" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-save-fill me-2"></i> Update Driver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){
    // Initialize Select2
    $('.select2').select2();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    // Remove errors on input/change
    $(document).on('input change', 'input, select', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.text-danger').fadeOut(200, function () { $(this).remove(); });
    });

    // Unit -> Department Logic
    function loadDepartments(unitId, selectedDeptId = null) {
        if (!unitId) {
            $('#department_id').empty().append('<option value="">Select Department</option>');
            return;
        }
        $.getJSON("{{ route('getDepartmentsByUnit') }}", {unit_id: unitId}, function(data){
            var $dept = $('#department_id').empty().append('<option value="">Select Department</option>');
            $.each(data.department_list || [], function(i,d){
                var isSelected = (selectedDeptId && d.id == selectedDeptId) ? 'selected' : '';
                $dept.append('<option value="'+d.id+'" '+isSelected+'>'+d.department_name+'</option>');
            });
            if (selectedDeptId) {
                $dept.val(selectedDeptId);
            }
            // Re-trigger select2 update if needed
            if ($.fn.select2) {
                $dept.trigger('change');
            }
        });
    }

    $('#unit_id').change(function(){
        var id = $(this).val();
        loadDepartments(id);
    });

    // Employee auto-fill
    $('#employee_id').on('change', function () {
        var empId = $(this).val();
        if (!empId) return;

        $.get("{{ route('getEmployeeInfo') }}", { employee_id: empId }, function (data) {
            if (!data || data.error) return;
            
            $('#driver_name').val(data.name || '');
            $('#nid').val(data.nid || '');
            $('#mobile').val(data.mobile || '');
            if(data.joining_date) $('input[name="joining_date"]').val(data.joining_date);
            if(data.date_of_birth) $('input[name="date_of_birth"]').val(data.date_of_birth);
            $('#present_address').val(data.present_address || '');
            $('#permanent_address').val(data.permanent_address || '');
        });
    });

    // Initial Load
    var initialUnit = "{{ $driver->unit_id }}";
    var initialDept = "{{ $driver->department_id }}";
    if(initialUnit) {
        loadDepartments(initialUnit, initialDept);
    }

    // Photo Preview
    $('#photograph').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview_image').attr('src', e.target.result); 
        }
        if(this.files[0]) reader.readAsDataURL(this.files[0]);
    });

    // submit update
    $('#driver_edit_form').submit(function(e){
        e.preventDefault();
        var id = $('#driver_id').val();
        var form = new FormData(this);
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').remove();

        var $btn = $('#updateDriverBtn').prop('disabled', true).text('Updating...');
        
        $.ajax({
            url: "{{ route('drivers.update', $driver->id) }}",
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
            success: function(res){
                Swal.fire({ icon:'success', title:'Updated', text:res.message, timer:1500, showConfirmButton:false })
                    .then(()=> window.location.href = "{{ route('drivers.index') }}");
            },
            error: function(xhr){
                $btn.prop('disabled', false).text('Update Driver');
                if (xhr.status === 422){
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(k,v){
                        var $el = $('[name="'+k+'"]');
                        $el.addClass('is-invalid');
                        if ($el.next('.text-danger').length === 0){
                            $el.after('<div class="text-danger small mt-1">'+v[0]+'</div>');
                        }
                    });
                    Swal.fire('Validation Error','Please correct highlighted fields','error');
                } else {
                    Swal.fire('Error','Server error','error');
                }
            }
        });
    });
});
</script>
@endpush
@endsection
