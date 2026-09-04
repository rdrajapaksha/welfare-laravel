<?php

namespace Tests\Feature;

use App\Enums\CommitteeBoard;
use App\Models\CommitteeMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvisoryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_advisory_page_renders_patrons_and_not_executive_officers(): void
    {
        CommitteeMember::factory()->create([
            'name' => 'H.M.C.P.K. Herath',
            'position_en' => 'Hon. President',
            'board' => CommitteeBoard::Executive,
            'is_current' => true,
        ]);
        CommitteeMember::factory()->create([
            'name' => 'I.P.P. Ratnayake',
            'position_en' => 'Patron (Divisional Secretary, Bandarawela)',
            'phone' => '071 443 5277',
            'board' => CommitteeBoard::Advisory,
            'is_current' => true,
        ]);

        $this->get('/en/about/advisory')
            ->assertSee('I.P.P. Ratnayake', false)
            ->assertSee('Patron (Divisional Secretary, Bandarawela)', false)
            ->assertSee('071 443 5277', false)
            ->assertDontSee('H.M.C.P.K. Herath', false);
    }
}
