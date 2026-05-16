@extends('admin.dashboard.master')

@section('main_content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .form-label { font-weight: 600; }
    .error-text { color: red; font-size: 1.2rem; margin-top: 2px; }
</style>
@endpush

<section role="main" class="content-body" style="background-color:#f8f9fa;">
<div class="container mt-4">
<br>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0" style="font-weight: 600; padding: 10px;">
                <i class="fa fa-calendar-plus me-2"></i>
                Create Maintenance Schedule
            </h5>
        </div>

        <div class="card-body">
            <form id="scheduleForm">
                @csrf
                <div class="row g-3">

                    {{-- Vehicle --}}
                    <div class="col-md-4">
                        <label class="form-label">Vehicle *</label>
                        <select name="vehicle_id" class="form-control select2">
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->vehicle_name }}</option>
                            @endforeach
                        </select>
                        <span class="error-text" id="error-vehicle_id"></span>
                    </div>

                    {{-- Type --}}
                    <div class="col-md-4">
                        <label class="form-label">Maintenance Type *</label>
                        <select name="maintenance_type_id" class="form-control select2">
                            @foreach($types as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        <span class="error-text" id="error-maintenance_type_id"></span>
                    </div>

                    {{-- Vendor --}}
                    <div class="col-md-4">
                        <label class="form-label">Vendor (Optional)</label>
                        <select name="vendor_id" class="form-control select2">
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                            @endforeach
                        </select>
                        <span class="error-text" id="error-vendor_id"></span>
                    </div>

                    {{-- Title --}}
                    <div class="col-md-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Maintenance title">
                        <span class="error-text" id="error-title"></span>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-3">
                        <label class="form-label">Scheduled Date *</label>
                        <input type="date" name="scheduled_at" class="form-control">
                        <span class="error-text" id="error-scheduled_at"></span>
                    </div>

                    {{-- Next Due --}}
                    <div class="col-md-3">
                        <label class="form-label">Next Due Date</label>
                        <input type="date" name="next_due_date" class="form-control">
                        <span class="error-text" id="error-next_due_date"></span>
                    </div>

                    {{-- KM --}}
                    <div class="col-md-3">
                        <label class="form-label">Due KM</label>
                        <input type="number" name="due_km" class="form-control" placeholder="Ex: 5000">
                        <span class="error-text" id="error-due_km"></span>
                    </div>

                    {{-- Frequency --}}
                    <div class="col-md-4">
                        <label class="form-label">Frequency</label>
                        <input type="text" name="frequency" class="form-control" placeholder="Ex: 3 months">
                        <span class="error-text" id="error-frequency"></span>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" rows="3" class="form-control"></textarea>
                        <span class="error-text" id="error-notes"></span>
                    </div>

                    <div class="col-md-12 text-end mt-3">
                        <button type="submit" id="saveBtn" class="btn btn-primary px-4">
                            <i class="fa fa-save me-1"></i> Save
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>
</section>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){

    // ---------- AJAX SUBMIT ----------
    $('#scheduleForm').submit(function(e){
        e.preventDefault();

        $("#saveBtn")
            .html('<i class="fa fa-spinner fa-spin me-2"></i> Saving...')
            .prop('disabled', true);

        $(".error-text").html(""); // clear errors

        $.ajax({
            url: "{{ route('maintenance.schedules.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){

                Swal.fire({
                    icon: 'success',
                    title: 'Saved Successfully!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = "{{ route('maintenance.schedules.index') }}";
                }, 1500);
            },

            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val){
                        $("#error-" + key).text(val[0]);
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please correct the highlighted fields'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!'
                    });
                }
            },

            complete: function(){
                $("#saveBtn")
                    .html('<i class="fa fa-save me-1"></i> Save')
                    .prop('disabled', false);
            }
        });
    });

});
</script>
@endsection
