<footer class="mt-auto bg-ink-950 text-ink-200">
    <div class="mesh-ink border-b border-white/10">
        <div class="container-page grid gap-10 py-14 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <a href="{{ locale_url('/') }}" class="inline-flex max-w-full items-center gap-3">
                    <span class="flex shrink-0 flex-col items-center gap-1.5">
                        <img src="{{ asset('logo.png') }}" alt="{{ $d['brand']['full'] }}" class="h-14 w-14 object-contain">
                        <span class="max-w-[11rem] text-center font-times text-[0.85rem] leading-snug text-brand-200 italic">{{ $d['brand']['tagline'] }}</span>
                    </span>
                    <span class="text-base font-extrabold text-white sm:text-lg">{{ $d['brand']['full'] }}</span>
                </a>
                <p class="mt-5 max-w-md text-sm leading-relaxed text-ink-300">{{ $d['footer']['aboutText'] }}</p>
                <div class="mt-6 space-y-2.5 text-sm">
                    <p>{{ $site['contact']['street'] }}, {{ $site['contact']['locality'] }} {{ $site['contact']['postal_code'] }}, {{ $site['contact']['country_name'] }}</p>
                    <p><a href="tel:{{ $site['contact']['phone'] }}" class="hover:text-white">{{ $site['contact']['phone_display'] }}</a></p>
                    <p><a href="mailto:{{ $site['contact']['email'] }}" class="hover:text-white">{{ $site['contact']['email'] }}</a></p>
                </div>
            </div>
            <nav aria-label="{{ $d['a11y']['footerNav'] }}" class="grid gap-8 sm:grid-cols-2 lg:col-span-5">
                @foreach ($footerNav as $column)
                    <div>
                        <h3 class="text-sm font-bold text-white">{{ $column['title'] }}</h3>
                        <ul class="mt-4 space-y-2.5 text-sm">
                            @foreach ($column['links'] as $link)
                                <li><a href="{{ locale_url($link['href']) }}" class="text-ink-300 transition hover:text-brand-300">{{ $link['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
            <div class="lg:col-span-3">
                <h3 class="text-sm font-bold text-white">{{ $d['footer']['newsletterTitle'] }}</h3>
                <p class="mt-3 text-sm text-ink-300">{{ $d['footer']['newsletterText'] }}</p>
                <form method="POST" action="{{ route('newsletter.store') }}" class="mt-4 flex gap-2">
                    @csrf
                    <input type="email" name="email" required placeholder="{{ $d['forms']['emailPlaceholder'] }}" class="field flex-1 bg-white/10 text-white placeholder:text-ink-400 border-white/20">
                    <button type="submit" class="btn btn-brand h-10 px-4">{{ $d['footer']['newsletterCta'] }}</button>
                </form>
                <div class="mt-6 rounded-2xl border border-white/12 bg-white/5 p-4">
                    <p class="text-sm font-semibold text-white">{{ $d['transparency']['pledgeTitle'] }}</p>
                    <p class="mt-1.5 text-xs leading-relaxed text-ink-300">{{ $d['transparency']['pledge2'] }}</p>
                    <a href="{{ locale_url('/transparency') }}" class="mt-3 inline-block text-xs font-bold text-brand-300 underline">{{ $d['transparency']['reportsTitle'] }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-page flex flex-col gap-3 py-6 text-xs text-ink-400 sm:flex-row sm:items-center sm:justify-between">
        <p>© {{ now()->year }} {{ $d['brand']['full'] }}. {{ $d['footer']['rights'] }} · {{ $d['brand']['regNo'] }}</p>
        <ul class="flex flex-wrap gap-5">
            <li><a href="{{ locale_url('/privacy') }}" class="hover:text-white">{{ $d['footer']['privacy'] }}</a></li>
            <li><a href="{{ locale_url('/terms') }}" class="hover:text-white">{{ $d['footer']['terms'] }}</a></li>
            <li><a href="{{ locale_url('/faq') }}" class="hover:text-white">{{ $d['nav']['faq'] }}</a></li>
            <li><a href="{{ locale_url('/contact') }}" class="hover:text-white">{{ $d['nav']['contact'] }}</a></li>
        </ul>
    </div>
</footer>
