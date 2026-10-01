<?php

namespace App\Exports;

use App\Models\MaintenanceRequisition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaintenanceExport implements FromCollection, WithHeadings
{
    protected $vehicle_id;
    protected $type_id;
    protected $vendor_id;
    protected $from_date;
    protected $to_date;

    public function __construct($vehicle_id = null, $type_id = null, $vendor_id = null, $from_date = null, $to_date = null)
    {
        $this->vehicle_id = $vehicle_id;
        $this->type_id = $type_id;
        $this->vendor_id = $vendor_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        $query = MaintenanceRequisition::with(['vehicle', 'maintenanceType', 'vendor']);

        // Role-based restriction
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if (!empty($this->vehicle_id)) {
            $query->where('vehicle_id', $this->vehicle_id);
        }

        if (!empty($this->type_id)) {
            $query->where('maintenance_type_id', $this->type_id);
        }

        if (!empty($this->vendor_id)) {
            $query->where('vendor_id', $this->vendor_id);
        }

        if (!empty($this->from_date) && !empty($this->to_date)) {
            $query->whereBetween('maintenance_date', [$this->from_date, $this->to_date]);
        }

        return $query->latest()->get()->map(function ($r) {
            return [
                'Vehicle' => $r->vehicle->vehicle_name ?? '-' . ' (' . ($r->vehicle->vehicle_number ?? '-') . ')',
                'Maintenance Type' => $r->maintenanceType->name ?? '-',
                'Service Title' => $r->service_title ?? '-',
                'Maintenance Date' => $r->maintenance_date ? $r->maintenance_date->format('d M Y') : '-',
                'Vendor' => $r->vendor->name ?? '-',
                'Charge Amount' => number_format($r->charge_amount ?? 0, 2),
                'Parts Cost' => number_format($r->total_parts_cost ?? 0, 2),
                'Total Cost' => number_format($r->total_cost ?? 0, 2),
                'Status' => $r->status ?? '-',
                'Priority' => $r->priority ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Vehicle',
            'Maintenance Type',
            'Service Title',
            'Maintenance Date',
            'Vendor',
            'Charge Amount',
            'Parts Cost',
            'Total Cost',
            'Status',
            'Priority',
        ];
    }
}
