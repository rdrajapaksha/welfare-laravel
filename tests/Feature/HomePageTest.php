<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_english_home_page_renders(): void
    {
        $this->get('/en')
            ->assertOk()
            ->assertSee('Heart Link Allianz', false);
    }
}
