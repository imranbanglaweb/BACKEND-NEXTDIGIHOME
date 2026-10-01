<div class="modal-header">
    <h5 class="modal-title">Create New Project</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form action="{{ route('projects.store') }}" method="POST" class="ajax-form">
    @csrf
    <div class="modal-body">
        <div id="modal-alert-container"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="project_name">Project Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('project_name') is-invalid @enderror" 
                           id="project_name" name="project_name" value="{{ old('project_name') }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

  {{--           <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Start Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                           id="start_date" name="start_date" value="{{ old('start_date') }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                           id="end_date" name="end_date" value="{{ old('end_date') }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control summernote @error('description') is-invalid @enderror" 
                              id="description" name="description">{{ old('description') }}</textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="status">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        {{-- <option value="">Select Status</option> --}}
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="on-hold" {{ old('status') === 'on-hold' ? 'selected' : '' }}>On Hold</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Save Project
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

        // Validate Start Date
        // if (!$('#start_date').val()) {
        //     isValid = false;
        //     $('#start_date').addClass('is-invalid');
        //     $('#start_date').siblings('.invalid-feedback').html('Start date is required');
        // }

        // // Validate End Date (if provided)
        // if ($('#end_date').val() && $('#start_date').val()) {
        //     if ($('#end_date').val() < $('#start_date').val()) {
        //         isValid = false;
        //         $('#end_date').addClass('is-invalid');
        //         $('#end_date').siblings('.invalid-feedback').html('End date must be after start date');
        //     }
        // }

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

function submitForm(form) {
    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: form.serialize(),
        beforeSend: function() {
            toggleLoading(true);
            form.find('button[type="submit"]').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                $('#projectModal').modal('hide');
                showAlert('success', response.message);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            } else {
                showModalAlert('error', response.message || 'Error occurred');
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                showFormErrors(form, xhr.responseJSON.errors);
                showModalAlert('error', 'Please correct the errors below.');
            } else {
                showModalAlert('error', 'An error occurred while processing your request.');
            }
        },
        complete: function() {
            toggleLoading(false);
            form.find('button[type="submit"]').prop('disabled', false);
        }
    });
}
</script> 