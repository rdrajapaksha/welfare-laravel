<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_donation_page_renders(): void
    {
        $this->get('/en/donations')
            ->assertSee('Heart Link Allianze', false)
            ->assertSee('Bandarawela Branch', false)
            ->assertSee('Direct my donation to', false)
            ->assertSee('General welfare fund', false)
            ->assertSee('Send the bank slip on WhatsApp', false)
            ->assertSee('076 818 5377', false)
            ->assertSee('https://wa.me/94768185377', false);
    }

    public function test_donation_page_lists_ongoing_projects_and_hides_completed_ones(): void
    {
        Project::factory()->create(['title_en' => 'Sarana Housing 2026']);
        Project::factory()->completed()->create(['title_en' => 'Finished Well Project']);

        $this->get('/en/donations')
            ->assertSee('Sarana Housing 2026', false)
            ->assertDontSee('Finished Well Project', false);
    }

    public function test_donation_page_preselects_a_community_project(): void
    {
        $project = Project::factory()->create([
            'slug' => 'sarana-housing-2026',
            'title_en' => 'Sarana Housing 2026',
        ]);

        $this->get('/en/donations?project=sarana-housing-2026')
            ->assertSee('Sarana Housing 2026', false)
            ->assertSee('project:'.$project->id, false);
    }

    public function test_project_page_support_link_opens_the_donation_form_for_that_project(): void
    {
        Project::factory()->create([
            'slug' => 'sarana-housing-2026',
            'title_en' => 'Sarana Housing 2026',
        ]);

        $this->get('/en/projects/sarana-housing-2026')
            ->assertSee(locale_url('/donations', ['project' => 'sarana-housing-2026']), false);
    }

    public function test_a_guest_can_submit_a_donation(): void
    {
        $response = $this->post('/en/donations', [
            'donor_name' => 'Priyantha Dias',
            'email' => 'priyantha@example.lk',
            'phone' => '0715550301',
            'amount' => 5000,
            'method' => 'BANK_TRANSFER',
            'purpose' => 'GENERAL',
        ]);

        $donation = Donation::query()->first();

        $this->assertNotNull($donation);
        $response->assertRedirect(route('donations.thanks', $donation));
        $this->assertSame('PENDING', $donation->status);
        $this->assertSame(5000, $donation->amount);
        $this->assertSame('GENERAL', $donation->purpose);
        $this->assertNull($donation->project_id);
    }

    public function test_a_guest_can_direct_a_donation_to_a_community_project(): void
    {
        $project = Project::factory()->create(['title_en' => 'Sarana Housing 2026']);

        $response = $this->post('/en/donations', [
            'donor_name' => 'Priyantha Dias',
            'email' => 'priyantha@example.lk',
            'phone' => '0715550301',
            'amount' => 5000,
            'method' => 'BANK_TRANSFER',
            'destination' => 'project:'.$project->id,
        ]);

        $donation = Donation::query()->first();

        $this->assertNotNull($donation);
        $response->assertRedirect(route('donations.thanks', $donation));
        $this->assertSame('PROJECT', $donation->purpose);
        $this->assertSame($project->id, $donation->project_id);

        $this->get(route('donations.thanks', $donation))
            ->assertSee('Sarana Housing 2026', false)
            ->assertSee('Send the bank slip on WhatsApp', false)
            ->assertSee($donation->reference, false)
            ->assertSee('https://wa.me/94768185377', false);
    }

    public function test_rejects_a_donation_directed_to_a_completed_project(): void
    {
        $project = Project::factory()->completed()->create();

        $this->from('/en/donations')
            ->post('/en/donations', [
                'donor_name' => 'Priyantha Dias',
                'email' => 'priyantha@example.lk',
                'amount' => 5000,
                'method' => 'BANK_TRANSFER',
                'destination' => 'project:'.$project->id,
            ])
            ->assertRedirect('/en/donations')
            ->assertSessionHasErrors('project_id');

        $this->assertSame(0, Donation::query()->count());
    }

    public function test_admin_donations_list_shows_where_the_gift_was_directed(): void
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create(['title_en' => 'Sarana Housing 2026']);
        Donation::factory()->create([
            'donor_name' => 'Priyantha Dias',
            'purpose' => 'PROJECT',
            'project_id' => $project->id,
        ]);

        $this->actingAs($admin)
            ->get('/en/admin/donations')
            ->assertSee('Direct my donation to', false)
            ->assertSee('Sarana Housing 2026', false)
            ->assertSee('Priyantha Dias', false);
    }

    public function test_admin_donations_list_escapes_project_titles(): void
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create([
            'title_en' => '<script>alert(1)</script>Well',
        ]);
        Donation::factory()->create([
            'purpose' => 'PROJECT',
            'project_id' => $project->id,
        ]);

        $this->actingAs($admin)
            ->get('/en/admin/donations')
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('Well', false);
    }
}
