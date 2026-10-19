<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApprovedDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed approved drivers, vehicles, and recruitment posts for frontend display.
     */
    public function run(): void
    {
        // Create sample users for approved data
        $driverUser = User::firstOrCreate(
            ['email' => 'sample.driver@example.com'],
            [
                'name' => 'Sample Driver Owner',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        $vehicleUser = User::firstOrCreate(
            ['email' => 'sample.vehicle@example.com'],
            [
                'name' => 'Sample Vehicle Owner',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        $recruiterUser = User::firstOrCreate(
            ['email' => 'sample.recruiter@example.com'],
            [
                'name' => 'Sample Recruiter',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        // Create 3 approved drivers
        for ($i = 1; $i <= 3; $i++) {
            Driver::firstOrCreate(
                [
                    'user_id' => $driverUser->id,
                    'license_number' => 'DL-SMP-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                ],
                [
                    'license_expiry' => now()->addYears(2),
                    'license_class' => 'A',
                    'experience_years' => 2 + $i,
                    'status' => 'available',
                    'approval_status' => 'approved',
                    'approved_at' => now()->subDays(5 * $i),
                    'rating' => 4.0 + ($i * 0.3),
                    'total_trips' => 100 * $i,
                ]
            );
        }

        // Create 3 approved vehicles
        $vehicleTypes = ['car', 'van', 'truck'];
        $fuelTypes = ['petrol', 'diesel', 'hybrid'];

        for ($i = 1; $i <= 3; $i++) {
            Vehicle::firstOrCreate(
                [
                    'license_plate' => 'SM-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                ],
                [
                    'user_id' => $vehicleUser->id,
                    'make' => collect(['Toyota', 'Honda', 'Ford'])->get($i - 1),
                    'model' => 'Sample Model ' . $i,
                    'year' => 2018 + $i,
                    'registration_number' => 'REG-SMP-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                    'color' => collect(['Black', 'White', 'Silver'])->get($i - 1),
                    'vehicle_type' => $vehicleTypes[$i - 1],
                    'fuel_type' => $fuelTypes[$i - 1],
                    'status' => 'available',
                    'approval_status' => 'approved',
                    'approved_at' => now()->subDays(7 * $i),
                ]
            );
        }

        // Create 3 approved recruitment posts
        for ($i = 1; $i <= 3; $i++) {
            Recruitment::firstOrCreate(
                [
                    'user_id' => $recruiterUser->id,
                    'title' => 'Sample Recruitment Opportunity ' . $i,
                ],
                [
                    'description' => 'Looking for qualified candidates for a trusted transport service.',
                    'position_type' => 'driver',
                    'location' => 'Accra, Ghana',
                    'requirements' => 'Valid driver license and experience.',
                    'status' => 'open',
                    'approval_status' => 'approved',
                    'approved_at' => now()->subDays(3 * $i),
                    'posted_at' => now()->subDays(3 * $i),
                ]
            );
        }

        $this->command->info('Approved data seeded successfully!');
        $approvedDrivers = Driver::where('approval_status', 'approved')->count();
        $approvedVehicles = Vehicle::where('approval_status', 'approved')->count();
        $approvedRecruitments = Recruitment::where('approval_status', 'approved')->count();
        $this->command->info("Created $approvedDrivers approved drivers, $approvedVehicles approved vehicles, and $approvedRecruitments approved recruitment posts.");
    }
}
