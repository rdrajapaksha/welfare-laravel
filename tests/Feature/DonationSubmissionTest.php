<?php

namespace Tests\Feature;

use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_donation_page_renders(): void
    {
        $this->get('/en/donations')
            ->assertSee('Heart Link Allianze', false)
            ->assertSee('Bandarawela Branch', false);
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
    }
}
