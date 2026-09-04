@extends('layouts.dash')
@section('title', $member->full_name)
@section('content')
<p class="text-sm"><a class="font-semibold text-brand-700" href="{{ route('admin.members.index') }}">{{ $d['common']['back'] }}</a></p>
<div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center">
    <x-person-photo :src="$member->photo_url" :name="$member->full_name" size="xl" />
    <div>
        <h1 class="text-3xl font-extrabold">{{ $member->full_name }}</h1>
        <p class="text-ink-500">{{ $member->membership_no }} · {{ $member->nic }}</p>
        <p class="mt-1 text-sm font-semibold text-brand-800">{{ lkr($dueAmount) }} due · {{ $unpaid->count() }} unpaid month(s)</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data" class="card-surface mt-8 grid gap-4 p-5 lg:grid-cols-2">
    @csrf
    @method('PUT')
    <div>
        <label class="label">{{ $d['forms']['fullName'] }}</label>
        <input class="field" name="full_name" required value="{{ old('full_name', $member->full_name) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['nameWithInitials'] }}</label>
        <input class="field" name="name_with_initials" value="{{ old('name_with_initials', $member->name_with_initials) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['nic'] }}</label>
        <input class="field" name="nic" required value="{{ old('nic', $member->nic) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['dateOfBirth'] }}</label>
        <input class="field" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($member->date_of_birth)->format('Y-m-d')) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['gender'] }}</label>
        <select class="field" name="gender">
            @foreach (['MALE' => $d['forms']['genderMale'], 'FEMALE' => $d['forms']['genderFemale'], 'OTHER' => $d['forms']['genderOther']] as $value => $label)
                <option value="{{ $value }}" @selected(old('gender', $member->gender) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">{{ $d['forms']['civilStatus'] }}</label>
        <select class="field" name="civil_status">
            @foreach (['SINGLE' => $d['forms']['civilSingle'], 'MARRIED' => $d['forms']['civilMarried'], 'OTHER' => $d['forms']['civilOther']] as $value => $label)
                <option value="{{ $value }}" @selected(old('civil_status', $member->civil_status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">{{ $d['forms']['occupation'] }}</label>
        <input class="field" name="occupation" value="{{ old('occupation', $member->occupation) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['bloodGroup'] }}</label>
        <input class="field" name="blood_group" value="{{ old('blood_group', $member->blood_group) }}">
    </div>
    <div class="lg:col-span-2">
        <label class="label">{{ $d['forms']['addressLine1'] }}</label>
        <input class="field" name="address_line1" required value="{{ old('address_line1', $member->address_line1) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['addressLine2'] }}</label>
        <input class="field" name="address_line2" value="{{ old('address_line2', $member->address_line2) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['city'] }}</label>
        <input class="field" name="city" required value="{{ old('city', $member->city) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['district'] }}</label>
        <input class="field" name="district" value="{{ old('district', $member->district) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['phone'] }}</label>
        <input class="field" name="phone" required value="{{ old('phone', $member->phone) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['whatsapp'] }}</label>
        <input class="field" name="whatsapp" value="{{ old('whatsapp', $member->whatsapp) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['email'] }}</label>
        <input class="field" type="email" name="email" value="{{ old('email', $member->email) }}">
    </div>
    <div>
        <label class="label">{{ d('forms.photo', 'Photo') }}</label>
        <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
    </div>
    <div>
        <label class="label">{{ $d['forms']['emergencyName'] }}</label>
        <input class="field" name="emergency_name" value="{{ old('emergency_name', $member->emergency_name) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['emergencyPhone'] }}</label>
        <input class="field" name="emergency_phone" value="{{ old('emergency_phone', $member->emergency_phone) }}">
    </div>
    <div>
        <label class="label">{{ $d['common']['status'] }}</label>
        <select class="field" name="status">
            @foreach (['ACTIVE','PENDING','SUSPENDED','RESIGNED'] as $status)
                <option value="{{ $status }}" @selected(old('status', $member->status) === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">{{ $d['forms']['membershipType'] }}</label>
        <select class="field" name="membership_type">
            @foreach (['ORDINARY','HONORARY','JUNIOR'] as $type)
                <option value="{{ $type }}" @selected(old('membership_type', $member->membership_type) === $type)>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="label">{{ $d['members']['memberSince'] }}</label>
        <input class="field" type="date" name="joined_at" value="{{ old('joined_at', optional($member->joined_at)->format('Y-m-d')) }}">
    </div>
    <div class="lg:col-span-2">
        <label class="label">{{ $d['dashboard']['profile'] }}</label>
        <textarea class="field" name="bio" rows="3">{{ old('bio', $member->bio) }}</textarea>
    </div>
    <label class="flex items-center gap-2 text-sm lg:col-span-2"><input type="checkbox" name="show_in_directory" value="1" @checked(old('show_in_directory', $member->show_in_directory))> {{ $d['dashboard']['directoryVisibility'] }}</label>
    <div class="lg:col-span-2">
        <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
    </div>
</form>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['dashboard']['paymentHistory'] }}</h2>
        @forelse ($member->payments as $payment)
            <p class="mt-2 text-sm">{{ $payment->receipt_no }} · {{ lkr($payment->amount) }} · {{ $payment->status }}</p>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['dashboard']['noPayments'] }}</p>
        @endforelse
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['dashboard']['myClaims'] }}</h2>
        @forelse ($member->benefitClaims as $claim)
            <p class="mt-2 text-sm">{{ $claim->claim_no }} · {{ $claim->status }} · {{ lkr($claim->amount) }}</p>
        @empty
            <p class="mt-2 text-sm text-ink-500">{{ $d['dashboard']['noClaims'] }}</p>
        @endforelse
    </div>
</div>
@endsection
