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
    <body class="bg-canvas font-sans text-ink-900">
        <div class="min-h-screen lg:grid lg:grid-cols-[16rem_1fr]">
            <aside class="border-b border-ink-200 bg-white p-4 lg:border-b-0 lg:border-r">
                <a href="{{ locale_url('/') }}" class="flex items-center gap-2">
                    <img src="{{ asset('logo.png') }}" alt="" class="h-8 w-8">
                    <span class="text-sm font-extrabold">{{ request()->routeIs('admin.*') ? $d['admin']['title'] : $d['dashboard']['title'] }}</span>
                </a>
                <nav class="mt-6 space-y-1">
                    @foreach (request()->routeIs('admin.*') ? $adminNav : $memberNav as $link)
                        <a href="{{ locale_url($link['href']) }}" class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->is('*/'.ltrim($link['href'], '/')) || request()->is('*/'.ltrim($link['href'], '/').'/*') ? 'bg-brand-50 text-brand-800' : 'text-ink-700 hover:bg-ink-50' }}">{{ $link['label'] }}</a>
                    @endforeach
                </nav>
                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button class="text-sm font-bold text-ink-500">{{ $d['nav']['logout'] }}</button>
                </form>
            </aside>
            <div>
                @if (session('status'))
                    <div class="m-4 rounded-2xl bg-teal-50 px-4 py-3 text-sm text-teal-900">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="m-4 rounded-2xl bg-brand-50 px-4 py-3 text-sm text-brand-900">{{ session('error') }}</div>
                @endif
                <div class="p-6 lg:p-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
