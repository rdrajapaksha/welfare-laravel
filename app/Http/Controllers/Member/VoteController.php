<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoteRequest;
use App\Models\Election;
use App\Models\ElectionVote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VoteController extends Controller
{
    public function index(): View
    {
        $member = request()->user()->member;
        abort_if($member === null, 403);

        $elections = Election::open()->with('candidates')->get();

        return view('member.vote', [
            'elections' => $elections,
            'votedIds' => $member->votes()->pluck('election_id'),
        ]);
    }

    public function store(string $locale, StoreVoteRequest $request, Election $election): RedirectResponse
    {
        $member = $request->user()->member;
        abort_if($member === null, 403);
        abort_unless($election->isOpen(), 403);

        if ($member->votes()->where('election_id', $election->id)->exists()) {
            return back()->with('error', (string) d('dashboard.alreadyVoted'));
        }

        $candidateId = $request->integer('election_candidate_id');
        abort_unless($election->candidates()->where('id', $candidateId)->exists(), 404);

        ElectionVote::query()->create([
            'election_id' => $election->id,
            'election_candidate_id' => $candidateId,
            'member_id' => $member->id,
        ]);

        return back()->with('status', (string) d('dashboard.voteSuccess'));
    }
}
