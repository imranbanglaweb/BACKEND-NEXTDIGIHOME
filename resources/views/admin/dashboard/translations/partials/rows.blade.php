@if($translations->count())
    @foreach($translations as $row)
        <tr>
            <td class="checkbox-cell">
                <input type="checkbox"
                       class="row-check"
                       value="{{ $row->id }}">
            </td>

            <td>
                <strong>{{ $row->key }}</strong>
            </td>

            <td>
                <input type="text"
                       class="form-control translation-input"
                       data-id="{{ $row->id }}"
                       value="{{ $row->value }}">
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="3" class="text-center">
            <strong>No translations found</strong>
        </td>
    </tr>
@endif
