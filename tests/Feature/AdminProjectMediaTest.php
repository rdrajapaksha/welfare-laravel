<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectPhoto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProjectMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_cannot_add_a_project_photo(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        $project = Project::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.projects.photos.store', $project), [
                'photo' => UploadedFile::fake()->image('site.jpg', 800, 500),
            ])
            ->assertForbidden();

        $this->assertSame(0, $project->photos()->count());
    }

    public function test_admin_can_publish_two_or_three_project_photos_on_the_public_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.projects.store'), [
                'title_en' => 'Sarana Housing 2026',
                'summary_en' => 'Homes for families after the floods.',
                'location' => 'Bandarawela',
                'status' => 'ONGOING',
                'target_amount' => 2500000,
                'cover_image' => UploadedFile::fake()->image('cover.jpg', 800, 500),
                'photos' => [
                    UploadedFile::fake()->image('site-one.jpg', 800, 500),
                    UploadedFile::fake()->image('site-two.jpg', 800, 500),
                ],
            ])
            ->assertRedirect();

        $project = Project::query()->where('title_en', 'Sarana Housing 2026')->first();

        $this->assertNotNull($project);
        $this->assertSame(3, $project->photos()->count());

        foreach ($project->photos as $photo) {
            Storage::disk('public')->assertExists($photo->path);
        }

        $page = $this->get(route('projects.show', $project));

        foreach ($project->photos as $photo) {
            $page->assertSee(media_url($photo->path), false);
        }

        $page->assertSee(locale_url('/donations', ['project' => $project->slug]), false);
    }

    public function test_admin_cannot_add_a_fourth_project_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create();

        foreach (range(1, 3) as $index) {
            $project->photos()->create([
                'path' => 'projects/existing-'.$index.'.jpg',
                'sort_order' => $index,
            ]);
        }

        $this->actingAs($admin)
            ->from(route('admin.projects.index'))
            ->post(route('admin.projects.photos.store', $project), [
                'photo' => UploadedFile::fake()->image('extra.jpg', 640, 480),
            ])
            ->assertRedirect(route('admin.projects.index'))
            ->assertSessionHasErrors('photo');

        $this->assertSame(3, $project->photos()->count());
    }

    public function test_admin_cannot_delete_a_photo_from_another_project(): void
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create();
        $other = Project::factory()->create();
        $photo = ProjectPhoto::factory()->for($other)->create();

        $this->actingAs($admin)
            ->delete(route('admin.projects.photos.destroy', [$project, $photo]))
            ->assertNotFound();

        $this->assertModelExists($photo);
    }

    public function test_replacing_the_cover_keeps_the_gallery_file_in_sync(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create([
            'cover_image' => 'projects/old-cover.jpg',
        ]);
        $project->photos()->create([
            'path' => 'projects/old-cover.jpg',
            'sort_order' => 0,
        ]);
        Storage::disk('public')->put('projects/old-cover.jpg', 'old-cover');

        $this->actingAs($admin)
            ->put(route('admin.projects.update', $project), [
                'title_en' => $project->title_en,
                'summary_en' => $project->summary_en,
                'location' => $project->location,
                'status' => $project->status,
                'target_amount' => $project->target_amount,
                'raised_amount' => $project->raised_amount,
                'cover_image' => UploadedFile::fake()->image('new-cover.jpg', 800, 500),
            ])
            ->assertRedirect();

        $project->refresh()->load('photos');

        $this->assertNotSame('projects/old-cover.jpg', $project->cover_image);
        $this->assertSame($project->cover_image, $project->photos->first()?->path);
        Storage::disk('public')->assertMissing('projects/old-cover.jpg');
        Storage::disk('public')->assertExists($project->cover_image);

        $this->get(route('projects.show', $project))
            ->assertSee(media_url($project->cover_image), false);
    }

    public function test_admin_can_remove_a_project_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create();
        $photo = ProjectPhoto::factory()->for($project)->create([
            'path' => 'projects/remove-me.jpg',
        ]);
        Storage::disk('public')->put($photo->path, 'image');

        $this->actingAs($admin)
            ->delete(route('admin.projects.photos.destroy', [$project, $photo]))
            ->assertRedirect();

        $this->assertSame(0, $project->photos()->count());
        Storage::disk('public')->assertMissing($photo->path);
    }
}
