@extends('layouts.site')
@section('title', $title)
@section('content')
@include('partials.page-hero', ['title' => $title, 'subtitle' => $subtitle, 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['about']['title'], 'href' => '/about'], ['label' => $title]]])
<section class="section-y">
    <div class="container-page">
        @if ($members->isEmpty())
            <p class="text-ink-500">{{ $d['common']['noResults'] }}</p>
        @elseif ($members->count() === 1)
            <div class="mx-auto max-w-md">
                @include('partials.board-member-card', ['member' => $members->first(), 'featured' => true])
            </div>
        @elseif ($members->count() <= 3)
            <div class="grid items-stretch gap-6 md:grid-cols-12">
                <div class="md:col-span-5">
                    @include('partials.board-member-card', ['member' => $members->first(), 'featured' => true])
                </div>
                <div class="grid gap-6 sm:grid-cols-2 md:col-span-7 md:grid-cols-1">
                    @foreach ($members->skip(1) as $member)
                        @include('partials.board-member-card', ['member' => $member, 'featured' => false])
                    @endforeach
                </div>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($members as $member)
                    @include('partials.board-member-card', ['member' => $member, 'featured' => $loop->first])
                @endforeach
            </div>
        @endif

        <div class="mt-12 grid gap-4 sm:grid-cols-2">
            <div class="card-surface p-6">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['contact']['detailsTitle'] }}</p>
                <p class="mt-3 text-sm leading-relaxed text-ink-600">{{ $site['contact']['street'] }}, {{ $site['contact']['locality'] }} {{ $site['contact']['postal_code'] }}</p>
                <p class="mt-2 text-sm font-semibold">
                    <a href="tel:{{ $site['contact']['phone'] }}" class="text-brand-700 hover:underline">{{ $site['contact']['phone_display'] }}</a>
                </p>
            </div>
            <a href="{{ locale_url($title === $d['about']['committeeTitle'] ? '/about/advisory' : '/about/committee') }}" class="card-surface card-interactive flex flex-col justify-center p-6">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['about']['title'] }}</p>
                <p class="mt-3 text-lg font-extrabold">{{ $title === $d['about']['committeeTitle'] ? $d['about']['committeeCtaAdvisory'] : $d['nav']['committee'] }}</p>
                <p class="mt-2 text-sm text-ink-600">{{ $d['about']['meetCommittee'] }}</p>
            </a>
        </div>
    </div>
</section>
@endsection
