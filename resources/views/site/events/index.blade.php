@extends('layouts.site')
@section('title', $d['events']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['events']['title'], 'subtitle' => $d['events']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['events']['title']]]])
<section class="section-y">
    <div class="container-page">
        <div class="mb-8 flex gap-2">
            <a href="{{ locale_url('/events') }}" class="rounded-full px-3 py-1 text-sm font-bold {{ ! $past ? 'bg-brand-600 text-white' : 'border border-ink-200' }}">{{ $d['events']['upcoming'] }}</a>
            <a href="{{ locale_url('/events', ['filter' => 'past']) }}" class="rounded-full px-3 py-1 text-sm font-bold {{ $past ? 'bg-brand-600 text-white' : 'border border-ink-200' }}">{{ $d['events']['past'] }}</a>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            @forelse ($events as $event)
                <a href="{{ route('events.show', $event) }}" class="card-surface card-interactive overflow-hidden">
                    @if ($event->cover_image)
                        <img src="{{ media_url($event->cover_image) }}" alt="" class="h-48 w-full object-cover">
                    @endif
                    <div class="p-5">
                    <p class="text-xs text-ink-500">{{ $event->starts_at->format('d M Y') }}</p>
                    <h2 class="mt-2 font-extrabold">{{ $event->translate('title') }}</h2>
                    <p class="mt-1 text-sm text-ink-600">{{ $event->venue }}, {{ $event->city }}</p>
                    </div>
                </a>
            @empty
                <p>{{ $past ? $d['events']['noPast'] : $d['events']['noUpcoming'] }}</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $events->links() }}</div>
    </div>
</section>
@endsection
