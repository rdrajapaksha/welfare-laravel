@extends('layouts.dash')
@section('title', $d['admin']['electionReport'])
@section('content')
<p class="text-sm"><a class="font-semibold text-brand-700" href="{{ route('admin.elections.index') }}">{{ $d['common']['back'] }}</a></p>
<h1 class="mt-2 text-3xl font-extrabold">{{ $election->translate('title') }}</h1>
<p class="mt-2 text-ink-600">{{ $d['admin']['votesCast'] }}: {{ $cast }} · {{ $d['admin']['turnout'] }}: {{ $eligible ? round(($cast / $eligible) * 100) : 0 }}%</p>
<div class="mt-8 space-y-3">
    @foreach ($election->candidates as $candidate)
        <div class="card-surface flex justify-between p-4">
            <div>
                <p class="font-bold">{{ $candidate->name }}</p>
                <p class="text-sm text-ink-500">{{ $candidate->translate('position') }}</p>
            </div>
            <p class="font-extrabold">{{ $candidate->votes->count() }}</p>
        </div>
    @endforeach
</div>
@endsection
