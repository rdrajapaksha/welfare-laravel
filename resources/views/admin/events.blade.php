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
<div class="mt-8 space-y-3">
    @foreach ($events as $event)
        <div class="card-surface flex items-center justify-between gap-4 p-4">
            <div>
                <p class="font-bold">{{ $event->translate('title') }}</p>
                <p class="text-sm text-ink-500">{{ $event->starts_at?->format('d M Y H:i') }} · {{ $event->city }}</p>
            </div>
            <form method="POST" action="{{ route('admin.events.destroy', $event) }}">@csrf @method('DELETE')<button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button></form>
        </div>
    @endforeach
</div>
<div class="mt-6">{{ $events->links() }}</div>
@endsection
