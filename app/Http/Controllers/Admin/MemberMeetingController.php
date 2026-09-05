<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberMeeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberMeetingController extends Controller
{
    public function index(): View
    {
        return view('admin.meetings', [
            'meetings' => MemberMeeting::query()->orderByDesc('held_at')->orderByDesc('id')->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        MemberMeeting::query()->create([
            ...$validated,
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'notes_si' => $validated['notes_en'],
            'notes_ta' => $validated['notes_en'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, MemberMeeting $meeting, Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $meeting->update([
            ...$validated,
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'notes_si' => $validated['notes_en'],
            'notes_ta' => $validated['notes_en'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, MemberMeeting $meeting): RedirectResponse
    {
        $meeting->delete();

        return back()->with('status', (string) d('common.success'));
    }

    /**
     * @return array{title_en: string, notes_en: string, host_name: string, host_address: string, held_at: string}
     */
    private function validated(Request $request): array
    {
        /** @var array{title_en: string, notes_en: string, host_name: string, host_address: string, held_at: string} $validated */
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'notes_en' => ['required', 'string'],
            'host_name' => ['required', 'string', 'max:255'],
            'host_address' => ['required', 'string', 'max:255'],
            'held_at' => ['required', 'date'],
        ]);

        return $validated;
    }
}
