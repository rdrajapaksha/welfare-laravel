@extends('layouts.dash')
@section('title', $d['dashboard']['digitalId'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['digitalId'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['dashboard']['digitalIdNote'] }}</p>
<div class="mt-8 max-w-md overflow-hidden rounded-3xl border border-ink-200 bg-white shadow-lift">
    <div class="bg-ink-950 px-6 py-4 text-white">
        <p class="text-xs uppercase tracking-wider">{{ $d['brand']['full'] }}</p>
        <p class="mt-1 font-times italic">{{ $d['brand']['tagline'] }}</p>
    </div>
    <div class="grid grid-cols-[auto_1fr_6.5rem] items-start gap-4 p-6">
        <x-person-photo :src="$member->photo_url" :name="$member->full_name" size="id" />
        <div class="min-w-0">
            <p class="text-xs text-ink-500">{{ $d['members']['membershipNo'] }}</p>
            <p class="text-lg font-extrabold">{{ $member->membership_no }}</p>
            <p class="mt-4 text-xl font-extrabold leading-snug">{{ $member->full_name }}</p>
            <p class="text-sm text-ink-600">{{ $member->membership_type }} · {{ $member->status }}</p>
        </div>
        <img alt="{{ $d['dashboard']['qrAlt'] }}" class="h-24 w-24" src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($member->membership_no) }}">
    </div>
</div>
@endsection
