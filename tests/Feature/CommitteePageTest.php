<?php

namespace Tests\Feature;

use App\Enums\CommitteeBoard;
use App\Models\CommitteeMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommitteePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_committee_page_renders_current_office_bearers_and_phones(): void
    {
        CommitteeMember::factory()->create([
            'name' => 'H.M.C.P.K. Herath',
            'position_en' => 'Hon. President',
            'phone' => '076 818 5377',
            'sort_order' => 0,
            'is_current' => true,
            'board' => CommitteeBoard::Executive,
        ]);
        CommitteeMember::factory()->create([
            'name' => 'A.M. Ajith Rupasinghe',
            'position_en' => 'Hon. Secretary',
            'phone' => '070 337 9955',
            'sort_order' => 1,
            'is_current' => true,
            'board' => CommitteeBoard::Executive,
        ]);
        CommitteeMember::factory()->create([
            'name' => 'Hidden Past Member',
            'is_current' => false,
            'sort_order' => 9,
            'board' => CommitteeBoard::Executive,
        ]);
        CommitteeMember::factory()->create([
            'name' => 'I.P.P. Ratnayake',
            'position_en' => 'Patron (Divisional Secretary, Bandarawela)',
            'board' => CommitteeBoard::Advisory,
            'is_current' => true,
        ]);

        $this->get('/en/about/committee')
            ->assertSee('H.M.C.P.K. Herath', false)
            ->assertSee('Hon. President', false)
            ->assertSee('076 818 5377', false)
            ->assertSee('A.M. Ajith Rupasinghe', false)
            ->assertSee('070 337 9955', false)
            ->assertDontSee('Hidden Past Member', false)
            ->assertDontSee('I.P.P. Ratnayake', false);
    }
}
