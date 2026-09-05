@extends('layouts.site')
@section('title', $d['projects']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['projects']['title'], 'subtitle' => $d['projects']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['projects']['title']]]])
<section class="section-y">
    <div class="container-page">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('projects.index') }}" class="rounded-full px-4 py-2 text-sm font-bold {{ $selectedTheme === null ? 'bg-brand-600 text-white' : 'bg-white text-ink-700 ring-1 ring-ink-200' }}">{{ $d['projects']['filterAll'] }}</a>
            @foreach (\App\Support\CommunityWork::themes() as $theme)
                <a href="{{ route('projects.index', ['theme' => $theme]) }}" class="rounded-full px-4 py-2 text-sm font-bold ring-1 {{ $selectedTheme === $theme ? 'bg-brand-600 text-white ring-brand-600' : \App\Models\Project::themeChipClassFor($theme) }}">{{ $d['projects']['themes'][strtolower($theme)] }}</a>
            @endforeach
        </div>

        @if ($selectedTheme === null && $projects->isNotEmpty())
            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                <div class="card-surface p-5">
                    <p class="text-3xl font-extrabold">{{ $projects->count() }}</p>
                    <p class="mt-1 text-sm text-ink-500">{{ $d['projects']['title'] }}</p>
                </div>
                <div class="card-surface p-5">
                    <p class="text-3xl font-extrabold">{{ $projects->min('completed_at')?->format('Y') }}–{{ $projects->max('completed_at')?->format('Y') }}</p>
                    <p class="mt-1 text-sm text-ink-500">{{ $d['projects']['completedOn'] }}</p>
                </div>
            </div>
        @endif

        @forelse ($grouped as $theme => $items)
            <div class="mt-12">
                <div class="flex items-center gap-3">
                    <span class="h-10 w-1.5 rounded-full {{ \App\Models\Project::themeBarClassFor($theme) }}"></span>
                    <div>
                        <p class="eyebrow">{{ $d['projects']['themes'][strtolower($theme)] }}</p>
                        <h2 class="text-2xl font-extrabold">{{ $d['projects']['themes'][strtolower($theme)] }}</h2>
                    </div>
                </div>
                <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($items as $project)
                        @include('partials.project-card', ['project' => $project])
                    @endforeach
                </div>
            </div>
        @empty
            <p class="mt-10 text-ink-500">{{ $d['common']['noResults'] }}</p>
        @endforelse
    </div>
</section>
@endsection
