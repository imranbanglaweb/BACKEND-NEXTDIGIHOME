@component('mail::message')
# Requisition Status Updated

Requisition **#{{ $requisition->id }}** status changed.

- **Requested By:** {{ $requisition->requestedBy->name ?? 'N/A' }}
- **Old Status:** {{ $oldStatus }}
- **New Status:** {{ $newStatus }}
- **From → To:** {{ $requisition->from_location }} → {{ $requisition->to_location }}
- **Travel Date:** {{ $requisition->travel_date }}

@if($remarks)
**Remarks:**  
{{ $remarks }}
@endif

@component('mail::button', ['url' => url(route('requisitions.show', $requisition->id))])
View Requisition
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
