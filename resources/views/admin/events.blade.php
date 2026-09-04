@extends('layouts.dash')
@section('title', $d['admin']['events'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['events'] }}</h1>
<form method="POST" action="{{ route('admin.events.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <textarea class="field" name="summary_en" rows="3" required placeholder="Summary"></textarea>
    <input class="field" name="venue" required placeholder="Venue">
    <input class="field" name="city" required placeholder="City">
    <input class="field" type="datetime-local" name="starts_at" required>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($events as $event)
        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $event->title_en) }}">
            <textarea class="field" name="summary_en" rows="3" required>{{ old('summary_en', $event->summary_en) }}</textarea>
            <input class="field" name="venue" required value="{{ old('venue', $event->venue) }}">
            <input class="field" name="city" required value="{{ old('city', $event->city) }}">
            <input class="field" type="datetime-local" name="starts_at" required value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}">
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $event->is_published))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
<div class="mt-6">{{ $events->links() }}</div>
@endsection
