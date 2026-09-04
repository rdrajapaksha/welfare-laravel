@extends('layouts.site')
@section('title', $d['gallery']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['gallery']['title'], 'subtitle' => $d['gallery']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['gallery']['title']]]])
<section class="section-y">
    <div class="container-page grid gap-5 md:grid-cols-3">
        @foreach ($albums as $album)
            <a href="{{ route('gallery.show', $album) }}" class="card-surface overflow-hidden">
                <img src="{{ asset(ltrim($album->cover_image, '/')) }}" alt="" class="h-44 w-full object-cover">
                <div class="p-4">
                    <h2 class="font-extrabold">{{ $album->translate('title') }}</h2>
                    <p class="mt-1 text-xs text-ink-500">{{ $album->taken_at->format('Y') }} · {{ $album->items->count() }} {{ $d['common']['photos'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="container-page mt-8">{{ $albums->links() }}</div>
</section>
@endsection
