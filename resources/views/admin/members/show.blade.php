@extends('layouts.dash')
@section('title', $member->full_name)
@section('content')
<p class="text-sm"><a class="font-semibold text-brand-700" href="{{ route('admin.members.index') }}">{{ $d['common']['back'] }}</a></p>
<h1 class="mt-2 text-3xl font-extrabold">{{ $member->full_name }}</h1>
<p class="text-ink-500">{{ $member->membership_no }} · {{ $member->nic }} · {{ lkr($dueAmount) }} due</p>
<form method="POST" action="{{ route('admin.members.update', $member) }}" class="card-surface mt-6 flex max-w-xl flex-wrap items-end gap-3 p-5">
    @csrf
    @method('PUT')
    <div>
        <label class="label">{{ $d['common']['status'] }}</label>
        <select class="field" name="status">
            @foreach (['ACTIVE','PENDING','SUSPENDED','RESIGNED'] as $status)
                <option value="{{ $status }}" @selected($member->status === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">Type</label>
        <select class="field" name="membership_type">
            @foreach (['ORDINARY','HONORARY','JUNIOR'] as $type)
                <option value="{{ $type }}" @selected($member->membership_type === $type)>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['dashboard']['paymentHistory'] }}</h2>
        @foreach ($member->payments as $payment)
            <p class="mt-2 text-sm">{{ $payment->receipt_no }} · {{ lkr($payment->amount) }} · {{ $payment->status }}</p>
        @endforeach
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['dashboard']['myClaims'] }}</h2>
        @foreach ($member->benefitClaims as $claim)
            <p class="mt-2 text-sm">{{ $claim->claim_no }} · {{ $claim->status }} · {{ lkr($claim->amount) }}</p>
        @endforeach
    </div>
</div>
@endsection
