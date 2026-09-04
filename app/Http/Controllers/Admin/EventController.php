<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('admin.events', [
            'events' => Event::query()->orderByDesc('starts_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'starts_at' => ['required', 'date'],
        ]);

        Event::query()->create([
            ...$validated,
            'slug' => Str::slug($validated['title_en']).'-'.Str::random(5),
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'body_en' => $validated['summary_en'],
            'body_si' => $validated['summary_en'],
            'body_ta' => $validated['summary_en'],
            'is_published' => true,
            'registration_open' => true,
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Event $event, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'starts_at' => ['required', 'date'],
        ]);

        $event->update([
            ...$validated,
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Event $event): RedirectResponse
    {
        $event->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
