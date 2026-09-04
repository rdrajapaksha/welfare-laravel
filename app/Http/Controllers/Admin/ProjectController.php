<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects', [
            'projects' => Project::query()->latest('started_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:PLANNED,ONGOING,COMPLETED'],
            'target_amount' => ['required', 'integer', 'min:0'],
            'raised_amount' => ['nullable', 'integer', 'min:0'],
        ]);

        Project::query()->create([
            'slug' => Str::slug($validated['title_en']).'-'.Str::lower(Str::random(4)),
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'body_en' => $validated['summary_en'],
            'body_si' => $validated['summary_en'],
            'body_ta' => $validated['summary_en'],
            'location' => $validated['location'],
            'status' => $validated['status'],
            'target_amount' => $validated['target_amount'],
            'raised_amount' => $validated['raised_amount'] ?? 0,
            'spent_amount' => 0,
            'started_at' => now(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Project $project, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:PLANNED,ONGOING,COMPLETED'],
            'target_amount' => ['required', 'integer', 'min:0'],
            'raised_amount' => ['nullable', 'integer', 'min:0'],
        ]);

        $project->update([
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'location' => $validated['location'],
            'status' => $validated['status'],
            'target_amount' => $validated['target_amount'],
            'raised_amount' => $validated['raised_amount'] ?? $project->raised_amount,
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Project $project): RedirectResponse
    {
        $project->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
