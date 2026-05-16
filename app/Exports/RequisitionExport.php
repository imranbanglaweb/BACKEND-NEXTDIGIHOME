<?php

namespace App\Exports;

use App\Models\Requisition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequisitionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Requisition::with(['requestedBy','department','vehicle','driver'])
            ->get()
            ->map(function($r){
                return [
                    '#'              => $r->id,
                    'Employee'       => $r->requestedBy->name ?? '',
                    'Department'     => $r->department->department_name ?? '',
                    'Vehicle'        => $r->vehicle->vehicle_name ?? '',
                    'Driver'         => $r->driver->name ?? $r->driver->driver_name ?? '',
                    'Travel Date'    => $r->travel_date,
                    'Return Date'    => $r->return_date,
                    'Status'         => $r->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee',
            'Department',
            'Vehicle',
            'Driver',
            'Travel Date',
            'Return Date',
            'Status',
        ];
    }
}

