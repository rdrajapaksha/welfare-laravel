@extends('layouts.site')
@section('title', $d['contact']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['contact']['title'], 'subtitle' => $d['contact']['subtitle']])
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-2">
        <form method="POST" action="{{ route('contact.store') }}" class="card-surface space-y-3 p-6">
            @csrf
            <input class="field" name="name" required placeholder="{{ $d['forms']['fullName'] }}" value="{{ old('name') }}">
            <input class="field" type="email" name="email" required placeholder="{{ $d['forms']['email'] }}" value="{{ old('email') }}">
            <input class="field" name="phone" placeholder="{{ $d['forms']['phone'] }}">
            <select class="field" name="topic">
                <option value="GENERAL">{{ $d['contact']['topicGeneral'] }}</option>
                <option value="MEMBERSHIP">{{ $d['contact']['topicMembership'] }}</option>
                <option value="DONATION">{{ $d['contact']['topicDonation'] }}</option>
                <option value="WELFARE">{{ $d['contact']['topicWelfare'] }}</option>
                <option value="VOLUNTEER">{{ $d['contact']['topicVolunteer'] }}</option>
            </select>
            <input class="field" name="subject" required placeholder="{{ $d['forms']['subject'] }}">
            <textarea class="field" name="message" rows="5" required placeholder="{{ $d['forms']['message'] }}">{{ old('message') }}</textarea>
            <button class="btn btn-brand" type="submit">{{ $d['common']['submit'] }}</button>
        </form>
        <div class="space-y-4">
            <div class="card-surface p-6">
                <h2 class="font-extrabold">{{ $d['contact']['detailsTitle'] }}</h2>
                <p class="mt-3 text-sm">{{ $site['contact']['street'] }}</p>
                <p class="text-sm">{{ $site['contact']['locality'] }} {{ $site['contact']['postal_code'] }}</p>
                <p class="text-sm">{{ $site['contact']['region'] }}, {{ $site['contact']['country_name'] }}</p>
                <p class="mt-3 text-sm">{{ $site['registration_no'] }}</p>
                <p class="text-sm">{{ $site['contact']['phone_display'] }}</p>
                <p class="text-sm">{{ $d['contact']['hotline'] }}: {{ $site['contact']['hotline_display'] }}</p>
                <p class="text-sm">{{ $site['contact']['email'] }}</p>
                <p class="mt-2 text-sm text-ink-500">{{ $d['contact']['officeHoursValue'] }}</p>
            </div>
            <iframe title="{{ $d['contact']['mapTitle'] }}" src="{{ $site['contact']['map_embed'] }}" class="h-64 w-full rounded-2xl border-0"></iframe>
        </div>
    </div>
</section>
@endsection
