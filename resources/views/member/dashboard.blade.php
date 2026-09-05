@extends('layouts.dash')
@section('title', $d['dashboard']['title'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['welcome'] }}{{ $member ? ', '.$member->full_name : '' }}</h1>
@if ($member)
    <div class="mt-4 flex items-center gap-4">
        <x-person-photo :src="$member->photo_url" :name="$member->full_name" size="md" />
        <p class="text-sm text-ink-500">{{ $member->membership_no }}</p>
    </div>
@endif
@if ($member && $dueAmount > 0)
    <div class="mt-6 rounded-2xl border border-brand-200 bg-brand-50 p-4 text-brand-900">
        <p class="font-bold">{{ $d['fees']['arrearsTitle'] }}</p>
        <p class="mt-1 text-sm">{{ str_replace(['{months}', '{amount}', '{fee}'], [$dueMonths->count(), lkr($dueAmount), lkr(\App\Support\MembershipDues::monthlyFee())], $d['fees']['arrearsText']) }}</p>
        <a href="{{ locale_url('/dashboard/payments') }}" class="mt-2 inline-block text-sm font-bold">{{ $d['fees']['viewPayments'] }}</a>
    </div>
@endif
<div class="mt-8 grid gap-4 sm:grid-cols-2 {{ $hasOpenElection ? 'lg:grid-cols-3' : 'lg:grid-cols-2' }}">
    <a href="{{ locale_url('/dashboard/id') }}" class="card-surface card-interactive p-5 font-bold">{{ $d['dashboard']['digitalId'] }}</a>
    <a href="{{ locale_url('/dashboard/payments') }}" class="card-surface card-interactive p-5 font-bold">{{ $d['dashboard']['payments'] }}</a>
    @if ($hasOpenElection)
        <a href="{{ locale_url('/dashboard/vote') }}" class="card-surface card-interactive p-5 font-bold">{{ $d['dashboard']['eVoting'] }}</a>
    @endif
</div>
@if ($nextMeeting)
    <a href="{{ locale_url('/dashboard/meetings') }}" class="card-surface card-interactive mt-6 block p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-brand-700">{{ $d['dashboard']['nextMeeting'] }}</p>
        <h2 class="mt-2 text-xl font-extrabold">{{ $nextMeeting->translate('title') }}</h2>
        <p class="mt-2 text-sm text-ink-600">{{ $nextMeeting->held_at->format('d M Y · g:i A') }} · {{ $d['dashboard']['hostedBy'] }} {{ $nextMeeting->host_name }}</p>
        <p class="mt-1 text-sm text-ink-600">{{ $nextMeeting->host_address }}</p>
    </a>
@endif
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['dashboard']['announcements'] }}</h2>
        @forelse ($announcements as $item)
            <article class="mt-4 border-t border-ink-100 pt-4">
                <h3 class="font-bold">{{ $item->translate('title') }}</h3>
                <p class="text-sm text-ink-600">{{ \Illuminate\Support\Str::limit($item->translate('body'), 140) }}</p>
            </article>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['dashboard']['noAnnouncements'] }}</p>
        @endforelse
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['dashboard']['myClaims'] }}</h2>
        @forelse ($claims as $claim)
            <p class="mt-3 text-sm">{{ $claim->claim_no }} · {{ $claim->programme?->translate('title') }} · {{ $claim->status }}</p>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['dashboard']['noClaims'] }}</p>
        @endforelse
    </div>
</div>
@endsection
