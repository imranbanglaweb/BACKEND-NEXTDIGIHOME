{{-- @extends('admin.dashboard.layouts.app') --}}
@extends('admin.dashboard.master')
@section('title', 'Create Document')

@section('main_content')
<section role="main" class="content-body">
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">Document Management</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Documents</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
        <!-- /.content-header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Document</h3>
                        <div class="card-tools">
                            <a href="{{ route('documents.index') }}" class="btn btn-sm btn-danger">
                                <i class="fa fa-list"></i> View Document List
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('documents.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                             {{--    <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date">Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                               id="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_name">Project Name<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('project_name') is-invalid @enderror" 
                                                id="project_name" name="project_name" required>
                                            <option value="">Select Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->project_name  }}" {{ old('project_name') == $project->project_name  ? 'selected' : '' }}>
                                                    {{ $project->project_name  }}
                                                </option>
                                            @endforeach
                                            <option value="other">Other</option>
                                        </select>
                                        @error('project_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- Other Project Input (Initially Hidden) -->
                                    <div class="form-group" id="other_project_div" style="display: none;">
                                        <label for="other_project">Other Project Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="other_project" placeholder="Enter new project name">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="land_name">Land Name<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('land_name') is-invalid @enderror" 
                                                id="land_name" name="land_name" required>
                                            <option value="">Select Land</option>
                                            @foreach($lands as $land)
                                                <option value="{{ $land->name }}" {{ old('land_name') == $land->name ? 'selected' : '' }}>
                                                    {{ $land->name }}
                                                </option>
                                            @endforeach
                                            <option value="other">Other</option>
                                        </select>
                                        @error('land_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- Other Land Input (Initially Hidden) -->
                                    <div class="form-group" id="other_land_div" style="display: none;">
                                        <label for="other_land">Other Land Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="other_land" placeholder="Enter new land name">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="document_name">Document Name<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('document_name') is-invalid @enderror" 
                                                id="document_name" name="document_name" required>
                                            <option value="">Select Document</option>
                                            @foreach($documentTypes as $document)
                                                <option value="{{ $document->name }}" {{ old('document_name') == $document->name ? 'selected' : '' }}>
                                                    {{ $document->name }}
                                                </option>
                                            @endforeach
                                            <option value="other">Other</option>
                                        </select>
                                        @error('document_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- Other Document Input (Initially Hidden) -->
                                    <div class="form-group" id="other_document_div" style="display: none;">
                                        <label for="other_document">Other Document Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="other_document" placeholder="Enter new document name">
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="withdrawal_reason">Reason of Document Withdrawn<span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('withdrawal_reason') is-invalid @enderror" 
                                                  id="withdrawal_reason" name="withdrawal_reason" rows="3" 
                                                  placeholder="Enter withdrawal reason">{{ old('withdrawal_reason') }}</textarea>
                                        @error('withdrawal_reason')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="document_taker">Document Taker Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('document_taker') is-invalid @enderror" 
                                               id="document_taker" name="document_taker" value="{{ old('document_taker') }}" 
                                               placeholder="Enter document taker name">
                                        @error('document_taker')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="witness_name">Witness Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('witness_name') is-invalid @enderror" 
                                               id="witness_name" name="witness_name" value="{{ old('witness_name') }}" 
                                               placeholder="Enter witness name">
                                        @error('witness_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="proposed_return_date">Proposed Return Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('proposed_return_date') is-invalid @enderror" 
                                               id="proposed_return_date" name="proposed_return_date" value="{{ old('proposed_return_date') }}">
                                        @error('proposed_return_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="vault_number">Vault Number<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('vault_number') is-invalid @enderror" 
                                               id="vault_number" name="vault_number" value="{{ old('vault_number') }}" 
                                               placeholder="Enter vault number">
                                        @error('vault_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Document
                            </button>
                            <a href="{{ route('documents.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .content {
        margin-left: 0;
        padding: 0 1rem;
    }
    .card {
        margin-bottom: 1rem;
    }
    .card-header {
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .card-title {
        margin-bottom: 0;
        font-size: 1.1rem;
        font-weight: 400;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .invalid-feedback {
        display: none;
        color: red;
        font-size: 80%;
        margin-top: 0.25rem;
    }
    .form-control.is-invalid {
        border-color: #dc3545 !important;
        background-image: none;
    }
    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
    }
    .error-fade {
        animation: fadeInOut 5s ease-in-out;
    }
    @keyframes fadeInOut {
        0% { opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Function to show error message
    function showError(element, message) {
        $(element).addClass('is-invalid');
        let errorDiv = $(element).siblings('.invalid-feedback');
        errorDiv.html(`<strong>${message}</strong>`).fadeIn();

        // Auto hide after 3 seconds
        setTimeout(function() {
            $(element).removeClass('is-invalid');
            errorDiv.fadeOut();
        }, 3000);
    }

    // Function to clear all errors
    function clearErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').fadeOut();
    }

    // Function to validate form
    function validateForm() {
        let isValid = true;
        
        // Clear previous errors
        clearErrors();
        
        // Validate required fields
        $('input[required], textarea[required]').each(function() {
            if (!$(this).val().trim()) {
                showError(this, 'This field is required');
                isValid = false;
            }
        });

        // Validate return date
        let documentDate = new Date($('#date').val());
        let returnDate = new Date($('#proposed_return_date').val());
        
        if ($('#proposed_return_date').val() && returnDate <= documentDate) {
            showError('#proposed_return_date', 'Return date must be after document date');
            isValid = false;
        }

        return isValid;
    }

    // Real-time validation on input
    $('input, textarea').on('input', function() {
        if ($(this).hasClass('is-invalid')) {
            if ($(this).val().trim()) {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').fadeOut();
            }
        }
    });

    // Form submission
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            this.submit();
        } else {
            // Scroll to first error
            let firstError = $('.is-invalid:first');
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
        }
    });

    // Set today's date as default
    $('#date').val(new Date().toISOString().split('T')[0]);

    // Update return date minimum when document date changes
    $('#date').on('change', function() {
        $('#proposed_return_date').attr('min', $(this).val());
    });

    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });

    // Handle "Other" option for Project
    $('#project_name').on('change', function() {
        if ($(this).val() === 'other') {
            $('#other_project_div').show();
            $('#other_project').prop('required', true);
        } else {
            $('#other_project_div').hide();
            $('#other_project').prop('required', false);
        }
    });

    // Handle "Other" option for Land
    $('#land_name').on('change', function() {
        if ($(this).val() === 'other') {
            $('#other_land_div').show();
            $('#other_land').prop('required', true);
        } else {
            $('#other_land_div').hide();
            $('#other_land').prop('required', false);
        }
    });

    // Handle "Other" option for Document
    $('#document_name').on('change', function() {
        if ($(this).val() === 'other') {
            $('#other_document_div').show();
            $('#other_document').prop('required', true);
        } else {
            $('#other_document_div').hide();
            $('#other_document').prop('required', false);
        }
    });

    // Form submission handling
    $('form').on('submit', function() {
        // Update select values if "Other" is chosen
        if ($('#project_name').val() === 'other') {
            $('#project_name').val($('#other_project').val());
        }
        if ($('#land_name').val() === 'other') {
            $('#land_name').val($('#other_land').val());
        }
        if ($('#document_name').val() === 'other') {
            $('#document_name').val($('#other_document').val());
        }
    });
});
</script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@endsection 