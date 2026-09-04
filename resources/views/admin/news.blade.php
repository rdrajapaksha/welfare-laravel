@extends('layouts.dash')
@section('title', $d['admin']['news'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['news'] }}</h1>
<form method="POST" action="{{ route('admin.news.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <select class="field" name="category">
        <option value="NEWS">NEWS</option>
        <option value="ACTIVITY_REPORT">ACTIVITY_REPORT</option>
        <option value="PRESS">PRESS</option>
    </select>
    <textarea class="field" name="excerpt_en" rows="2" required placeholder="Excerpt"></textarea>
    <textarea class="field" name="body_en" rows="5" required placeholder="Body"></textarea>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($posts as $post)
        <form method="POST" action="{{ route('admin.news.update', $post) }}" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $post->title_en) }}">
            <select class="field" name="category">
                @foreach (['NEWS', 'ACTIVITY_REPORT', 'PRESS'] as $category)
                    <option value="{{ $category }}" @selected(old('category', $post->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <textarea class="field" name="excerpt_en" rows="2" required>{{ old('excerpt_en', $post->excerpt_en) }}</textarea>
            <textarea class="field" name="body_en" rows="5" required>{{ old('body_en', $post->body_en) }}</textarea>
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.news.destroy', $post) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
<div class="mt-6">{{ $posts->links() }}</div>
@endsection
