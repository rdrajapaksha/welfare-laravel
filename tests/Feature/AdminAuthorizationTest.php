<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_admin_area(): void
    {
        $this->get('/en/admin')->assertRedirect(route('login'));
    }

    public function test_members_cannot_access_the_admin_area(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)->get('/en/admin')->assertForbidden();
    }

    public function test_admins_can_view_the_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/en/admin')
            ->assertOk();
    }

    public function test_an_admin_can_admit_a_membership_application(): void
    {
        $admin = User::factory()->admin()->create();
        $application = MembershipApplication::factory()->create([
            'email' => 'new.member@example.lk',
            'nic' => '199012345678',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.applications.admit', $application))
            ->assertRedirect();

        $this->assertDatabaseHas('members', [
            'email' => 'new.member@example.lk',
            'nic' => '199012345678',
            'status' => 'ACTIVE',
        ]);
        $this->assertSame('APPROVED', $application->fresh()->status);
    }
}
