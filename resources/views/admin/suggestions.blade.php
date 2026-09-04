@extends('layouts.dash')
@section('title', $d['admin']['suggestions'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['suggestions'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['admin']['suggestionsHint'] }}</p>
<div class="mt-6 space-y-4">
    @forelse ($suggestions as $suggestion)
        <div class="card-surface p-5">
            <p class="font-extrabold">{{ $suggestion->subject }} <span class="text-sm font-semibold text-ink-400">{{ $suggestion->reference }}</span></p>
            <p class="text-sm text-ink-500">{{ $suggestion->is_anonymous ? $d['dashboard']['anonymous'] : $suggestion->member?->full_name }} · {{ $suggestion->category }}</p>
            <p class="mt-2 whitespace-pre-line text-sm">{{ $suggestion->body }}</p>
            <form method="POST" action="{{ route('admin.suggestions.update', $suggestion) }}" class="mt-3 space-y-2">
                @csrf
                @method('PUT')
                <select class="field" name="status">
                    @foreach (['NEW','REVIEWING','DONE','ARCHIVED'] as $status)
                        <option value="{{ $status }}" @selected($suggestion->status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <textarea class="field" name="admin_note" rows="2" placeholder="{{ $d['admin']['internalNote'] }}">{{ $suggestion->admin_note }}</textarea>
                <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
            </form>
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
<div class="mt-6">{{ $suggestions->links() }}</div>
@endsection
