<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommitteeBoard;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteeMemberRequest;
use App\Models\CommitteeMember;
use App\Support\PhotoStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommitteeMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.committee', [
            'executive' => CommitteeMember::query()->executive()->orderBy('sort_order')->orderBy('id')->get(),
            'advisory' => CommitteeMember::query()->advisory()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(string $locale, StoreCommitteeMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $board = CommitteeBoard::from($validated['board']);

        CommitteeMember::query()->create([
            ...$this->translatedFields($validated),
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'term_from' => $validated['term_from'],
            'term_to' => $validated['term_to'] ?? null,
            'board' => $board,
            'is_current' => true,
            'sort_order' => $validated['sort_order'] ?? CommitteeMember::query()->where('board', $board)->count(),
            'photo_url' => PhotoStore::store($request->file('photo'), 'committee'),
        ]);

        return redirect()->route('admin.committee.index')->with('status', (string) d('admin.officerSaved'));
    }

    public function update(string $locale, CommitteeMember $committeeMember, StoreCommitteeMemberRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $committeeMember->update([
            ...$this->translatedFields($validated),
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'term_from' => $validated['term_from'],
            'term_to' => $validated['term_to'] ?? null,
            'board' => CommitteeBoard::from($validated['board']),
            'is_current' => $request->boolean('is_current'),
            'sort_order' => $validated['sort_order'] ?? $committeeMember->sort_order,
            'photo_url' => PhotoStore::store($request->file('photo'), 'committee', $committeeMember->photo_url),
        ]);

        return redirect()->route('admin.committee.index')->with('status', (string) d('admin.officerSaved'));
    }

    public function destroy(string $locale, CommitteeMember $committeeMember): RedirectResponse
    {
        PhotoStore::delete($committeeMember->photo_url);
        $committeeMember->delete();

        return redirect()->route('admin.committee.index')->with('status', (string) d('admin.officerRemoved'));
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function translatedFields(array $validated): array
    {
        return [
            'name' => $validated['name'],
            'position_en' => $validated['position_en'],
            'position_si' => $validated['position_si'] !== '' ? $validated['position_si'] : $validated['position_en'],
            'position_ta' => $validated['position_ta'] !== '' ? $validated['position_ta'] : $validated['position_en'],
            'bio_en' => $validated['bio_en'] ?? '',
            'bio_si' => ($validated['bio_si'] ?? '') !== '' ? $validated['bio_si'] : ($validated['bio_en'] ?? ''),
            'bio_ta' => ($validated['bio_ta'] ?? '') !== '' ? $validated['bio_ta'] : ($validated['bio_en'] ?? ''),
        ];
    }
}
