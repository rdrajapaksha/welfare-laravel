<article class="card-surface card-interactive overflow-hidden p-0">
    <div class="relative bg-ink-950">
        <div class="flex justify-center px-6 pt-8 pb-6">
            <x-person-photo :src="$member->photo_url" :name="$member->name" size="xl" />
        </div>
    </div>
    <div class="p-6">
        <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">{{ $member->translate('position') }}</p>
        <h3 class="mt-2 text-xl font-extrabold leading-snug">{{ $member->name }}</h3>
        @if ($member->translate('bio') !== '')
            <p class="mt-2 text-sm leading-relaxed text-ink-600">{{ $member->translate('bio') }}</p>
        @endif
        @if ($member->phone)
            <p class="mt-3 text-sm font-semibold">
                <a href="tel:{{ str_replace(' ', '', $member->phone) }}" class="text-brand-700 hover:underline">{{ $member->phone }}</a>
            </p>
        @endif
        <p class="mt-3 text-xs text-ink-500">{{ $d['about']['termLabel'] }} {{ $member->term_from }}–{{ $member->term_to ?? $d['about']['present'] }}</p>
    </div>
</article>
