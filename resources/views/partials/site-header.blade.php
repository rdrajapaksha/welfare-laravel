@php
    $user = auth()->user();
    $dashboardHref = $user?->isAdmin() ? locale_url('/admin') : locale_url('/dashboard');
    $path = '/'.implode('/', array_slice(request()->segments(), 1));
    if ($path === '/') {
        $path = '';
    }
    $isActive = function (string $href) use ($path): bool {
        $clean = parse_url($href, PHP_URL_PATH) ?: $href;
        if ($clean === '/' || $clean === '') {
            return $path === '' || $path === '/';
        }
        return $path === $clean || str_starts_with($path, $clean.'/');
    };
@endphp

<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-full focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">{{ $d['nav']['skipToContent'] }}</a>

<div class="hidden bg-ink-950 text-ink-200 lg:block">
    <div class="container-page flex h-10 items-center justify-between text-[0.8125rem]">
        <div class="flex items-center gap-6">
            <a href="tel:{{ $site['contact']['hotline'] }}" class="inline-flex items-center gap-1.5 transition hover:text-white">
                <span class="text-ink-400">{{ $d['contact']['hotline'] }}:</span>
                <span class="font-semibold text-white">{{ $site['contact']['hotline_display'] }}</span>
            </a>
            <a href="mailto:{{ $site['contact']['email'] }}" class="transition hover:text-white">{{ $site['contact']['email'] }}</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-ink-400">{{ $site['registration_no'] }}</span>
            <span class="h-3.5 w-px bg-white/20" aria-hidden="true"></span>
            @auth
                <a href="{{ $dashboardHref }}" class="font-semibold text-white">{{ $d['nav']['dashboard'] }}</a>
            @else
                <a href="{{ locale_url('/login') }}" class="font-semibold text-white transition hover:text-brand-300">{{ $d['nav']['login'] }}</a>
            @endauth
        </div>
    </div>
</div>

<header
    x-data="{ scrolled: false, mobileOpen: false, openSection: null }"
    x-init="scrolled = window.scrollY > 12"
    @scroll.window="scrolled = window.scrollY > 12"
    class="sticky top-0 z-50 overflow-x-clip transition-all duration-300"
    :class="scrolled ? 'glass-panel border-b border-ink-200/60 shadow-soft' : 'border-b border-transparent bg-canvas'"
>
    <div class="container-page flex items-center gap-2.5 py-2">
        <a href="{{ locale_url('/') }}" class="group flex min-w-0 flex-1 items-center gap-2.5">
            <span class="flex shrink-0 flex-col items-center gap-0.5">
                <span class="inline-flex animate-logo-spin">
                    <img src="{{ asset('logo.png') }}" alt="{{ $d['brand']['full'] }}" class="h-10 w-10 object-contain">
                </span>
                <span class="max-w-[9.5rem] text-center font-times text-[0.7rem] leading-snug text-ink-800 italic">{{ $d['brand']['tagline'] }}</span>
            </span>
            <span class="min-w-0 text-[0.75rem] font-extrabold leading-snug tracking-tight text-ink-950 sm:text-[0.88rem] lg:text-[0.95rem]">{{ $d['brand']['full'] }}</span>
        </a>

        <div class="flex shrink-0 items-center gap-2">
            <div class="hidden sm:flex items-center gap-1 rounded-full border border-ink-200 bg-white p-0.5 text-xs font-bold">
                @foreach ($site['locale_meta'] as $code => $meta)
                    <a href="{{ switch_locale_url($code) }}" class="rounded-full px-2 py-1 {{ $locale === $code ? 'bg-brand-600 text-white' : 'text-ink-600 hover:text-brand-700' }}">{{ $meta['short'] }}</a>
                @endforeach
            </div>
            <a href="{{ locale_url('/donations') }}" class="inline-flex h-9 items-center rounded-full bg-brand-600 px-3 text-xs font-bold text-white shadow-glow transition hover:bg-brand-700 sm:text-sm">
                {{ $d['nav']['donateNow'] }}
            </a>
            <button type="button" class="grid h-9 w-9 place-items-center rounded-full border border-ink-200 text-ink-800 xl:hidden" @click="mobileOpen = true" aria-label="{{ $d['nav']['openMenu'] }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <nav aria-label="{{ $d['a11y']['mainNav'] }}" class="hidden border-t border-ink-200/70 xl:block">
        <ul class="container-page flex flex-wrap items-center justify-center gap-x-0.5 py-1">
            @foreach ($siteNav as $item)
                <li class="group relative">
                    <a href="{{ locale_url($item['href']) }}" class="inline-flex items-center gap-1 rounded-full px-2.5 py-1.5 text-[0.78rem] font-semibold whitespace-nowrap {{ $isActive($item['href']) ? 'bg-brand-50 text-brand-700' : 'text-ink-700 hover:bg-ink-100/70 hover:text-brand-700' }}">
                        {{ $item['label'] }}
                        @if (! empty($item['children']))
                            <svg class="h-3.5 w-3.5 transition group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        @endif
                    </a>
                    @if (! empty($item['children']))
                        <div class="pointer-events-none absolute top-full left-1/2 z-50 w-64 -translate-x-1/2 pt-2 opacity-0 transition group-hover:pointer-events-auto group-hover:opacity-100">
                            <ul class="overflow-hidden rounded-2xl border border-ink-200 bg-white p-2 shadow-lift">
                                @foreach ($item['children'] as $child)
                                    <li>
                                        <a href="{{ locale_url($child['href']) }}" class="block rounded-xl px-3 py-2 text-sm font-medium text-ink-700 hover:bg-brand-50 hover:text-brand-800">{{ $child['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>

    <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-50 xl:hidden" style="display:none">
        <button type="button" class="absolute inset-0 bg-ink-950/60" @click="mobileOpen = false" aria-label="{{ $d['nav']['closeMenu'] }}"></button>
        <div class="absolute inset-y-0 right-0 flex w-full max-w-sm flex-col bg-canvas shadow-2xl">
            <div class="flex items-center justify-between border-b border-ink-200 px-5 py-3">
                <span class="text-sm font-extrabold">{{ $d['brand']['full'] }}</span>
                <button type="button" class="grid h-9 w-9 place-items-center rounded-full border" @click="mobileOpen = false">×</button>
            </div>
            <nav class="flex-1 overflow-y-auto px-4 py-5">
                <ul class="flex flex-col gap-1">
                    @foreach ($siteNav as $item)
                        <li>
                            <a href="{{ locale_url($item['href']) }}" class="block rounded-xl px-3 py-3 text-[0.9375rem] font-semibold {{ $isActive($item['href']) ? 'bg-brand-50 text-brand-800' : 'text-ink-800' }}">{{ $item['label'] }}</a>
                            @if (! empty($item['children']))
                                <ul class="ml-3 border-l border-ink-200 pl-3">
                                    @foreach ($item['children'] as $child)
                                        <li><a href="{{ locale_url($child['href']) }}" class="block px-3 py-2 text-sm text-ink-600">{{ $child['label'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
            <div class="space-y-3 border-t border-ink-200 p-5">
                <div class="flex items-center gap-1">
                    @foreach ($site['locale_meta'] as $code => $meta)
                        <a href="{{ switch_locale_url($code) }}" class="rounded-full px-2 py-1 text-xs font-bold {{ $locale === $code ? 'bg-brand-600 text-white' : 'border border-ink-200' }}">{{ $meta['short'] }}</a>
                    @endforeach
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ locale_url('/join') }}" class="btn btn-outline h-11">{{ $d['nav']['join'] }}</a>
                    <a href="{{ locale_url('/donations') }}" class="btn btn-brand h-11">{{ $d['nav']['donateNow'] }}</a>
                </div>
            </div>
        </div>
    </div>
</header>
