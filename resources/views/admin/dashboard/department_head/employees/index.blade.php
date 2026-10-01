@extends('admin.dashboard.master')

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #0891b2;
        --primary-dark: #0e7490;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
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
    
    .page-header p {
        margin: 5px 0 0 0;
        opacity: 0.9;
    }
    
    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .card-header {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-header h3 {
        margin: 0;
        color: #1e293b;
        font-weight: 600;
    }
    
    .btn-primary-custom {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-primary-custom:hover {
        background: var(--primary-dark);
    }
    
    .table-responsive {
        padding: 0;
    }
    
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-custom thead th {
        background: #f8fafc;
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-custom tbody td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }
    
    .table-custom tbody tr:hover {
        background: #f8fafc;
    }
    
    .badge-active {
        background: #d1fae5;
        color: #047857;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-inactive {
        background: #fee2e2;
        color: #b91c1c;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .action-btns {
        display: flex;
        gap: 8px;
    }
    
    .btn-edit {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
    }
    
    .btn-delete {
        background: var(--danger-color);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
    }
    
    .employee-photo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<div class="page-header">
    <h2><i class="fa fa-users mr-2"></i> Department Employees</h2>
    <p>Manage employees in {{ $department->department_name ?? 'Your Department' }}</p>
</div>

<div class="content-card">
    <div class="card-header">
        <h3>Employee List</h3>
        <a href="{{ route('admin.employees.department.create') }}" class="btn-primary-custom">
            <i class="fa fa-plus mr-2"></i> Add Employee
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table-custom" id="employees-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Department</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employee_lists as $employee)
                <tr>
                    <td>#{{ str_pad($employee->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @if($employee->photo && file_exists(public_path($employee->photo)))
                            <img src="{{ asset('public/'.$employee->photo) }}" class="employee-photo" alt="photo">
                        @else
                            <i class="fa fa-user-circle text-muted" style="font-size: 30px;"></i>
                        @endif
                    </td>
                    <td><strong>{{ $employee->employee_name }}</strong></td>
                    <td>{{ $employee->unit_name }}</td>
                    <td>{{ $employee->department_name }}</td>
                    <td>{{ $employee->location_name }}</td>
                    <td>
                        <span class="badge-active">Active</span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.employees.department.edit', $employee->id) }}" class="btn-edit">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button class="btn-delete" onclick="deleteEmployee({{ $employee->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px;">
                        <i class="fa fa-users" style="font-size: 48px; color: #cbd5e1;"></i>
                        <p style="margin-top: 15px; color: #64748b;">No employees found in your department</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function deleteEmployee(id) {
    if(confirm('Are you sure you want to delete this employee?')) {
        fetch('{{ route("admin.employees.department.index") }}/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting employee');
            }
        })
        .catch(error => {
            alert('Error deleting employee');
        });
    }
}
</script>
@endsection
