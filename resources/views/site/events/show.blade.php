@extends('layouts.site')
@section('title', $event->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $event->translate('title'), 'subtitle' => $event->translate('summary'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['events']['title'], 'href' => '/events'], ['label' => $event->translate('title')]]])
@php
    $gallery = $event->galleryPaths();
    $count = count($gallery);
    $gridClass = match ($count) {
        2, 4 => 'grid gap-3 sm:grid-cols-2',
        3, 5 => 'grid gap-3 sm:grid-cols-3',
        default => '',
    };
    $heroSpan = $count === 3 || $count === 5;
@endphp
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-3">
        <article class="lg:col-span-2 space-y-6 leading-relaxed">
            @if ($gallery !== [])
                <div class="overflow-hidden rounded-3xl {{ $count > 1 ? $gridClass : '' }}" x-data="{ active: null }">
                    @foreach ($gallery as $index => $path)
                        <button type="button" class="group relative block overflow-hidden {{ $count === 1 ? 'w-full' : '' }} {{ $heroSpan && $index === 0 ? 'sm:col-span-2 sm:row-span-2' : '' }}" @click="active = {{ $index }}">
                            <img src="{{ media_url($path) }}" alt="{{ $event->translate('title') }}" class="h-full w-full object-cover {{ $count === 1 ? 'max-h-[28rem] rounded-3xl' : 'aspect-[4/3] rounded-2xl' }} {{ $heroSpan && $index === 0 ? 'sm:aspect-[4/3] sm:min-h-full' : '' }}">
                        </button>
                    @endforeach
                    <div x-show="active !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-ink-950/80 p-6" @click.self="active = null">
                        <button type="button" class="absolute right-6 top-6 text-sm font-bold text-white" @click="active = null">{{ $d['common']['close'] }}</button>
                        @foreach ($gallery as $index => $path)
                            <img x-show="active === {{ $index }}" src="{{ media_url($path) }}" alt="{{ $event->translate('title') }}" class="max-h-[90vh] max-w-full rounded-2xl object-contain">
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="space-y-4">
                {!! $event->translate('body') !!}
            </div>
        </article>
        <aside class="card-surface p-5">
            <p class="text-sm">{{ $d['events']['venue'] }}: {{ $event->venue }}, {{ $event->city }}</p>
            <p class="mt-2 text-sm">{{ $d['events']['startsAt'] }}: {{ $event->starts_at->format('d M Y H:i') }}</p>
            @if ($event->registration_open)
                <h2 class="mt-6 font-extrabold">{{ $d['events']['registerTitle'] }}</h2>
                <form method="POST" action="{{ route('events.register', $event) }}" class="mt-4 space-y-3">
                    @csrf
                    <input class="field" name="full_name" required placeholder="{{ $d['forms']['fullName'] }}" value="{{ old('full_name', auth()->user()?->name) }}">
                    <input class="field" type="email" name="email" required placeholder="{{ $d['forms']['email'] }}" value="{{ old('email', auth()->user()?->email) }}">
                    <input class="field" name="phone" required placeholder="{{ $d['forms']['phone'] }}">
                    <input class="field" type="number" name="guests" min="0" max="10" value="0">
                    <button class="btn btn-brand w-full" type="submit">{{ $d['events']['registerCta'] }}</button>
                </form>
            @else
                <p class="mt-4 text-sm">{{ $d['events']['registrationClosed'] }}</p>
            @endif
        </aside>
    </div>
</section>
@endsection
