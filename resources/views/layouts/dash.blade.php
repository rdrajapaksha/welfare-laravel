<!DOCTYPE html>
<html lang="{{ config('hla.locale_meta')[$locale]['html'] ?? 'en-LK' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', $d['meta']['defaultTitle'])</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Sinhala:wght@400;600;700&family=Noto+Sans+Tamil:wght@400;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-canvas font-sans text-ink-900" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen lg:grid lg:grid-cols-[17rem_1fr]">
            <div class="flex items-center justify-between border-b border-ink-200 bg-white px-4 py-3 lg:hidden">
                <a href="{{ locale_url('/') }}" class="flex items-center gap-2">
                    <img src="{{ asset('logo.png') }}" alt="" class="h-8 w-8">
                    <span class="text-sm font-extrabold">{{ request()->routeIs('admin.*') ? $d['admin']['title'] : $d['dashboard']['title'] }}</span>
                </a>
                <button type="button" class="grid h-10 w-10 place-items-center rounded-full border border-ink-200" @click="sidebarOpen = true" aria-label="{{ $d['nav']['openMenu'] }}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 bg-ink-950/50 lg:hidden" @click="sidebarOpen = false"></div>
            <aside
                class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-ink-200 bg-white lg:static lg:z-0 lg:w-auto lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <div class="flex items-center justify-between gap-2 border-b border-ink-100 px-4 py-4">
                    <a href="{{ locale_url('/') }}" class="flex min-w-0 items-center gap-2">
                        <img src="{{ asset('logo.png') }}" alt="" class="h-8 w-8 shrink-0">
                        <span class="truncate text-sm font-extrabold">{{ request()->routeIs('admin.*') ? $d['admin']['title'] : $d['dashboard']['title'] }}</span>
                    </a>
                    <button type="button" class="grid h-9 w-9 place-items-center rounded-full border lg:hidden" @click="sidebarOpen = false">×</button>
                </div>
                <nav class="flex-1 space-y-1 overflow-y-auto p-3">
                    @foreach (request()->routeIs('admin.*') ? $adminNav : $memberNav as $link)
                        <a href="{{ locale_url($link['href']) }}" class="block rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->is('*/'.ltrim($link['href'], '/')) || request()->is('*/'.ltrim($link['href'], '/').'/*') ? 'bg-brand-50 text-brand-800' : 'text-ink-700 hover:bg-ink-50' }}">{{ $link['label'] }}</a>
                    @endforeach
                </nav>
                <form method="POST" action="{{ route('logout') }}" class="border-t border-ink-100 p-4">
                    @csrf
                    <button class="text-sm font-bold text-ink-500">{{ $d['nav']['logout'] }}</button>
                </form>
            </aside>
            <div class="min-w-0">
                @if (session('status'))
                    <div class="m-4 rounded-2xl bg-teal-50 px-4 py-3 text-sm text-teal-900">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="m-4 rounded-2xl bg-brand-50 px-4 py-3 text-sm text-brand-900">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="m-4 rounded-2xl bg-brand-50 px-4 py-3 text-sm text-brand-900">{{ $errors->first() }}</div>
                @endif
                <div class="p-4 sm:p-6 lg:p-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
