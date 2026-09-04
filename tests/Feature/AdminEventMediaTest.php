<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventPhoto;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminEventMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_cannot_add_an_event_photo(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        $event = Event::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.events.photos.store', $event), [
                'photo' => UploadedFile::fake()->image('camp.jpg', 800, 500),
            ])
            ->assertForbidden();

        $this->assertSame(0, $event->photos()->count());
    }

    public function test_admin_can_publish_multiple_event_photos_on_the_public_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.events.store'), [
                'title_en' => 'Mobile medical camp Kandy',
                'summary_en' => 'Doctors and volunteers serve families at the school grounds.',
                'venue' => 'Peradeniya Maha Vidyalaya grounds',
                'city' => 'Kandy',
                'starts_at' => now()->addDays(12)->format('Y-m-d H:i:s'),
                'cover_image' => UploadedFile::fake()->image('cover.jpg', 800, 500),
                'photos' => [
                    UploadedFile::fake()->image('camp-one.jpg', 800, 500),
                    UploadedFile::fake()->image('camp-two.jpg', 800, 500),
                    UploadedFile::fake()->image('camp-three.jpg', 800, 500),
                    UploadedFile::fake()->image('camp-four.jpg', 800, 500),
                ],
            ])
            ->assertRedirect();

        $event = Event::query()->where('title_en', 'Mobile medical camp Kandy')->first();

        $this->assertNotNull($event);
        $this->assertSame(5, $event->photos()->count());

        foreach ($event->photos as $photo) {
            Storage::disk('public')->assertExists($photo->path);
        }

        $page = $this->get(route('events.show', $event));

        foreach ($event->photos as $photo) {
            $page->assertSee(media_url($photo->path), false);
        }
    }

    public function test_admin_cannot_add_a_sixth_event_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();

        foreach (range(1, 5) as $index) {
            $event->photos()->create([
                'path' => 'events/existing-'.$index.'.jpg',
                'sort_order' => $index,
            ]);
        }

        $this->actingAs($admin)
            ->from(route('admin.events.index'))
            ->post(route('admin.events.photos.store', $event), [
                'photo' => UploadedFile::fake()->image('extra.jpg', 640, 480),
            ])
            ->assertRedirect(route('admin.events.index'))
            ->assertSessionHasErrors('photo');

        $this->assertSame(5, $event->photos()->count());
    }

    public function test_admin_cannot_delete_a_photo_from_another_event(): void
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();
        $other = Event::factory()->create();
        $photo = EventPhoto::factory()->for($other)->create();

        $this->actingAs($admin)
            ->delete(route('admin.events.photos.destroy', [$event, $photo]))
            ->assertNotFound();

        $this->assertModelExists($photo);
    }
}
