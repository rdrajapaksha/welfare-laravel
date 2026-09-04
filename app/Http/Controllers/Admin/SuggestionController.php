<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuggestionController extends Controller
{
    public function index(): View
    {
        return view('admin.suggestions', [
            'suggestions' => Suggestion::query()->with('member')->latest()->paginate(20),
        ]);
    }

    public function update(string $locale, Request $request, Suggestion $suggestion): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:NEW,REVIEWING,DONE,ARCHIVED'],
            'admin_note' => ['nullable', 'string'],
        ]);

        $suggestion->update($validated);

        return back()->with('status', (string) d('common.success'));
    }
}
