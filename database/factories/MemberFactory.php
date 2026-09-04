<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'membership_no' => 'HLA-'.fake()->unique()->numberBetween(2000, 9999),
            'full_name' => $name,
            'name_with_initials' => $name,
            'nic' => fake()->unique()->numerify('19##########'),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['MALE', 'FEMALE']),
            'civil_status' => 'MARRIED',
            'occupation' => 'Teacher',
            'address_line1' => fake()->streetAddress(),
            'city' => 'Bandarawela',
            'district' => 'Badulla',
            'phone' => '077'.fake()->numerify('#######'),
            'email' => fake()->unique()->safeEmail(),
            'membership_type' => 'ORDINARY',
            'status' => 'ACTIVE',
            'joined_at' => now()->subMonths(6),
            'show_in_directory' => true,
            'user_id' => null,
        ];
    }

    public function forUser(?User $user = null): static
    {
        return $this->state(function () use ($user) {
            $user ??= User::factory()->create();

            return [
                'user_id' => $user->id,
                'email' => $user->email,
                'full_name' => $user->name,
            ];
        });
    }
}
