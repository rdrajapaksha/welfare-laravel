<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
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
            'summary_en' => 'A community event hosted by the association.',
            'summary_si' => 'A community event hosted by the association.',
            'summary_ta' => 'A community event hosted by the association.',
            'body_en' => '<p>Members and neighbours are welcome to take part.</p>',
            'body_si' => '<p>Members and neighbours are welcome to take part.</p>',
            'body_ta' => '<p>Members and neighbours are welcome to take part.</p>',
            'venue' => 'HLA Association Hall',
            'city' => 'Bandarawela',
            'starts_at' => now()->addDays(10)->setTime(9, 0),
            'is_published' => true,
            'registration_open' => true,
        ];
    }
}
