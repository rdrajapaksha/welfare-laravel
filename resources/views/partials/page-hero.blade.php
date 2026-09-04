<section class="relative overflow-hidden bg-ink-950 text-white">
    <div class="mesh-ink pointer-events-none absolute inset-0"></div>
    <div class="container-page relative py-14 lg:py-20">
        @isset($crumbs)
            <nav aria-label="{{ $d['a11y']['breadcrumb'] }}" class="text-xs font-semibold text-ink-300">
                @foreach ($crumbs as $i => $crumb)
                    @if ($i > 0)<span class="px-2 text-ink-500">/</span>@endif
                    @if (! empty($crumb['href']))
                        <a href="{{ locale_url($crumb['href']) }}" class="hover:text-white">{{ $crumb['label'] }}</a>
                    @else
                        <span class="text-white">{{ $crumb['label'] }}</span>
                    @endif
                @endforeach
            </nav>
        @endisset
        <h1 class="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $title }}</h1>
        @isset($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-ink-300">{{ $subtitle }}</p>
        @endisset
        @isset($actions)
            <div class="mt-8 flex flex-wrap gap-3">{{ $actions }}</div>
        @endisset
    </div>
</section>
