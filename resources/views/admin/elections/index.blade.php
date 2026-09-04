@extends('layouts.dash')
@section('title', $d['admin']['elections'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['elections'] }}</h1>
<form method="POST" action="{{ route('admin.elections.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <select class="field" name="status">
        <option value="DRAFT">DRAFT</option>
        <option value="OPEN">OPEN</option>
        <option value="CLOSED">CLOSED</option>
    </select>
    <input class="field" type="datetime-local" name="opens_at">
    <input class="field" type="datetime-local" name="closes_at">
    <button class="btn btn-brand" type="submit">{{ $d['admin']['createElection'] }}</button>
</form>
<div class="mt-8 space-y-6">
    @foreach ($elections as $election)
        <div class="card-surface p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="font-extrabold">{{ $election->translate('title') }}</p>
                    <p class="text-sm text-ink-500">{{ $election->status }} · {{ $election->candidates_count }} candidates · {{ $election->votes_count }} votes</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <form method="POST" action="{{ route('admin.elections.update', $election) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')
                        <select class="field mt-0" name="status">
                            @foreach (['DRAFT', 'OPEN', 'CLOSED'] as $status)
                                <option value="{{ $status }}" @selected($election->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline h-10" type="submit">{{ $d['common']['save'] }}</button>
                    </form>
                    <a class="font-bold text-brand-700" href="{{ route('admin.elections.report', $election) }}">{{ $d['admin']['electionReport'] }}</a>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.elections.candidates', $election) }}" class="mt-4 grid gap-2 sm:grid-cols-3">
                @csrf
                <input class="field mt-0" name="name" required placeholder="Name">
                <input class="field mt-0" name="position_en" required placeholder="{{ $d['admin']['position'] }}">
                <button class="btn btn-outline" type="submit">{{ $d['admin']['addCandidate'] }}</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
