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
<div class="mt-8 space-y-3">
    @foreach ($posts as $post)
        <div class="card-surface flex items-center justify-between gap-4 p-4">
            <div>
                <p class="font-bold">{{ $post->translate('title') }}</p>
                <p class="text-sm text-ink-500">{{ $post->category }} · {{ $post->published_at?->format('d M Y') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.news.destroy', $post) }}">@csrf @method('DELETE')<button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button></form>
        </div>
    @endforeach
</div>
<div class="mt-6">{{ $posts->links() }}</div>
@endsection
