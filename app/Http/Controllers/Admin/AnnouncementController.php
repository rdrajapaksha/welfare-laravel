<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        return view('admin.announcements', [
            'announcements' => Announcement::query()->latest('published_at')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'body_en' => ['required', 'string'],
            'audience' => ['required', 'in:ALL,MEMBERS,COMMITTEE'],
            'priority' => ['required', 'in:NORMAL,IMPORTANT,URGENT'],
        ]);

        Announcement::query()->create([
            ...$validated,
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'body_si' => $validated['body_en'],
            'body_ta' => $validated['body_en'],
            'is_published' => true,
            'published_at' => now(),
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
