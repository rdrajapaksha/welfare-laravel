<?php

namespace Database\Factories;

use App\Models\Programme;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Programme>
 */
class ProgrammeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(4)),
            'category' => 'WELFARE',
            'title_en' => $title,
            'title_si' => $title,
            'title_ta' => $title,
            'summary_en' => fake()->sentence(),
            'summary_si' => fake()->sentence(),
            'summary_ta' => fake()->sentence(),
            'body_en' => fake()->paragraph(),
            'body_si' => fake()->paragraph(),
            'body_ta' => fake()->paragraph(),
            'icon' => 'heart',
            'benefit_amount' => 15000,
            'eligibility_en' => 'Members in good standing.',
            'eligibility_si' => 'Members in good standing.',
            'eligibility_ta' => 'Members in good standing.',
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
