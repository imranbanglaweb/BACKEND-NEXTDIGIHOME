<div class="modal-header" style="background-color: brown;">
            <h5 class="modal-title text-white" style="color: #fff">
                <i class="fa fa-edit"></i> Edit Document
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

<form id="editDocumentForm" action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div id="modal-alert-container"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="project_id" class="required">Project Name</label>
                    <select class="form-control select2-searchable @error('project_id') is-invalid @enderror" 
                            id="project_id" name="project_id">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" 
                                {{ $document->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="land_id" class="required">Land Name</label>
                    <select class="form-control select2-searchable @error('land_id') is-invalid @enderror" 
                            id="land_id" name="land_id">
                        <option value="">Select Land</option>
                        @foreach($lands as $land)
                            <option value="{{ $land->id }}" 
                                {{ $document->land_id == $land->id ? 'selected' : '' }}>
                                {{ $land->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="document_id" class="required">Document Type</label>
                    <select class="form-control select2-searchable @error('document_id') is-invalid @enderror" 
                            id="document_id" name="document_id">
                        <option value="">Select Document Type</option>
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}" 
                                {{ $document->document_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="document_taker">Document Taker<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('document_taker') is-invalid @enderror" 
                           id="document_taker" name="document_taker" 
                           value="{{ old('document_taker', $document->document_taker) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="witness_name">Witness Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('witness_name') is-invalid @enderror" 
                           id="witness_name" name="witness_name" 
                           value="{{ old('witness_name', $document->witness_name) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="vault_number">Vault Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('vault_number') is-invalid @enderror" 
                           id="vault_number" name="vault_number" 
                           value="{{ old('vault_number', $document->vault_number) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="vault_location">Vault Location<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('vault_location') is-invalid @enderror" 
                           id="vault_location" name="vault_location" 
                           value="{{ old('vault_location', $document->vault_location) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="proposed_return_date">Proposed Return Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('proposed_return_date') is-invalid @enderror" 
                           id="proposed_return_date" name="proposed_return_date" 
                           value="{{ old('proposed_return_date', $document->proposed_return_date->format('Y-m-d')) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            @if($document->status === 'withdrawn')
            <div class="col-md-6">
                <div class="form-group">
                    <label for="actual_return_date">Actual Return Date</label>
                    <input type="date" class="form-control @error('actual_return_date') is-invalid @enderror" 
                           id="actual_return_date" name="actual_return_date">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="returner_name">Returner Name</label>
                    <input type="text" class="form-control @error('returner_name') is-invalid @enderror" 
                           id="returner_name" name="returner_name">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="return_witness">Return Witness</label>
                    <input type="text" class="form-control @error('return_witness') is-invalid @enderror" 
                           id="return_witness" name="return_witness">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            @endif

            <div class="col-md-12">
                <div class="form-group">
                    <label for="withdrawal_reason">Withdrawal Reason<span class="text-danger">*</span></label>
                    <textarea class="form-control tinymce @error('withdrawal_reason') is-invalid @enderror" 
                              id="withdrawal_reason" name="withdrawal_reason">{{ old('withdrawal_reason', $document->withdrawal_reason) }}</textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                     <label for="document_scan" class="required">
                   Document File
                   </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="document_scan" name="document_scan">
                                <label class="custom-file-label" for="document_scan">Choose file</label>
                            </div>
                    <small class="text-muted">Allowed files: PDF, JPG, JPEG, PNG (max 2MB)</small>
                    @if($document->document_scan)
                        <div class="mt-2">
                            <a href="{{ $document->document_scan_url }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fa fa-file"></i> View Current Document
                            </a>
                        </div>
                    @endif
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Update Document
        </button>
    </div>
</form>

<style>
.select2-container .select2-selection--single {
    height: 38px;
    line-height: 38px;
}

.select2-container--bootstrap4 .select2-selection--single.is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: block;
}

.required:after {
    content: " *";
    color: #dc3545;
}
</style>


<script>
$(document).ready(function() {
    const form = $('#editDocumentForm');
    
    // Initialize Select2
    $('.select2-searchable').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Select an option'
    });

    // Initialize validation
    form.validate({
        ignore: '', // Don't ignore hidden inputs
        rules: {
            project_id: {
                required: true
            },
            land_id: {
                required: true
            },
            document_id: {
                required: true
            },
            document_taker: {
                required: true,
                minlength: 3
            },
            witness_name: {
                required: true
            },
            withdrawal_reason: {
                required: true
            },
            vault_number: {
                required: true
            },
            vault_location: {
                required: true
            },
            proposed_return_date: {
                required: true
            },
            //  document_scan: {
            //     required: true,
            //     extension: "pdf|doc|jpg|jpeg|png|docx|xls|xlsx",
            //     filesize: 8242880 // 8MB in bytes
            // }
        },
        messages: {
            project_id: "Please select a project",
            land_id: "Please select a land",
            document_id: "Please select a document type",
            document_taker: {
                required: "Please enter document taker name",
                minlength: "Name must be at least 3 characters"
            },
            witness_name: "Please enter witness name",
            withdrawal_reason: "Please enter withdrawal reason",
            vault_number: "Please enter vault number",
            vault_location: "Please enter vault location",
            proposed_return_date: "Please select proposed return date",
            // document_scan: {
            //     extension: "Allowed file types: PDF, JPG, JPEG, PNG",
            //     filesize: "File size must be less than 2MB"
            // }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            if ($(element).hasClass('select2-searchable')) {
                $(element).next('.select2-container').find('.select2-selection').addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
            if ($(element).hasClass('select2-searchable')) {
                $(element).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-searchable')) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Handle form submission
    form.on('submit', function(e) {
        e.preventDefault();
        
        if (form.valid()) {
            submitEditForm($(this));
        }
    });

    // Handle Select2 validation on change
    $('.select2-searchable').on('change', function() {
        $(this).valid();
    });

    // Custom file input handler
    $(".custom-file-input").on("change", function() {
        let fileName = $(this).val().split("\\").pop();
        $(this).next(".custom-file-label").addClass("selected").html(fileName);
    });
});

if (typeof $.validator !== 'undefined') {
    $.validator.addMethod("filesize", function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, "File size must be less than {0}");
}

function submitEditForm($form) {
    const submitBtn = $form.find('button[type="submit"]');
    const originalText = submitBtn.html();
    
    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: new FormData($form[0]),
        processData: false,
        contentType: false,
        beforeSend: function() {
            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 1500
                }).then(() => {
                    $('#editDocumentModal').modal('hide');
                    location.reload();
                });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(field => {
                    const element = $form.find(`[name="${field}"]`);
                    element.addClass('is-invalid');
                    if (element.hasClass('select2-searchable')) {
                        element.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    }
                    element.next('.invalid-feedback').html(errors[field][0]);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while updating the document'
                });
            }
        },
        complete: function() {
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
}
</script>
