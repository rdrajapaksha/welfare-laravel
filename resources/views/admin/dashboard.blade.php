@extends('layouts.dash')
@section('title', $d['admin']['title'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['overview'] }}</h1>
<div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    <div class="card-surface p-5"><p class="text-xs font-bold uppercase text-ink-400">{{ $d['admin']['kpiActiveMembers'] }}</p><p class="mt-2 text-3xl font-extrabold">{{ $members }}</p></div>
    <div class="card-surface p-5"><p class="text-xs font-bold uppercase text-ink-400">{{ $d['admin']['kpiPendingApplications'] }}</p><p class="mt-2 text-3xl font-extrabold">{{ $applications }}</p></div>
    <div class="card-surface p-5"><p class="text-xs font-bold uppercase text-ink-400">{{ $d['admin']['kpiDonationsMonth'] }}</p><p class="mt-2 text-3xl font-extrabold">{{ lkr($donationsMonth) }}</p></div>
    <div class="card-surface p-5"><p class="text-xs font-bold uppercase text-ink-400">{{ $d['admin']['kpiOpenTickets'] }}</p><p class="mt-2 text-3xl font-extrabold">{{ $openTickets }}</p></div>
    <div class="card-surface p-5"><p class="text-xs font-bold uppercase text-ink-400">{{ $d['admin']['kpiUpcomingEvents'] }}</p><p class="mt-2 text-3xl font-extrabold">{{ $upcomingEvents }}</p></div>
    <div class="card-surface p-5"><p class="text-xs font-bold uppercase text-ink-400">{{ $d['admin']['kpiVolunteers'] }}</p><p class="mt-2 text-3xl font-extrabold">{{ $volunteers }}</p></div>
</div>
<div class="mt-8">
    <a href="{{ route('admin.committee.index') }}" class="card-surface card-interactive flex items-center justify-between gap-4 p-5">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['admin']['committeePage'] }}</p>
            <p class="mt-1 font-extrabold">{{ $d['admin']['manageOfficers'] }}</p>
            <p class="mt-1 text-sm text-ink-500">{{ $d['admin']['committeeHint'] }}</p>
        </div>
        <span class="btn btn-brand">{{ $d['admin']['manageOfficers'] }}</span>
    </a>
</div>
<div class="mt-10 grid gap-6 lg:grid-cols-2">
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['recentDonations'] }}</h2>
        @forelse ($recentDonations as $donation)
            <p class="mt-3 text-sm">{{ $donation->donor_name }} · {{ lkr($donation->amount) }} · {{ $donation->status }}</p>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
        @endforelse
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['recentApplications'] }}</h2>
        @forelse ($recentApplications as $application)
            <p class="mt-3 text-sm">{{ $application->full_name }} · {{ $application->status }}</p>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
        @endforelse
    </div>
</div>
@endsection
