<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Date</th>
                <th>Project Name</th>
                <th>Land Name</th>
                <th>Document Type</th>
                <th>Document Taker</th>
                <th>Witness Name</th>
                <th>Scan Document</th>
                {{-- <th>Preview</th> --}}
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
            <tr>
                <td>{{ $document->date->format('d M Y') }}</td>
                <td>{{ optional($document->project)->project_name }}</td>
                <td>{{ optional($document->land)->name }}</td>
                <td>{{ optional($document->documentType)->name }}</td>
                <td>{{ $document->document_taker }}</td>
                <td>{{ $document->witness_name }}</td>
 
                <td>
                    @if(pathinfo($document->document_scan, PATHINFO_EXTENSION) === 'pdf')
                        <button class="btn btn-primary btn-sm" 
                                onclick="previewDocument('{{ asset('storage/app/documents/' . $document->document_scan) }}')"
                                title="Preview PDF">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                
                    @else
                         <img src="{{ asset('storage/app/documents/' . $document->document_scan) }}" 
                         alt="Document Scan" width="50" height="50" style="border-radius: 50%">
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-success btn-sm" 
                                onclick="approveDocument({{ $document->id }})"
                                title="Approve">
                            <i class="fa fa-check"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" 
                                onclick="rejectDocument({{ $document->id }})"
                                title="Reject">
                            <i class="fa fa-times"></i>
                        </button>
                        <button class="btn btn-info btn-sm" 
                                onclick="viewDocument({{ $document->id }})"
                                title="View Details">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">
                    <div class="empty-state">
                        <i class="fa fa-folder-open text-muted mb-3"></i>
                        <p class="text-muted mb-0">No pending approvals found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div> 
<script src="{{ asset('public/js/document_preview.js') }}"></script>
<script>

   function approveDocument(id) {
    // Get the approve button element
    const approveButton = document.querySelector(`button[onclick="approveDocument(${id})"]`);

    // Disable the button and change its text and icon
    approveButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
    approveButton.disabled = true;

    Swal.fire({
        title: 'Approve Document',
        text: 'Are you sure you want to approve this document?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve it',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return $.ajax({
                // url: `/documents/${id}/approve`,
                url: "{{ route('documents.approve', ':id') }}".replace(':id', id),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        return response; // Return the response to handle it in `then`
                    } else {
                        throw new Error(response.message); // Throw an error to trigger the error handling
                    }
                },
                error: function(xhr) {
                    throw new Error(xhr.responseJSON?.message || 'An error occurred'); // Handle AJAX errors
                }
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Success', result.value.message, 'success')
                .then(() => location.reload()); // Reload the page after approval
        } else {
            // If the user cancels or an error occurs, reset the button
            approveButton.innerHTML = '<i class="fa fa-check"></i>';
            approveButton.disabled = false;
        }
    }).catch((error) => {
        // Reset the button on error
        approveButton.innerHTML = '<i class="fa fa-check"></i> Approve';
        approveButton.disabled = false;
        Swal.fire('Error', error.message, 'error'); // Show error message if something goes wrong
    });
}

</script>