<?php

namespace App\Exports;

use App\Models\TripSheet;
use App\Models\Vehicle;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleUtilizationExport implements FromCollection, WithHeadings
{
    protected $vehicle_id;
    protected $from_date;
    protected $to_date;

    public function __construct($vehicle_id = null, $from_date = null, $to_date = null)
    {
        $this->vehicle_id = $vehicle_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        $query = TripSheet::with('vehicle')
            ->select(
                'vehicle_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(end_km - start_km) as total_distance'),
                DB::raw('SUM(0) as total_fuel')
            )
            ->groupBy('vehicle_id');

        // Role-based restriction
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if (!empty($this->vehicle_id)) {
            $query->where('vehicle_id', $this->vehicle_id);
        }

        if (!empty($this->from_date) && !empty($this->to_date)) {
            $query->whereBetween('start_date', [$this->from_date, $this->to_date]);
        }

        return $query->get()->map(function ($r) {
            return [
                'Vehicle' => $r->vehicle->vehicle_name ?? '-' . ' (' . ($r->vehicle->vehicle_number ?? '-') . ')',
                'Total Trips' => $r->total_trips,
                'Total Distance (KM)' => number_format($r->total_distance ?? 0, 2),
                'Total Fuel (L)' => number_format($r->total_fuel ?? 0, 2),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Vehicle',
            'Total Trips',
            'Total Distance (KM)',
            'Total Fuel (L)',
        ];
    }
}
