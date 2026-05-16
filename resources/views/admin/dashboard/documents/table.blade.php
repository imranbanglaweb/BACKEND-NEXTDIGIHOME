@foreach($documents as $key => $document)
<tr id="document-{{ $document->id }}">
    <td>{{ $key + 1 }}</td>
    <td>{{ $document->date->format('d-m-Y') }}</td>
    <td>{{ optional($document->project)->project_name }}</td>
    <td>{{ optional($document->land)->name }}</td>
    <td>{{ optional($document->documentType)->name }}</td>
    <td>{{ $document->document_taker }}</td>
    {{-- <td>{{ $document->proposed_return_date->format('d-m-Y') }}</td> --}}
 {{--    <td>
        <span class="badge badge-{{ $document->status === 'withdrawn' ? 'warning' : 'success' }}">
            {{ ucfirst($document->status) }}
        </span>
    </td> --}}
    <td>
        <div class="btn-group">
            @can('view')
            <button type="button" class="btn btn-info btn-sm" onclick="viewDocument({{ $document->id }})">
                <i class="fa fa-eye"></i>
            </button>
            @endcan
            @can('edit')
            <button type="button" class="btn btn-primary btn-sm" onclick="editDocument({{ $document->id }})">
                <i class="fa fa-pencil"></i>
            </button>
            @endcan
            @if($document->status !== 'returned')
            <button type="button" class="btn btn-success btn-sm" 
                    onclick="showReturnModal({{ $document->id }})" 
                    title="Return Document">
                <i class="fa fa-undo"></i>
            </button>
            @endif
            @can('view-history')
            <button type="button" class="btn btn-warning btn-sm" onclick="viewHistory({{ $document->id }})">
                <i class="fa fa-history"></i>
            </button>
            @endcan
            @can('delete')
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteDocument({{ $document->id }})">
                <i class="fa fa-trash-o"></i>
            </button>
            @endcan
        </div>
    </td>
</tr>
@endforeach 

@push('scripts')
<script>
function showReturnModal(id) {
    console.log('Opening return modal for document:', id);
    $.ajax({
        url: "{{ route('documents.return-modal', ':id') }}".replace(':id', id),
        type: 'GET',
        success: function(response) {
            console.log('Return modal response:', response);
            if (response.success) {
                $('#returnDocumentModal').remove();
                $('body').append(`<div class="modal fade" id="returnDocumentModal" 
                    tabindex="-1" role="dialog" aria-hidden="true">${response.view}</div>`);
                $('#returnDocumentModal').modal('show');
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Return modal error:', error);
            console.error('Response:', xhr.responseText);
            Swal.fire('Error', 'Could not load return form', 'error');
        }
    });
}
</script>
@endpush 