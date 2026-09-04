<?php

namespace Tests\Feature;

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
