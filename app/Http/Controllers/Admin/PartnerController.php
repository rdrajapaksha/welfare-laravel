<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Support\PhotoStore;
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
            'logo' => PhotoStore::imageRules(required: true),
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        Partner::query()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::lower(Str::random(4)),
            'tier' => $validated['tier'],
            'logo_url' => PhotoStore::store($request->file('logo'), 'partners'),
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
            'logo' => PhotoStore::imageRules(),
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        $partner->update([
            'name' => $validated['name'],
            'tier' => $validated['tier'],
            'logo_url' => PhotoStore::store($request->file('logo'), 'partners', $partner->logo_url),
            'website' => $validated['website'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Partner $partner): RedirectResponse
    {
        PhotoStore::delete($partner->logo_url);
        $partner->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
