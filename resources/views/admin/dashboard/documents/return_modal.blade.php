<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="background-color: brown;">
            <h5 class="modal-title text-white" style="color: #fff">
                <i class="fa fa-undo"></i> Return Document
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form id="returnDocumentForm" action="{{ route('documents.return', ['id' => $document->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <!-- Preloader -->
                <div id="preloader" style="display: none;">
                    <div class="d-flex justify-content-center align-items-center" style="height: 100px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="ml-3">Submitting your request, please wait...</span>
                    </div>
                </div>
                <!-- Document Summary Card -->
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #17a2b8;">
                        <h6 class="mb-0 text-white"><i class="fa fa-info-circle"></i> Document Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-details">
                                    <tr>
                                        <th width="40%">Project</th>
                                        <td><span class="badge badge-info">{{ $project->project_name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Land</th>
                                        <td><span class="badge badge-secondary">{{ $land->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Document Type</th>
                                        <td><span class="badge badge-primary">{{ $documentType->name ?? 'N/A' }}</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-details">
                                    <tr>
                                        <th width="40%">Withdrawn By</th>
                                        <td>{{ $document->document_taker }}</td>
                                    </tr>
                                    <tr>
                                        <th>Withdrawal Date</th>
                                        <td>{{ $document->created_at->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Expected Return</th>
                                        <td>{{ $document->proposed_return_date->format('d M Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Return Details Card -->
                <div class="card">
                    <div class="card-header" style="background-color: #28a745;">
                        <h6 class="mb-0 text-white"><i class="fa fa-clipboard-check"></i> Return Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="returner_name" class="required">Name of the person returning the document </label>
                                    <input type="text" class="form-control" id="returner_name" name="returner_name" 
                                           placeholder="Enter name of person returning document">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                  <div class="form-group">
                            <label for="document_type_id" class="required">Document Type</label>
                            <select class="form-control select2-searchable" id="document_id" name="document_id">
                                <option value="">Select Document Type</option>
                                @foreach($document_lists as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="return_witness" class="required">Return Witness</label>
                                    <input type="text" class="form-control" id="return_witness" name="return_witness" 
                                           placeholder="Enter witness name">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="submitter_name" class="required">Name of the Submission of the document </label>
                                    <input type="text" class="form-control" id="submitter_name" name="submitter_name" 
                                           placeholder="Enter Submitter name">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fa fa-upload"></i> Signature Upload</h6>
                                </div>
                                <div class="form-group">
                                    <label for="submitter_signature" class="required">Signature of the person present at the time of submission of the document </label>
                                    <input type="file" class="custom-file-input" id="submitter_signature" name="submitter_signature">
                                    <label class="custom-file-label" for="submitter_signature">Choose file</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-3d">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fa fa-upload"></i> Return Document Upload</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="returned_documents" class="required">Document File</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="document_scan" name="returned_documents">
                                        <label class="custom-file-label" for="document_scan">Choose file</label>
                                        <small class="form-text text-muted">
                                            Allowed files: PDF, DOC, DOCX, XLS, XLSX (Max size: 5MB)
                                        </small>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="background-color: #f8f9fa;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Confirm Return
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.modal-content {
    border: none;
    border-radius: 0.3rem;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 1rem;
    border-radius: 0.25rem;
}

.card-header {
    border-bottom: none;
    border-radius: 0.25rem 0.25rem 0 0 !important;
}

.table-details {
    margin-bottom: 0;
}

.table-details th {
    background-color: rgba(0, 0, 0, 0.03);
    font-weight: 600;
    border-top: none;
    width: 40%;
}

.table-details td {
    border-top: none;
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}

.form-control {
    border-radius: 0.25rem;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.required:after {
    content: " *";
    color: #000;
}

.btn {
    padding: 0.375rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.invalid-feedback {
    display: block;
    margin-top: 0.25rem;
}

/* Animation */
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    const form = $('#returnDocumentForm');
    
    // Initialize Select2 with proper configuration
    $('.select2-searchable').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true,
        minimumResultsForSearch: 10,
    }).on('select2:open', function() {
        // Fix dropdown positioning if needed
        setTimeout(function() {
            $('.select2-search__field').focus();
        }, 10);
    });

    // Initialize validation
    form.validate({
        ignore: [], // Don't ignore hidden Select2 inputs
        rules: {
            returner_name: "required",
            document_id: "required",
            submitter_name: "required",
            returned_documents: {
                required: true,
                extension: "pdf|doc|jpg|jpeg|png|docx|xls|xlsx",
                filesize: 8242880 // 8MB in bytes
            }
        },
        messages: {
            returner_name: "Please enter returner name",
            document_id: "Please Select Document Name",
            return_witness: "Please enter witness name",
            submitter_name: "Please enter Submitter Name",
            returned_documents: {
                required: "Please upload a document file",
                extension: "Allowed file types: PDF, jpg, jpeg, png, DOC, DOCX, XLS, XLSX",
                filesize: "File size must be less than 8MB"
            }
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        validClass: 'valid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            if ($(element).hasClass('select2-searchable')) {
                $(element).next('.select2-container')
                    .find('.select2-selection')
                    .addClass('is-invalid')
                    .removeClass('is-valid');
            }
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
            if ($(element).hasClass('select2-searchable')) {
                $(element).next('.select2-container')
                    .find('.select2-selection')
                    .removeClass('is-invalid')
                    .addClass('is-valid');
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-searchable')) {
                error.addClass('d-block');
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.addClass('d-block');
                error.insertAfter(element);
            }
        }
    });

    // Handle form submission
    form.on('submit', function(e) {
        e.preventDefault();
        
        if (form.valid()) {
            submitForm($(this));
        }
    });

    // Move the modal hide handler inside document ready
    $('#returnDocumentModal').on('hidden.bs.modal', function() {
        const form = $('#documentForm'); // Get form reference again
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.is-valid').removeClass('is-valid');
        form.find('.invalid-feedback').empty(); // Use empty() instead of remove()
        $('.select2-selection').removeClass('is-invalid is-valid');
        form[0].reset();
        $('.select2-searchable').val('').trigger('change'); // Reset Select2
    });

    // Move Select2 change handler inside document ready
    $('.select2-searchable').on('change', function() {
        $(this).valid();
        $(this).next('.select2-container').removeClass('is-invalid');
        $(this).next('.select2-container').next('.error').remove();
    });

    // Custom file input handler
    $(".custom-file-input").on("change", function() {
        let fileName = $(this).val().split("\\").pop();
        // alert(fileName);
        $(this).next(".custom-file-label").addClass("selected").html(fileName);
    });
});

// Keep submitForm function outside document ready
function submitForm($form) {
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
                    $('#returnDocumentModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'An error occurred'
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
                    text: 'An error occurred while saving the document'
                });
            }
        },
        complete: function() {
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
}

if (typeof $.validator !== 'undefined') {
    $.validator.addMethod("filesize", function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, "File size must be less than {0}");
}
</script>

{{-- 
<script type="text/javascript">
$(document).ready(function() {
    const form = $('#returnDocumentForm');
    
    // Initialize validation
    form.validate({
        rules: {
            returner_name: "required",
            document_id: "required",
            submitter_name: "required",
            returned_documents: {
                required: true,
                extension: "pdf|doc|jpg|jpeg|png|docx|xls|xlsx",
                filesize: 8242880 // 8MB in bytes
            }
        },
        messages: {
            returner_name: "Please enter returner name",
            document_id: "Please Select Document Name",
            return_witness: "Please enter witness name",
            submitter_name: "Please enter Submitter Name",
            returned_documents: {
                required: "Please upload a document file",
                extension: "Allowed file types: PDF, jpg, jpeg, png, DOC, DOCX, XLS, XLSX",
                filesize: "File size must be less than 8MB"
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.addClass('d-block');
            error.insertAfter(element);
        }
    });

    // Handle form submission
    form.on('submit', function(e) {
        e.preventDefault();
        if (form.valid()) {
            $('#preloader').show();
            const formData = new FormData(this);
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#preloader').hide();
                    if (response.success) {
                        alert('Document returned successfully');
                        $('#return_modal').modal('hide');
                        // Optionally, refresh the document list
                    } else {
                        alert('An error occurred: ' + response.message);
                    }
                },
                error: function(xhr) {
                    $('#preloader').hide();
                    alert('An error occurred while returning the document');
                }
            });
        }
    });
});
</script> --}}