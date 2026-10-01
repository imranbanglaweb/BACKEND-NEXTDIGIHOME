@extends('admin.dashboard.master')
@section('title', 'Create Project')

@section('main_content')
<section role="main" class="content-body">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">Create Project</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Project</h3>
                    <div class="card-tools">
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-list"></i> View List
                        </a>
                    </div>
                </div>

                <form action="{{ route('projects.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_name">Project Name<span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('project_name') is-invalid @enderror"
                                           id="project_name" 
                                           name="project_name" 
                                           value="{{ old('project_name') }}"
                                           required>
                                    @error('project_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status<span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="starting_date">Start Date</label>
                                    <input type="date" 
                                           class="form-control @error('starting_date') is-invalid @enderror"
                                           id="starting_date" 
                                           name="starting_date" 
                                           value="{{ old('starting_date') }}">
                                    @error('starting_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ending_date">End Date</label>
                                    <input type="date" 
                                           class="form-control @error('ending_date') is-invalid @enderror"
                                           id="ending_date" 
                                           name="ending_date" 
                                           value="{{ old('ending_date') }}">
                                    @error('ending_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project_description">Description</label>
                                    <textarea class="form-control @error('project_description') is-invalid @enderror"
                                              id="project_description" 
                                              name="project_description" 
                                              rows="3">{{ old('project_description') }}</textarea>
                                    @error('project_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('projects.index') }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-footer {
        background: none;
    }
    .invalid-feedback {
        display: block;
    }
</style>
@endpush

@push('scripts')
<script>
    // Date validation
    $('#ending_date').change(function() {
        var startDate = $('#starting_date').val();
        var endDate = $(this).val();
        
        if (startDate && endDate && startDate > endDate) {
            alert('End date should be greater than start date');
            $(this).val('');
        }
    });

    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush 