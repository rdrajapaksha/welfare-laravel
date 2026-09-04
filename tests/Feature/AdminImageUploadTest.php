<?php

namespace Tests\Feature;

use App\Models\GalleryAlbum;
use App\Models\Member;
use App\Models\NewsPost;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_cannot_upload_a_gallery_cover(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->post(route('admin.gallery.store'), [
                'title_en' => 'Flood relief 2026',
                'category' => 'COMMUNITY',
                'cover_image' => UploadedFile::fake()->image('flood.jpg', 800, 500),
            ])
            ->assertForbidden();

        $this->assertSame(0, GalleryAlbum::query()->count());
    }

    public function test_gallery_form_rejects_a_missing_cover_image(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.gallery.index'))
            ->post(route('admin.gallery.store'), [
                'title_en' => 'Flood relief 2026',
                'category' => 'COMMUNITY',
            ])
            ->assertRedirect(route('admin.gallery.index'))
            ->assertSessionHasErrors('cover_image');

        $this->assertSame(0, GalleryAlbum::query()->count());
    }

    public function test_admin_can_upload_a_gallery_cover_from_their_computer(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.gallery.store'), [
                'title_en' => 'Flood relief 2026',
                'category' => 'COMMUNITY',
                'cover_image' => UploadedFile::fake()->image('flood.jpg', 800, 500),
            ])
            ->assertRedirect();

        $album = GalleryAlbum::query()->where('title_en', 'Flood relief 2026')->first();

        $this->assertNotNull($album);
        $this->assertNotNull($album->cover_image);
        Storage::disk('public')->assertExists($album->cover_image);

        $this->get('/en/gallery')
            ->assertSee('Flood relief 2026', false)
            ->assertSee(media_url($album->cover_image), false);
    }

    public function test_admin_can_add_another_photo_to_a_gallery_album(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $album = GalleryAlbum::query()->create([
            'slug' => 'medical-camps',
            'category' => 'EVENT',
            'title_en' => 'Medical camps',
            'title_si' => 'Medical camps',
            'title_ta' => 'Medical camps',
            'cover_image' => '/media/medical-camp.svg',
            'taken_at' => now(),
            'is_published' => true,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.gallery.items.store', $album), [
                'photo' => UploadedFile::fake()->image('camp.jpg', 640, 480),
            ])
            ->assertRedirect();

        $item = $album->items()->first();

        $this->assertNotNull($item);
        Storage::disk('public')->assertExists($item->url);

        $this->get(route('gallery.show', $album))
            ->assertSee(media_url($item->url), false);
    }

    public function test_admin_can_publish_a_news_cover_on_the_public_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.news.store'), [
                'title_en' => 'Bandarawela dry ration drive',
                'excerpt_en' => 'Families received dry rations after the floods.',
                'body_en' => 'The full report from the field.',
                'category' => 'NEWS',
                'cover_image' => UploadedFile::fake()->image('rations.jpg', 800, 500),
            ])
            ->assertRedirect();

        $post = NewsPost::query()->where('title_en', 'Bandarawela dry ration drive')->first();

        $this->assertNotNull($post);
        Storage::disk('public')->assertExists($post->cover_image);

        $this->get('/en/news')
            ->assertSee('Bandarawela dry ration drive', false)
            ->assertSee(media_url($post->cover_image), false);
    }

    public function test_admin_can_upload_a_partner_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.partners.store'), [
                'name' => 'Uva Provincial Council',
                'tier' => 'GOVERNMENT',
                'website' => 'https://example.lk',
                'logo' => UploadedFile::fake()->image('partner.png', 200, 80),
            ])
            ->assertRedirect();

        $partner = Partner::query()->where('name', 'Uva Provincial Council')->first();

        $this->assertNotNull($partner);
        Storage::disk('public')->assertExists($partner->logo_url);

        $this->get('/en/partners')
            ->assertSee('Uva Provincial Council', false)
            ->assertSee(media_url($partner->logo_url), false);
    }
}
