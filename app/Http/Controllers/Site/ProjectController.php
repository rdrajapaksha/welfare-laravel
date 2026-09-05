<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\CommunityWork;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $theme = strtoupper(request()->string('theme')->toString());
        $selectedTheme = in_array($theme, CommunityWork::themes(), true) ? $theme : null;

        $projects = Project::query()
            ->when($selectedTheme !== null, fn ($query) => $query->where('theme', $selectedTheme))
            ->orderByDesc('completed_at')
            ->orderByDesc('started_at')
            ->orderByDesc('id')
            ->get();

        $grouped = Collection::make(CommunityWork::themes())
            ->mapWithKeys(fn (string $name): array => [$name => $projects->where('theme', $name)->values()])
            ->filter(fn (Collection $items): bool => $items->isNotEmpty());

        return view('site.projects.index', [
            'projects' => $projects,
            'grouped' => $grouped,
            'selectedTheme' => $selectedTheme,
        ]);
    }

    public function show(string $locale, Project $project): View
    {
        $project->load(['allocations', 'photos']);

        return view('site.projects.show', ['project' => $project]);
    }
}
