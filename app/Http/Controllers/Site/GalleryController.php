<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();

        $albums = GalleryAlbum::published()
            ->with('items')
            ->when($type !== '', function ($query) use ($type) {
                $query->whereHas('items', fn ($items) => $items->where('type', $type));
            })
            ->paginate(12)
            ->withQueryString();

        return view('site.gallery.index', [
            'albums' => $albums,
            'type' => $type,
        ]);
    }

    public function show(string $locale, GalleryAlbum $gallery): View
    {
        abort_unless($gallery->is_published, 404);

        $gallery->load(['items' => fn ($query) => $query->orderBy('sort_order')]);

        return view('site.gallery.show', ['album' => $gallery]);
    }
}
