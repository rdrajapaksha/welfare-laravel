<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFeeRecordingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_record_a_membership_fee_before_the_society_was_founded(): void
    {
        $admin = User::factory()->admin()->create();
        $member = Member::factory()->create();

        $this->actingAs($admin)
            ->from(route('admin.fees.index'))
            ->post(route('admin.fees.record'), [
                'member_id' => $member->id,
                'year' => 2024,
                'month' => 6,
                'method' => 'CASH',
            ])
            ->assertRedirect(route('admin.fees.index'))
            ->assertSessionHasErrors('year');

        $this->assertDatabaseMissing('payments', [
            'member_id' => $member->id,
            'period_year' => 2024,
        ]);
    }
}
