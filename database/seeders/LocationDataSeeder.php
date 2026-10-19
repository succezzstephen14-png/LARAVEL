<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\Vehicle;

class LocationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add sample GPS coordinates to approved drivers
        Driver::where('approval_status', 'approved')
            ->whereNull('latitude')
            ->take(5)
            ->get()
            ->each(function ($driver) {
                $driver->update([
                    'latitude' => 5.6037 + (rand(-500, 500) / 10000), // Accra area
                    'longitude' => -0.1870 + (rand(-500, 500) / 10000),
                    'last_location_update' => now(),
                    'tracking_location' => 'Accra, Ghana',
                    'tracking_status' => 'available'
                ]);
            });

        // Add sample GPS coordinates to approved vehicles
        Vehicle::where('approval_status', 'approved')
            ->whereNull('latitude')
            ->take(5)
            ->get()
            ->each(function ($vehicle) {
                $vehicle->update([
                    'latitude' => 5.6037 + (rand(-300, 300) / 10000), // Accra/Tema area
                    'longitude' => -0.1870 + (rand(-300, 300) / 10000),
                    'last_location_update' => now(),
                    'tracking_location' => 'Tema, Ghana',
                    'tracking_status' => 'available'
                ]);
            });
    }
}
