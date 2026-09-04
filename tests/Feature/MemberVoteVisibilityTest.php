<?php

namespace Tests\Feature;

use App\Models\Election;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberVoteVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_hides_voting_when_no_election_is_open(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        Election::factory()->create(['status' => 'DRAFT']);

        $this->actingAs($user)
            ->get('/en/dashboard')
            ->assertDontSee('E-Voting', false);
    }

    public function test_dashboard_shows_voting_when_an_election_is_open(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        Election::factory()->open()->create();

        $this->actingAs($user)
            ->get('/en/dashboard')
            ->assertSee('E-Voting', false);
    }

    public function test_members_cannot_vote_in_a_draft_election(): void
    {
        $user = User::factory()->create();
        $member = Member::factory()->forUser($user)->create();
        $election = Election::factory()->create(['status' => 'DRAFT']);
        $candidate = $election->candidates()->create([
            'name' => 'Nimal Perera',
            'position_en' => 'President',
            'position_si' => 'President',
            'position_ta' => 'President',
            'sort_order' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('member.vote.store', $election), [
                'election_candidate_id' => $candidate->id,
            ])
            ->assertForbidden();

        $this->assertSame(0, $member->votes()->count());
    }
}
