<?php

namespace App\Exports;

use App\Models\TripSheet;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriverPerformanceExport implements FromCollection, WithHeadings
{
    protected $driver_id;
    protected $from_date;
    protected $to_date;

    public function __construct($driver_id = null, $from_date = null, $to_date = null)
    {
        $this->driver_id = $driver_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        $query = TripSheet::with('driver')
            ->select(
                'driver_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(end_km - start_km) as total_distance'),
                DB::raw('SUM(0) as total_fuel'),
                DB::raw('SUM(0) as delayed_trips'),
                DB::raw('SUM(0) as incidents')
            )
            ->groupBy('driver_id');

        // Role-based restriction
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if (!empty($this->driver_id)) {
            $query->where('driver_id', $this->driver_id);
        }

        if (!empty($this->from_date) && !empty($this->to_date)) {
            $query->whereBetween('start_date', [$this->from_date, $this->to_date]);
        }

        return $query->get()->map(function ($r) {
            return [
                'Driver' => $r->driver->driver_name ?? '-',
                'Total Trips' => $r->total_trips,
                'Total Distance (KM)' => number_format($r->total_distance ?? 0, 2),
                'Total Fuel (L)' => number_format($r->total_fuel ?? 0, 2),
                'Delayed Trips' => $r->delayed_trips ?? 0,
                'Incidents' => $r->incidents ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Driver',
            'Total Trips',
            'Total Distance (KM)',
            'Total Fuel (L)',
            'Delayed Trips',
            'Incidents',
        ];
    }
}
