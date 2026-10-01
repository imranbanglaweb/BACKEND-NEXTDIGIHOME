<!-- Modal HTML -->
<div class="modal-header bg-primary">
    <h5 class="modal-title text-black">
        <i class="fa fa-file-plus"></i> Create New Document
    </h5>
    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form id="documentForm" action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
      
                <!-- Document Classification -->
                <div class="card mb-3 shadow-3d">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fa fa-tags"></i> Classification</h6>
                    </div>
                    <div class="card-body">
                        <!-- Project Selection -->
                        <div class="form-group">
                            <label for="project_id" class="required">Project</label>
                            <select class="form-control select2-searchable @error('project_id') is-invalid @enderror" id="project_id" name="project_id">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Land Selection -->
                        <div class="form-group">
                            <label for="land_id" class="required">Land</label>
                            <select class="form-control select2-searchable @error('land_id') is-invalid @enderror" id="land_id" name="land_id">
                                <option value="">Select Land</option>
                                @foreach($lands as $land)
                                    <option value="{{ $land->id }}">{{ $land->name }}</option>
                                @endforeach
                            </select>
                            @error('land_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Document Type -->
                        <div class="form-group">
                            <label for="document_type_id" class="required">Document Type</label>
                            <select class="form-control select2-searchable @error('document_type_id') is-invalid @enderror" id="document_id" name="document_id">
                                <option value="">Select Document Type</option>
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('document_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="withdrawal_reason">Reason of Document Withdrawn</label>
                    <textarea class="form-control" id="withdrawal_reason" name="withdrawal_reason" rows="5" placeholder="Enter Reason of Document Withdrawn"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <!-- Document Details -->
                <div class="card mb-3 shadow-3d">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fa fa-file-alt"></i> Document Details</h6>
                    </div>
                    <div class="card-body">
                        <!-- Document Taker -->
                        <div class="form-group">
                            <label for="document_taker" class="required">Document Taker</label>
                            <input type="text" class="form-control" id="document_taker" name="document_taker" placeholder="Enter name of person taking document" value="{{ Auth::user()->name}}" readonly="">
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Witness Name -->
                        <div class="form-group">
                            <label for="witness_name" class="required">Witness Name</label>
                            <p style="font-size: 11px; color: brown">
                                Name and signature of the person present at the time of taking the document <strong></strong></p>
                            <input type="text" class="form-control" id="witness_name" name="witness_name" placeholder="Enter witness name">
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Vault Details Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Vault Number -->
                                <div class="form-group">
                                    <label for="vault_number" class="required">Vault Number</label>
                                    <input type="text" class="form-control" id="vault_number" name="vault_number" placeholder="Enter vault number">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Vault Location -->
                                <div class="form-group">
                                    <label for="vault_location" class="required">Vault Location</label>
                                    <input type="text" class="form-control" id="vault_location" name="vault_location" placeholder="Enter vault location">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Dates Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Proposed Return Date -->
                                <div class="form-group">
                                    <label for="proposed_return_date" class="required">Proposed Return Date</label>
                                    <input type="date" class="form-control" id="proposed_return_date" name="proposed_return_date">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status" class="required">Status</label>
                                    <select class="form-control select2-basic" id="status" name="status">
                                        {{-- <option value="">Select Status</option> --}}
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="withdrawn">Withdrawn</option>
                                        <option value="expired">Expired</option>
                                        <option value="pending">Pending Review</option>
                                        <option value="checked_out">Checked Out</option>
                                        <option value="returned">Returned</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document File -->
                <div class="card shadow-3d">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fa fa-upload"></i> Document Upload</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="document_scan" class="required">Document File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="document_scan" name="document_scan">
                                <label class="custom-file-label" for="document_scan">Choose file</label>
                            </div>
                            <small class="form-text text-muted">
                                Allowed files: PDF, DOC, DOCX, XLS, XLSX (Max size: 5MB)
                            </small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary" id="saveDocument">
            <i class="fa fa-save"></i> Save Document
        </button>
    </div>
</form>

<!-- Script Section -->
<style type="text/css">
    /* 3D Shadow Effect */
    .shadow-3d {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease-in-out;
    }

    /* Card Styling */
    .card {
        border-radius: 10px;
        border: none;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
    }

    .card-header {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    /* Form Styling */
    .form-control {
        border-radius: 5px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .required {
        font-size: 12px !important;
        font-weight: normal;
        color: #000 !important;
    }

    /* Add these styles for Select2 validation */
    .select2-container.is-invalid .select2-selection {
        border-color: #dc3545;
    }

    .select2-container + .error {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545 !important;;
    }
    .modal-title {
    color: black;
    font-size: 18px;
    font-weight: bold;
    padding-top: 10px;
}
</style>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script type="text/javascript">
$(document).ready(function() {
    const form = $('#documentForm');
    
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
            project_id: "required",
            land_id: "required",
            document_id: "required",
            withdrawal_reason: "required",
            document_taker: "required",
            witness_name: "required",
            vault_number: "required",
            vault_location: "required",
            withdrawal_reason: "required",
            proposed_return_date: "required",
            document_scan: {
                required: true,
                extension: "pdf|doc|jpg|jpeg|png|docx|xls|xlsx",
                filesize: 8242880 // 8MB in bytes
            }
        },
        messages: {
            project_id: "Please select a project",
            land_id: "Please select a land",
            document_id: "Please select a document type",
            document_taker: "Please enter document taker name",
            witness_name: "Please enter witness name",
            vault_number: "Please enter vault number",
            vault_location: "Please enter vault location",
            withdrawal_reason: "Please enter withdrawal reason",
            proposed_return_date: "Please select proposed return date",
            document_scan: {
                required: "Please upload a document file",
                extension: "Allowed file types: PDF,jpg,jpeg,png, DOC, DOCX, XLS, XLSX",
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
    $('#documentModal').on('hidden.bs.modal', function() {
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

    // Hide error messages after 5 seconds
    form.find('.invalid-feedback').each(function() {
        const errorElement = $(this);
        if (errorElement.text().trim() !== '') {
            setTimeout(function() {
                errorElement.fadeOut();
            }, 5000);
        }
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
                    $('#documentModal').modal('hide');
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
