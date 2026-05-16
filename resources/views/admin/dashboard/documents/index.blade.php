@extends('admin.dashboard.master')
@section('title', 'Documents')

@section('main_content')
<div class="content-header content-body">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Documents</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Documents</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
   <section role="main" class="content-body">
        <div class="row">
            <div class="col-12">
                <!-- Search Panel -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Search Documents</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="searchForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Project</label>
                                        <select class="form-control select2" name="project_name" id="search_project">
                                            <option value="">All Projects</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->project_name }}">{{ $project->project_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Land</label>
                                        <select class="form-control select2" name="land_name" id="search_land">
                                            <option value="">All Lands</option>
                                            @foreach($lands as $land)
                                                <option value="{{ $land->name }}">{{ $land->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Document Type</label>
                                        <select class="form-control select2" name="document_name" id="search_document">
                                            <option value="">All Types</option>
                                            @foreach($documentTypes as $type)
                                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="search_status">
                                            <option value="">All Status</option>
                                            <option value="withdrawn">Withdrawn</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Range</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="date_from" id="search_date_from">
                                            <div class="input-group-append">
                                                <span class="input-group-text">to</span>
                                            </div>
                                            <input type="date" class="form-control" name="date_to" id="search_date_to">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Document Taker</label>
                                        <input type="text" class="form-control" name="document_taker" id="search_taker" placeholder="Search by taker name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Returner Name</label>
                                        <input type="text" class="form-control" name="returner_name" id="search_returner" placeholder="Search by returner name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <button type="button" class="btn btn-default" onclick="resetSearch()">
                                                <i class="fa fa-undo"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Document List</h3>
                        <div class="card-tools">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-download"></i> Export
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" onclick="exportDocuments('excel')">
                                        <i class="fa fa-file-o text-success mr-2"></i>Excel
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="exportDocuments('pdf')">
                                        <i class="fa fa-file-pdf-o text-danger mr-2"></i>PDF
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="exportDocuments('csv')">
                                        <i class="fa fa-file-text-o text-primary mr-2"></i>CSV
                                    </a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="createDocument()">
                                <i class="fa fa-plus"></i> Add New Document
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <div id="alert-container"></div>
                        <div class="table-responsive">
                            <table id="documentsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Project Name</th>
                                        <th>Land Name</th>
                                        <th>Document Name</th>
                                        <th>Document Taker</th>
                                        {{-- <th>Return Date</th> --}}
                                        {{-- <th>Status</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('admin.dashboard.documents.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single {
    height: 38px;
    line-height: 38px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        width: '100%'
    });

    // Handle search form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        searchDocuments();
    });
});

function searchDocuments() {
    $.ajax({
        url: "{{ route('documents.index') }}",
        type: 'GET',
        data: $('#searchForm').serialize(),
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#documentsTable tbody').html(response.view);
            } else {
                showAlert('error', 'Error loading documents');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function resetSearch() {
    $('#searchForm')[0].reset();
    $('.select2').val('').trigger('change');
    searchDocuments();
}

// Show/Hide Loading
function toggleLoading(show = true) {
    $('.loading-overlay')[show ? 'fadeIn' : 'fadeOut'](300);
}

// Show Alert with SweetAlert2
function showAlert(type, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: type === 'success' ? 'success' : 'error',
        title: message
    });
}

// View Document
function viewDocument(id) {
    $.ajax({
        url: "{{ url('documents') }}/" + id,
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#documentModal .modal-content').html(response.view);
                $('#documentModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading document details');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading document details: ' + error);
            console.error('AJAX Error:', error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

// Edit Document
function editDocument(id) {
    $.ajax({
        url: "{{ url('documents') }}/" + id + "/edit",
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#documentModal .modal-content').html(response.view);
                $('#documentModal').modal('show');
                
                // Initialize Select2 after modal is shown
                $('#documentModal').on('shown.bs.modal', function() {
                    $('.select2').select2({
                        dropdownParent: $('#documentModal')
                    });
                });
            } else {
                showAlert('error', response.message || 'Error loading edit form');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading edit form: ' + error);
            console.error('AJAX Error:', error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

// Delete Document with SweetAlert2 confirmation
function deleteDocument(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('documents') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    toggleLoading(true);
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $(`#document-${id}`).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        showAlert('error', response.message || 'Error deleting document');
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('error', 'Error deleting document: ' + error);
                    console.error('AJAX Error:', error);
                },
                complete: function() {
                    toggleLoading(false);
                }
            });
        }
    });
}

// Create Document with SweetAlert2 success message
function createDocument() {
    $.ajax({
        url: "{{ route('documents.create') }}",
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#documentModal .modal-content').html(response.view);
                $('#documentModal').modal('show');
                
                // Initialize Select2
                $('#documentModal').on('shown.bs.modal', function() {
                    $('.select2').select2({
                        dropdownParent: $('#documentModal')
                    });
                });
            } else {
                showAlert('error', response.message || 'Error loading form');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading form: ' + error);
            console.error('AJAX Error:', error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

// Form submission success handler
function handleFormSuccess(response) {
    if (response.success) {
        $('#documentModal').modal('hide');
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response.message,
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.reload();
        });
    } else {
        showAlert('error', response.message || 'Error occurred');
    }
}

// Export Documents
function exportDocuments(type) {
    Swal.fire({
        title: 'Exporting Documents',
        text: 'Please wait while we prepare your file...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "{{ route('documents.export') }}",
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            type: type
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response, status, xhr) {
            const contentType = xhr.getResponseHeader('content-type');
            const filename = type.toUpperCase() + '_Documents_' + new Date().toISOString().slice(0,10) + '.' + type;
            
            // Create blob and download
            const blob = new Blob([response], { type: contentType });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            Swal.fire({
                icon: 'success',
                title: 'Export Successful!',
                text: `Your ${type.toUpperCase()} file has been downloaded.`,
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: 'An error occurred while exporting the documents.'
            });
            console.error('Export Error:', error);
        }
    });
}

function returnDocument(id) {
    Swal.fire({
        title: 'Return Document',
        html:
            '<div class="form-group">' +
            '<label>Returner Name</label>' +
            '<input type="text" id="returner_name" class="form-control" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>Return Witness</label>' +
            '<input type="text" id="return_witness" class="form-control" required>' +
            '</div>',
        showCancelButton: true,
        confirmButtonText: 'Return',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const returnerName = document.getElementById('returner_name').value;
            const returnWitness = document.getElementById('return_witness').value;
            
            if (!returnerName || !returnWitness) {
                Swal.showValidationMessage('Please fill in all fields');
                return false;
            }
            
            return {
                returner_name: returnerName,
                return_witness: returnWitness
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('documents') }}/${id}/return`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ...result.value
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while returning the document'
                    });
                }
            });
        }
    });
}

function viewHistory(id) {
    $.ajax({
        url: `{{ url('documents') }}/${id}/history`,
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#documentModal .modal-content').html(response.view);
                $('#documentModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading history');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading history: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}
</script>
@endpush
@endsection 