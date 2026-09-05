<?php

namespace Tests\Feature;

use App\Support\AboutContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_renders_vision_mission_objectives_and_intro(): void
    {
        $this->get('/en/about')
            ->assertSee(AboutContent::vision()['en'], false)
            ->assertSee(AboutContent::mission()['en'], false)
            ->assertSee('Heart Link Allianze is a welfare organisation', false)
            ->assertSee('To support people facing economic and social difficulties.', false)
            ->assertSee('To contribute towards building a healthier, happier and more compassionate society.', false);
    }

    public function test_about_page_history_starts_from_2025_founding(): void
    {
        $this->get('/en/about')
            ->assertSee('Society founded', false)
            ->assertSee('Heart Link Allianze Welfare Society was formed in Bandarawela in 2025', false)
            ->assertSee('BD/BW/SSW/01/149', false)
            ->assertDontSee('A neighbourhood collection tin', false)
            ->assertDontSee('1,860 households', false)
            ->assertDontSee('Sarana housing', false);
    }

    public function test_about_page_does_not_render_committee_shortcut_cards(): void
    {
        $this->get('/en/about')
            ->assertDontSee('Meet the people who lead the society.', false);
    }
}
