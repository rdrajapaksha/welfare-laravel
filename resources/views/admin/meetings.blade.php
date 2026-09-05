@extends('layouts.dash')
@section('title', $d['admin']['meetings'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['meetings'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['admin']['meetingsHint'] }}</p>
<form method="POST" action="{{ route('admin.meetings.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="{{ $d['admin']['meetingTitle'] }}">
    <textarea class="field" name="notes_en" rows="3" required placeholder="{{ $d['dashboard']['meetingNotes'] }}"></textarea>
    <input class="field" name="host_name" required placeholder="{{ $d['admin']['hostName'] }}">
    <input class="field" name="host_address" required placeholder="{{ $d['admin']['hostAddress'] }}">
    <label class="block text-sm font-semibold text-ink-600">{{ $d['admin']['heldAt'] }}</label>
    <input class="field" type="datetime-local" name="held_at" required>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" checked> {{ $d['common']['published'] }}</label>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($meetings as $meeting)
        <form method="POST" action="{{ route('admin.meetings.update', $meeting) }}" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $meeting->title_en) }}">
            <textarea class="field" name="notes_en" rows="3" required>{{ old('notes_en', $meeting->notes_en) }}</textarea>
            <input class="field" name="host_name" required value="{{ old('host_name', $meeting->host_name) }}">
            <input class="field" name="host_address" required value="{{ old('host_address', $meeting->host_address) }}">
            <input class="field" type="datetime-local" name="held_at" required value="{{ old('held_at', $meeting->held_at?->format('Y-m-d\TH:i')) }}">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $meeting->is_published))> {{ $d['common']['published'] }}</label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
<div class="mt-6">{{ $meetings->links() }}</div>
@endsection
