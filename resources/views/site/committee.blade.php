@extends('layouts.site')
@section('title', $title)
@section('content')
@include('partials.page-hero', ['title' => $title, 'subtitle' => $subtitle, 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['about']['title'], 'href' => '/about'], ['label' => $title]]])
<section class="section-y">
    <div class="container-page grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($members as $member)
            @include('partials.board-member-card', ['member' => $member])
        @empty
            <p class="text-sm text-ink-500">{{ $d['common']['noResults'] }}</p>
        @endforelse
    </div>
</section>
@endsection
