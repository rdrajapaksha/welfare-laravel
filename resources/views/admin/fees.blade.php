@extends('layouts.dash')
@section('title', $d['admin']['fees'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['fees'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['admin']['feesHint'] }}</p>
<form method="POST" action="{{ route('admin.fees.store') }}" class="card-surface mt-6 grid max-w-xl gap-3 p-5 sm:grid-cols-2">
    @csrf
    <div>
        <label class="label">{{ $d['fees']['monthlyFeeLabel'] }}</label>
        <input class="field" type="number" name="monthly_fee" min="1" value="{{ $monthlyFee }}" required>
    </div>
    <div>
        <label class="label">{{ $d['members']['feesRegistration'] }}</label>
        <input class="field" type="number" name="registration_fee" min="1" value="{{ $registrationFee }}" required>
    </div>
    <div class="sm:col-span-2"><button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button></div>
</form>
<form method="POST" action="{{ route('admin.fees.record') }}" class="card-surface mt-6 grid max-w-xl gap-3 p-5 sm:grid-cols-2">
    @csrf
    <h2 class="sm:col-span-2 font-extrabold">{{ $d['admin']['recordPayment'] }}</h2>
    <select class="field sm:col-span-2" name="member_id" required>
        @foreach ($members as $member)
            <option value="{{ $member->id }}">{{ $member->membership_no }} · {{ $member->full_name }}</option>
        @endforeach
    </select>
    <input class="field" type="number" name="year" value="{{ now()->year }}" required>
    <input class="field" type="number" name="month" min="1" max="12" value="{{ now()->month }}" required>
    <select class="field sm:col-span-2" name="method">
        <option value="BANK_TRANSFER">{{ $d['donations']['methodBank'] }}</option>
        <option value="CASH">{{ $d['donations']['methodCash'] }}</option>
        <option value="CHEQUE">{{ $d['donations']['methodCheque'] }}</option>
    </select>
    <div class="sm:col-span-2"><button class="btn btn-outline" type="submit">{{ $d['admin']['recordPayment'] }}</button></div>
</form>
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['pendingRenewals'] }}</h2>
        @forelse ($pending as $payment)
            <form method="POST" action="{{ route('admin.fees.confirm', $payment) }}" class="mt-3 flex items-center justify-between text-sm">
                @csrf
                <span>{{ $payment->member?->full_name }} · {{ $payment->period_year }}-{{ $payment->period_month }} · {{ lkr($payment->amount) }}</span>
                <button class="font-bold text-brand-700" type="submit">{{ $d['admin']['confirmPayment'] }}</button>
            </form>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
        @endforelse
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['arrearsList'] }}</h2>
        @forelse ($arrears as $row)
            <p class="mt-2 text-sm">{{ $row['member']->full_name }} · {{ $row['months'] }} mo · {{ lkr($row['amount']) }}</p>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['admin']['noArrears'] }}</p>
        @endforelse
    </div>
</div>
@endsection
