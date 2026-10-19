<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomIdGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_driver_recruitment_and_booking_ids_are_alphanumeric(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $this->assertMatchesRegularExpression('/^USR-[A-Z0-9]+$/', (string) $user->id);

        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'LIC-123456',
            'license_expiry' => '2030-01-01',
            'experience_years' => '4',
        ]);

        $this->assertMatchesRegularExpression('/^DRV-[A-Z0-9]+$/', (string) $driver->id);

        $recruitment = Recruitment::create([
            'user_id' => $user->id,
            'title' => 'Driver Needed',
            'description' => 'Need a safe driver',
            'location' => 'Accra',
        ]);

        $this->assertMatchesRegularExpression('/^REC-[A-Z0-9]+$/', (string) $recruitment->id);

        $booking = Booking::create([
            'user_id' => $user->id,
            'driver_id' => $driver->id,
            'recruitment_id' => $recruitment->id,
            'booking_date' => now(),
            'booking_type' => 'driver',
            'status' => 'pending',
        ]);

        $this->assertMatchesRegularExpression('/^BKNG-[A-Z0-9]+$/', (string) $booking->id);
    }
}
