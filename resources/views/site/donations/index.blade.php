@extends('layouts.site')
@section('title', $d['donations']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['donations']['title'], 'subtitle' => $d['donations']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['donations']['title']]]])
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-2">
        <form method="POST" action="{{ route('donations.store') }}" class="card-surface space-y-4 p-6">
            @csrf
            <h2 class="text-xl font-extrabold">{{ $d['donations']['donateTitle'] }}</h2>
            @error('amount')<p class="text-sm text-brand-700">{{ $message }}</p>@enderror
            <label class="label">{{ $d['forms']['fullName'] }}</label>
            <input class="field" name="donor_name" required value="{{ old('donor_name') }}">
            <label class="label">{{ $d['forms']['email'] }}</label>
            <input class="field" type="email" name="email" value="{{ old('email') }}">
            <label class="label">{{ $d['forms']['phone'] }}</label>
            <input class="field" name="phone" value="{{ old('phone') }}">
            <label class="label">{{ $d['donations']['amountLabel'] }}</label>
            <input class="field" type="number" name="amount" min="100" required value="{{ old('amount', 5000) }}">
            <label class="label">{{ $d['donations']['purposeLabel'] }}</label>
            <select class="field" name="purpose">
                <option value="GENERAL">{{ $d['donations']['purposeGeneral'] }}</option>
                <option value="EMERGENCY">{{ $d['donations']['purposeEmergency'] }}</option>
                <option value="EDUCATION">{{ $d['donations']['purposeEducation'] }}</option>
                <option value="MEDICAL">{{ $d['donations']['purposeMedical'] }}</option>
            </select>
            <label class="label">{{ $d['donations']['methodTitle'] }}</label>
            <select class="field" name="method">
                <option value="BANK_TRANSFER">{{ $d['donations']['methodBank'] }}</option>
                <option value="CASH">{{ $d['donations']['methodCash'] }}</option>
                <option value="CHEQUE">{{ $d['donations']['methodCheque'] }}</option>
            </select>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_anonymous" value="1"> {{ $d['donations']['anonymousLabel'] }}</label>
            <button class="btn btn-brand" type="submit">{{ $d['donations']['submitCta'] }}</button>
        </form>
        <div id="bank" class="card-surface p-6">
            <h2 class="text-xl font-extrabold">{{ $d['donations']['bankTitle'] }}</h2>
            <p class="mt-2 text-sm text-ink-600">{{ $d['donations']['bankSubtitle'] }}</p>
            <dl class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between gap-4"><dt>{{ $d['donations']['bankName'] }}</dt><dd class="font-semibold">{{ $site['bank']['bank_name'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt>{{ $d['donations']['bankBranch'] }}</dt><dd class="font-semibold">{{ $site['bank']['branch'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt>{{ $d['donations']['bankAccountName'] }}</dt><dd class="font-semibold text-right">{{ $site['bank']['account_name'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt>{{ $d['donations']['bankAccountNo'] }}</dt><dd class="font-semibold">{{ $site['bank']['account_no'] }}</dd></div>
                <div class="flex justify-between gap-4"><dt>{{ $d['donations']['bankSwift'] }}</dt><dd class="font-semibold">{{ $site['bank']['swift'] }}</dd></div>
            </dl>
            <p class="mt-4 text-xs text-ink-500">{{ $d['donations']['bankNote'] }}</p>
        </div>
    </div>
</section>
@endsection
