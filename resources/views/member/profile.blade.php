@extends('layouts.dash')
@section('title', $d['dashboard']['profile'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['profile'] }}</h1>
<form method="POST" action="{{ route('member.profile.update') }}" class="mt-6 max-w-xl space-y-3">
    @csrf
    @method('PUT')
    <input class="field" name="phone" value="{{ old('phone', $member->phone) }}" required>
    <input class="field" name="whatsapp" value="{{ old('whatsapp', $member->whatsapp) }}">
    <input class="field" type="email" name="email" value="{{ old('email', $member->email) }}">
    <input class="field" name="address_line1" value="{{ old('address_line1', $member->address_line1) }}" required>
    <input class="field" name="city" value="{{ old('city', $member->city) }}" required>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="show_in_directory" value="1" @checked($member->show_in_directory)> {{ $d['dashboard']['directoryVisibility'] }}</label>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
@endsection
