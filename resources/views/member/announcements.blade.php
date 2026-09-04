@extends('layouts.dash')
@section('title', $d['dashboard']['announcements'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['announcements'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['dashboard']['announcementsSubtitle'] }}</p>
<div class="mt-6 space-y-4">
    @forelse ($announcements as $item)
        <article class="card-surface p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-700">{{ $item->priority }} · {{ $item->audience }}</p>
            <h2 class="mt-1 text-xl font-extrabold">{{ $item->translate('title') }}</h2>
            <p class="mt-2 whitespace-pre-line text-ink-600">{{ $item->translate('body') }}</p>
        </article>
    @empty
        <p class="text-sm text-ink-500">{{ $d['dashboard']['noAnnouncements'] }}</p>
    @endforelse
</div>
@endsection
