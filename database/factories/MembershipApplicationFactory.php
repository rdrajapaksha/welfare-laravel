<?php

namespace Database\Factories;

use App\Models\MembershipApplication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<MembershipApplication>
 */
class MembershipApplicationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_no' => 'HLA-A-'.strtoupper(Str::random(7)),
            'full_name' => fake()->name(),
            'nic' => fake()->unique()->numerify('19##########'),
            'date_of_birth' => '1990-01-15',
            'gender' => 'FEMALE',
            'occupation' => 'Nurse',
            'address_line1' => '12 Lake Road',
            'city' => 'Maharagama',
            'district' => 'Colombo',
            'phone' => '0775550101',
            'email' => fake()->unique()->safeEmail(),
            'membership_type' => 'ORDINARY',
            'motivation' => 'I want to support welfare work.',
            'status' => 'PENDING',
        ];
    }
}
