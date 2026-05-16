<tbody id="historyTableBody" class="sortable">
    @forelse($histories as $history)
    <tr data-id="{{ $history->id }}">
        <td class="sort-handle">
            <i class="fa fa-bars text-muted"></i>
        </td>
        <td>{{ $history->action_date->format('d M Y H:i:s') }}</td>
        <td>
            <strong>{{ $history->document->document_name }}</strong><br>
            <small class="text-muted">
                Project: {{ $history->document->project_name }}<br>
                Land: {{ $history->document->land_name }}
            </small>
        </td>
        <td>
            <span class="badge badge-{{ 
                $history->action === 'created' ? 'success' : 
                ($history->action === 'updated' ? 'info' : 
                ($history->action === 'returned' ? 'warning' : 'primary')) 
            }}">
                {{ ucfirst($history->action) }}
            </span>
        </td>
        <td>{{ $history->details }}</td>
        <td>
            {{ $history->performer->name }}<br>
            <small class="text-muted">{{ $history->performer->email }}</small>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center">No history records found</td>
    </tr>
    @endforelse
</tbody> 