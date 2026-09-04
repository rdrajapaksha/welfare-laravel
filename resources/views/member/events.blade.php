@extends('layouts.dash')
@section('title', $d['dashboard']['events'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['myEvents'] }}</h1>
<div class="mt-6 space-y-3">
    @forelse ($registrations as $registration)
        <div class="card-surface p-4">
            <p class="font-bold">{{ $registration->event?->translate('title') }}</p>
            <p class="text-sm text-ink-600">{{ $registration->event?->starts_at?->format('d M Y, H:i') }} · {{ $registration->status }}</p>
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['dashboard']['noEventRegistrations'] }}</p>
    @endforelse
</div>
<p class="mt-6"><a class="font-bold text-brand-700" href="{{ locale_url('/events') }}">{{ $d['common']['viewAll'] }}</a></p>
@endsection
