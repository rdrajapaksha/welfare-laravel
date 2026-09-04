@extends('layouts.site')
@section('title', $d['volunteer']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['volunteer']['title'], 'subtitle' => $d['volunteer']['subtitle']])
<section class="section-y">
    <div class="container-page max-w-2xl">
        <form method="POST" action="{{ route('volunteer.store') }}" class="card-surface space-y-3 p-6">
            @csrf
            <input class="field" name="full_name" required placeholder="{{ $d['forms']['fullName'] }}" value="{{ old('full_name') }}">
            <input class="field" type="email" name="email" required placeholder="{{ $d['forms']['email'] }}" value="{{ old('email') }}">
            <input class="field" name="phone" required placeholder="{{ $d['forms']['phone'] }}">
            <input class="field" name="city" required placeholder="{{ $d['forms']['city'] }}">
            <input class="field" name="district" required placeholder="{{ $d['forms']['district'] }}">
            <p class="text-sm font-semibold">{{ $d['volunteer']['interestsLabel'] }}</p>
            <div class="grid grid-cols-2 gap-2 text-sm">
                @foreach (['events','medical','education','fundraising','media','logistics','admin','it'] as $area)
                    <label class="flex items-center gap-2"><input type="checkbox" name="interests[]" value="{{ $area }}"> {{ $d['volunteer']['area'.ucfirst($area)] ?? $area }}</label>
                @endforeach
            </div>
            @error('interests')<p class="text-xs text-brand-700">{{ $message }}</p>@enderror
            <select class="field" name="availability" required>
                <option value="WEEKENDS">{{ $d['volunteer']['availabilityWeekends'] }}</option>
                <option value="WEEKDAYS">{{ $d['volunteer']['availabilityWeekdays'] }}</option>
                <option value="EVENINGS">{{ $d['volunteer']['availabilityEvenings'] }}</option>
                <option value="FLEXIBLE">{{ $d['volunteer']['availabilityFlexible'] }}</option>
            </select>
            <input class="field" type="number" name="hours_per_month" min="4" value="8">
            <button class="btn btn-brand" type="submit">{{ $d['volunteer']['submitCta'] }}</button>
        </form>
    </div>
</section>
@endsection
