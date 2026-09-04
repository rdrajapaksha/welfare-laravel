<article class="card-surface card-interactive flex h-full min-h-[26rem] flex-col overflow-hidden p-0">
    <div class="relative flex min-h-[11.5rem] items-center justify-center overflow-hidden bg-gradient-to-br from-ink-950 via-ink-900 to-brand-900 px-6 py-8">
        <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-gold-400/20"></div>
        <x-person-photo :src="$member->photo_url" :name="$member->name" size="lg" />
    </div>
    <div class="flex flex-1 flex-col gap-3 p-6">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-gold-700">{{ $member->translate('position') }}</p>
        <h3 class="text-xl font-extrabold leading-snug">{{ $member->name }}</h3>
        @if ($member->translate('bio') !== '')
            <p class="line-clamp-3 text-sm leading-relaxed text-ink-600">{{ $member->translate('bio') }}</p>
        @endif
        @if ($member->phone)
            <p class="text-sm font-semibold">
                <a href="tel:{{ str_replace(' ', '', $member->phone) }}" class="text-brand-700 hover:underline">{{ $member->phone }}</a>
            </p>
        @endif
        @if ($member->email)
            <p class="text-sm">
                <a href="mailto:{{ $member->email }}" class="text-ink-600 hover:text-brand-700">{{ $member->email }}</a>
            </p>
        @endif
        <p class="mt-auto pt-1 text-xs font-medium text-ink-500">{{ $d['about']['termLabel'] }} {{ $member->term_from }}–{{ $member->term_to ?? $d['about']['present'] }}</p>
    </div>
</article>
