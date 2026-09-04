@extends('layouts.dash')
@section('title', $d['dashboard']['eVoting'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['eVoting'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['dashboard']['eVotingNote'] }}</p>
@forelse ($elections as $election)
    <div class="card-surface mt-6 p-5">
        <h2 class="text-xl font-extrabold">{{ $election->translate('title') }}</h2>
        <p class="mt-1 text-sm text-ink-600">{{ $election->translate('description') }}</p>
        @if ($votedIds->contains($election->id))
            <p class="mt-4 font-semibold text-teal-800">{{ $d['dashboard']['alreadyVoted'] }}</p>
        @else
            <form method="POST" action="{{ route('member.vote.store', $election) }}" class="mt-4 space-y-3">
                @csrf
                @foreach ($election->candidates as $candidate)
                    <label class="flex items-start gap-3 rounded-xl border border-ink-100 p-3">
                        <input type="radio" name="election_candidate_id" value="{{ $candidate->id }}" required>
                        <span>
                            <span class="font-bold">{{ $candidate->name }}</span>
                            <span class="block text-sm text-ink-500">{{ $candidate->translate('position') }}</span>
                        </span>
                    </label>
                @endforeach
                <button class="btn btn-brand" type="submit">{{ $d['dashboard']['castVote'] }}</button>
            </form>
        @endif
    </div>
@empty
    <p class="mt-6 text-sm text-ink-500">{{ $d['dashboard']['noElections'] }}</p>
@endforelse
@endsection
