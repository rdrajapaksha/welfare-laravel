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

    public function test_about_page_does_not_render_committee_shortcut_cards(): void
    {
        $this->get('/en/about')
            ->assertDontSee('Meet the people who lead the society.', false);
    }
}
