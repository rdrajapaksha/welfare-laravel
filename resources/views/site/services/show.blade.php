@extends('layouts.site')
@section('title', $programme->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $programme->translate('title'), 'subtitle' => $programme->translate('summary'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['services']['title'], 'href' => '/services'], ['label' => $programme->translate('title')]]])
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-3">
        <article class="lg:col-span-2 space-y-4 text-ink-700 leading-relaxed">
            {!! $programme->translate('body') !!}
        </article>
        <aside class="space-y-4">
            @if ($programme->benefit_amount)
                <div class="card-surface p-5"><p class="text-sm text-ink-500">{{ $d['services']['benefitUpTo'] }}</p><p class="text-2xl font-extrabold">{{ lkr($programme->benefit_amount) }}</p></div>
            @endif
            <div class="card-surface p-5">
                <h2 class="font-extrabold">{{ $d['services']['eligibility'] }}</h2>
                <p class="mt-2 text-sm text-ink-600">{{ $programme->translate('eligibility') }}</p>
            </div>
            <a href="{{ locale_url('/join') }}" class="btn btn-brand w-full">{{ $d['services']['applyCta'] }}</a>
        </aside>
    </div>
</section>
@endsection
