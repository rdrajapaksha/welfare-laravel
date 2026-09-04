<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(): View
    {
        return view('admin.programmes', [
            'programmes' => Programme::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'category' => ['required', 'in:WELFARE,EMERGENCY,MEMBER_SUPPORT'],
            'benefit_amount' => ['nullable', 'integer', 'min:0'],
        ]);

        Programme::query()->create([
            'slug' => Str::slug($validated['title_en']).'-'.Str::lower(Str::random(4)),
            'category' => $validated['category'],
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'body_en' => $validated['summary_en'],
            'body_si' => $validated['summary_en'],
            'body_ta' => $validated['summary_en'],
            'eligibility_en' => '',
            'eligibility_si' => '',
            'eligibility_ta' => '',
            'benefit_amount' => $validated['benefit_amount'] ?: null,
            'is_active' => true,
            'sort_order' => Programme::query()->count(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, Programme $programme, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'category' => ['required', 'in:WELFARE,EMERGENCY,MEMBER_SUPPORT'],
            'benefit_amount' => ['nullable', 'integer', 'min:0'],
        ]);

        $programme->update([
            'category' => $validated['category'],
            'title_en' => $validated['title_en'],
            'title_si' => $validated['title_en'],
            'title_ta' => $validated['title_en'],
            'summary_en' => $validated['summary_en'],
            'summary_si' => $validated['summary_en'],
            'summary_ta' => $validated['summary_en'],
            'benefit_amount' => $validated['benefit_amount'] ?: null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, Programme $programme): RedirectResponse
    {
        $programme->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
