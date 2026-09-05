<?php

namespace Tests\Feature;

use App\Enums\CommitteeBoard;
use App\Models\CommitteeMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_english_home_page_renders_letterhead_identity(): void
    {
        $this->get('/en')
            ->assertSee('Heart Link Allianze', false)
            ->assertSee('BD/BW/SSW/01/149', false)
            ->assertSee('Bogahapelessa', false)
            ->assertSee('Bandarawela', false)
            ->assertSee('070 337 9955', false)
            ->assertSee('076 818 5377', false);
    }

    public function test_home_page_header_logo_spins(): void
    {
        $this->get('/en')
            ->assertSee('animate-logo-spin', false)
            ->assertSee('logo.png', false);
    }

    public function test_home_page_does_not_render_executive_committee_cards(): void
    {
        CommitteeMember::factory()->create([
            'name' => 'H.M.C.P.K. Herath',
            'position_en' => 'Hon. President',
            'is_current' => true,
            'board' => CommitteeBoard::Executive,
        ]);

        $this->get('/en')
            ->assertDontSee('H.M.C.P.K. Herath', false)
            ->assertDontSee('Hon. President', false);
    }

    public function test_home_page_shows_current_society_scale_not_demo_figures(): void
    {
        $this->get('/en')
            ->assertSee('Active members', false)
            ->assertSee('text-3xl font-extrabold">30</p>', false)
            ->assertSee('6,250', false)
            ->assertSee('Rs. 48,600,000', false)
            ->assertSee('Registered volunteers', false)
            ->assertSee('text-3xl font-extrabold">10</p>', false)
            ->assertSee('Audited figures, updated every quarter.', false)
            ->assertSee('Since 2025 Heart Link Allianze', false)
            ->assertSee('from Bandarawela since 2025', false)
            ->assertDontSee('1,840', false)
            ->assertDontSee('420', false)
            ->assertDontSee('For over a decade', false)
            ->assertDontSee('since 2013', false);
    }

    public function test_contact_page_renders_registered_office(): void
    {
        $this->get('/en/contact')
            ->assertSee('No. 118, Bogahapelessa, Mahulpotha', false)
            ->assertSee('Bandarawela', false)
            ->assertSee('BD/BW/SSW/01/149', false)
            ->assertSee('070 337 9955', false)
            ->assertSee('076 818 5377', false);
    }
}
