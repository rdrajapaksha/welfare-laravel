@extends('layouts.site')

@section('title', $d['auth']['loginTitle'])

@section('content')
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-2">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $d['brand']['tagline'] }}</p>
            <h1 class="mt-3 text-4xl font-extrabold">{{ $d['auth']['loginTitle'] }}</h1>
            <p class="mt-3 max-w-lg text-ink-600">{{ $d['auth']['loginSubtitle'] }}</p>
            <p class="mt-6 text-sm text-ink-500">{{ $d['auth']['noAccount'] }} <a class="font-bold text-brand-700" href="{{ locale_url('/join') }}">{{ $d['auth']['joinCta'] }}</a></p>
        </div>
        <div class="card-surface p-6 sm:p-8">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label" for="email">{{ $d['auth']['email'] }}</label>
                    <input id="email" class="field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')<p class="mt-1 text-xs text-brand-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="password">{{ $d['auth']['password'] }}</label>
                    <input id="password" class="field" type="password" name="password" required autocomplete="current-password">
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember">
                    {{ $d['auth']['rememberMe'] }}
                </label>
                <button class="btn btn-brand w-full" type="submit">{{ $d['auth']['loginCta'] }}</button>
                <a class="block text-center text-sm font-semibold text-ink-500" href="{{ route('password.request') }}">{{ $d['auth']['forgotPassword'] }}</a>
            </form>
            <div class="mt-8 rounded-2xl bg-ink-50 p-4 text-sm">
                <p class="font-bold">{{ $d['auth']['demoTitle'] }}</p>
                <p class="mt-1 text-ink-600">{{ $d['auth']['demoNote'] }}</p>
                <p class="mt-3"><span class="font-semibold">{{ $d['auth']['demoAdmin'] }}</span> admin@heartlinkallianz.lk / Admin@hla2026</p>
                <p><span class="font-semibold">{{ $d['auth']['demoMember'] }}</span> member@heartlinkallianz.lk / Member@hla2026</p>
            </div>
        </div>
    </div>
</section>
@endsection
