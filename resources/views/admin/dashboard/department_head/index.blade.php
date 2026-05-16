@extends('admin.dashboard.master')

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    body { font-family: 'Inter', sans-serif; }
    
    .page-header {
        background: var(--bg-gradient);
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.35);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .btn-light-custom {
        background: white;
        color: #764ba2;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    
    .btn-light-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .card-premium {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        border: none;
    }
    
    .card-header-premium {
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        padding: 20px 30px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-premium h4 {
        color: #1e293b;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-premium thead th {
        background: linear-gradient(to right, #1e293b, #334155);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        border-bottom: none;
        vertical-align: middle;
    }
    
    .table-premium thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    
    .table-premium thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    
    .table-premium tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    
    .table-premium tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-premium tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    
    .avatar-premium {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
    }
    
    .badge-premium {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
    }
    
    .badge-success { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .badge-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 0 4px;
    }
    
    .btn-action:hover { transform: translateY(-2px); }
    .btn-edit { background: linear-gradient(135deg, #4f46e5, #4338ca); color: white; }
    .btn-notify { background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; }
    .btn-delete { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    
    /* Custom Modal */
    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
    }
    
    .custom-modal-overlay.active { display: flex;  z-index: 9999;}
    
    .custom-modal {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }
    
    .custom-modal-header {
        background: var(--bg-gradient);
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .custom-modal-header h5 {
        color: white;
        margin: 0;
        font-weight: 600;
    }
    
    .custom-modal-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
    }
    
    .custom-modal-body { padding: 30px; }
    
    .custom-modal-footer {
        padding: 20px 30px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    
    .form-label-premium {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-control-premium {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 14px;
        width: 100%;
        box-sizing: border-box;
    }
    
    .form-control-premium:focus {
        border-color: var(--primary-color);
        outline: none;
    }
    
    .form-control-premium.is-invalid {
        border-color: #ef4444;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 13px;
        margin-top: 5px;
    }
    
    .btn-submit-premium {
        background: var(--bg-gradient);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .btn-submit-premium:hover { transform: translateY(-2px); }
    .btn-submit-premium:disabled { opacity: 0.7; cursor: not-allowed; }
    
    .btn-cancel-premium {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state-icon { font-size: 64px; margin-bottom: 20px; opacity: 0.5; }
    .text-muted-premium { color: #94a3b8; }
    
    /* Toast */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 100000;
    }
    
    .toast-notification {
        background: white;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 300px;
        transform: translateX(120%);
        transition: transform 0.4s ease;
    }
    
    .toast-notification.show { transform: translateX(0); }
    .toast-notification.success { border-left: 4px solid #10b981; }
    .toast-notification.error { border-left: 4px solid #ef4444; }
    
    .toast-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .toast-notification.success .toast-icon { background: #d1fae5; color: #10b981; }
    .toast-notification.error .toast-icon { background: #fee2e2; color: #ef4444; }
    
    /* Search Box Styles */
    .search-box {
        position: relative;
    }
    
    .search-box input {
        padding-left: 40px;
        width: 280px;
    }
    
    .search-box .fa-search {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    
    .search-box .clear-search {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        display: none;
    }
    
    .search-box .clear-search:hover {
        color: #64748b;
    }
    
    .filtered-row { display: none !important; }
    
    .search-highlight {
        background-color: #fef08a;
        padding: 0 2px;
        border-radius: 2px;
    }
    
    .no-results-row { display: table-row !important; }
    
    /* Highlighted row for assigned departments */
    .table-success-row {
        background-color: rgba(16, 185, 129, 0.08) !important;
    }
    
    .table-success-row:hover {
        background-color: rgba(16, 185, 129, 0.15) !important;
    }
</style>
<br>
<br>
<section role="main" class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h2 style="margin-top: -28px;"><i class="fa fa-user-tie"></i> Department Head Management</h2>
                <button class="btn-light-custom open-modal-btn"  style="margin-top: -28px;">
                    <i class="fa fa-plus-circle me-2"></i>Assign Department Head
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius: 12px; margin-bottom: 20px; padding: 15px 20px;">
            <i class="fa fa-check-circle me-2"></i><strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="border-radius: 12px; margin-bottom: 20px; padding: 15px 20px;">
            <i class="fa fa-exclamation-circle me-2"></i><strong>{{ session('error') }}</strong>
        </div>
    @endif

    <div class="card card-premium">
        <div class="card-header card-header-premium">
            <h4><i class="fa fa-list"></i> Department Heads List</h4>
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" id="searchDepartmentHeads" class="form-control-premium" placeholder="Search department, head, email...">
                <span class="clear-search" id="clearSearch"><i class="fa fa-times-circle"></i></span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-premium" id="departmentHeadsTable">
                    <thead style="background: linear-gradient(to right, #1e293b, #334155); color: white;">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="10%">Department</th>
                            <th width="12%">Department Head</th>
                            <th width="18%">Email</th>
                            <th width="12%">Phone</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="13%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $index => $department)
                        <tr class="@if($department->headEmployee || $department->head_email) table-success-row @endif">
                            <td class="text-center text-muted-premium fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($department->headEmployee || $department->head_email)
                                        <span class="badge bg-success" style="font-size: 10px;"><i class="fa fa-check me-1"></i>Assigned</span>
                                    @else
                                        <span class="badge bg-warning" style="font-size: 10px;"><i class="fa fa-clock me-1"></i>Pending</span>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $department->department_name }}</div>
                                        <small class="text-muted-premium">{{ $department->department_code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($department->headEmployee)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-premium me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                            {{ substr($department->headEmployee->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $department->headEmployee->name }}</div>
                                            <small class="text-muted-premium">{{ $department->headEmployee->designation ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                @elseif($department->head_name)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-premium me-3" style="background: linear-gradient(135deg, #64748b, #475569);">
                                            {{ substr($department->head_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $department->head_name }}</div>
                                            <small class="badge bg-secondary" style="font-size: 10px;">Manual</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted-premium"><i class="fa fa-exclamation-circle"></i> Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($department->headEmployee && $department->headEmployee->email)
                                    <a href="mailto:{{ $department->headEmployee->email }}" style="color: var(--primary-color); text-decoration: none;">
                                        <i class="fa fa-envelope me-1"></i>{{ $department->headEmployee->email }}
                                    </a>
                                @elseif($department->head_email)
                                    <a href="mailto:{{ $department->head_email }}" style="color: var(--primary-color); text-decoration: none;">
                                        <i class="fa fa-envelope me-1"></i>{{ $department->head_email }}
                                    </a>
                                @else
                                    <span class="text-muted-premium">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($department->headEmployee && $department->headEmployee->phone)
                                    <i class="fa fa-phone me-1 text-muted-premium"></i>{{ $department->headEmployee->phone }}
                                @else
                                    <span class="text-muted-premium">N/A</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($department->headEmployee || $department->head_email)
                                    <span class="badge badge-premium badge-success"><i class="fa fa-check-circle me-1"></i>Active</span>
                                @else
                                    <span class="badge badge-premium badge-warning"><i class="fa fa-exclamation-circle me-1"></i>Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-action btn-edit" 
                                        data-department-id="{{ $department->id }}"
                                        data-department-name="{{ $department->department_name }}"
                                        data-head-employee-id="{{ $department->head_employee_id }}"
                                        data-head-email="{{ $department->head_email }}"
                                        data-head-name="{{ $department->head_name }}"
                                        title="Edit"><i class="fa fa-edit"></i>
                                    </button>
                                    @if($department->headEmployee || $department->head_email)
                                    <button class="btn btn-action btn-notify" 
                                        data-department-id="{{ $department->id }}"
                                        data-head-email="{{ $department->head_email ?: $department->headEmployee->email }}"
                                        data-head-name="{{ $department->head_name ?: $department->headEmployee->name }}"
                                        title="Send Email"><i class="fa fa-envelope"></i>
                                    </button>
                                    @endif
                                    @if($department->head_employee_id || $department->head_email)
                                    <button class="btn btn-action btn-delete"
                                        data-department-id="{{ $department->id }}"
                                        data-department-name="{{ $department->department_name }}"
                                        title="Remove"><i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-icon">&#128203;</div>
                                <h5 class="text-muted-premium">No departments found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- Custom Modal --}}
<div class="custom-modal-overlay" id="assignHeadModal">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <h5 id="modalTitle"><i class="fa fa-user-tie"></i> Assign Department Head</h5>
            <button class="custom-modal-close" id="closeModal">&times;</button>
        </div>
        <form id="assignHeadForm" action="{{ route('admin.department-heads.store') }}" method="POST">
            @csrf
            <input type="hidden" name="department_id" id="modal_department_id">
            <div class="custom-modal-body">
                <div class="mb-3">
                    <label class="form-label-premium">
                        <i class="fa fa-building text-primary"></i>Select Department <span class="text-danger">*</span>
                    </label>
                    <select name="department_id" id="department_select" class="form-control-premium" required>
                        <option value="">Please Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->department_name }} ({{ $dept->department_code }})</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-department_id" style="display: none;"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label-premium"><i class="fa fa-users text-primary"></i>Assignment Method</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="radio" name="head_type" id="head_type_employee" value="employee" checked>
                        <label for="head_type_employee" style="cursor: pointer; padding: 10px 15px; border: 2px solid #e2e8f0; border-radius: 10px; flex: 1; text-align: center;">
                            <i class="fa fa-user me-2"></i>From Employees
                        </label>
                        <input type="radio" name="head_type" id="head_type_manual" value="manual">
                        <label for="head_type_manual" style="cursor: pointer; padding: 10px 15px; border: 2px solid #e2e8f0; border-radius: 10px; flex: 1; text-align: center;">
                            <i class="fa fa-pencil me-2"></i>Manual Entry
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="employee_selection_section">
                    <label class="form-label-premium"><i class="fa fa-user text-primary"></i>Select Employee <span class="text-danger">*</span></label>
                    <div style="position: relative;">
                        <select name="head_employee_id" id="head_employee_id" class="form-control-premium">
                            <option value="">Please Select Department First</option>
                        </select>
                        <span id="employee_loading" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: none;">
                            <i class="fa fa-spinner fa-spin text-primary"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback error-head_employee_id" style="display: none;"></div>
                </div>

                <div id="manual_entry_section" style="display: none;">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label-premium"><i class="fa fa-user text-primary"></i>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control-premium" id="head_name" name="head_name" placeholder="Enter name">
                            <div class="invalid-feedback error-head_name" style="display: none;"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label-premium"><i class="fa fa-envelope text-primary"></i>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control-premium" id="head_email_manual" name="head_email" placeholder="Enter email">
                            <div class="invalid-feedback error-head_email" style="display: none;"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div style="padding: 15px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 12px;">
                        <input type="checkbox" id="send_notification" name="send_notification" value="1" style="width: 18px; height: 18px; cursor: pointer;">
                        <label for="send_notification" style="cursor: pointer; margin-left: 10px;">
                            <strong><i class="fa fa-paper-plane text-primary me-2"></i>Send Notification Email</strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn-cancel-premium" id="cancelModalBtn">Cancel</button>
                <button type="submit" class="btn-submit-premium" id="submitBtn">Save Assignment</button>
            </div>
        </form>
    </div>
</div>

{{-- Forms for notification and remove --}}
<form id="sendNotificationForm" action="{{ route('admin.department-heads.send-notification') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="department_id" id="notify_department_id">
</form>
<form id="removeHeadForm" action="{{ route('admin.department-heads.remove') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="department_id" id="remove_department_id">
</form>

{{-- Toast Container --}}
<div class="toast-container" id="toastContainer"></div>

<script>
// Modal functions
function openModal() {
    document.getElementById('assignHeadModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Initialize Select2 for employee dropdown after modal is visible
    const empSelect = document.getElementById('head_employee_id');
    if (!$(empSelect).hasClass('select2-hidden-accessible')) {
        $(empSelect).select2({
            placeholder: 'Please Select Employee',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#assignHeadModal')
        });
    }
}

function closeModal() {
    document.getElementById('assignHeadModal').classList.remove('active');
    document.body.style.overflow = '';
    resetModal();
}

function resetModal() {
    document.getElementById('assignHeadForm').reset();
    document.getElementById('modal_department_id').value = '';
    document.getElementById('department_select').value = '';
    document.getElementById('department_select').disabled = false;
    document.getElementById('head_employee_id').innerHTML = '<option value="">Please Select Department First</option>';
    document.getElementById('modalTitle').innerHTML = '<i class="fa fa-user-tie"></i> Assign Department Head';
    
    // Clear errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => { el.style.display = 'none'; el.textContent = ''; });
}

// Toast function
function showToast(type, title, message) {
    const container = document.getElementById('toastContainer');
    const toastId = 'toast-' + Date.now();
    const icon = type === 'success' ? '✓' : '✕';
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification ' + type;
    toast.id = toastId;
    toast.innerHTML = '<div class="toast-icon">' + icon + '</div><div><div style="font-weight: 600;">' + title + '</div><div style="font-size: 13px; color: #64748b;">' + message + '</div></div>';
    
    container.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 5000);
}

// Escape regex special characters
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Highlight matching text function
function highlightText(element, searchTerm) {
    const existingHighlights = element.querySelectorAll('.search-highlight');
    existingHighlights.forEach(el => {
        el.outerHTML = el.innerHTML;
    });
    
    if (!searchTerm) return;
    
    const textNodes = [];
    const walker = document.createTreeWalker(element, NodeFilter.SHOW_TEXT, null, false);
    let node;
    while (node = walker.nextNode()) {
        if (node.textContent.toLowerCase().includes(searchTerm) && node.parentElement.tagName !== 'SCRIPT' && node.parentElement.tagName !== 'STYLE') {
            textNodes.push(node);
        }
    }
    
    textNodes.forEach(textNode => {
        const span = document.createElement('span');
        span.className = 'search-highlight';
        span.style.backgroundColor = '#fef08a';
        span.style.padding = '0 2px';
        span.style.borderRadius = '2px';
        
        const regex = new RegExp('(' + escapeRegExp(searchTerm) + ')', 'gi');
        span.textContent = textNode.textContent;
        textNode.parentNode.replaceChild(span, textNode);
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Open modal
    document.querySelectorAll('.open-modal-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            resetModal();
            openModal();
        });
    });
    
    // Close modal
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
    
    document.getElementById('assignHeadModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    // Head type toggle
    document.querySelectorAll('input[name="head_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('employee_selection_section').style.display = this.value === 'employee' ? 'block' : 'none';
            document.getElementById('manual_entry_section').style.display = this.value === 'manual' ? 'block' : 'none';
            document.getElementById('head_employee_id').required = this.value === 'employee';
            document.getElementById('head_name').required = this.value === 'manual';
            document.getElementById('head_email_manual').required = this.value === 'manual';
        });
    });
    
    // Populate employees
    document.getElementById('department_select').addEventListener('change', function() {
        const deptId = this.value;
        const empSelect = document.getElementById('head_employee_id');
        const loadingSpan = document.getElementById('employee_loading');
        
        // Destroy existing Select2 if initialized
        if ($(empSelect).hasClass('select2-hidden-accessible')) {
            $(empSelect).select2('destroy');
        }
        empSelect.innerHTML = '<option value="">Please Select Employee</option>';
        empSelect.disabled = true;
        loadingSpan.style.display = 'inline-block';
        
        if (deptId) {
            fetch('{{ route('admin.department-heads.employees', ['departmentId' => ':deptId']) }}'.replace(':deptId', deptId))
                .then(res => res.json())
                .then(employees => {
                    employees.forEach(emp => {
                        const option = document.createElement('option');
                        option.value = emp.id;
                        option.textContent = emp.name + ' - ' + (emp.designation || 'N/A');
                        empSelect.appendChild(option);
                    });
                    empSelect.disabled = false;
                    loadingSpan.style.display = 'none';
                    // Initialize Select2 after populating
                    $(empSelect).select2({
                        placeholder: 'Please Select Employee',
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#assignHeadModal')
                    });
                })
                .catch(() => {
                    empSelect.disabled = false;
                    loadingSpan.style.display = 'none';
                });
        } else {
            empSelect.disabled = false;
            loadingSpan.style.display = 'none';
        }
    });
    
    // Edit button - using event delegation
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-edit');
        if (btn) {
            const deptId = btn.dataset.departmentId;
            const deptName = btn.dataset.departmentName;
            const headEmpId = btn.dataset.headEmployeeId;
            const headEmail = btn.dataset.headEmail;
            const headName = btn.dataset.headName;
            
            document.getElementById('modal_department_id').value = deptId || '';
            document.getElementById('department_select').value = deptId || '';
            document.getElementById('department_select').disabled = true;
            document.getElementById('modalTitle').innerHTML = '<i class="fa fa-edit"></i> Edit Department Head for ' + (deptName || '');
            
            // Open modal first so Select2 can calculate position correctly
            openModal();
            
            if (headEmpId) {
                document.querySelector('input[value="employee"]').checked = true;
                document.getElementById('employee_selection_section').style.display = 'block';
                document.getElementById('manual_entry_section').style.display = 'none';
                
                fetch('{{ route('admin.department-heads.employees', ['departmentId' => ':deptId']) }}?selected_employee_id=' + headEmpId + '&departmentId=' + deptId)
                    .then(res => res.json())
                    .then(employees => {
                        const empSelect = document.getElementById('head_employee_id');
                        const loadingSpan = document.getElementById('employee_loading');
                        
                        // Destroy existing Select2 to reinitialize with new data
                        if ($(empSelect).hasClass('select2-hidden-accessible')) {
                            $(empSelect).select2('destroy');
                        }
                        
                        // Populate employees
                        empSelect.innerHTML = '<option value="">Please Select Employee</option>';
                        employees.forEach(emp => {
                            const option = document.createElement('option');
                            option.value = emp.id;
                            option.textContent = emp.name + ' - ' + (emp.designation || 'N/A');
                            empSelect.appendChild(option);
                        });
                        
                        // Set the selected value
                        empSelect.value = headEmpId;
                        
                        // Initialize Select2 after setting value
                        $(empSelect).select2({
                            placeholder: 'Please Select Employee',
                            allowClear: true,
                            width: '100%',
                            dropdownParent: $('#assignHeadModal')
                        });
                        
                        // Ensure the value is set after Select2 initialization
                        empSelect.value = headEmpId;
                        $(empSelect).trigger('change');
                        
                        loadingSpan.style.display = 'none';
                    });
            } else if (headEmail) {
                document.querySelector('input[value="manual"]').checked = true;
                document.getElementById('employee_selection_section').style.display = 'none';
                document.getElementById('manual_entry_section').style.display = 'block';
                document.getElementById('head_name').value = headName || '';
                document.getElementById('head_email_manual').value = headEmail || '';
            }
        }
    });
    
    // Send notification button - event delegation
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-notify');
        if (btn) {
            Swal.fire({
                title: 'Send Notification?',
                text: 'Send email notification to ' + btn.dataset.headName + ' (' + btn.dataset.headEmail + ')?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Send!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('notify_department_id').value = btn.dataset.departmentId;
                    document.getElementById('sendNotificationForm').submit();
                }
            });
        }
    });
    
    // Remove button - event delegation
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-delete');
        if (btn) {
            Swal.fire({
                title: 'Remove Department Head?',
                text: 'Are you sure you want to remove the department head for ' + btn.dataset.departmentName + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Remove!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('remove_department_id').value = btn.dataset.departmentId;
                    document.getElementById('removeHeadForm').submit();
                }
            });
        }
    });
    
    // Form submission
    document.getElementById('assignHeadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => { el.style.display = 'none'; el.textContent = ''; });
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';
        
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Save Assignment';
            
            if (data.message) {
                closeModal();
                showToast('success', 'Success!', data.message);
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(xhr => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Save Assignment';
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                for (const field in errors) {
                    const fieldEl = document.querySelector('[name="' + field + '"]');
                    const errorEl = document.querySelector('.error-' + field);
                    if (fieldEl) fieldEl.classList.add('is-invalid');
                    if (errorEl) { errorEl.textContent = errors[field][0]; errorEl.style.display = 'block'; }
                }
                showToast('error', 'Validation Error', 'Please check the form for errors.');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                showToast('error', 'Error!', xhr.responseJSON.message);
            } else {
                showToast('error', 'Error!', 'Something went wrong.');
            }
        });
    });
    
    // Search functionality
    document.getElementById('searchDepartmentHeads').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const clearBtn = document.getElementById('clearSearch');
        const table = document.getElementById('departmentHeadsTable');
        const tbody = table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr:not(.empty-state-row)');
        
        // Show/hide clear button
        clearBtn.style.display = searchTerm ? 'block' : 'none';
        
        // Filter rows
        let visibleCount = 0;
        rows.forEach(row => {
            const departmentName = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const departmentCode = row.querySelector('td:nth-child(2) small')?.textContent.toLowerCase() || '';
            const headName = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const email = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
            const phone = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';
            const status = row.querySelector('td:nth-child(6)')?.textContent.toLowerCase() || '';
            
            const rowText = departmentName + ' ' + departmentCode + ' ' + headName + ' ' + email + ' ' + phone + ' ' + status;
            
            if (rowText.includes(searchTerm)) {
                row.style.display = '';
                row.classList.remove('filtered-row');
                visibleCount++;
            } else {
                row.style.display = 'none';
                row.classList.add('filtered-row');
            }
        });
        
        // Show/hide empty state based on results
        if (searchTerm && visibleCount === 0) {
            // Show no results found
            if (!tbody.querySelector('.no-results-row')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = '<td colspan="7" class="empty-state">' +
                    '<div class="empty-state-icon">&#128270;</div>' +
                    '<h5 class="text-muted-premium">No department heads found</h5>' +
                    '<p class="text-muted-premium">Try different search terms</p>' +
                    '</td>';
                tbody.insertBefore(noResultsRow, tbody.firstChild);
            }
        } else {
            const noResultsRow = tbody.querySelector('.no-results-row');
            if (noResultsRow) noResultsRow.remove();
        }
        
        // Highlight matching text
        if (searchTerm) {
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    highlightText(row, searchTerm);
                }
            });
        } else {
            rows.forEach(row => {
                const highlighted = row.querySelectorAll('.search-highlight');
                highlighted.forEach(el => {
                    el.outerHTML = el.innerHTML;
                });
            });
        }
    });
    
    // Clear search button
    document.getElementById('clearSearch').addEventListener('click', function() {
        const searchInput = document.getElementById('searchDepartmentHeads');
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });
});
</script>
@endsection
