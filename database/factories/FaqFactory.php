<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = fake()->sentence().'?';
        $answer = fake()->paragraph();

        return [
            'category' => 'GENERAL',
            'question_en' => $question,
            'question_si' => $question,
            'question_ta' => $question,
            'answer_en' => $answer,
            'answer_si' => $answer,
            'answer_ta' => $answer,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}
