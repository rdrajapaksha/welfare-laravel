@extends('layouts.dash')
@section('title', $d['dashboard']['benefits'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['benefits'] }}</h1>
<form method="POST" action="{{ route('member.benefits.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <h2 class="font-extrabold">{{ $d['dashboard']['newClaim'] }}</h2>
    <select class="field" name="programme_id" required>
        @foreach ($programmes as $programme)
            <option value="{{ $programme->id }}">{{ $programme->translate('title') }}</option>
        @endforeach
    </select>
    <input class="field" type="number" name="amount" min="1" required placeholder="{{ $d['common']['amount'] }}">
    <textarea class="field" name="reason" rows="4" required placeholder="{{ $d['dashboard']['ticketDescription'] }}"></textarea>
    <button class="btn btn-brand" type="submit">{{ $d['common']['submit'] }}</button>
</form>
<div class="mt-8 space-y-3">
    <h2 class="font-extrabold">{{ $d['dashboard']['myClaims'] }}</h2>
    @forelse ($claims as $claim)
        <div class="card-surface flex flex-wrap justify-between gap-3 p-4 text-sm">
            <span>{{ $claim->claim_no }} · {{ $claim->programme?->translate('title') }}</span>
            <span>{{ lkr($claim->amount) }} · {{ $claim->status }}</span>
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['dashboard']['noClaims'] }}</p>
    @endforelse
</div>
@endsection
