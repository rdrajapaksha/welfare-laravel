<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectPhoto>
 */
class ProjectPhotoFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'path' => 'projects/photo-'.fake()->unique()->numerify('###').'.jpg',
            'sort_order' => 0,
        ];
    }
}
