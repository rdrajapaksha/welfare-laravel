@extends('layouts.site')

@section('title', $d['meta']['defaultTitle'])

@section('content')
<section class="relative overflow-hidden bg-canvas">
    <div class="mesh-brand pointer-events-none absolute inset-0"></div>
    <div class="container-page relative grid items-center gap-12 py-16 lg:grid-cols-12 lg:py-24">
        <div class="lg:col-span-6">
            <p class="inline-flex items-center gap-2 rounded-full border border-brand-200 bg-white/80 px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] text-brand-800">{{ $d['home']['heroEyebrow'] }}</p>
            <h1 class="mt-6 text-4xl font-extrabold tracking-tight sm:text-6xl lg:text-[4.1rem] lg:leading-[1.05]">
                {{ $d['home']['heroTitle'] }}
                <span class="text-gradient-brand accent-underline">{{ $d['home']['heroTitleAccent'] }}</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-relaxed text-ink-600">{{ $d['home']['heroSubtitle'] }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ locale_url('/donations') }}" class="btn btn-brand">{{ $d['home']['heroPrimaryCta'] }}</a>
                <a href="{{ locale_url('/join') }}" class="btn btn-outline">{{ $d['home']['heroSecondaryCta'] }}</a>
            </div>
            <p class="mt-6 text-sm font-medium text-ink-500">{{ $d['home']['heroTrust'] }}</p>
        </div>
        <div class="relative lg:col-span-6">
            <img src="{{ asset('media/hero-primary.svg') }}" alt="" class="rounded-3xl shadow-lift">
            <div class="absolute -bottom-6 left-4 max-w-xs rounded-2xl bg-white p-4 shadow-lift sm:left-8">
                <p class="text-xs font-bold uppercase tracking-wider text-brand-700">{{ $d['transparency']['ratioTitle'] }}</p>
                <p class="mt-1 text-2xl font-extrabold">{{ $directPct }}¢</p>
                <p class="text-xs text-ink-500">{{ $d['transparency']['ratioText'] }}</p>
            </div>
        </div>
    </div>
</section>

<section class="section-y">
    <div class="container-page">
        <p class="text-center text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['home']['statsTitle'] }}</p>
        <h2 class="mt-3 text-center text-3xl font-extrabold">{{ $d['home']['statsTitle'] }}</h2>
        <p class="mt-3 text-center text-ink-600">{{ $d['home']['statsSubtitle'] }}</p>
        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                [$d['home']['statMembers'], $memberCount, false],
                [$d['home']['statFamilies'], config('hla.impact.families_assisted'), false],
                [$d['home']['statDisbursed'], config('hla.impact.welfare_disbursed'), true],
                [$d['home']['statProjects'], config('hla.impact.projects'), false],
                [$d['home']['statVolunteers'], config('hla.impact.volunteers'), false],
                [$d['home']['statYears'], now()->year - config('hla.founded_year'), false],
            ] as $stat)
                <div class="card-surface card-interactive p-6">
                    <p class="text-sm font-semibold text-ink-500">{{ $stat[0] }}</p>
                    <p class="mt-3 text-3xl font-extrabold">{{ $stat[2] ? lkr((int) $stat[1]) : number_format((int) $stat[1]) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-y bg-white">
    <div class="container-page grid items-center gap-12 lg:grid-cols-2">
        <img src="{{ asset('media/about-team.svg') }}" alt="" class="rounded-3xl">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['home']['aboutEyebrow'] }}</p>
            <h2 class="mt-3 text-3xl font-extrabold">{{ $d['home']['aboutTitle'] }}</h2>
            <p class="mt-4 text-ink-600">{{ $d['home']['aboutText'] }}</p>
            <ul class="mt-6 space-y-2 text-sm text-ink-700">
                <li>{{ $d['home']['aboutPoint1'] }}</li>
                <li>{{ $d['home']['aboutPoint2'] }}</li>
                <li>{{ $d['home']['aboutPoint3'] }}</li>
            </ul>
            <a href="{{ locale_url('/about') }}" class="btn btn-ink mt-8">{{ $d['home']['aboutCta'] }}</a>
        </div>
    </div>
</section>

<section class="section-y">
    <div class="container-page">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['home']['servicesEyebrow'] }}</p>
                <h2 class="mt-3 text-3xl font-extrabold">{{ $d['home']['servicesTitle'] }}</h2>
                <p class="mt-3 max-w-2xl text-ink-600">{{ $d['home']['servicesSubtitle'] }}</p>
            </div>
            <a href="{{ locale_url('/services') }}" class="hidden text-sm font-bold text-brand-700 sm:inline">{{ $d['home']['servicesCta'] }}</a>
        </div>
        <div class="mt-10 grid gap-5 md:grid-cols-2">
            @foreach ($programmes as $programme)
                <a href="{{ route('services.show', $programme) }}" class="card-surface card-interactive p-6">
                    <p class="text-xs font-bold uppercase text-brand-700">{{ $programme->category }}</p>
                    <h3 class="mt-2 text-xl font-extrabold">{{ $programme->translate('title') }}</h3>
                    <p class="mt-2 text-sm text-ink-600">{{ $programme->translate('summary') }}</p>
                    @if ($programme->benefit_amount)
                        <p class="mt-4 text-sm font-bold">{{ $d['services']['benefitUpTo'] }} {{ lkr($programme->benefit_amount) }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section-y bg-white">
    <div class="container-page">
        <h2 class="text-3xl font-extrabold">{{ $d['home']['projectsTitle'] }}</h2>
        <p class="mt-3 text-ink-600">{{ $d['home']['projectsSubtitle'] }}</p>
        <div class="mt-10 grid gap-5 lg:grid-cols-3">
            @foreach ($projects as $project)
                <a href="{{ route('projects.show', $project) }}" class="card-surface card-interactive overflow-hidden">
                    <img src="{{ asset(ltrim($project->cover_image ?? '/media/community-hall.svg', '/')) }}" alt="" class="h-40 w-full object-cover">
                    <div class="p-5">
                        <p class="text-xs font-bold uppercase text-teal-700">{{ $project->status }}</p>
                        <h3 class="mt-2 font-extrabold">{{ $project->translate('title') }}</h3>
                        <p class="mt-2 text-sm text-ink-600">{{ $project->translate('summary') }}</p>
                        <p class="mt-4 text-sm font-semibold">{{ $d['projects']['raised'] }} {{ lkr($project->raised_amount) }} / {{ lkr($project->target_amount) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-2">
        <div>
            <h2 class="text-3xl font-extrabold">{{ $d['home']['newsTitle'] }}</h2>
            <div class="mt-6 space-y-4">
                @foreach ($news as $post)
                    <a href="{{ route('news.show', $post) }}" class="card-surface block p-5">
                        <p class="text-xs text-ink-500">{{ optional($post->published_at)->format('d M Y') }}</p>
                        <h3 class="mt-1 font-extrabold">{{ $post->translate('title') }}</h3>
                        <p class="mt-1 text-sm text-ink-600">{{ $post->translate('excerpt') }}</p>
                    </a>
                @endforeach
            </div>
        </div>
        <div>
            <h2 class="text-3xl font-extrabold">{{ $d['home']['eventsTitle'] }}</h2>
            <div class="mt-6 space-y-4">
                @forelse ($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="card-surface block p-5">
                        <p class="text-xs text-ink-500">{{ $event->starts_at->format('d M Y · H:i') }}</p>
                        <h3 class="mt-1 font-extrabold">{{ $event->translate('title') }}</h3>
                        <p class="mt-1 text-sm text-ink-600">{{ $event->venue }}, {{ $event->city }}</p>
                    </a>
                @empty
                    <p class="text-ink-500">{{ $d['events']['noUpcoming'] }}</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="section-y bg-white">
    <div class="container-page">
        <h2 class="text-3xl font-extrabold">{{ $d['home']['faqTitle'] }}</h2>
        <div class="mt-8 divide-y divide-ink-200 rounded-2xl border border-ink-200 bg-white" x-data="{ open: 0 }">
            @foreach ($faqs as $i => $faq)
                <div>
                    <button type="button" class="flex w-full items-center justify-between px-5 py-4 text-left font-bold" @click="open = open === {{ $i }} ? null : {{ $i }}">
                        {{ $faq->translate('question') }}
                    </button>
                    <div x-show="open === {{ $i }}" x-cloak class="px-5 pb-4 text-sm text-ink-600">{{ $faq->translate('answer') }}</div>
                </div>
            @endforeach
        </div>
        <a href="{{ locale_url('/faq') }}" class="mt-6 inline-block text-sm font-bold text-brand-700">{{ $d['home']['faqCta'] }}</a>
    </div>
</section>

<section class="section-y">
    <div class="container-page rounded-[2rem] bg-ink-950 px-8 py-14 text-white lg:px-16">
        <h2 class="text-3xl font-extrabold">{{ $d['home']['ctaTitle'] }}</h2>
        <p class="mt-3 max-w-2xl text-ink-300">{{ $d['home']['ctaText'] }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ locale_url('/donations') }}" class="btn btn-brand">{{ $d['home']['ctaDonate'] }}</a>
            <a href="{{ locale_url('/join') }}" class="btn border border-white/30 text-white">{{ $d['home']['ctaJoin'] }}</a>
            <a href="{{ locale_url('/volunteer') }}" class="btn border border-white/30 text-white">{{ $d['home']['ctaVolunteer'] }}</a>
        </div>
    </div>
</section>
@endsection
