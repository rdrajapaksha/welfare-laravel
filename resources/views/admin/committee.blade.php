@extends('layouts.dash')
@section('title', $d['admin']['committeePage'])
@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['admin']['title'] }}</p>
        <h1 class="mt-1 text-3xl font-extrabold">{{ $d['admin']['committeePage'] }}</h1>
        <p class="mt-2 max-w-2xl text-ink-600">{{ $d['admin']['committeeHint'] }}</p>
    </div>
    <a href="{{ locale_url('/about/committee') }}" class="btn btn-outline">{{ $d['admin']['viewPublicPage'] }}</a>
</div>

<section class="mt-10">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="text-2xl font-extrabold">{{ $d['about']['committeeTitle'] }}</h2>
            <p class="mt-1 text-sm text-ink-500">{{ $d['nav']['committee'] }}</p>
        </div>
        <a href="{{ locale_url('/about/committee') }}" class="text-sm font-bold text-brand-700">{{ $d['admin']['viewPublicPage'] }}</a>
    </div>
    @include('admin.partials.board-form', ['board' => 'EXECUTIVE', 'members' => $executive])
</section>

<section class="mt-14">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="text-2xl font-extrabold">{{ $d['about']['advisoryTitle'] }}</h2>
            <p class="mt-1 max-w-2xl text-sm text-ink-500">{{ $d['admin']['advisoryHint'] }}</p>
        </div>
        <a href="{{ locale_url('/about/advisory') }}" class="text-sm font-bold text-brand-700">{{ $d['admin']['viewPublicPage'] }}</a>
    </div>
    @include('admin.partials.board-form', ['board' => 'ADVISORY', 'members' => $advisory])
</section>
@endsection
