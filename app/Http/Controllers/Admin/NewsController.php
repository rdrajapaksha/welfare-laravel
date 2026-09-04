<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('admin.news', [
            'posts' => NewsPost::query()->latest('published_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'excerpt_en' => ['required', 'string'],
            'body_en' => ['required', 'string'],
            'category' => ['required', 'in:NEWS,ACTIVITY_REPORT,PRESS'],
        ]);

        NewsPost::query()->create([
            ...$validated,
            'slug' => Str::slug($validated['title_en']).'-'.Str::random(5),
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'excerpt_si' => $validated['excerpt_en'],
            'excerpt_ta' => $validated['excerpt_en'],
            'body_si' => $validated['body_en'],
            'body_ta' => $validated['body_en'],
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, NewsPost $news, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'excerpt_en' => ['required', 'string'],
            'body_en' => ['required', 'string'],
            'category' => ['required', 'in:NEWS,ACTIVITY_REPORT,PRESS'],
        ]);

        $news->update([
            ...$validated,
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'excerpt_si' => $validated['excerpt_en'],
            'excerpt_ta' => $validated['excerpt_en'],
            'body_si' => $validated['body_en'],
            'body_ta' => $validated['body_en'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, NewsPost $news): RedirectResponse
    {
        $news->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
