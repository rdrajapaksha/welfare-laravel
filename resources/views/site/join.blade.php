@extends('layouts.site')
@section('title', $d['members']['joinTitle'])
@section('content')
@include('partials.page-hero', ['title' => $d['members']['joinTitle'], 'subtitle' => $d['members']['joinSubtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['members']['joinTitle']]]])
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-2">
        <div>
            <div class="card-surface p-6">
                <h2 class="font-extrabold">{{ $d['members']['requestOnlyTitle'] }}</h2>
                <p class="mt-2 text-sm text-ink-600">{{ $d['members']['requestOnlyText'] }}</p>
            </div>
            <dl class="mt-6 grid grid-cols-2 gap-4">
                <div class="card-surface p-5"><dt class="text-xs text-ink-500">{{ $d['members']['feesRegistration'] }}</dt><dd class="mt-1 text-xl font-extrabold">{{ lkr($registrationFee) }}</dd></div>
                <div class="card-surface p-5"><dt class="text-xs text-ink-500">{{ $d['members']['feesMonthly'] }}</dt><dd class="mt-1 text-xl font-extrabold">{{ lkr($monthlyFee) }}</dd></div>
            </dl>
        </div>
        <form method="POST" action="{{ route('join.store') }}" class="card-surface space-y-3 p-6">
            @csrf
            @foreach ([
                'full_name' => 'fullName',
                'nic' => 'nic',
                'occupation' => 'occupation',
                'address_line1' => 'addressLine1',
                'city' => 'city',
                'district' => 'district',
                'phone' => 'phone',
                'email' => 'email',
            ] as $field => $labelKey)
                <div>
                    <label class="label">{{ $d['forms'][$labelKey] }}</label>
                    <input class="field" name="{{ $field }}" value="{{ old($field) }}" @if ($field === 'email') type="email" @endif {{ $field === 'occupation' ? '' : 'required' }}>
                    @error($field)<p class="text-xs text-brand-700">{{ $message }}</p>@enderror
                </div>
            @endforeach
            <label class="label">{{ $d['forms']['dateOfBirth'] }}</label>
            <input class="field" type="date" name="date_of_birth" required value="{{ old('date_of_birth') }}">
            <label class="label">{{ $d['forms']['gender'] }}</label>
            <select class="field" name="gender" required>
                <option value="MALE">{{ $d['forms']['genderMale'] }}</option>
                <option value="FEMALE">{{ $d['forms']['genderFemale'] }}</option>
                <option value="OTHER">{{ $d['forms']['genderOther'] }}</option>
            </select>
            <input type="hidden" name="membership_type" value="ORDINARY">
            <label class="flex items-start gap-2 text-sm"><input type="checkbox" name="consent" value="1" required> {{ $d['forms']['consentLabel'] }}</label>
            <button class="btn btn-brand" type="submit">{{ $d['members']['submitRequest'] }}</button>
        </form>
    </div>
</section>
@endsection
