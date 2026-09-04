@extends('layouts.dash')
@section('title', $d['admin']['gallery'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['gallery'] }}</h1>
<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    @include('admin.partials.image-field', ['name' => 'cover_image', 'required' => true])
    <select class="field" name="category">
        <option value="EVENT">EVENT</option>
        <option value="COMMUNITY">COMMUNITY</option>
        <option value="HIGHLIGHT">HIGHLIGHT</option>
    </select>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 grid gap-4 sm:grid-cols-2">
    @foreach ($albums as $album)
        <div class="card-surface overflow-hidden">
            <img src="{{ media_url($album->cover_image) }}" alt="" class="h-36 w-full object-cover">
            <form method="POST" action="{{ route('admin.gallery.update', $album) }}" enctype="multipart/form-data" class="space-y-3 p-4">
                @csrf
                @method('PUT')
                <input class="field" name="title_en" required value="{{ old('title_en', $album->title_en) }}">
                @include('admin.partials.image-field', ['name' => 'cover_image', 'current' => $album->cover_image])
                <select class="field" name="category">
                    @foreach (['EVENT', 'COMMUNITY', 'HIGHLIGHT'] as $category)
                        <option value="{{ $category }}" @selected(old('category', $album->category) === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                <label class="flex items-center gap-2 text-sm font-semibold">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $album->is_published))>
                    {{ $d['admin']['showPublic'] }}
                </label>
                <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
            </form>
            @if ($album->items->isNotEmpty())
                <div class="grid grid-cols-3 gap-2 px-4">
                    @foreach ($album->items as $item)
                        <div class="space-y-1">
                            <img src="{{ media_url($item->url) }}" alt="" class="h-16 w-full rounded-lg object-cover">
                            <form method="POST" action="{{ route('admin.gallery.items.destroy', [$album, $item]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('admin.gallery.items.store', $album) }}" enctype="multipart/form-data" class="space-y-2 px-4 pt-3">
                @csrf
                <label class="label">{{ $d['admin']['addPhoto'] }}</label>
                <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp" required>
                <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
            </form>
            <form method="POST" action="{{ route('admin.gallery.destroy', $album) }}" class="px-4 py-4">
                @csrf
                @method('DELETE')
                <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
            </form>
        </div>
    @endforeach
</div>
<div class="mt-6">{{ $albums->links() }}</div>
@endsection
