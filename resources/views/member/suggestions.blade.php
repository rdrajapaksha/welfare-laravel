@extends('layouts.dash')
@section('title', $d['dashboard']['suggestions'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['suggestions'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['dashboard']['suggestionsNote'] }}</p>
<form method="POST" action="{{ route('member.suggestions.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <h2 class="font-extrabold">{{ $d['dashboard']['newSuggestion'] }}</h2>
    <select class="field" name="category" required>
        <option value="SUGGESTION">{{ $d['dashboard']['catSuggestion'] }}</option>
        <option value="IDEA">{{ $d['dashboard']['catIdea'] }}</option>
        <option value="GRIEVANCE">{{ $d['dashboard']['catGrievance'] }}</option>
    </select>
    <input class="field" name="subject" required placeholder="{{ $d['dashboard']['ticketSubject'] }}">
    <textarea class="field" name="body" rows="4" required placeholder="{{ $d['dashboard']['suggestionBody'] }}"></textarea>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_anonymous" value="1"> {{ $d['dashboard']['submitAnonymous'] }}</label>
    <button class="btn btn-brand" type="submit">{{ $d['dashboard']['submitSuggestion'] }}</button>
</form>
<div class="mt-8 space-y-3">
    <h2 class="font-extrabold">{{ $d['dashboard']['mySuggestions'] }}</h2>
    @forelse ($suggestions as $suggestion)
        <div class="card-surface p-4">
            <p class="font-bold">{{ $suggestion->subject }} <span class="text-xs font-semibold text-ink-400">{{ $suggestion->reference }}</span></p>
            <p class="mt-1 text-sm text-ink-600">{{ $suggestion->status }}</p>
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['dashboard']['noSuggestions'] }}</p>
    @endforelse
</div>
@endsection
