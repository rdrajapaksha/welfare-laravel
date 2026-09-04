<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        return view('admin.partners', [
            'partners' => Partner::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tier' => ['required', 'string', 'max:40'],
            'logo_url' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        Partner::query()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::lower(Str::random(4)),
            'tier' => $validated['tier'],
            'logo_url' => $validated['logo_url'],
            'website' => $validated['website'] ?? null,
            'is_active' => true,
            'sort_order' => Partner::query()->count(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Partner $partner, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tier' => ['required', 'string', 'max:40'],
            'logo_url' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        $partner->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Partner $partner): RedirectResponse
    {
        $partner->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
