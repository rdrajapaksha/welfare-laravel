@extends('layouts.site')
@section('title', $d['news']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['news']['title'], 'subtitle' => $d['news']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['news']['title']]]])
<section class="section-y">
    <div class="container-page">
        <div class="mb-8 flex flex-wrap gap-2">
            <a href="{{ locale_url('/news') }}" class="rounded-full px-3 py-1 text-sm font-bold {{ $category === '' ? 'bg-brand-600 text-white' : 'border border-ink-200' }}">{{ $d['common']['all'] }}</a>
            <a href="{{ locale_url('/news', ['category' => 'ACTIVITY_REPORT']) }}" class="rounded-full px-3 py-1 text-sm font-bold {{ $category === 'ACTIVITY_REPORT' ? 'bg-brand-600 text-white' : 'border border-ink-200' }}">{{ $d['news']['categoryReport'] }}</a>
        </div>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <a href="{{ route('news.show', $post) }}" class="card-surface card-interactive overflow-hidden">
                    @if ($post->cover_image)
                        <img src="{{ media_url($post->cover_image) }}" alt="" class="h-48 w-full object-cover">
                    @endif
                    <div class="p-5">
                    <p class="text-xs text-ink-500">{{ optional($post->published_at)->format('d M Y') }}</p>
                    <h2 class="mt-2 font-extrabold">{{ $post->translate('title') }}</h2>
                    <p class="mt-2 text-sm text-ink-600">{{ $post->translate('excerpt') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
