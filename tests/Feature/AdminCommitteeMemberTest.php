<?php

namespace Tests\Feature;

use App\Enums\CommitteeBoard;
use App\Models\CommitteeMember;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCommitteeMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_officer_management(): void
    {
        $this->get('/en/admin/committee')->assertRedirect(route('login'));
    }

    public function test_members_cannot_create_an_officer(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->post(route('admin.committee.store'), $this->officerPayload())
            ->assertForbidden();
    }

    public function test_admin_officer_page_lists_executive_members(): void
    {
        $admin = User::factory()->admin()->create();
        CommitteeMember::factory()->create([
            'name' => 'H.M.C.P.K. Herath',
            'position_en' => 'Hon. President',
            'board' => CommitteeBoard::Executive,
        ]);

        $this->actingAs($admin)
            ->get('/en/admin/committee')
            ->assertSee('H.M.C.P.K. Herath', false)
            ->assertSee('Hon. President', false)
            ->assertSee('Add officer', false);
    }

    public function test_admin_can_create_an_executive_officer_with_a_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.committee.store'), $this->officerPayload([
                'photo' => UploadedFile::fake()->image('president.jpg', 200, 240),
            ]))
            ->assertRedirect(route('admin.committee.index'));

        $officer = CommitteeMember::query()->where('name', 'Nimal Perera')->first();

        $this->assertNotNull($officer);
        $this->assertSame('EXECUTIVE', $officer->board->value);
        $this->assertSame('076 111 2222', $officer->phone);
        $this->assertNotNull($officer->photo_url);
        Storage::disk('public')->assertExists($officer->photo_url);

        $this->get('/en/about/committee')
            ->assertSee('Nimal Perera', false)
            ->assertSee('Hon. President', false)
            ->assertSee('076 111 2222', false);
    }

    public function test_admin_can_replace_an_officer_name_and_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $officer = CommitteeMember::factory()->create([
            'name' => 'Old Officer',
            'position_en' => 'Hon. Secretary',
            'board' => CommitteeBoard::Executive,
            'is_current' => true,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.committee.update', $officer), $this->officerPayload([
                'name' => 'A.M. Ajith Rupasinghe',
                'position_en' => 'Hon. Secretary',
                'is_current' => '1',
                'photo' => UploadedFile::fake()->image('secretary.jpg', 180, 220),
            ]))
            ->assertRedirect(route('admin.committee.index'));

        $officer->refresh();

        $this->assertSame('A.M. Ajith Rupasinghe', $officer->name);
        $this->assertNotNull($officer->photo_url);
        Storage::disk('public')->assertExists($officer->photo_url);

        $this->get('/en/about/committee')
            ->assertSee('A.M. Ajith Rupasinghe', false)
            ->assertDontSee('Old Officer', false);
    }

    public function test_admin_can_hide_an_officer_from_the_public_page(): void
    {
        $admin = User::factory()->admin()->create();
        $officer = CommitteeMember::factory()->create([
            'name' => 'Past President',
            'position_en' => 'Hon. President',
            'board' => CommitteeBoard::Executive,
            'is_current' => true,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.committee.update', $officer), $this->officerPayload([
                'name' => 'Past President',
                'position_en' => 'Hon. President',
            ]))
            ->assertRedirect(route('admin.committee.index'));

        $this->assertFalse($officer->fresh()->is_current);

        $this->get('/en/about/committee')
            ->assertDontSee('Past President', false);
    }

    public function test_admin_can_remove_an_officer(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $officer = CommitteeMember::factory()->create([
            'name' => 'Temporary Officer',
            'board' => CommitteeBoard::Executive,
            'is_current' => true,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.committee.destroy', $officer))
            ->assertRedirect(route('admin.committee.index'));

        $this->assertDatabaseMissing('committee_members', ['id' => $officer->id]);

        $this->get('/en/about/committee')
            ->assertDontSee('Temporary Officer', false);
    }

    public function test_officer_form_rejects_an_empty_payload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.committee.index'))
            ->post(route('admin.committee.store'), [])
            ->assertRedirect(route('admin.committee.index'))
            ->assertSessionHasErrors(['board', 'name', 'position_en', 'term_from']);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function officerPayload(array $overrides = []): array
    {
        return array_merge([
            'board' => 'EXECUTIVE',
            'name' => 'Nimal Perera',
            'position_en' => 'Hon. President',
            'position_si' => '',
            'position_ta' => '',
            'bio_en' => 'No. 1, Example Road, Bandarawela.',
            'phone' => '076 111 2222',
            'term_from' => 2024,
            'term_to' => 2026,
            'sort_order' => 0,
        ], $overrides);
    }
}
