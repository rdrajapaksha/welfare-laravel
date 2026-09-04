<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        return view('admin.documents', [
            'documents' => Document::query()->latest('published_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:40'],
            'file_url' => ['required', 'string', 'max:255'],
        ]);

        Document::query()->create([
            'slug' => Str::slug($validated['title_en']).'-'.Str::lower(Str::random(4)),
            'category' => $validated['category'],
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'description_en' => '',
            'description_si' => '',
            'description_ta' => '',
            'file_url' => $validated['file_url'],
            'file_type' => 'pdf',
            'members_only' => $request->boolean('members_only'),
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Document $document, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:40'],
            'file_url' => ['required', 'string', 'max:255'],
        ]);

        $document->update([
            'category' => $validated['category'],
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'file_url' => $validated['file_url'],
            'members_only' => $request->boolean('members_only'),
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Document $document): RedirectResponse
    {
        $document->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
