@extends('layouts.site')
@section('title', $event->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $event->translate('title'), 'subtitle' => $event->translate('summary'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['events']['title'], 'href' => '/events'], ['label' => $event->translate('title')]]])
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-3">
        <article class="lg:col-span-2 space-y-4 leading-relaxed">{!! $event->translate('body') !!}</article>
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
