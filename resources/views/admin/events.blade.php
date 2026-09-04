@extends('layouts.dash')
@section('title', $d['admin']['events'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['events'] }}</h1>
<form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <textarea class="field" name="summary_en" rows="3" required placeholder="Summary"></textarea>
    <input class="field" name="venue" required placeholder="Venue">
    <input class="field" name="city" required placeholder="City">
    <input class="field" type="datetime-local" name="starts_at" required>
    @include('admin.partials.image-field', ['name' => 'cover_image'])
    <div>
        <label class="label">{{ $d['admin']['eventPhotos'] }}</label>
        <input class="field" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple>
        <p class="mt-1 text-xs text-ink-500">{{ $d['admin']['eventPhotosHint'] }}</p>
        @error('photos')
            <p class="text-sm text-brand-700">{{ $message }}</p>
        @enderror
        @error('photos.*')
            <p class="text-sm text-brand-700">{{ $message }}</p>
        @enderror
    </div>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($events as $event)
        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $event->title_en) }}">
            <textarea class="field" name="summary_en" rows="3" required>{{ old('summary_en', $event->summary_en) }}</textarea>
            <input class="field" name="venue" required value="{{ old('venue', $event->venue) }}">
            <input class="field" name="city" required value="{{ old('city', $event->city) }}">
            <input class="field" type="datetime-local" name="starts_at" required value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}">
            @include('admin.partials.image-field', ['name' => 'cover_image', 'current' => $event->cover_image])
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $event->is_published))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <div class="card-surface -mt-2 space-y-3 p-5">
            <p class="label">{{ $d['admin']['eventPhotos'] }}</p>
            @if ($event->photos->isNotEmpty())
                <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                    @foreach ($event->photos as $photo)
                        <div class="space-y-1">
                            <img src="{{ media_url($photo->path) }}" alt="" class="h-20 w-full rounded-lg object-cover">
                            <form method="POST" action="{{ route('admin.events.photos.destroy', [$event, $photo]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($event->photos->count() < \App\Models\Event::MAX_PHOTOS)
                <form method="POST" action="{{ route('admin.events.photos.store', $event) }}" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <label class="label">{{ $d['admin']['addPhoto'] }}</label>
                    <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp" required>
                    @error('photo')
                        <p class="text-sm text-brand-700">{{ $message }}</p>
                    @enderror
                    <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
                </form>
            @else
                <p class="text-xs text-ink-500">{{ $d['admin']['eventPhotosHint'] }}</p>
            @endif
        </div>
        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
<div class="mt-6">{{ $events->links() }}</div>
@endsection
