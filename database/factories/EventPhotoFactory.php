<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventPhoto>
 */
class EventPhotoFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'path' => 'events/photo-'.fake()->unique()->numerify('###').'.jpg',
            'sort_order' => 0,
        ];
    }
}
