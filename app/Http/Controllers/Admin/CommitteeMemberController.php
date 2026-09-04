<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommitteeBoard;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteeMemberRequest;
use App\Models\CommitteeMember;
use Illuminate\Http\RedirectResponse;

class CommitteeMemberController extends Controller
{
    public function store(StoreCommitteeMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $board = CommitteeBoard::from($validated['board']);

        CommitteeMember::query()->create([
            'name' => $validated['name'],
            'position_en' => $validated['position_en'],
            'position_si' => $validated['position_si'] !== '' ? $validated['position_si'] : $validated['position_en'],
            'position_ta' => $validated['position_ta'] !== '' ? $validated['position_ta'] : $validated['position_en'],
            'bio_en' => $validated['bio_en'] ?? '',
            'bio_si' => ($validated['bio_si'] ?? '') !== '' ? $validated['bio_si'] : ($validated['bio_en'] ?? ''),
            'bio_ta' => ($validated['bio_ta'] ?? '') !== '' ? $validated['bio_ta'] : ($validated['bio_en'] ?? ''),
            'phone' => $validated['phone'] ?? null,
            'term_from' => $validated['term_from'],
            'term_to' => $validated['term_to'] ?? null,
            'board' => $board,
            'is_current' => true,
            'sort_order' => CommitteeMember::query()->where('board', $board)->count(),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function update(string $locale, CommitteeMember $committeeMember, StoreCommitteeMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $committeeMember->update([
            'name' => $validated['name'],
            'position_en' => $validated['position_en'],
            'position_si' => $validated['position_si'] !== '' ? $validated['position_si'] : $validated['position_en'],
            'position_ta' => $validated['position_ta'] !== '' ? $validated['position_ta'] : $validated['position_en'],
            'bio_en' => $validated['bio_en'] ?? '',
            'bio_si' => ($validated['bio_si'] ?? '') !== '' ? $validated['bio_si'] : ($validated['bio_en'] ?? ''),
            'bio_ta' => ($validated['bio_ta'] ?? '') !== '' ? $validated['bio_ta'] : ($validated['bio_en'] ?? ''),
            'phone' => $validated['phone'] ?? null,
            'term_from' => $validated['term_from'],
            'term_to' => $validated['term_to'] ?? null,
            'board' => CommitteeBoard::from($validated['board']),
            'is_current' => $request->boolean('is_current'),
        ]);

        return back()->with('status', (string) d('common.success'));
    }

    public function destroy(string $locale, CommitteeMember $committeeMember): RedirectResponse
    {
        $committeeMember->delete();

        return back()->with('status', (string) d('common.success'));
    }
}
