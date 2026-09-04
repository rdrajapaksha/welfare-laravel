<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery', [
            'albums' => GalleryAlbum::query()->latest('taken_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'cover_image' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:EVENT,COMMUNITY,HIGHLIGHT'],
        ]);

        GalleryAlbum::query()->create([
            ...$validated,
            'slug' => Str::slug($validated['title_en']).'-'.Str::random(5),
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'taken_at' => now(),
            'is_published' => true,
        ]);

        return back()->with('status', (string) d('common.success'));
    }
}
