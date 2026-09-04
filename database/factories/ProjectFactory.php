<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'title_en' => Str::title($title),
            'title_si' => Str::title($title),
            'title_ta' => Str::title($title),
            'summary_en' => 'A community project delivered with members and partners.',
            'summary_si' => 'A community project delivered with members and partners.',
            'summary_ta' => 'A community project delivered with members and partners.',
            'body_en' => '<p>Work is underway with volunteer labour and audited spending.</p>',
            'body_si' => '<p>Work is underway with volunteer labour and audited spending.</p>',
            'body_ta' => '<p>Work is underway with volunteer labour and audited spending.</p>',
            'location' => 'Bandarawela',
            'target_amount' => 1000000,
            'raised_amount' => 250000,
            'spent_amount' => 100000,
            'beneficiaries' => 20,
            'status' => 'ONGOING',
            'started_at' => now()->subMonth(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'COMPLETED',
            'completed_at' => now()->subWeek(),
        ]);
    }
}
