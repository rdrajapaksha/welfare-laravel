@extends('layouts.dash')
@section('title', $d['dashboard']['payments'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['payments'] }}</h1>
<p class="mt-2">{{ $d['fees']['amountDue'] }}: <strong>{{ lkr($dueAmount) }}</strong></p>
@if ($unpaid->isNotEmpty())
    <form method="POST" action="{{ route('member.payments.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
        @csrf
        @foreach ($unpaid as $month)
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="months[]" value="{{ $month['key'] }}"> {{ $month['label'] }}</label>
        @endforeach
        <select class="field" name="method">
            <option value="BANK_TRANSFER">{{ $d['donations']['methodBank'] }}</option>
            <option value="CASH">{{ $d['donations']['methodCash'] }}</option>
            <option value="CHEQUE">{{ $d['donations']['methodCheque'] }}</option>
        </select>
        <button class="btn btn-brand" type="submit">{{ $d['fees']['renewSubmit'] }}</button>
    </form>
@endif
<div class="mt-8 space-y-2">
    @foreach ($payments as $payment)
        <div class="card-surface flex justify-between p-4 text-sm">
            <span>{{ $payment->receipt_no }} · {{ $payment->period_year }}-{{ $payment->period_month }}</span>
            <span>{{ lkr($payment->amount) }} · {{ $payment->status }}</span>
        </div>
    @endforeach
</div>
@endsection
