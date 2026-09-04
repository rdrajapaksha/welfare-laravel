<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuggestionRequest;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SuggestionController extends Controller
{
    public function index(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        return view('member.suggestions', [
            'suggestions' => $member->suggestions()->where('is_anonymous', false)->latest()->get(),
        ]);
    }

    public function store(StoreSuggestionRequest $request): RedirectResponse
    {
        $member = $request->user()->member;
        abort_if($member === null, 403);

        $anonymous = $request->boolean('is_anonymous');

        $suggestion = Suggestion::query()->create([
            ...$request->safe()->only(['category', 'subject', 'body', 'is_anonymous']),
            'reference' => 'HLA-S-'.strtoupper(Str::random(7)),
            'member_id' => $anonymous ? null : $member->id,
            'status' => 'NEW',
        ]);

        return back()->with('status', d('dashboard.suggestionSuccess').' '.$suggestion->reference);
    }
}
