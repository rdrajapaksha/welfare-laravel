<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use App\Support\AboutContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminWebsiteContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_website_content(): void
    {
        $this->get('/en/admin/content')->assertRedirect(route('login'));
        $this->put(route('admin.content.about'), [])->assertRedirect(route('login'));
    }

    public function test_members_cannot_update_about_content(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->put(route('admin.content.about'), $this->aboutPayload())
            ->assertForbidden();
    }

    public function test_admin_update_is_shown_on_the_about_page(): void
    {
        $admin = User::factory()->admin()->create();
        $payload = $this->aboutPayload([
            'vision_en' => 'A kinder community for people in need.',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.content.about'), $payload)
            ->assertRedirect();

        $this->get('/en/about')
            ->assertSee('A kinder community for people in need.', false);
    }

    public function test_admin_about_form_rejects_an_empty_payload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.content.index'))
            ->put(route('admin.content.about'), [])
            ->assertRedirect(route('admin.content.index'))
            ->assertSessionHasErrors(['vision_en', 'mission_en', 'intro_en', 'objectives_en']);
    }

    /**
     * @param  array<string, string>  $overrides
     * @return array<string, string>
     */
    private function aboutPayload(array $overrides = []): array
    {
        return array_merge([
            'vision_en' => AboutContent::vision()['en'],
            'vision_si' => AboutContent::vision()['si'],
            'vision_ta' => AboutContent::vision()['ta'],
            'mission_en' => AboutContent::mission()['en'],
            'mission_si' => AboutContent::mission()['si'],
            'mission_ta' => AboutContent::mission()['ta'],
            'intro_en' => AboutContent::intro()['en'],
            'intro_si' => AboutContent::intro()['si'],
            'intro_ta' => AboutContent::intro()['ta'],
            'objectives_en' => AboutContent::objectivesText()['en'],
            'objectives_si' => AboutContent::objectivesText()['si'],
            'objectives_ta' => AboutContent::objectivesText()['ta'],
        ], $overrides);
    }
}
