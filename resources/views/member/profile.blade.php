@extends('layouts.dash')
@section('title', $d['dashboard']['profile'])
@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-center">
    <x-person-photo :src="$member->photo_url" :name="$member->full_name" size="lg" />
    <div>
        <h1 class="text-3xl font-extrabold">{{ $d['dashboard']['profile'] }}</h1>
        <p class="text-sm text-ink-500">{{ $member->membership_no }} · {{ $member->full_name }}</p>
    </div>
</div>
<form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    @method('PUT')
    <div>
        <label class="label">{{ $d['forms']['phone'] }}</label>
        <input class="field" name="phone" value="{{ old('phone', $member->phone) }}" required>
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
        <label class="label">{{ $d['forms']['addressLine1'] }}</label>
        <input class="field" name="address_line1" value="{{ old('address_line1', $member->address_line1) }}" required>
    </div>
    <div>
        <label class="label">{{ $d['forms']['addressLine2'] }}</label>
        <input class="field" name="address_line2" value="{{ old('address_line2', $member->address_line2) }}">
    </div>
    <div>
        <label class="label">{{ $d['forms']['city'] }}</label>
        <input class="field" name="city" value="{{ old('city', $member->city) }}" required>
    </div>
    <div>
        <label class="label">{{ $d['forms']['occupation'] }}</label>
        <input class="field" name="occupation" value="{{ old('occupation', $member->occupation) }}">
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
        <label class="label">{{ d('forms.photo', 'Photo') }}</label>
        <input class="field" type="file" name="photo" accept="image/jpeg,image/png,image/webp">
    </div>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="show_in_directory" value="1" @checked($member->show_in_directory)> {{ $d['dashboard']['directoryVisibility'] }}</label>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
@endsection
