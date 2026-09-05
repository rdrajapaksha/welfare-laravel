<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\MemberMeeting;
use App\Models\Project;
use App\Support\CommunityWork;
use Database\Seeders\CommunityWorkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityWorkTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_projects_page_shows_real_completed_work_and_hides_retired_demo_titles(): void
    {
        Project::factory()->create([
            'slug' => 'sarana-housing-2026',
            'title_en' => 'Sarana Housing 2026',
        ]);

        $this->seed(CommunityWorkSeeder::class);

        $this->get('/en/projects')
            ->assertOk()
            ->assertSee('Relief Aid for Displaced Communities', false)
            ->assertSee('Medical Camp at B/ Dharmashoka College', false)
            ->assertSee('Disaster relief', false)
            ->assertDontSee('Sarana Housing 2026', false)
            ->assertDontSee('8/2 Helahinna', false);

        $relief = Project::query()->where('slug', 'relief-aid-bandarawela-2025')->firstOrFail();

        $this->get('/si/projects')
            ->assertOk()
            ->assertSee($relief->title_si, false);

        $this->get('/en/projects?theme=HEALTH')
            ->assertOk()
            ->assertSee('Medical Camp at B/ Dharmashoka College', false)
            ->assertDontSee('Relief Aid for Displaced Communities', false);
    }

    public function test_completed_project_page_hides_empty_fundraising_totals(): void
    {
        $this->seed(CommunityWorkSeeder::class);

        $this->get('/en/projects/relief-aid-bandarawela-2025')
            ->assertOk()
            ->assertSee('Mr. Irosh Rathnayake', false)
            ->assertDontSee('Raised:', false)
            ->assertDontSee('Target:', false)
            ->assertDontSee(locale_url('/donations', ['project' => 'relief-aid-bandarawela-2025']), false);
    }

    public function test_home_page_shows_completed_community_work_without_empty_fundraising(): void
    {
        $this->seed(CommunityWorkSeeder::class);

        $this->get('/en')
            ->assertOk()
            ->assertSee('Recent community work', false)
            ->assertSee('Monthly Financial Assistance for Medical Treatment', false)
            ->assertDontSee('Raised Rs.', false);
    }

    public function test_seeder_clears_retired_project_links_from_donations(): void
    {
        $retired = Project::factory()->create([
            'slug' => 'pahana-scholarship-fund',
            'title_en' => 'Pahana Scholarship Fund',
        ]);
        $donation = Donation::factory()->create(['project_id' => $retired->id]);

        $this->seed(CommunityWorkSeeder::class);

        $this->assertDatabaseMissing('projects', ['slug' => 'pahana-scholarship-fund']);
        $this->assertNull($donation->fresh()->project_id);
        $this->assertCount(12, CommunityWork::projects());
        $this->assertSame(12, Project::query()->count());
        $this->assertSame(5, MemberMeeting::query()->count());

        $sports = collect(CommunityWork::projects())->firstWhere('slug', 'bandarawela-ds-sports-festival');
        $this->assertIsArray($sports);
        $this->assertStringNotContainsString("\u{FFFD}", (string) $sports['body_si']);
        $this->assertStringNotContainsString('success.', (string) $sports['body_si']);
    }
}
