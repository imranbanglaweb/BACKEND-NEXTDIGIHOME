@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: #fff !important; padding: 0;">
<br>
<br>
    <div class="container-fluid px-4">
        {{-- Premium Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 py-3" style="border-bottom: 1px solid #e9ecef;">
            <div>
                <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; margin: 0;">
                    <i class="fa fa-clipboard-list text-primary me-2" style="font-size: 28px;"></i> Requisition Management
                </h2>
                <p class="text-muted mb-0" style="font-size: 14px; margin-top: 5px;">Manage and track all transport requisitions</p>
            </div>
            <a href="{{ route('requisitions.create') }}" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px; border-radius: 6px;">
                <i class="fa fa-plus me-2"></i>Create Requisition
            </a>
        </div>
<hr>
        {{-- Stats Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-3 text-center">
                        <div class="mb-2" style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                            <i class="fa fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0" style="font-size: 13px;">Total</p>
                            <h4 class="mb-0 fw-bold" style="font-size: 24px; color: #1a1a2e;">{{ $stats['total'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-3 text-center">
                        <div class="mb-2" style="width: 48px; height: 48px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0" style="font-size: 13px;">Pending</p>
                            <h4 class="mb-0 fw-bold" style="font-size: 24px; color: #1a1a2e;">{{ $stats['pending'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-3 text-center">
                        <div class="mb-2" style="width: 48px; height: 48px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0" style="font-size: 13px;">Approved</p>
                            <h4 class="mb-0 fw-bold" style="font-size: 24px; color: #1a1a2e;">{{ $stats['approved'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-3 text-center">
                        <div class="mb-2" style="width: 48px; height: 48px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                            <i class="fa fa-times-circle"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0" style="font-size: 13px;">Rejected</p>
                            <h4 class="mb-0 fw-bold" style="font-size: 24px; color: #1a1a2e;">{{ $stats['rejected'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Panel --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-bottom: 1px solid #e9ecef; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-semibold" style="color: #1a1a2e;">
                    <i class="fa fa-filter me-2 text-primary"></i>Filters & Search
                </h5>
            </div>
            <div class="card-body p-4">
                <form id="searchForm">
                    <div class="row g-3">
                        {{-- Requisition Number --}}
                        <div class="col-md-3">
                            <label for="requisition_number" class="form-label fw-semibold mb-2" style="font-size: 14px; color: #495057;">Requisition No.</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa fa-search text-muted"></i></span>
                                <input type="text" name="requisition_number" id="requisition_number"
                                       class="form-control border-start-0 ps-0" style="font-size: 14px;" placeholder="Enter requisition number...">
                            </div>
                        </div>

                        {{-- Employee Search - Hidden for Employee Role --}}
                        @if(!auth()->user()->hasRole('Employee'))
                        <div class="col-md-3">
                            <label for="employee_name" class="form-label fw-semibold mb-2" style="font-size: 14px; color: #495057;">Employee</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa fa-user text-muted"></i></span>
                                <input type="text" name="employee_name" id="employee_name"
                                       class="form-control border-start-0 ps-0" style="font-size: 14px;" placeholder="Search employee...">
                            </div>
                        </div>
                        @endif

                        {{-- Department - Hidden for Employee Role --}}
                        @if(!auth()->user()->hasRole('Employee'))
                        <div class="col-md-3">
                            <label for="department_id" class="form-label fw-semibold mb-2" style="font-size: 14px; color: #495057;">Department</label>
                            <select name="department_id" id="department_id" class="form-select" style="font-size: 14px;">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        {{-- Status --}}
                        <div class="col-md-3">
                            <label for="status" class="form-label fw-semibold mb-2" style="font-size: 14px; color: #495057;">Status</label>
                            <select name="status" id="status" class="form-select" style="font-size: 14px;">
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        {{-- Date Range - Hidden for Employee Role --}}
                        @if(!auth()->user()->hasRole('Employee'))
                        <div class="col-md-3">
                            <label for="start_date" class="form-label fw-semibold mb-2" style="font-size: 14px; color: #495057;">From Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" style="font-size: 14px;">
                        </div>

                        <div class="col-md-3">
                            <label for="end_date" class="form-label fw-semibold mb-2" style="font-size: 14px; color: #495057;">To Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" style="font-size: 14px;">
                        </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" style="font-size: 14px; padding: 10px 20px; border-radius: 6px;">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-outline-secondary" style="font-size: 14px; padding: 10px 20px; border-radius: 6px;">
                                    <i class="fa fa-redo me-2"></i>Reset
                                </button>
                                @if(!auth()->user()->hasRole('Employee'))
                                <button type="button" id="exportBtn" class="btn btn-success" style="font-size: 14px; padding: 10px 20px; border-radius: 6px;">
                                    <i class="fa fa-file-export me-2"></i>Export
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #e9ecef; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-semibold" style="color: #1a1a2e;">
                    <i class="fa fa-table me-2 text-primary"></i>Requisition Records
                </h5>
                <div class="d-flex align-items-center">
                    <span class="me-2 text-muted" style="font-size: 14px;">Show:</span>
                    <select id="perPage" class="form-select form-select-sm" style="width: auto; font-size: 14px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">

                {{-- Preloader --}}
                <div id="loader" class="text-center py-5" style="display: none;">
                    <div class="preloader">
                        <div class="preloader-content">
                            <div class="spinner-container">
                                <div class="spinner">
                                    <div class="spinner-ring"></div>
                                    <div class="spinner-ring"></div>
                                    <div class="spinner-ring"></div>
                                </div>
                            </div>
                            <div class="preloader-text">Loading requisitions...</div>
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="requisitionsTable" style="font-size: 14px;">
                        <thead>
                            <tr class="table-dark">
                                <th width="50" class="text-center rounded-start">#</th>
                                <th>Req. Number</th>
                                @if(!auth()->user()->hasRole('Employee'))
                                <th>Requested By</th>
                                <th>Department</th>
                                @endif
                                <th>Route</th>
                                <th>Travel Date</th>
                                <th>Return Date</th>
                                <th>Vehicle</th>
                                <th>Approval Status</th>
                                <th>Status</th>
                                <th width="120" class="text-center rounded-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">
                            @include('admin.dashboard.requisition.table')
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div id="paginationContainer" class="p-3 border-top bg-light" style="border-radius: 0 0 12px 12px;">
                    @include('admin.dashboard.requisition.pagination')
                </div>

            </div>
        </div>

    </div>

</section>

<script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
    /* Premium Card Styles */
    .card {
        transition: box-shadow 0.2s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }
    
    /* Table Styles */
    .table {
        font-size: 14px;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        white-space: nowrap;
        padding: 14px 12px;
        vertical-align: middle;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: #fff;
        border: none;
    }
    .table thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    .table thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    .table tbody td {
        vertical-align: middle;
        padding: 14px 12px;
        border-color: #e9ecef;
        color: #495057;
    }
    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    .table tbody tr:last-child {
        border-bottom: none;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa !important;
    }
    
    /* Status Badges */
    .badge {
        font-weight: 600;
        font-size: 12px;
        padding: 0.4em 0.75em;
        border-radius: 6px;
        text-transform: capitalize;
    }
    .badge.bg-warning-subtle {
        background-color: #fff3cd !important;
        color: #856404 !important;
        border: 1px solid #ffeeba;
    }
    .badge.bg-success-subtle {
        background-color: #d4edda !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb;
    }
    .badge.bg-danger-subtle {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb;
    }
    .badge.bg-secondary-subtle {
        background-color: #e2e3e5 !important;
        color: #383d41 !important;
        border: 1px solid #d6d8db;
    }
    .badge.bg-info-subtle {
        background-color: #d1ecf1 !important;
        color: #0c5460 !important;
        border: 1px solid #bee5eb;
    }
    .badge.bg-dark-subtle {
        background-color: #d6d8d9 !important;
        color: #1b1e21 !important;
        border: 1px solid #c6c8ca;
    }
    
    /* Department Badge */
    .table-badge {
        font-size: 12px !important;
        background-color: #e3f2fd !important;
        color: #0d47a1 !important;
        border: 1px solid #90caf9;
    }
    
    /* Form Elements */
    .form-control, .form-select {
        font-size: 14px;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    .input-group-text {
        font-size: 14px;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    /* Pagination */
    .pagination {
        font-size: 14px;
    }
    .pagination .page-link {
        padding: 0.4rem 0.75rem;
        font-size: 13px;
        border-radius: 6px;
        margin: 0 0.15rem;
        border: 1px solid #dee2e6;
        color: #495057;
        transition: all 0.2s ease;
    }
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #495057;
    }
    .pagination .page-item.active .page-link {
        background-color: #2c3e50;
        border-color: #2c3e50;
        color: #fff;
    }
    
    /* Loader */
    #loader {
        display: none;
    }
    
    /* Preloader Styles */
    .preloader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .preloader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .spinner-container {
        position: relative;
        width: 60px;
        height: 60px;
        margin-bottom: 1rem;
    }
    .spinner {
        position: relative;
        width: 100%;
        height: 100%;
    }
    .spinner-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #667eea;
        animation: spin 1s linear infinite;
    }
    .spinner-ring:nth-child(2) {
        width: 80%;
        height: 80%;
        top: 10%;
        left: 10%;
        border-top-color: #764ba2;
        animation-duration: 0.8s;
        animation-direction: reverse;
    }
    .spinner-ring:nth-child(3) {
        width: 60%;
        height: 60%;
        top: 20%;
        left: 20%;
        border-top-color: #f093fb;
        animation-duration: 0.6s;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .preloader-text {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .progress-bar {
        width: 200px;
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
        animation: progress 1.5s ease-in-out infinite;
    }
    @keyframes progress {
        0% { width: 0%; opacity: 0.5; }
        50% { width: 70%; opacity: 1; }
        100% { width: 100%; opacity: 0.5; }
    }
    
    /* Buttons */
    .btn {
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
    }
    .btn-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
    }
    
    /* Select2 Styling */
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 14px;
        min-height: 42px;
    }
    .select2-container--bootstrap-5 .select2-selection--single {
        height: auto;
    }
    .select2-container--bootstrap-5 .select2-selection__rendered {
        line-height: 1.5;
        padding-left: 0;
    }
    .select2-container--bootstrap-5 .select2-selection__arrow {
        height: 38px;
    }
    
    /* Per Page Select */
    #perPage {
        width: auto;
        min-width: 70px;
    }
    
    /* Modal Backdrop */
    .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); opacity: 1; }
    .modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select an option',
            allowClear: true
        });

        // Search with AJAX
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            fetchData(1);
        });

        // Reset form
        $('#resetBtn').on('click', function() {
            $('#searchForm')[0].reset();
            $('.select2').val(null).trigger('change');
            fetchData(1);
        });

        // Per page change
        $('#perPage').on('change', function() {
            fetchData(1);
        });

        // Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchData(page);
        });

        // Export functionality
        $('#exportBtn').on('click', function() {
            Swal.fire({
                title: 'Export Requisitions',
                text: 'Choose export format',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-file-excel me-2"></i>Excel',
                cancelButtonText: '<i class="fa fa-file-pdf me-2"></i>PDF',
                showDenyButton: true,
                denyButtonText: '<i class="fa fa-file-csv me-2"></i>CSV',
                denyButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    exportData('excel');
                } else if (result.isDenied) {
                    exportData('csv');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    exportData('pdf');
                }
            });
        });
    });

    // Fetch data with pagination
    function fetchData(page = 1) {
        $('#loader').show();
        $('#tableData').hide();
        $('#paginationContainer').hide();

        const formData = $('#searchForm').serialize() + '&per_page=' + $('#perPage').val() + '&page=' + page;

        $.ajax({
            url: "{{ route('requisitions.index') }}",
            data: formData,
            success: function (response) {
                $('#tableData').html(response.html || response.table);
                $('#paginationContainer').html(response.pagination || '');
                $('#tableData').show();
                $('#paginationContainer').show();
                $('#loader').hide();
                
                // Update stats if provided
                if (response.stats) {
                    updateStats(response.stats);
                }
            },
            error: function(xhr) {
                $('#loader').hide();
                $('#tableData').show();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load data. Please try again.'
                });
            }
        });
    }

    // Update stats cards
    function updateStats(stats) {
        console.log('Stats updated:', stats);
    }

    // Export data
    function exportData(format) {
        const formData = $('#searchForm').serialize();
        
        Swal.fire({
            title: 'Exporting Data',
            text: 'Please wait while we prepare your file...',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        let url = "";
        if (format === 'pdf') {
            url = "{{ route('reports.requisitions.pdf') }}";
        } else {
            url = "{{ route('reports.requisitions.excel') }}";
        }
        window.location.href = url + "?" + formData;
        
        setTimeout(() => {
            Swal.close();
        }, 2000);
    }

    // Approve with SweetAlert
    $(document).on('click', '.approveRequest', function () {
        const id = $(this).data('id');
        const reqNumber = $(this).data('req-number');
        
        Swal.fire({
            title: 'Approve Requisition?',
            html: `Are you sure you want to approve requisition <strong>${reqNumber}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-check me-2"></i>Yes, Approve!',
            cancelButtonText: '<i class="fa fa-times me-2"></i>Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 1, reqNumber);
            }
        });
    });

    // Reject with SweetAlert
    $(document).on('click', '.rejectRequest', function () {
        const id = $(this).data('id');
        const reqNumber = $(this).data('req-number');
        
        Swal.fire({
            title: 'Reject Requisition?',
            html: `Are you sure you want to reject requisition <strong>${reqNumber}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-times me-2"></i>Yes, Reject!',
            cancelButtonText: '<i class="fa fa-arrow-left me-2"></i>Cancel',
            reverseButtons: true,
            input: 'textarea',
            inputLabel: 'Rejection Reason (Optional)',
            inputPlaceholder: 'Enter reason for rejection...',
            inputAttributes: {
                'aria-label': 'Enter reason for rejection'
            },
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 2, reqNumber, result.value);
            }
        });
    });

    // Delete with SweetAlert
    $(document).on('click', '.deleteItem', function () {
        const id = $(this).data('id');
        const reqNumber = $(this).data('req-number');
        
        Swal.fire({
            title: 'Delete Requisition?',
            html: `You are about to delete requisition <strong>${reqNumber}</strong>. This action cannot be undone!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash me-2"></i>Yes, Delete!',
            cancelButtonText: '<i class="fa fa-times me-2"></i>Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                deleteRequisition(id, reqNumber);
            }
        });
    });

    // Update status function
    function updateStatus(id, status, reqNumber, reason = null) {
        const statusText = status == 1 ? 'approved' : 'rejected';
        
        $.ajax({
            url: "{{ route('requisitions.updateStatus', '') }}/" + id,
            type: "POST",
            data: {
                id: id,
                status: status,
                reason: reason,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Processing...',
                    text: `Updating requisition ${reqNumber}`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || `Requisition ${reqNumber} has been ${statusText} successfully.`,
                    timer: 2000,
                    showConfirmButton: false
                });
                fetchData();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || `Failed to update requisition ${reqNumber}.`
                });
            }
        });
    }

    // Delete requisition function
    function deleteRequisition(id, reqNumber) {
        const deleteUrl = "{{ route('requisitions.destroy', ':id') }}".replace(':id', id);
        
        $.ajax({
            url: deleteUrl,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Deleting...',
                    text: `Removing requisition ${reqNumber}`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message || `Requisition ${reqNumber} has been deleted successfully.`,
                    timer: 2000,
                    showConfirmButton: false
                });
                fetchData();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || `Failed to delete requisition ${reqNumber}.`
                });
            }
        });
    }
</script>
@endsection
