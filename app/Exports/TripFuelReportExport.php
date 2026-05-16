<?php

namespace App\Exports;

use App\Models\TripSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TripFuelReportExport implements FromCollection, WithHeadings
{
    protected $vehicle_id;
    protected $driver_id;
    protected $from_date;
    protected $to_date;

    public function __construct($vehicle_id = null, $driver_id = null, $from_date = null, $to_date = null)
    {
        $this->vehicle_id = $vehicle_id;
        $this->driver_id = $driver_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        $query = TripSheet::with(['vehicle', 'driver']);

        if (!empty($this->vehicle_id)) {
            $query->where('vehicle_id', $this->vehicle_id);
        }

        if (!empty($this->driver_id)) {
            $query->where('driver_id', $this->driver_id);
        }

        if (!empty($this->from_date) && !empty($this->to_date)) {
            $query->whereBetween('start_date', [$this->from_date, $this->to_date]);
        }

        return $query->latest()->get()->map(function ($r) {
            $eff = $r->fuel_liter > 0 ? $r->distance_km / $r->fuel_liter : 0;
            return [
                'Vehicle' => $r->vehicle->vehicle_name ?? '-' . ' (' . ($r->vehicle->vehicle_number ?? '-') . ')',
                'Driver' => $r->driver->driver_name ?? '-',
                'Trip Date' => $r->trip_start_date,
                'Distance (KM)' => number_format($r->distance_km, 2),
                'Fuel (L)' => number_format($r->fuel_liter, 2),
                'Efficiency (km/L)' => $eff > 0 ? number_format($eff, 2) : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Vehicle',
            'Driver',
            'Trip Date',
            'Distance (KM)',
            'Fuel (L)',
            'Efficiency (km/L)',
        ];
    }
}
