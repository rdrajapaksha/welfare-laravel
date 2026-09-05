<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\MemberMeeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class MemberMeetingAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_member_meetings(): void
    {
        URL::defaults([]);

        $this->get('/en/dashboard/meetings')->assertRedirect('/en/login');
    }

    public function test_members_can_see_the_host_address_and_unpublished_meetings_stay_hidden(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        $visible = MemberMeeting::factory()->create([
            'title_en' => 'September member meeting',
            'host_address' => '8/2 Helahinna, Bandarawela',
            'held_at' => now()->addWeek(),
        ]);
        MemberMeeting::factory()->unpublished()->create([
            'title_en' => 'Draft committee huddle',
            'host_address' => 'Hidden lane, Bandarawela',
            'held_at' => now()->addDays(3),
        ]);

        $this->actingAs($user)
            ->get('/en/dashboard/meetings')
            ->assertOk()
            ->assertSee('September member meeting', false)
            ->assertSee('8/2 Helahinna, Bandarawela', false)
            ->assertDontSee('Draft committee huddle', false)
            ->assertDontSee('Hidden lane, Bandarawela', false);

        $this->get('/en/projects')
            ->assertDontSee($visible->host_address, false);
    }

    public function test_member_meeting_page_escapes_host_details(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        MemberMeeting::factory()->create([
            'title_en' => 'October member meeting <script>alert("x")</script>',
            'host_name' => 'Host <b>Name</b>',
            'host_address' => '8/2 Helahinna <script>alert("xss")</script>',
            'held_at' => now()->addWeek(),
        ]);

        $this->actingAs($user)
            ->get('/en/dashboard/meetings')
            ->assertOk()
            ->assertDontSee('<script>alert("x")</script>', false)
            ->assertDontSee('<script>alert("xss")</script>', false)
            ->assertDontSee('<b>Name</b>', false)
            ->assertSee('&lt;script&gt;', false);
    }

    public function test_members_cannot_create_meetings_in_admin(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->post(route('admin.meetings.store'), $this->payload())
            ->assertForbidden();

        $this->assertDatabaseCount('member_meetings', 0);
    }

    public function test_admin_meeting_form_rejects_an_empty_payload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.meetings.index'))
            ->post(route('admin.meetings.store'), [])
            ->assertRedirect(route('admin.meetings.index'))
            ->assertSessionHasErrors(['title_en', 'notes_en', 'host_name', 'host_address', 'held_at']);
    }

    public function test_admin_can_publish_a_meeting_for_members(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();
        Member::factory()->forUser($member)->create();

        $this->actingAs($admin)
            ->post(route('admin.meetings.store'), $this->payload())
            ->assertRedirect();

        $this->assertDatabaseHas('member_meetings', [
            'title_en' => 'October member meeting',
            'host_address' => '8/2 Helahinna, Bandarawela',
            'is_published' => true,
        ]);

        $this->actingAs($member)
            ->get('/en/dashboard/meetings')
            ->assertSee('October member meeting', false)
            ->assertSee('8/2 Helahinna, Bandarawela', false);
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(): array
    {
        return [
            'title_en' => 'October member meeting',
            'notes_en' => 'Hosted at a member home.',
            'host_name' => 'A.M. Ajith Rupasinghe',
            'host_address' => '8/2 Helahinna, Bandarawela',
            'held_at' => now()->addMonth()->format('Y-m-d\TH:i'),
            'is_published' => '1',
        ];
    }
}
