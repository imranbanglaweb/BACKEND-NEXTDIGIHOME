@extends('admin.dashboard.master')
@section('title', 'Pending Approvals')

@section('main_content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pending Approvals</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pending Approvals</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Documents Pending Approvalsss</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Document</th>
                                <th>Project</th>
                                <th>Submitted By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $document)
                            <tr>
                                <td>
                                    {{ $document->created_at->format('d M Y') }}
                                </td>
                                <td>{{ $document->document_name }}</td>
                                <td>{{ $document->project_name }}</td>
                                <td>{{ $document->creator->name }}</td>
                                <td>
                                  {{--   <button class="btn btn-success btn-sm" onclick="approveDocument({{ $document->id }})">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="rejectDocument({{ $document->id }})">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                    <button class="btn btn-info btn-sm" onclick="viewDocument({{ $document->id }})">
                                        <i class="fa fa-eye"></i> View
                                    </button> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No documents pending approval</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
    
/* Add smooth transition for button state changes */
button.btn-success {
    transition: all 0.3s ease;
}

/* Style for the spinner */
button.btn-success .fa-spinner {
    margin-right: 5px;
}
</style>
@push('scripts')
<script>

//    function approveDocument(id) {
//     // Get the approve button element
//     const approveButton = document.querySelector(`button[onclick="approveDocument(${id})"]`);

//     // Disable the button and change its text and icon
//     approveButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Approving...';
//     approveButton.disabled = true;

//     Swal.fire({
//         title: 'Approve Document',
//         text: 'Are you sure you want to approve this document?',
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonText: 'Yes, approve it',
//         cancelButtonText: 'Cancel',
//         showLoaderOnConfirm: true,
//         preConfirm: () => {
//             return $.ajax({
//                 // url: `/documents/${id}/approve`,
//                 url: "{{ route('documents.approve', ':id') }}".replace(':id', id),
//                 type: 'POST',
//                 data: {
//                     _token: '{{ csrf_token() }}'
//                 },
//                 success: function(response) {
//                     if (response.success) {
//                         return response; // Return the response to handle it in `then`
//                     } else {
//                         throw new Error(response.message); // Throw an error to trigger the error handling
//                     }
//                 },
//                 error: function(xhr) {
//                     throw new Error(xhr.responseJSON?.message || 'An error occurred'); // Handle AJAX errors
//                 }
//             });
//         }
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire('Success', result.value.message, 'success')
//                 .then(() => location.reload()); // Reload the page after approval
//         } else {
//             // If the user cancels or an error occurs, reset the button
//             approveButton.innerHTML = '<i class="fa fa-check"></i> Approve';
//             approveButton.disabled = false;
//         }
//     }).catch((error) => {
//         // Reset the button on error
//         approveButton.innerHTML = '<i class="fa fa-check"></i> Approve';
//         approveButton.disabled = false;
//         Swal.fire('Error', error.message, 'error'); // Show error message if something goes wrong
//     });
// }

// function approveDocument(id) {
//     Swal.fire({
//         title: 'Approve Document',
//         text: 'Are you sure you want to approve this document?',
//         icon: 'question',
//         showCancelButton: true,
//         confirmButtonText: 'Yes, approve it',
//         cancelButtonText: 'Cancel'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: `/documents/${id}/approve`,
//                 type: 'POST',
//                 data: {
// {{-- //                     _token: '{{ csrf_token() }}' --}}
//                 },
//                 success: function(response) {
//                     if (response.success) {
//                         Swal.fire('Success', response.message, 'success')
//                             .then(() => location.reload());
//                     } else {
//                         Swal.fire('Error', response.message, 'error');
//                     }
//                 }
//             });
//         }
//     });
// }

function rejectDocument(id) {
    Swal.fire({
        title: 'Reject Document',
        input: 'textarea',
        inputLabel: 'Rejection Reason',
        inputPlaceholder: 'Enter reason for rejection...',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: (reason) => {
            if (!reason) {
                Swal.showValidationMessage('Please enter a rejection reason');
                return false;
            }
            return $.ajax({
                url: `/documents/${id}/reject`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rejection_reason: reason
                }
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.success) {
                Swal.fire('Success', result.value.message, 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('Error', result.value.message, 'error');
            }
        }
    });
}
</script>
@endpush
@endsection 