<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DefaultAdminAccountsTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_admin_accounts_are_created_with_expected_credentials(): void
    {
        User::ensureDefaultAdminAccounts();

        $systemAdmin = User::where('email', 'system.admin@dashboard.local')->first();
        $cmsAdmin = User::where('email', 'site.admin@dashboard.local')->first();

        $this->assertNotNull($systemAdmin);
        $this->assertNotNull($cmsAdmin);
        $this->assertSame('admin', $systemAdmin->role);
        $this->assertSame('cms_admin', $cmsAdmin->role);
        $this->assertTrue(Hash::check('SysAdm@2026!', $systemAdmin->password));
        $this->assertTrue(Hash::check('SiteAdm@2026!', $cmsAdmin->password));
        $this->assertTrue(Auth::attempt([
            'email' => 'system.admin@dashboard.local',
            'password' => 'SysAdm@2026!',
        ]));
    }
}
