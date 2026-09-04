<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_supported_locales_render_the_home_page(): void
    {
        $this->get('/si')->assertOk();
        $this->get('/ta')->assertOk();
    }

    public function test_unknown_locale_is_not_found(): void
    {
        $this->get('/fr')->assertNotFound();
    }
}
