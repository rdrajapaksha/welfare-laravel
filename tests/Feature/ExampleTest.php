<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_root_path_redirects_to_the_default_locale(): void
    {
        $this->get('/')->assertRedirect('/en');
    }
}
