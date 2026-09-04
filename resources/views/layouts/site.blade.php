<!DOCTYPE html>
<html lang="{{ config('hla.locale_meta')[$locale]['html'] ?? 'en-LK' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', $d['meta']['defaultTitle'])</title>
        <meta name="description" content="@yield('description', $d['meta']['description'])">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Sinhala:wght@400;600;700&family=Noto+Sans+Tamil:wght@400;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-canvas font-sans antialiased text-ink-900">
        @include('partials.site-header')
        <main id="main" class="flex-1">
            @if (session('status'))
                <div class="container-page pt-6">
                    <div class="rounded-2xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900">{{ session('status') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="container-page pt-6">
                    <div class="rounded-2xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm font-medium text-brand-900">{{ session('error') }}</div>
                </div>
            @endif
            @yield('content')
        </main>
        @include('partials.site-footer')
    </body>
</html>
