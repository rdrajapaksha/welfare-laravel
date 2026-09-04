<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_cannot_create_a_programme(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->post(route('admin.programmes.store'), [
                'title_en' => 'Emergency school kit grant',
                'summary_en' => 'School books and uniforms for children after a crisis.',
                'category' => 'WELFARE',
                'benefit_amount' => 15000,
            ])
            ->assertForbidden();
    }

    public function test_admin_programme_form_rejects_an_empty_payload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.programmes.index'))
            ->post(route('admin.programmes.store'), [])
            ->assertRedirect(route('admin.programmes.index'))
            ->assertSessionHasErrors(['title_en', 'summary_en', 'category']);
    }

    public function test_admin_can_publish_a_programme_on_the_services_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.programmes.store'), [
                'title_en' => 'Emergency school kit grant',
                'summary_en' => 'School books and uniforms for children after a crisis.',
                'category' => 'WELFARE',
                'benefit_amount' => 15000,
            ])
            ->assertRedirect();

        $this->get('/en/services')
            ->assertSee('Emergency school kit grant', false)
            ->assertSee('School books and uniforms for children after a crisis.', false);
    }

    public function test_admin_can_replace_a_news_headline_on_the_public_page(): void
    {
        $admin = User::factory()->admin()->create();
        $post = NewsPost::query()->create([
            'slug' => 'flood-relief-update',
            'category' => 'NEWS',
            'title_en' => 'Old flood headline',
            'title_si' => 'Old flood headline',
            'title_ta' => 'Old flood headline',
            'excerpt_en' => 'A short excerpt.',
            'excerpt_si' => 'A short excerpt.',
            'excerpt_ta' => 'A short excerpt.',
            'body_en' => 'The full report from the field.',
            'body_si' => 'The full report from the field.',
            'body_ta' => 'The full report from the field.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->actingAs($admin)
            ->put(route('admin.news.update', $post), [
                'title_en' => 'Bandarawela families received dry rations',
                'excerpt_en' => 'A short excerpt.',
                'body_en' => 'The full report from the field.',
                'category' => 'NEWS',
                'is_published' => '1',
            ])
            ->assertRedirect();

        $this->get('/en/news')
            ->assertSee('Bandarawela families received dry rations', false)
            ->assertDontSee('Old flood headline', false);
    }

    public function test_admin_can_publish_an_annual_report_on_the_transparency_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.reports.store'), [
                'year' => 2019,
                'title_en' => 'Annual report 2019',
                'summary_en' => 'Audited accounts for the 2019 financial year.',
                'file' => UploadedFile::fake()->createWithContent(
                    'annual-2019.pdf',
                    "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF\n",
                ),
                'total_income' => 1250000,
                'total_expenditure' => 980000,
                'welfare_spend' => 720000,
                'admin_spend' => 80000,
            ])
            ->assertRedirect();

        $this->get('/en/transparency')
            ->assertSee('Annual report 2019', false)
            ->assertSee('Audited accounts for the 2019 financial year.', false)
            ->assertSee('Download report', false);
    }
}
