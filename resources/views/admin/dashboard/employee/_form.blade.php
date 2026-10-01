<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-sitemap text-primary mr-1"></i> Unit</strong></label>
                        <select class="form-control unit_id select2" name="unit_id">
                            <option value="">Please select</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id}}" {{ (isset($employee_edit) && $employee_edit->unit_id == $unit->id) ? 'selected' : '' }}>{{ $unit->unit_name}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback d-none" data-field="unit_id"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-map-marker-alt text-primary mr-1"></i> Location</strong></label>
                        <select class="form-control select2" name="location_id">
                            <option value="">Please select</option>
                            @if(isset($locations))
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ (isset($employee_edit) && $employee_edit->location_id == $location->id) ? 'selected' : '' }}>{{ $location->location_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback d-none" data-field="location_id"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-layer-group text-primary mr-1"></i> Department</strong></label>
                        <select class="form-control department_name select2" name="department_id">
                            <option value="">Please select</option>
                            @if(isset($departments))
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ (isset($employee_edit) && $employee_edit->department_id == $department->id) ? 'selected' : '' }}>{{ $department->department_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback d-none" data-field="department_id"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong><i class="fa fa-id-badge text-primary mr-1"></i> Employee Code</strong></label>
                        {!! Form::text('employee_code', null, ['placeholder' => 'E.g. EMP-001','class' => 'form-control', 'id' => 'employee_code']) !!}
                        <div class="invalid-feedback d-none" data-field="employee_code"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong><i class="fa fa-user text-primary mr-1"></i> Name</strong></label>
                        {!! Form::text('name', null, ['placeholder' => 'Full name','class' => 'form-control', 'id' => 'name']) !!}
                        <div class="invalid-feedback d-none" data-field="name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong><i class="fa fa-envelope text-primary mr-1"></i> Email</strong></label>
                        {!! Form::email('email', null, ['placeholder' => 'email@example.com','class' => 'form-control', 'id' => 'email']) !!}
                        <div class="invalid-feedback d-none" data-field="email"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-phone text-primary mr-1"></i> Phone</strong></label>
                        {!! Form::text('phone', null, ['placeholder' => '+8801XXXXXXXXX','class' => 'form-control', 'id' => 'phone']) !!}
                        <div class="invalid-feedback d-none" data-field="phone"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-briefcase text-primary mr-1"></i> Employee Type</strong></label>
                        <select name="employee_type" class="form-control select2" id="employee_type">
                            <option value="">Please select</option>
                            <option value="Permanent" {{ (isset($employee_edit) && $employee_edit->employee_type == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                            <option value="Contract" {{ (isset($employee_edit) && $employee_edit->employee_type == 'Contract') ? 'selected' : '' }}>Contract</option>
                            <option value="Intern" {{ (isset($employee_edit) && $employee_edit->employee_type == 'Intern') ? 'selected' : '' }}>Intern</option>
                        </select>
                        <div class="invalid-feedback d-none" data-field="employee_type"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-user-tie text-primary mr-1"></i> Designation</strong></label>
                        {!! Form::text('designation', null, ['placeholder' => 'Designation','class' => 'form-control', 'id' => 'designation']) !!}
                        <div class="invalid-feedback d-none" data-field="designation"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-tint text-primary mr-1"></i> Blood Group</strong></label>
                        {!! Form::text('blood_group', null, ['placeholder' => 'e.g. A+','class' => 'form-control', 'id' => 'blood_group']) !!}
                        <div class="invalid-feedback d-none" data-field="blood_group"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-id-card text-primary mr-1"></i> NID</strong></label>
                        {!! Form::text('nid', null, ['placeholder' => 'National ID','class' => 'form-control', 'id' => 'nid']) !!}
                        <div class="invalid-feedback d-none" data-field="nid"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong><i class="fa fa-calendar-alt text-primary mr-1"></i> Join Date</strong></label>
                        {!! Form::date('join_date', null, ['class' => 'form-control', 'id' => 'join_date']) !!}
                        <div class="invalid-feedback d-none" data-field="join_date"></div>
                    </div>
                </div>

                        <div class="form-group">
                            <label><strong><i class="fa fa-home text-primary mr-1"></i> Present Address</strong></label>
                            {!! Form::textarea('present_address', null, ['rows'=>3,'placeholder' => 'Present address','class' => 'form-control', 'id' => 'present_address']) !!}
                            <div class="invalid-feedback d-none" data-field="present_address"></div>
                        </div>

                        <div class="form-group">
                            <label><strong><i class="fa fa-map-marker-alt text-primary mr-1"></i> Permanent Address</strong></label>
                            {!! Form::textarea('permanent_address', null, ['rows'=>3,'placeholder' => 'Permanent address','class' => 'form-control', 'id' => 'permanent_address']) !!}
                            <div class="invalid-feedback d-none" data-field="permanent_address"></div>
                        </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control" id="status">
                            <option value="Active" {{ (isset($employee_edit) && $employee_edit->status == 'Active') ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ (isset($employee_edit) && $employee_edit->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="invalid-feedback d-none" data-field="status"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group">
                            <label><strong>Photo</strong></label>
                            <div class="mb-2">
                                <!-- <img id="photo-preview" src="{{ asset('public/uploads/default-avatar.png') }}" alt="preview" style="max-width:100%; height:150px; object-fit:cover;" /> -->
                            <i class="fa fa-user text-primary" style="font-size:34px; height:50px; object-fit:cover;"></i>
                            </div>
                            {!! Form::file('photo', ['class'=>'form-control-file','id'=>'photo-input']) !!}
                            <div class="invalid-feedback d-none" data-field="photo"></div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Save Employee</button>
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary btn-block mt-2"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>