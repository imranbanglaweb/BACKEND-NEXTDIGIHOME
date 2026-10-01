<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GpsTrack;
use App\Models\Vehicle;
use App\Models\Driver;
use Carbon\Carbon;

class GpsTrackSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Vehicle::with('driver')->limit(20)->get();
        
        if ($vehicles->isEmpty()) {
            $this->command->info('No vehicles found. Please seed vehicles first.');
            return;
        }

        $this->command->info('Creating sample GPS tracking data...');

        foreach ($vehicles as $index => $vehicle) {
            // Create a route with multiple points around Dhaka area
            $baseLat = 23.8103 + (rand(-50, 50) / 1000); // Dhaka area
            $baseLng = 90.4125 + (rand(-50, 50) / 1000);
            
            // Generate 5-10 points per vehicle with some movement
            $points = rand(5, 10);
            $startTime = Carbon::now()->subHours(rand(1, 8));
            
            for ($i = 0; $i < $points; $i++) {
                $lat = $baseLat + ($i * 0.001) + (rand(-10, 10) / 10000);
                $lng = $baseLng + ($i * 0.001) + (rand(-10, 10) / 10000);
                $speed = rand(20, 80);
                $heading = rand(0, 360);
                
                GpsTrack::create([
                    'vehicle_id' => $vehicle->id,
                    'driver_id' => $vehicle->driver_id,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'speed' => $speed,
                    'heading' => $heading,
                    'altitude' => rand(5, 15),
                    'battery_level' => rand(60, 100),
                    'signal_strength' => rand(70, 100),
                    'device_id' => 'device_' . $vehicle->id,
                    'device_type' => 'Android',
                    'status' => $i == ($points - 1) ? 'active' : 'moving',
                    'recorded_at' => $startTime->copy()->addMinutes($i * 10),
                ]);
            }
            
            // Add current position (latest)
            $currentLat = $baseLat + ($points * 0.001);
            $currentLng = $baseLng + ($points * 0.001);
            
            GpsTrack::create([
                'vehicle_id' => $vehicle->id,
                'driver_id' => $vehicle->driver_id,
                'latitude' => $currentLat,
                'longitude' => $currentLng,
                'speed' => rand(0, 30),
                'heading' => rand(0, 360),
                'altitude' => rand(5, 15),
                'battery_level' => rand(60, 100),
                'signal_strength' => rand(70, 100),
                'device_id' => 'device_' . $vehicle->id,
                'device_type' => 'Android',
                'status' => 'active',
                'recorded_at' => Carbon::now(),
            ]);
        }

        $totalTracks = GpsTrack::count();
        $this->command->info("Created {$totalTracks} sample GPS tracking records for {$vehicles->count()} vehicles.");
    }
}