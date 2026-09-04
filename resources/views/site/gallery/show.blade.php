@extends('layouts.site')
@section('title', $album->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $album->translate('title'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['gallery']['title'], 'href' => '/gallery'], ['label' => $album->translate('title')]]])
<section class="section-y">
    <div class="container-page grid gap-4 md:grid-cols-3">
        @forelse ($album->items as $item)
            <img src="{{ media_url($item->url) }}" alt="{{ $item->translate('caption') }}" class="rounded-2xl">
        @empty
            @if ($album->cover_image)
                <img src="{{ media_url($album->cover_image) }}" alt="{{ $album->translate('title') }}" class="rounded-2xl">
            @endif
        @endforelse
    </div>
</section>
@endsection
