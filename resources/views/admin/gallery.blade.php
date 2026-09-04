@extends('layouts.dash')
@section('title', $d['admin']['gallery'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['gallery'] }}</h1>
<form method="POST" action="{{ route('admin.gallery.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <input class="field" name="cover_image" required placeholder="/media/flood-relief.svg" value="/media/flood-relief.svg">
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
            <img src="{{ asset(ltrim($album->cover_image, '/')) }}" alt="" class="h-36 w-full object-cover">
            <div class="p-4">
                <p class="font-bold">{{ $album->translate('title') }}</p>
                <p class="text-sm text-ink-500">{{ $album->category }}</p>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-6">{{ $albums->links() }}</div>
@endsection
