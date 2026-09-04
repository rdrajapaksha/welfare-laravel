<?php

namespace Database\Factories;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Donation>
 */
class DonationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => 'HLA-D-'.strtoupper(Str::random(8)),
            'donor_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '0771234567',
            'amount' => 5000,
            'currency' => 'LKR',
            'method' => 'BANK_TRANSFER',
            'purpose' => 'GENERAL',
            'status' => 'PENDING',
            'is_anonymous' => false,
            'is_recurring' => false,
        ];
    }
}
