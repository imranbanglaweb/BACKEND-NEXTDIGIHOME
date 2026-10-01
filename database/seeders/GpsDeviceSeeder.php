<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GpsDevice;
use App\Models\Vehicle;

class GpsDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating sample GPS devices...');

        // Device types and protocols
        $deviceTypes = ['GT06N', 'TK103', 'A8', 'Syrus', 'Meiligao', 'Custom'];
        $protocols = ['GT06', 'TK103', 'A8', 'Syrus', 'Meiligao'];
        $servers = [
            ['host' => 'gps-server-1.example.com', 'port' => 8080],
            ['host' => 'gps-server-2.example.com', 'port' => 8081],
            ['host' => '192.168.1.100', 'port' => 9000],
            ['host' => 'tracker.example.com', 'port' => 7070],
        ];

        // Get vehicles (create GPS devices for some vehicles)
        $vehicles = Vehicle::take(15)->get();

        if ($vehicles->isEmpty()) {
            $this->command->warn('No vehicles found. Creating GPS devices without vehicle assignment.');
            $this->createUnassignedDevices($deviceTypes, $protocols, $servers);
            return;
        }

        $createdCount = 0;

        // Create GPS device for each vehicle
        foreach ($vehicles as $vehicle) {
            $deviceType = $deviceTypes[array_rand($deviceTypes)];
            $protocol = $protocols[array_rand($protocols)];
            $server = $servers[array_rand($servers)];

            // Generate realistic IMEI (15 digits)
            $imei = $this->generateIMEI();

            // Generate SIM number
            $simNumber = $this->generateSIMNumber();

            GpsDevice::create([
                'vehicle_id' => $vehicle->id,
                'device_name' => ucwords(strtolower($vehicle->vehicle_name)) . ' GPS - ' . $deviceType,
                'device_type' => $deviceType,
                'imei_number' => $imei,
                'sim_number' => $simNumber,
                'protocol' => $protocol,
                'server_host' => $server['host'],
                'server_port' => $server['port'],
                'is_active' => rand(0, 1) ? true : false,
                'installation_date' => now()->subDays(rand(30, 365)),
                'notes' => 'GPS tracking device installed for vehicle monitoring. Protocol: ' . $protocol . '. Device Type: ' . $deviceType,
            ]);

            $createdCount++;
        }

        // Create some unassigned GPS devices (spare/stock)
        $this->createUnassignedDevices($deviceTypes, $protocols, $servers, 5);

        $totalDevices = GpsDevice::count();
        $this->command->info("✓ Created {$createdCount} GPS devices for vehicles.");
        $this->command->info("✓ Total GPS devices in database: {$totalDevices}");
    }

    /**
     * Create unassigned GPS devices (spare/stock)
     */
    private function createUnassignedDevices($deviceTypes, $protocols, $servers, $count = 5)
    {
        for ($i = 1; $i <= $count; $i++) {
            $deviceType = $deviceTypes[array_rand($deviceTypes)];
            $protocol = $protocols[array_rand($protocols)];
            $server = $servers[array_rand($servers)];

            GpsDevice::create([
                'vehicle_id' => null, // Unassigned
                'device_name' => 'GPS Device (Stock) #' . $i,
                'device_type' => $deviceType,
                'imei_number' => $this->generateIMEI(),
                'sim_number' => $this->generateSIMNumber(),
                'protocol' => $protocol,
                'server_host' => $server['host'],
                'server_port' => $server['port'],
                'is_active' => false,
                'installation_date' => null,
                'notes' => 'Spare/Stock GPS device. Type: ' . $deviceType . '. Ready for assignment.',
            ]);
        }
    }

    /**
     * Generate a realistic IMEI number (15 digits)
     * Format: TAC (6 digits) + FAC (2 digits) + SNR (6 digits) + Check digit (1 digit)
     */
    private function generateIMEI(): string
    {
        // TAC (Type Approval Code) - typically starts with 35 for GPS devices
        $tac = '35' . str_pad(rand(0, 999999), 4, '0', STR_PAD_LEFT);

        // FAC (Final Assembly Code) - manufacturer specific
        $fac = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);

        // SNR (Serial Number) - unique per device
        $snr = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Combine first 14 digits
        $imei14 = $tac . $fac . $snr;

        // Calculate Luhn check digit
        $checkDigit = $this->luhnCheckDigit($imei14);

        return $imei14 . $checkDigit;
    }

    /**
     * Generate a realistic SIM number (MSISDN format - typically 11-15 digits)
     * Bangladesh format: 88017XXXXXXX (Grameenphone), 88013XXXXXXX (Banglalink), etc.
     */
    private function generateSIMNumber(): string
    {
        $operators = [
            '8801',  // Grameenphone
            '8801',  // Banglalink
            '8802',  // Robi
            '8801',  // Teletalk
        ];

        $operator = $operators[array_rand($operators)];
        $remaining = str_pad(rand(0, 9999999999), 7, '0', STR_PAD_LEFT);

        return $operator . $remaining;
    }

    /**
     * Calculate Luhn check digit
     */
    private function luhnCheckDigit($num): int
    {
        $digits = str_split($num);
        $sum = 0;

        foreach (array_reverse($digits) as $i => $digit) {
            if ($i % 2 == 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return (10 - ($sum % 10)) % 10;
    }
}
