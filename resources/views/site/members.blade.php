@extends('layouts.site')
@section('title', $d['members']['directoryTitle'])
@section('content')
@include('partials.page-hero', ['title' => $d['members']['directoryTitle'], 'subtitle' => $d['members']['directorySubtitle']])
<section class="section-y">
    <div class="container-page">
        <form class="mb-8 grid gap-3 sm:grid-cols-4" method="GET">
            <input class="field" name="q" value="{{ $search }}" placeholder="{{ $d['members']['searchPlaceholder'] }}">
            <select class="field" name="district">
                <option value="">{{ $d['members']['filterDistrict'] }}</option>
                @foreach ($districts as $item)
                    <option value="{{ $item }}" @selected($district === $item)>{{ $item }}</option>
                @endforeach
            </select>
            <select class="field" name="type">
                <option value="">{{ $d['members']['filterType'] }}</option>
                <option value="ORDINARY" @selected($type === 'ORDINARY')>{{ $d['members']['typeOrdinary'] }}</option>
                <option value="JUNIOR" @selected($type === 'JUNIOR')>{{ $d['members']['typeJunior'] }}</option>
            </select>
            <button class="btn btn-ink">{{ $d['common']['search'] }}</button>
        </form>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($members as $member)
                <article class="card-surface flex items-center gap-4 p-5">
                    <x-person-photo :src="$member->photo_url" :name="$member->full_name" size="sm" />
                    <div class="min-w-0">
                        <h2 class="font-extrabold">{{ $member->full_name }}</h2>
                        <p class="text-sm text-ink-500">{{ $member->membership_no }} · {{ $member->city }}</p>
                        <p class="mt-1 text-xs">{{ $member->membership_type }}</p>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $members->links() }}</div>
    </div>
</section>
@endsection
