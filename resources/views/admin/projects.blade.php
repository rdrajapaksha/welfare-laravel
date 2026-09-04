@extends('layouts.dash')
@section('title', $d['admin']['projects'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['projects'] }}</h1>
<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <textarea class="field" name="summary_en" rows="3" required placeholder="Summary"></textarea>
    <input class="field" name="location" required placeholder="Location">
    <select class="field" name="status">
        <option value="PLANNED">PLANNED</option>
        <option value="ONGOING">ONGOING</option>
        <option value="COMPLETED">COMPLETED</option>
    </select>
    <input class="field" type="number" name="target_amount" min="0" required placeholder="Target (LKR)">
    <input class="field" type="number" name="raised_amount" min="0" placeholder="Raised (LKR)">
    @include('admin.partials.image-field', ['name' => 'cover_image'])
    <div>
        <label class="label">{{ $d['admin']['projectPhotos'] }}</label>
        <input class="field" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple>
        <p class="mt-1 text-xs text-ink-500">{{ $d['admin']['projectPhotosHint'] }}</p>
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
    @foreach ($projects as $project)
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $project->title_en) }}">
            <textarea class="field" name="summary_en" rows="3" required>{{ old('summary_en', $project->summary_en) }}</textarea>
            <input class="field" name="location" required value="{{ old('location', $project->location) }}">
            <select class="field" name="status">
                @foreach (['PLANNED', 'ONGOING', 'COMPLETED'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <input class="field" type="number" name="target_amount" min="0" required value="{{ old('target_amount', $project->target_amount) }}">
            <input class="field" type="number" name="raised_amount" min="0" value="{{ old('raised_amount', $project->raised_amount) }}">
            @include('admin.partials.image-field', ['name' => 'cover_image', 'current' => $project->cover_image])
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <div class="card-surface -mt-2 space-y-3 p-5">
            <p class="label">{{ $d['admin']['projectPhotos'] }}</p>
            @if ($project->photos->isNotEmpty())
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($project->photos as $photo)
                        <div class="space-y-1">
                            <img src="{{ media_url($photo->path) }}" alt="" class="h-20 w-full rounded-lg object-cover">
                            <form method="POST" action="{{ route('admin.projects.photos.destroy', [$project, $photo]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($project->photos->count() < \App\Models\Project::MAX_PHOTOS)
                <form method="POST" action="{{ route('admin.projects.photos.store', $project) }}" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <label class="label">{{ $d['admin']['addPhoto'] }}</label>
                    <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp" required>
                    @error('photo')
                        <p class="text-sm text-brand-700">{{ $message }}</p>
                    @enderror
                    <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
                </form>
            @else
                <p class="text-xs text-ink-500">{{ $d['admin']['projectPhotosHint'] }}</p>
            @endif
        </div>
        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
@endsection
