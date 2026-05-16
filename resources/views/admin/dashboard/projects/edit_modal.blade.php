<div class="modal-header">
    <h5 class="modal-title">Edit Project</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form action="{{ route('projects.update', $project->id) }}" method="POST" class="ajax-form">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div id="modal-alert-container"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="project_name">Project Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('project_name') is-invalid @enderror" 
                           id="project_name" name="project_name" value="{{ old('project_name', $project->project_name) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="project_description">Description</label>
                    <textarea class="form-control summernote @error('project_description') is-invalid @enderror" 
                              id="project_description" name="project_description">{{ old('project_description', $project->project_description) }}</textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="status">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="on-hold" {{ old('status', $project->status) === 'on-hold' ? 'selected' : '' }}>On Hold</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Update Project
        </button>
    </div>
</form>

<script>
$(function() {
    // Initialize form validation
    $('.ajax-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        clearFormErrors(form);
        
        // Validate required fields
        var isValid = true;
        
        // Validate Project Name
        if (!$('#project_name').val()) {
            isValid = false;
            $('#project_name').addClass('is-invalid');
            $('#project_name').siblings('.invalid-feedback').html('Project name is required');
        }

        // Validate Status
        if (!$('#status').val()) {
            isValid = false;
            $('#status').addClass('is-invalid');
            $('#status').siblings('.invalid-feedback').html('Please select a status');
        }

        if (!isValid) {
            showModalAlert('error', 'Please correct the errors below.');
            return false;
        }

        // Submit form if validation passes
        submitForm(form);
    });

    // Clear validation on input change
    $('.ajax-form').find('input, select, textarea').on('change', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').html('');
        $('#modal-alert-container').empty();
    });
});
</script> 