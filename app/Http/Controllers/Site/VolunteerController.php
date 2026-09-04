<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVolunteerRequest;
use App\Models\VolunteerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VolunteerController extends Controller
{
    public function create(): View
    {
        return view('site.volunteer');
    }

    public function store(StoreVolunteerRequest $request): RedirectResponse
    {
        VolunteerApplication::query()->create([
            ...$request->safe()->except(['interests']),
            'interests' => implode(',', $request->validated('interests')),
            'reference' => 'HLA-V-'.strtoupper(Str::random(7)),
            'status' => 'NEW',
        ]);

        return back()->with('status', (string) d('volunteer.successText'));
    }
}
