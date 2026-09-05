@extends('layouts.dash')
@section('title', $d['dashboard']['meetings'])
@section('content')
<p class="eyebrow">{{ $d['dashboard']['membersOnly'] }}</p>
<h1 class="mt-2 text-3xl font-extrabold">{{ $d['dashboard']['meetings'] }}</h1>
<p class="mt-2 max-w-2xl text-ink-600">{{ $d['dashboard']['meetingsSubtitle'] }}</p>

@if ($nextMeeting)
    <article class="card-surface mt-8 overflow-hidden">
        <div class="grid gap-0 lg:grid-cols-[16rem_1fr]">
            <div class="bg-brand-700 p-6 text-white">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-100">{{ $d['dashboard']['nextMeeting'] }}</p>
                <p class="mt-4 text-4xl font-extrabold">{{ $nextMeeting->held_at->format('d') }}</p>
                <p class="mt-1 text-lg font-bold">{{ $nextMeeting->held_at->format('F Y') }}</p>
                <p class="mt-3 text-sm text-brand-100">{{ $nextMeeting->held_at->format('l · g:i A') }}</p>
            </div>
            <div class="p-6 sm:p-8">
                <h2 class="text-2xl font-extrabold">{{ $nextMeeting->translate('title') }}</h2>
                <p class="mt-4 text-sm font-bold uppercase tracking-wider text-ink-500">{{ $d['dashboard']['hostedBy'] }}</p>
                <p class="mt-1 font-extrabold">{{ $nextMeeting->host_name }}</p>
                <p class="mt-1 text-ink-600">{{ $nextMeeting->host_address }}</p>
                <p class="mt-4 whitespace-pre-line text-ink-600">{{ $nextMeeting->translate('notes') }}</p>
            </div>
        </div>
    </article>
@endif

<div class="mt-10 grid gap-8 lg:grid-cols-2">
    <section>
        <h2 class="text-xl font-extrabold">{{ $d['dashboard']['upcomingMeetings'] }}</h2>
        <div class="mt-4 space-y-3">
            @forelse ($upcoming as $meeting)
                <article class="card-surface p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-brand-700">{{ $meeting->held_at->format('d M Y · g:i A') }}</p>
                    <h3 class="mt-1 font-extrabold">{{ $meeting->translate('title') }}</h3>
                    <p class="mt-2 text-sm text-ink-600">{{ $d['dashboard']['hostedBy'] }} {{ $meeting->host_name }}</p>
                    <p class="text-sm text-ink-600">{{ $meeting->host_address }}</p>
                </article>
            @empty
                <p class="text-sm text-ink-500">{{ $d['dashboard']['noMeetings'] }}</p>
            @endforelse
        </div>
    </section>
    <section>
        <h2 class="text-xl font-extrabold">{{ $d['dashboard']['pastMeetings'] }}</h2>
        <div class="mt-4 space-y-3">
            @forelse ($past as $meeting)
                <article class="card-surface p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-ink-500">{{ $meeting->held_at->format('d M Y') }}</p>
                    <h3 class="mt-1 font-extrabold">{{ $meeting->translate('title') }}</h3>
                    <p class="mt-2 text-sm text-ink-600">{{ $d['dashboard']['hostedBy'] }} {{ $meeting->host_name }}</p>
                    <p class="text-sm text-ink-600">{{ $meeting->host_address }}</p>
                </article>
            @empty
                <p class="text-sm text-ink-500">{{ $d['dashboard']['noMeetings'] }}</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
