<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use App\Support\AboutContent;
use App\Support\SiteContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminWebsiteContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_website_content(): void
    {
        $this->get('/en/admin/content')->assertRedirect(route('login'));
        $this->put(route('admin.content.about'), [])->assertRedirect(route('login'));
        $this->put(route('admin.content.home'), [])->assertRedirect(route('login'));
        $this->put(route('admin.content.legal'), [])->assertRedirect(route('login'));
        $this->put(route('admin.content.identity'), [])->assertRedirect(route('login'));
    }

    public function test_members_cannot_update_about_content(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->put(route('admin.content.about'), $this->aboutPayload())
            ->assertForbidden();
    }

    public function test_members_cannot_update_homepage_copy(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->put(route('admin.content.home'), $this->homePayload())
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

    public function test_admin_homepage_copy_is_shown_on_the_home_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.content.home'), $this->homePayload([
                'hero_title_en' => 'Neighbours who look after neighbours.',
            ]))
            ->assertRedirect();

        $this->get('/en')
            ->assertSee('Neighbours who look after neighbours.', false);
    }

    public function test_admin_home_form_rejects_an_empty_payload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.content.index'))
            ->put(route('admin.content.home'), [])
            ->assertRedirect(route('admin.content.index'))
            ->assertSessionHasErrors(['hero_title_en', 'cta_title_en', 'footer_about_en']);
    }

    public function test_admin_bank_branch_is_shown_on_the_donations_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.content.identity'), $this->identityPayload([
                'branch' => 'Mahulpotha Town Branch',
            ]))
            ->assertRedirect();

        $this->get('/en/donations')
            ->assertSee('Mahulpotha Town Branch', false)
            ->assertSee(config('hla.bank.account_no'), false);
    }

    public function test_admin_privacy_copy_is_shown_on_the_privacy_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.content.legal'), $this->legalPayload([
                'privacy_en' => 'We keep membership files only for association work.',
            ]))
            ->assertRedirect();

        $this->get('/en/privacy')
            ->assertSee('We keep membership files only for association work.', false);
    }

    /**
     * @param  array<string, string>  $overrides
     * @return array<string, string>
     */
    private function homePayload(array $overrides = []): array
    {
        return array_merge(SiteContent::homeForm(), $overrides);
    }

    /**
     * @param  array<string, string>  $overrides
     * @return array<string, string>
     */
    private function legalPayload(array $overrides = []): array
    {
        return array_merge(SiteContent::legalForm(), $overrides);
    }

    /**
     * @param  array<string, string>  $overrides
     * @return array<string, string>
     */
    private function identityPayload(array $overrides = []): array
    {
        $site = config('hla');

        return array_merge([
            'name' => $site['name'],
            'short_name' => $site['short_name'],
            'registration_no' => $site['registration_no'],
            'street' => $site['contact']['street'],
            'locality' => $site['contact']['locality'],
            'region' => $site['contact']['region'],
            'postal_code' => $site['contact']['postal_code'],
            'phone_display' => $site['contact']['phone_display'],
            'hotline_display' => $site['contact']['hotline_display'],
            'email' => $site['contact']['email'],
            'bank_name' => $site['bank']['bank_name'],
            'branch' => $site['bank']['branch'],
            'account_name' => $site['bank']['account_name'],
            'account_no' => $site['bank']['account_no'],
            'swift' => $site['bank']['swift'],
        ], $overrides);
    }
}
