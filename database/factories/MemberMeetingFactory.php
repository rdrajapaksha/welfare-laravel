<?php

namespace Database\Factories;

use App\Models\MemberMeeting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberMeeting>
 */
class MemberMeetingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = 'Monthly member meeting';

        return [
            'title_en' => $title,
            'title_si' => $title,
            'title_ta' => $title,
            'notes_en' => 'Hosted at a member home.',
            'notes_si' => 'Hosted at a member home.',
            'notes_ta' => 'Hosted at a member home.',
            'host_name' => 'Kamal Perera',
            'host_address' => '8/2 Helahinna, Bandarawela',
            'held_at' => now()->addWeek(),
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
        ]);
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes): array => [
            'held_at' => now()->subMonth(),
        ]);
    }
}
