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
</style>

<div class="page-header">
    <h2><i class="fa fa-user-plus mr-2"></i> Add Department Employee</h2>
    <p>Create a new employee in your department</p>
</div>

<div class="content-card">
    <form action="{{ route('admin.employees.department.store') }}" method="POST" enctype="multipart/form-data" id="employee-form">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label>Unit <span style="color: red;">*</span></label>
                <select name="unit_id" class="form-control" required>
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Employee Code</label>
                <input type="text" name="employee_code" class="form-control" placeholder="Auto-generated if empty">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Name <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Enter employee name" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email address">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
            </div>
            
            <div class="form-group">
                <label>Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="Enter designation">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Employee Type</label>
                <select name="employee_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Contract">Contract</option>
                    <option value="Intern">Intern</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Location</label>
                <select name="location_id" class="form-control">
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Join Date</label>
                <input type="date" name="join_date" class="form-control">
            </div>
        </div>
        
        <div class="form-group">
            <label>Blood Group</label>
            <select name="blood_group" class="form-control">
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>NID</label>
            <input type="text" name="nid" class="form-control" placeholder="Enter NID number">
        </div>
        
        <div class="form-group">
            <label>Present Address</label>
            <textarea name="present_address" class="form-control" rows="3" placeholder="Enter present address"></textarea>
        </div>
        
        <div class="form-group">
            <label>Permanent Address</label>
            <textarea name="permanent_address" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
        </div>
        
        <div class="form-group">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>
        
        <div style="margin-top: 30px;">
            <a href="{{ route('admin.employees.department.index') }}" class="btn-back">Back</a>
            <button type="submit" class="btn-submit">Create Employee</button>
        </div>
    </form>
</div>
@endsection
