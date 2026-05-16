@component('mail::message')
# Requisition Status Update

Dear {{ $requisition->employee->name ?? 'User' }},

We would like to inform you that there has been an update to your transport requisition.

## Requisition Details

| Field | Details |
|-------|---------|
| **Requisition ID** | #{{ $requisition->id }} |
| **Date** | {{ $requisition->requisition_date ? \Carbon\Carbon::parse($requisition->requisition_date)->format('d M, Y') : 'N/A' }} |
| **From** | {{ $requisition->from_address ?? 'N/A' }} |
| **To** | {{ $requisition->to_address ?? 'N/A' }} |
| **Transport Type** | {{ $requisition->transportType->name ?? 'N/A' }} |

## Status Information

| Status | Details |
|--------|---------|
| **Previous Status** | {{ $oldStatus->name ?? 'N/A' }} |
| **Current Status** | {{ $newStatus->name ?? 'N/A' }} |

@if($remarks)
## Remarks
> {{ $remarks }}
@endif

@component('mail::button', ['url' => route('admin.requisitions.show', $requisition->id), 'color' => 'primary'])
View Requisition Details
@endcomponent

If you have any questions or concerns regarding this requisition, please contact the transport department.

Thank you for using our services.

Best regards,<br>
{{ config('app.name') }} Team
@endcomponent
