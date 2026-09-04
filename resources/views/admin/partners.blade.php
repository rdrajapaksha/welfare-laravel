@extends('layouts.dash')
@section('title', $d['admin']['partnersPage'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['partnersPage'] }}</h1>
<form method="POST" action="{{ route('admin.partners.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="name" required placeholder="Name">
    <input class="field" name="tier" required placeholder="Tier" value="COMMUNITY">
    <input class="field" name="logo_url" required placeholder="/media/flood-relief.svg" value="/media/flood-relief.svg">
    <input class="field" name="website" placeholder="https://">
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($partners as $partner)
        <form method="POST" action="{{ route('admin.partners.update', $partner) }}" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="name" required value="{{ old('name', $partner->name) }}">
            <input class="field" name="tier" required value="{{ old('tier', $partner->tier) }}">
            <input class="field" name="logo_url" required value="{{ old('logo_url', $partner->logo_url) }}">
            <input class="field" name="website" value="{{ old('website', $partner->website) }}">
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->is_active))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
@endsection
