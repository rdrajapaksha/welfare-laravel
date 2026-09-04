<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Support\PhotoStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery', [
            'albums' => GalleryAlbum::query()->with('items')->latest('taken_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'cover_image' => PhotoStore::imageRules(required: true),
            'category' => ['required', 'in:EVENT,COMMUNITY,HIGHLIGHT'],
        ]);

        $path = PhotoStore::store($request->file('cover_image'), 'gallery');

        $album = GalleryAlbum::query()->create([
            'slug' => Str::slug($validated['title_en']).'-'.Str::random(5),
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'cover_image' => $path,
            'category' => $validated['category'],
            'taken_at' => now(),
            'is_published' => true,
        ]);

        $album->items()->create([
            'type' => 'PHOTO',
            'url' => $path,
            'sort_order' => 0,
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, GalleryAlbum $gallery, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'cover_image' => PhotoStore::imageRules(),
            'category' => ['required', 'in:EVENT,COMMUNITY,HIGHLIGHT'],
        ]);

        $gallery->update([
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'cover_image' => PhotoStore::store($request->file('cover_image'), 'gallery', $gallery->cover_image),
            'category' => $validated['category'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, GalleryAlbum $gallery): RedirectResponse
    {
        $gallery->load('items');

        foreach ($gallery->items as $item) {
            PhotoStore::delete($item->url);
        }

        PhotoStore::delete($gallery->cover_image);
        $gallery->delete();

        return back()->with('status', (string) d('common.success'));
    }

    public function storeItem(string $locale, GalleryAlbum $gallery, Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => PhotoStore::imageRules(required: true),
        ]);

        $path = PhotoStore::store($request->file('photo'), 'gallery');

        $gallery->items()->create([
            'type' => 'PHOTO',
            'url' => $path,
            'sort_order' => $gallery->items()->count(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroyItem(string $locale, GalleryAlbum $gallery, GalleryItem $item): RedirectResponse
    {
        abort_unless($item->gallery_album_id === $gallery->id, 404);

        PhotoStore::delete($item->url);
        $item->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
