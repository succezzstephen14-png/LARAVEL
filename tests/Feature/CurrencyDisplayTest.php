<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_and_reports_format_payments_in_ghc(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Payment::create([
            'user_id' => $admin->id,
            'reference' => 'TEST-GHC-REFERENCE',
            'amount' => 5000,
            'type' => 'vehicle',
            'status' => 'completed',
            'approval_status' => 'approved',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('GHC 50.00')
            ->assertDontSee('?50');

        $this->get(route('admin.analytics.export-pdf'))
            ->assertOk()
            ->assertSee('GHC 50.00');

        $this->get(route('admin.analytics.export-csv'))
            ->assertOk()
            ->assertSee('Amount (GHC)')
            ->assertSee('50.00');
    }

    public function test_recruitment_salary_range_uses_ghc(): void
    {
        $recruitment = new Recruitment([
            'salary_range_min' => 1200,
            'salary_range_max' => 2500,
        ]);

        $this->assertSame('GHC 1,200.00 - GHC 2,500.00', $recruitment->salary_range);
    }
}
