@extends('admin.dashboard.master')
@section('title', 'Edit Document')

@section('main_content')
<section role="main" class="content-body">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">Edit Document</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Documents</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Document</h3>
                        <div class="card-tools">
                            <a href="{{ route('documents.index') }}" class="btn btn-sm btn-danger">
                                <i class="fa fa-list"></i> View Document List
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('documents.update', $document->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_name">Project Name<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('project_name') is-invalid @enderror" 
                                                id="project_name" name="project_name" required>
                                            <option value="">Select Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->project_name }}" 
                                                    {{ old('project_name', $document->project_name) == $project->project_name ? 'selected' : '' }}>
                                                    {{ $project->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('project_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="land_name">Land Name<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('land_name') is-invalid @enderror" 
                                                id="land_name" name="land_name" required>
                                            <option value="">Select Land</option>
                                            @foreach($lands as $land)
                                                <option value="{{ $land->name }}" 
                                                    {{ old('land_name', $document->land_name) == $land->name ? 'selected' : '' }}>
                                                    {{ $land->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('land_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="document_name">Document Name<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('document_name') is-invalid @enderror" 
                                                id="document_name" name="document_name" required>
                                            <option value="">Select Document</option>
                                            @foreach($documentTypes as $document_type)
                                                <option value="{{ $document_type->name }}" 
                                                    {{ old('document_name', $document->document_name) == $document_type->name ? 'selected' : '' }}>
                                                    {{ $document_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('document_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="withdrawal_reason">Reason of Document Withdrawn<span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('withdrawal_reason') is-invalid @enderror" 
                                                  id="withdrawal_reason" name="withdrawal_reason" rows="3" 
                                                  required>{{ old('withdrawal_reason', $document->withdrawal_reason) }}</textarea>
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
                                               id="document_taker" name="document_taker" 
                                               value="{{ old('document_taker', $document->document_taker) }}" required>
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
                                               id="witness_name" name="witness_name" 
                                               value="{{ old('witness_name', $document->witness_name) }}" required>
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
                                               id="proposed_return_date" name="proposed_return_date" 
                                               value="{{ old('proposed_return_date', $document->proposed_return_date->format('Y-m-d')) }}" required>
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
                                               id="vault_number" name="vault_number" 
                                               value="{{ old('vault_number', $document->vault_number) }}" required>
                                        @error('vault_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                @if($document->status === 'withdrawn')
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="actual_return_date">Actual Return Date</label>
                                        <input type="date" class="form-control @error('actual_return_date') is-invalid @enderror" 
                                               id="actual_return_date" name="actual_return_date" 
                                               value="{{ old('actual_return_date') }}">
                                        @error('actual_return_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="returner_name">Returner Name</label>
                                        <input type="text" class="form-control @error('returner_name') is-invalid @enderror" 
                                               id="returner_name" name="returner_name" 
                                               value="{{ old('returner_name') }}">
                                        @error('returner_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Document
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
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .card-footer {
        background: none;
    }
    .invalid-feedback {
        display: block;
    }
</style>
@endpush

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });

    // Date validation
    $('#actual_return_date').change(function() {
        var proposedDate = new Date($('#proposed_return_date').val());
        var actualDate = new Date($(this).val());
        
        if (actualDate < proposedDate) {
            alert('Actual return date cannot be earlier than proposed return date');
            $(this).val('');
        }
    });
});
</script>
@endpush
@endsection 