<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('site.projects.index', [
            'projects' => Project::query()->orderByDesc('started_at')->get(),
        ]);
    }

    public function show(string $locale, Project $project): View
    {
        $project->load(['allocations', 'photos']);

        return view('site.projects.show', ['project' => $project]);
    }
}
