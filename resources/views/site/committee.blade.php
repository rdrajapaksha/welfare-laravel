@extends('layouts.site')
@section('title', $d['about']['committeeTitle'])
@section('content')
@include('partials.page-hero', ['title' => $d['about']['committeeTitle'], 'subtitle' => $d['about']['committeeSubtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['about']['title'], 'href' => '/about'], ['label' => $d['about']['committeeTitle']]]])
<section class="section-y">
    <div class="container-page grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($members as $member)
            <article class="card-surface p-6">
                <p class="text-xs font-bold uppercase text-brand-700">{{ $member->translate('position') }}</p>
                <h3 class="mt-2 text-xl font-extrabold">{{ $member->name }}</h3>
                <p class="mt-2 text-sm text-ink-600">{{ $member->translate('bio') }}</p>
                <p class="mt-3 text-xs text-ink-500">{{ $d['about']['termLabel'] }} {{ $member->term_from }}–{{ $member->term_to ?? $d['about']['present'] }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection
