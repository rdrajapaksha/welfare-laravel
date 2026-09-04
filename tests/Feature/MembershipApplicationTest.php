<?php

namespace Tests\Feature;

use App\Models\MembershipApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_join_page_renders(): void
    {
        $this->get('/en/join')->assertOk();
    }

    public function test_a_guest_can_submit_a_membership_application(): void
    {
        $this->from('/en/join')->post('/en/join', [
            'full_name' => 'Iresha Madushani',
            'nic' => '199534567890',
            'date_of_birth' => '1995-06-02',
            'gender' => 'FEMALE',
            'occupation' => 'Nurse',
            'address_line1' => '12 Lake Road',
            'city' => 'Maharagama',
            'district' => 'Colombo',
            'phone' => '0775550101',
            'email' => 'iresha.m@example.lk',
            'membership_type' => 'ORDINARY',
            'consent' => '1',
        ])->assertRedirect('/en/join');

        $this->assertDatabaseHas('membership_applications', [
            'email' => 'iresha.m@example.lk',
            'nic' => '199534567890',
            'status' => 'PENDING',
        ]);

        $this->assertSame(1, MembershipApplication::query()->count());
    }
}
