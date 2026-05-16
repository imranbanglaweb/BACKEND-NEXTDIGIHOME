@extends('admin.dashboard.master')

@section('main_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    body {
        background: #f5f7fa !important;
    }

    .premium-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .premium-header {
        background: var(--primary-gradient);
        padding: 25px 30px;
        color: #fff;
    }

    .premium-header h3 {
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-card {
        border-radius: 12px;
        padding: 20px 25px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .stat-card.bg-primary { background: var(--primary-gradient); }
    .stat-card.bg-success { background: var(--success-gradient); }
    .stat-card.bg-warning { background: var(--warning-gradient); }
    .stat-card.bg-danger { background: var(--danger-gradient); }

    .stat-card .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
    }

    .stat-card .stat-label {
        font-size: 0.95rem;
        opacity: 0.95;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        opacity: 0.3;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1.4rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
    }

    .premium-table {
        border-radius: 12px;
        overflow: hidden;
    }

    .premium-table thead th {
        background: #1e1e2f;
        color: #fff;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 1.2rem;
        letter-spacing: 0.5px;
        border: none;
    }

    .premium-table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f0f0f0;
        font-size: 1.4rem;
    }

    .premium-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-sent { background: linear-gradient(135deg, #11998e, #38ef7d); color: #fff; }
    .status-failed { background: linear-gradient(135deg, #eb3349, #f45c43); color: #fff; }
    .status-pending { background: linear-gradient(135deg, #f093fb, #f5576c); color: #fff; }

    .failed-reason {
        font-size: 1.2rem;
        color: #dc3545;
        margin-top: 5px;
        font-style: italic;
    }

    .btn-view {
        background: var(--info-gradient);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 15px;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        color: #fff;
    }

    .btn-delete {
        background: var(--danger-gradient);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 15px;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(235, 51, 73, 0.4);
        color: #fff;
    }

    /* Preloader Styles */
    .preloader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .preloader-overlay.active {
        display: flex;
    }

    .preloader-content {
        text-align: center;
    }

    .preloader-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
    }

    .preloader-text {
        font-size: 1.4rem;
        color: #667eea;
        font-weight: 600;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .table-responsive {
        position: relative;
        min-height: 300px;
    }

    .table-loading {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }

    .table-loading.active {
        display: flex;
    }
</style>

<section role="main" class="content-body">
    <!-- Preloader Overlay -->
    <div class="preloader-overlay" id="globalPreloader">
        <div class="preloader-content">
            <div class="preloader-spinner"></div>
            <div class="preloader-text">Loading...</div>
        </div>
    </div>

    <div class="container-fluid p-4">
        <div class="premium-card">
            <div class="premium-header d-flex justify-content-between align-items-center">
                <div>
                    <h3><i class="fa fa-envelope me-2"></i> Email Log History</h3>
                    <p style="opacity: 0.8; margin: 5px 0 0 0; font-size: 1.3rem;">Monitor and track all email notifications</p>
                </div>
                <a href="{{ route('emaillogs.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-sync-alt me-1"></i> Refresh
                </a>
            </div>
<br>
            <div class="card-body p-4">
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card bg-primary">
                            <div class="stat-value">{{ $stats['total'] }}</div>
                            <div class="stat-label">Total Emails</div>
                            <i class="fa fa-envelope stat-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-success">
                            <div class="stat-value">{{ $stats['sent'] }}</div>
                            <div class="stat-label">Sent Successfully</div>
                            <i class="fa fa-check-circle stat-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-warning">
                            <div class="stat-value">{{ $stats['pending'] }}</div>
                            <div class="stat-label">Pending</div>
                            <i class="fa fa-clock stat-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-danger">
                            <div class="stat-value">{{ $stats['failed'] }}</div>
                            <div class="stat-label">Failed</div>
                            <i class="fa fa-times-circle stat-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filter-section">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="Sent" {{ request('status') == 'Sent' ? 'selected' : '' }}>Sent</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Failed" {{ request('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Recipient Email</label>
                            <input type="text" name="recipient" class="form-control" 
                                   placeholder="Search by email..." id="recipientFilter"
                                   value="{{ request('recipient') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" id="fromDateFilter"
                                   value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" id="toDateFilter"
                                   value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100" id="filterBtn">
                                <i class="fa fa-search me-1"></i> Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Email Logs Table -->
                <div class="table-responsive">
                    <div class="table-loading" id="tableLoader">
                        <div class="preloader-content">
                            <div class="preloader-spinner"></div>
                            <div class="preloader-text">Loading data...</div>
                        </div>
                    </div>
                    <table class="table premium-table">
                        <thead>
                            <tr>
                                <th width="5%"><i class="fa fa-hashtag me-1"></i> ID</th>
                                <th width="15%"><i class="fa fa-link me-1"></i> Requisition</th>
                                <th width="20%"><i class="fa fa-user me-1"></i> Recipient</th>
                                <th width="20%"><i class="fa fa-heading me-1"></i> Subject</th>
                                <th width="12%"><i class="fa fa-info-circle me-1"></i> Status</th>
                                <th width="15%"><i class="fa fa-calendar me-1"></i> Date</th>
                                <th width="13%"><i class="fa fa-cogs me-1"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody id="emailLogsTable">
                            @forelse($emaillogs as $log)
                                <tr>
                                    <td><strong>#{{ $log->id }}</strong></td>
                                    <td>
                                        @if($log->requisition)
                                            <a href="{{ route('requisitions.show', $log->requisition->id) }}" class="text-decoration-none">
                                                <i class="fa fa-external-link-alt me-1 text-muted"></i>
                                                {{ $log->requisition->requisition_number }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fa fa-envelope text-muted me-1"></i>
                                        {{ $log->recipient_email }}
                                    </td>
                                    <td title="{{ $log->subject }}">
                                        {{ Str::limit($log->subject, 35) }}
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($log->status) {
                                                'Sent' => 'status-sent',
                                                'Failed' => 'status-failed',
                                                'Pending' => 'status-pending',
                                                default => 'status-pending'
                                            };
                                            $statusIcon = match($log->status) {
                                                'Sent' => 'fa-check',
                                                'Failed' => 'fa-times',
                                                'Pending' => 'fa-clock',
                                                default => 'fa-question'
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            <i class="fa {{ $statusIcon }}"></i>
                                            {{ $log->status }}
                                        </span>
                                        @if($log->status === 'Failed' && $log->error_message)
                                            <div class="failed-reason">
                                                <i class="fa fa-exclamation-triangle me-1"></i>
                                                {{ $log->error_message }}
                                            </div>
                                        @elseif($log->status === 'Failed')
                                            <div class="failed-reason">
                                                <i class="fa fa-exclamation-triangle me-1"></i>
                                                Delivery failed - Unknown error
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $log->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('emaillogs.show', $log->id) }}" 
                                           class="btn btn-view" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-delete"
                                                data-id="{{ $log->id }}"
                                                title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa fa-inbox fa-4x mb-3 text-secondary" style="opacity: 0.3;"></i>
                                            <p class="mb-0" style="font-size: 1.5rem;">No email logs found</p>
                                            <small>Try adjusting your filters</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted" style="font-size: 1.3rem;">
                        Showing {{ $emaillogs->firstItem() ?? 0 }} to {{ $emaillogs->lastItem() ?? 0 }} 
                        of {{ $emaillogs->total() }} entries
                    </div>
                    <div>
                        {{ $emaillogs->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    // Show preloader on filter form submit
    $('#filterForm').on('submit', function(e) {
        if ($(window).width() > 768) {
            $('#tableLoader').addClass('active');
        }
    });

    // Clear filters
    $('#filterBtn').on('click', function(e) {
        // Let the form submit naturally for server-side filtering
    });

    // Auto-submit on filter change
    $('#statusFilter, #recipientFilter, #fromDateFilter, #toDateFilter').on('change', function() {
        $('#filterForm').submit();
    });

    // Hide preloader after page load
    $(window).on('load', function() {
        $('#tableLoader').removeClass('active');
    });

    // Fallback to hide preloader after 2 seconds
    setTimeout(function() {
        $('#tableLoader').removeClass('active');
    }, 2000);

    // Delete email log with confirmation
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#eb3349',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '{{ url("/emaillogs/") }}/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Email log has been deleted.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload the page to refresh the table
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection
