@extends('admin.dashboard.master')

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #0891b2;
        --primary-dark: #0e7490;
    }
    
    body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    
    .page-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        color: white;
    }
    
    .page-header h2 {
        margin: 0;
        font-weight: 600;
    }
    
    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #374151;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .btn-submit {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-submit:hover {
        background: var(--primary-dark);
    }
    
    .btn-back {
        background: #6b7280;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }
    
    .btn-back:hover {
        background: #4b5563;
    }
    
    .photo-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
    }
</style>

<div class="page-header">
    <h2><i class="fa fa-user-edit mr-2"></i> Edit Department Employee</h2>
    <p>Update employee information</p>
</div>

<div class="content-card">
    <form action="{{ route('admin.employees.department.update', $employee_edit->id) }}" method="POST" enctype="multipart/form-data" id="employee-form">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label>Unit <span style="color: red;">*</span></label>
                <select name="unit_id" class="form-control" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $employee_edit->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Employee Code</label>
                <input type="text" name="employee_code" class="form-control" value="{{ $employee_edit->employee_code }}" placeholder="Auto-generated if empty">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Name <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ $employee_edit->name }}" placeholder="Enter employee name" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $employee_edit->email }}" placeholder="Enter email address">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $employee_edit->phone }}" placeholder="Enter phone number">
            </div>
            
            <div class="form-group">
                <label>Designation</label>
                <input type="text" name="designation" class="form-control" value="{{ $employee_edit->designation }}" placeholder="Enter designation">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Employee Type</label>
                <select name="employee_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="Permanent" {{ $employee_edit->employee_type == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                    <option value="Contract" {{ $employee_edit->employee_type == 'Contract' ? 'selected' : '' }}>Contract</option>
                    <option value="Intern" {{ $employee_edit->employee_type == 'Intern' ? 'selected' : '' }}>Intern</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Active" {{ $employee_edit->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $employee_edit->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Location</label>
                <select name="location_id" class="form-control">
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ $employee_edit->location_id == $location->id ? 'selected' : '' }}>{{ $location->location_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Join Date</label>
                <input type="date" name="join_date" class="form-control" value="{{ $employee_edit->join_date }}">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Blood Group</label>
                <select name="blood_group" class="form-control">
                    <option value="">Select Blood Group</option>
                    <option value="A+" {{ $employee_edit->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ $employee_edit->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ $employee_edit->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ $employee_edit->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="AB+" {{ $employee_edit->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ $employee_edit->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                    <option value="O+" {{ $employee_edit->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ $employee_edit->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>NID</label>
                <input type="text" name="nid" class="form-control" value="{{ $employee_edit->nid }}" placeholder="Enter NID number">
            </div>
        </div>
        
        <div class="form-group">
            <label>Present Address</label>
            <textarea name="present_address" class="form-control" rows="3" placeholder="Enter present address">{{ $employee_edit->present_address }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Permanent Address</label>
            <textarea name="permanent_address" class="form-control" rows="3" placeholder="Enter permanent address">{{ $employee_edit->permanent_address }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Photo</label>
            @if($employee_edit->photo && file_exists(public_path($employee_edit->photo)))
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('public/'.$employee_edit->photo) }}" class="photo-preview" alt="Current Photo">
                    <p style="margin-top: 5px; color: #64748b; font-size: 12px;">Current Photo</p>
                </div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>
        
        <div style="margin-top: 30px;">
            <a href="{{ route('admin.employees.department.index') }}" class="btn-back">Back</a>
            <button type="submit" class="btn-submit">Update Employee</button>
        </div>
    </form>
</div>
@endsection
