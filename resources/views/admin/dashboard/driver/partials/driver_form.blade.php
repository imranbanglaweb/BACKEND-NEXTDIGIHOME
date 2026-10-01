{{-- drivers/_form.blade.php --}}
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Unit</label>
        <select class="form-select select2" name="unit_id" id="unit_id">
            <option value="">Select Unit</option>
            @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ (isset($driver) && $driver->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Department</label>
        <select class="form-select select2" name="department_id" id="department_id">
            <option value="">Select Department</option>
            @if(isset($driver) && $driver->department_id)
                @php $dept = \App\Models\Department::find($driver->department_id); @endphp
                @if($dept)
                    <option value="{{ $dept->id }}" selected>{{ $dept->department_name }}</option>
                @endif
            @endif
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Employee ID</label>
        <select class="form-select select2" name="employee_code" id="employee_code">
            <option value="">Select Employee</option>
            @foreach($employees as $emp)
                @php
                    $empValue = $emp->employee_code ?? $emp->id;
                    $empText = trim(($emp->name ?? '') . ' ' . ($emp->employee_code ?? ''));
                    if ($empText === '') { $empText = 'Employee '.$emp->id; }
                @endphp
                <option value="{{ $empValue }}" {{ (isset($driver) && $driver->employee_code == $empValue) ? 'selected' : '' }}>{{ $empText }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Driver Name</label>
        <input type="text" name="driver_name" id="driver_name" class="form-control" value="{{ $driver->driver_name ?? old('driver_name') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">License Number</label>
        <input type="text" name="license_number" class="form-control" value="{{ $driver->license_number ?? old('license_number') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">License Type</label>
        <select name="license_type_id" id="license_type_id" class="form-select select2">
            <option value="">Select License Type</option>
            @foreach($licenseTypes as $lt)
                <option value="{{ $lt->id }}" {{ (isset($driver) && $driver->license_type_id == $lt->id) ? 'selected' : '' }}>{{ $lt->type_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">License Issue Date</label>
        <input type="date" name="license_issue_date" class="form-control" value="{{ isset($driver) ? $driver->license_issue_date : '' }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Joining Date</label>
        <input type="date" name="joining_date" class="form-control" value="{{ isset($driver) ? $driver->joining_date : '' }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="{{ isset($driver) ? $driver->date_of_birth : '' }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">NID</label>
        <input type="text" name="nid" id="nid" class="form-control" value="{{ $driver->nid ?? '' }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $driver->mobile ?? '' }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Present Address</label>
        <input type="text" name="present_address" id="present_address" class="form-control" value="{{ $driver->present_address ?? '' }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Permanent Address</label>
        <input type="text" name="permanent_address" id="permanent_address" class="form-control" value="{{ $driver->permanent_address ?? '' }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Working Time Slot</label>
        <input type="text" name="working_time_slot" class="form-control" value="{{ $driver->working_time_slot ?? '' }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Leave Status</label>
        <select name="leave_status" class="form-select">
            <option value="0" {{ (isset($driver) && $driver->leave_status==0) ? 'selected':'' }}>Active</option>
            <option value="1" {{ (isset($driver) && $driver->leave_status==1) ? 'selected':'' }}>On Leave</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Photograph</label>
        <input type="file" name="photograph" class="form-control">
        @if(isset($driver) && $driver->photograph)
            <div class="mt-2"><img src="{{ asset('storage/'.$driver->photograph) }}" style="max-height:80px;"></div>
        @endif
    </div>
</div>
