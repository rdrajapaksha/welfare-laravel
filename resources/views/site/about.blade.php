@extends('layouts.site')
@section('title', $d['about']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['about']['title'], 'subtitle' => $d['about']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['about']['title']]]])
<section class="section-y">
    <div class="container-page grid items-center gap-12 lg:grid-cols-2">
        <img src="{{ asset('media/about-team.svg') }}" alt="" class="rounded-3xl">
        <div>
            <h2 class="text-3xl font-extrabold">{{ $d['about']['introTitle'] }}</h2>
            <div class="mt-4 space-y-4 text-ink-600">
                @foreach ($introParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section id="vision" class="section-y bg-white">
    <div class="container-page grid gap-6 lg:grid-cols-2">
        <article class="card-surface border-l-4 border-gold-500 p-8">
            <h2 class="text-2xl font-extrabold">{{ $d['about']['visionTitle'] }}</h2>
            <p class="mt-4 text-lg leading-relaxed">{{ $vision }}</p>
        </article>
        <article class="card-surface border-l-4 border-brand-600 p-8">
            <h2 class="text-2xl font-extrabold">{{ $d['about']['missionTitle'] }}</h2>
            <p class="mt-4 text-lg leading-relaxed">{{ $mission }}</p>
        </article>
    </div>
</section>
<section id="objectives" class="section-y">
    <div class="container-page">
        <h2 class="text-3xl font-extrabold">{{ $d['about']['objectivesTitle'] }}</h2>
        <ol class="mt-8 grid gap-3 sm:grid-cols-2">
            @foreach ($objectives as $objective)
                <li class="card-surface flex gap-3 p-5 text-sm leading-relaxed text-ink-700">
                    <span class="font-extrabold text-brand-700">{{ $loop->iteration }}.</span>
                    <span>{{ $objective }}</span>
                </li>
            @endforeach
        </ol>
    </div>
</section>
<section class="section-y bg-white">
    <div class="container-page">
        <h2 class="text-3xl font-extrabold">{{ $d['about']['valuesTitle'] }}</h2>
        <div class="mt-10 grid gap-5 sm:grid-cols-2">
            @foreach ($values as $value)
                <article class="card-surface p-6">
                    <h3 class="text-xl font-extrabold">{{ \App\Support\AboutContent::pick($value['title']) }}</h3>
                    <p class="mt-2 text-sm text-ink-600">{{ \App\Support\AboutContent::pick($value['text']) }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
<section id="history" class="section-y">
    <div class="container-page">
        <h2 class="text-3xl font-extrabold">{{ $d['about']['historyTitle'] }}</h2>
        <ol class="relative mt-12 space-y-8 border-l-2 border-gold-300 pl-8">
            @foreach ($history as $item)
                <li class="relative">
                    <span class="absolute -left-[2.15rem] top-1.5 h-3 w-3 rounded-full border-2 border-white bg-brand-600 shadow-soft"></span>
                    <p class="text-xs font-bold uppercase text-brand-700">{{ $item['year'] }}</p>
                    <h3 class="mt-1 text-lg font-extrabold">{{ \App\Support\AboutContent::pick($item['title']) }}</h3>
                    <p class="mt-2 max-w-2xl text-sm text-ink-600">{{ \App\Support\AboutContent::pick($item['text']) }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endsection
