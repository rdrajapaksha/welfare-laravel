<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ElectionController extends Controller
{
    public function index(): View
    {
        return view('admin.elections.index', [
            'elections' => Election::query()->withCount('votes', 'candidates')->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:DRAFT,OPEN,CLOSED'],
            'opens_at' => ['nullable', 'date'],
            'closes_at' => ['nullable', 'date'],
        ]);

        Election::query()->create([
            ...$validated,
            'slug' => Str::slug($validated['title_en']).'-'.Str::random(5),
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:DRAFT,OPEN,CLOSED'],
        ]);

        $election->update($validated);

        return back()->with('status', (string) d('common.success'));
    }

    public function addCandidate(string $locale, Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position_en' => ['required', 'string', 'max:255'],
        ]);

        $election->candidates()->create([
            ...$validated,
            'position_si' => $validated['position_en'],
            'position_ta' => $validated['position_en'],
            'sort_order' => $election->candidates()->count(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function report(string $locale, Election $election): View
    {
        $election->load('candidates.votes');
        $eligible = Member::query()->where('status', 'ACTIVE')->count();
        $cast = $election->votes()->count();

        return view('admin.elections.report', [
            'election' => $election,
            'eligible' => $eligible,
            'cast' => $cast,
        ]);
    }
}
