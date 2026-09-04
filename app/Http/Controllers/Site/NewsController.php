<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category')->toString();

        $posts = NewsPost::published()
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->paginate(9)
            ->withQueryString();

        return view('site.news.index', [
            'posts' => $posts,
            'category' => $category,
        ]);
    }

    public function show(string $locale, NewsPost $news): View
    {
        abort_unless($news->is_published, 404);

        $news->increment('views');

        return view('site.news.show', [
            'post' => $news,
            'related' => NewsPost::published()->where('id', '!=', $news->id)->take(3)->get(),
        ]);
    }
}
