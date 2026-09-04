<?php

namespace Database\Factories;

use App\Enums\CommitteeBoard;
use App\Models\CommitteeMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommitteeMember>
 */
class CommitteeMemberFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $bio = $name.' serves the current executive committee.';

        return [
            'name' => $name,
            'position_en' => 'Committee Member',
            'position_si' => 'කමිටු සාමාජික',
            'position_ta' => 'குழு உறுப்பினர்',
            'bio_en' => $bio,
            'bio_si' => $bio,
            'bio_ta' => $bio,
            'email' => null,
            'phone' => null,
            'term_from' => 2024,
            'term_to' => 2026,
            'sort_order' => 0,
            'is_current' => true,
            'board' => CommitteeBoard::Executive,
        ];
    }
}
