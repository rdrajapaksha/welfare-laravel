<?php

namespace Database\Factories;

use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Election>
 */
class ElectionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = 'AGM '.fake()->unique()->numberBetween(2024, 2035);

        return [
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'title_en' => $title,
            'title_si' => $title,
            'title_ta' => $title,
            'description_en' => 'Committee election.',
            'description_si' => 'Committee election.',
            'description_ta' => 'Committee election.',
            'status' => 'DRAFT',
            'opens_at' => now()->subDay(),
            'closes_at' => now()->addDays(14),
        ];
    }

    public function open(): static
    {
        return $this->state(fn (): array => [
            'status' => 'OPEN',
            'opens_at' => now()->subDay(),
            'closes_at' => now()->addDays(14),
        ]);
    }
}
