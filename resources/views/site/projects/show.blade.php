@extends('layouts.site')
@section('title', $project->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $project->translate('title'), 'subtitle' => $project->translate('summary'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['projects']['title'], 'href' => '/projects'], ['label' => $project->translate('title')]]])
@php
    $gallery = $project->galleryPaths();
@endphp
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-3">
        <article class="lg:col-span-2 space-y-6 leading-relaxed text-ink-700">
            @if ($gallery !== [])
                <div class="overflow-hidden rounded-3xl {{ count($gallery) > 1 ? 'grid gap-3 '. (count($gallery) === 2 ? 'sm:grid-cols-2' : 'sm:grid-cols-3') : '' }}" x-data="{ active: null }">
                    @foreach ($gallery as $index => $path)
                        <button type="button" class="group relative block overflow-hidden {{ count($gallery) === 1 ? 'w-full' : '' }} {{ count($gallery) === 3 && $index === 0 ? 'sm:col-span-2 sm:row-span-2' : '' }}" @click="active = {{ $index }}">
                            <img src="{{ media_url($path) }}" alt="{{ $project->translate('title') }}" class="h-full w-full object-cover {{ count($gallery) === 1 ? 'max-h-[28rem] rounded-3xl' : 'aspect-[4/3] rounded-2xl' }} {{ count($gallery) === 3 && $index === 0 ? 'sm:aspect-[4/3] sm:min-h-full' : '' }}">
                        </button>
                    @endforeach
                    <div x-show="active !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-ink-950/80 p-6" @click.self="active = null">
                        <button type="button" class="absolute right-6 top-6 text-sm font-bold text-white" @click="active = null">{{ $d['common']['close'] }}</button>
                        @foreach ($gallery as $index => $path)
                            <img x-show="active === {{ $index }}" src="{{ media_url($path) }}" alt="{{ $project->translate('title') }}" class="max-h-[90vh] max-w-full rounded-2xl object-contain">
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="space-y-4">
                {!! $project->translate('body') !!}
            </div>
        </article>
        <aside class="card-surface h-fit space-y-4 p-6">
            <p class="inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.14em] ring-1 {{ $project->themeChipClass() }}">{{ $project->themeLabel() }}</p>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-teal-700">{{ $d['projects']['status'.ucfirst(strtolower($project->status))] ?? $project->status }}</p>
            @if ($project->location)
                <p>{{ $d['projects']['location'] }}: <strong>{{ $project->location }}</strong></p>
            @endif
            @if ($project->completed_at)
                <p>{{ $d['projects']['completedOn'] }}: <strong>{{ $project->completed_at->toFormattedDateString() }}</strong></p>
            @endif
            @if ($project->hasFundraising())
                <p>{{ $d['projects']['raised'] }}: <strong>{{ lkr($project->raised_amount) }}</strong></p>
                <p>{{ $d['projects']['target'] }}: <strong>{{ lkr($project->target_amount) }}</strong></p>
            @endif
            @if ((int) $project->spent_amount > 0)
                <p>{{ $d['projects']['spent'] }}: <strong>{{ lkr($project->spent_amount) }}</strong></p>
            @endif
            @if ((int) $project->beneficiaries > 0)
                <p>{{ $d['projects']['beneficiaries'] }}: <strong>{{ number_format($project->beneficiaries) }}</strong></p>
            @endif
            @if ($project->status === 'ONGOING' && $project->hasFundraising())
                <a href="{{ locale_url('/donations', ['project' => $project->slug]) }}" class="btn btn-brand w-full">{{ $d['projects']['fundProject'] }}</a>
            @endif
        </aside>
    </div>
</section>
@endsection
