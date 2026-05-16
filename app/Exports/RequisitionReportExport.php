<?php

namespace App\Exports;

use App\Models\Requisition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequisitionReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Requisition::select(
            'requisition_number',
            'travel_date',
            'status'
        )->get();
    }

    public function headings(): array
    {
        return ['Requisition No', 'Travel Date', 'Status'];
    }
}
