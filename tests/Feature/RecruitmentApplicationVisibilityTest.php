<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecruitmentApplicationVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_users_cannot_view_recruitment_application_records(): void
    {
        $applicant = User::factory()->create(['role' => 'user']);
        $booking = $this->createRecruitmentApplication($applicant);

        $this->actingAs($applicant)
            ->get(route('bookings.show', $booking))
            ->assertForbidden();

        $this->actingAs($applicant)
            ->get(route('bookings.my-applications'))
            ->assertForbidden();

        $this->actingAs($applicant)
            ->get(route('admin.applications'))
            ->assertForbidden();

        $this->actingAs($applicant)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee($booking->id);

        $this->actingAs($applicant)
            ->get(route('bookings.my-bookings'))
            ->assertOk()
            ->assertDontSee($booking->id);
    }

    public function test_admins_can_view_recruitment_applications(): void
    {
        $applicant = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = $this->createRecruitmentApplication($applicant);

        $this->actingAs($admin)
            ->get(route('bookings.show', $booking))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('bookings.my-applications'))
            ->assertRedirect(route('admin.applications'));

        $this->actingAs($admin)
            ->get(route('admin.applications'))
            ->assertOk()
            ->assertSee($applicant->email);
    }

    private function createRecruitmentApplication(User $applicant): Booking
    {
        return Booking::create([
            'user_id' => $applicant->id,
            'booking_type' => 'recruitment',
            'booking_date' => now(),
            'application_role' => 'driver',
            'status' => 'pending',
            'approval_status' => 'pending',
            'payment_status' => 'paid',
        ]);
    }
}
