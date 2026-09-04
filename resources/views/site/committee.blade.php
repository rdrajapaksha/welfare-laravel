@extends('layouts.site')
@section('title', $title)
@section('content')
@include('partials.page-hero', ['title' => $title, 'subtitle' => $subtitle, 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['about']['title'], 'href' => '/about'], ['label' => $title]]])
<section class="section-y">
    <div class="container-page">
        @if ($members->isEmpty())
            <p class="text-ink-500">{{ $d['common']['noResults'] }}</p>
        @else
            <div class="grid items-stretch gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($members as $member)
                    @include('partials.board-member-card', ['member' => $member])
                @endforeach
            </div>
        @endif

        <div class="mt-12 grid items-stretch gap-4 sm:grid-cols-2">
            <div class="card-surface flex h-full flex-col p-6">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['contact']['detailsTitle'] }}</p>
                <p class="mt-3 text-sm leading-relaxed text-ink-600">{{ $site['contact']['street'] }}, {{ $site['contact']['locality'] }} {{ $site['contact']['postal_code'] }}</p>
                <p class="mt-2 text-sm font-semibold">
                    <a href="tel:{{ $site['contact']['phone'] }}" class="text-brand-700 hover:underline">{{ $site['contact']['phone_display'] }}</a>
                </p>
            </div>
            <a href="{{ locale_url($title === $d['about']['committeeTitle'] ? '/about/advisory' : '/about/committee') }}" class="card-surface card-interactive flex h-full flex-col justify-center p-6">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['about']['title'] }}</p>
                <p class="mt-3 text-lg font-extrabold">{{ $title === $d['about']['committeeTitle'] ? $d['about']['committeeCtaAdvisory'] : $d['nav']['committee'] }}</p>
                <p class="mt-2 text-sm text-ink-600">{{ $d['about']['meetCommittee'] }}</p>
            </a>
        </div>
    </div>
</section>
@endsection
