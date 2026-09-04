<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_dashboard(): void
    {
        $this->get('/en/dashboard')->assertRedirect(route('login'));
    }

    public function test_a_member_can_view_the_dashboard(): void
    {
        $user = User::factory()->create(['name' => 'Kamal Perera']);
        Member::factory()->forUser($user)->create(['full_name' => 'Kamal Perera']);

        $this->actingAs($user)
            ->get('/en/dashboard')
            ->assertOk()
            ->assertSee('Kamal Perera', false);
    }
}
