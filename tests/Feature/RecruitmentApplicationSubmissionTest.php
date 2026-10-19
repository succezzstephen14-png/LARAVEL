<?php

namespace Tests\Feature;

use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class RecruitmentApplicationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_driver_recruitment_links_use_the_correct_role_and_guest_sees_submission_confirmation(): void
    {
        $owner = User::factory()->create();
        $recruitment = $this->createRecruitment($owner, 'cleaner');

        $this->get(route('recruitments.index'))
            ->assertOk()
            ->assertSee(route('guest.application.page', [
                'role' => 'cleaner',
                'recruitment' => $recruitment->id,
            ]));

        $this->get(route('guest.application.page', [
            'role' => 'cleaner',
            'recruitment' => $recruitment->id,
        ]))
            ->assertOk()
            ->assertDontSee('You have been redirected to the correct application role.');

        Mail::shouldReceive('raw')
            ->once()
            ->withArgs(function (string $body, callable $callback): bool {
                $this->assertStringContainsString('Your application has been received and is being reviewed.', $body);
                $this->assertStringContainsString('Management will get back to you with a decision.', $body);
                $this->assertStringNotContainsString('booking request has been approved', $body);

                $mailMessage = Mockery::mock();
                $mailMessage->shouldReceive('to')->once()->with('applicant@example.com')->andReturnSelf();
                $mailMessage->shouldReceive('subject')->once()->with('Recruitment application received')->andReturnSelf();
                $callback($mailMessage);

                return true;
            });

        $this->post(route('guest.application.store', [
            'role' => 'cleaner',
            'recruitment' => $recruitment->id,
        ]), [
            'application_role' => 'cleaner',
            'description' => 'I have relevant experience.',
            'guest_name' => 'Applicant',
            'guest_email' => 'applicant@example.com',
            'guest_phone' => '0550000000',
        ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('success', 'Application sent successfully! Your application is pending admin review.');

        $this->assertDatabaseHas('bookings', [
            'recruitment_id' => $recruitment->id,
            'booking_type' => 'recruitment',
            'application_role' => 'cleaner',
            'guest_email' => 'applicant@example.com',
        ]);
    }

    public function test_authenticated_applicant_receives_submission_confirmation(): void
    {
        $owner = User::factory()->create();
        $applicant = User::factory()->create(['role' => 'user']);
        $recruitment = $this->createRecruitment($owner, 'office_assistant');

        Mail::shouldReceive('raw')
            ->once()
            ->withArgs(function (string $body, callable $callback) use ($applicant): bool {
                $this->assertStringContainsString('Your application has been received and is being reviewed.', $body);
                $this->assertStringContainsString('Management will get back to you with a decision.', $body);

                $mailMessage = Mockery::mock();
                $mailMessage->shouldReceive('to')->once()->with($applicant->email)->andReturnSelf();
                $mailMessage->shouldReceive('subject')->once()->with('Recruitment application received')->andReturnSelf();
                $callback($mailMessage);

                return true;
            });

        $this->actingAs($applicant)
            ->post(route('application.store', [
                'role' => 'office-assistant',
                'recruitment' => $recruitment->id,
            ]), [
                'application_role' => 'office_assistant',
                'description' => 'I have relevant experience.',
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('success', 'Application sent successfully! Your application is pending admin review.');
    }

    public function test_legacy_recruitment_application_route_also_sends_receipt_email(): void
    {
        $owner = User::factory()->create();
        $applicant = User::factory()->create(['role' => 'user']);
        $recruitment = $this->createRecruitment($owner, 'driver');

        Mail::shouldReceive('raw')
            ->once()
            ->withArgs(function (string $body, callable $callback) use ($applicant): bool {
                $this->assertStringContainsString('Your application has been received and is being reviewed.', $body);
                $this->assertStringContainsString('Management will get back to you with a decision.', $body);

                $mailMessage = Mockery::mock();
                $mailMessage->shouldReceive('to')->once()->with($applicant->email)->andReturnSelf();
                $mailMessage->shouldReceive('subject')->once()->with('Recruitment application received')->andReturnSelf();
                $callback($mailMessage);

                return true;
            });

        $this->actingAs($applicant)
            ->post(route('recruitments.apply', $recruitment), [
                'description' => 'I have relevant experience.',
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('success', 'Application submitted! Awaiting admin review.');
    }

    private function createRecruitment(User $owner, string $position): Recruitment
    {
        return Recruitment::create([
            'user_id' => $owner->id,
            'title' => ucfirst(str_replace('_', ' ', $position)) . ' role',
            'description' => 'A sample open role.',
            'position_type' => $position,
            'location' => 'Accra',
            'status' => 'open',
            'approval_status' => 'approved',
            'posted_at' => now(),
        ]);
    }
}
