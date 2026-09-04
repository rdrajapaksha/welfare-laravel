<article class="card-surface p-6">
    <p class="text-xs font-bold uppercase text-brand-700">{{ $member->translate('position') }}</p>
    <h3 class="mt-2 text-xl font-extrabold">{{ $member->name }}</h3>
    @if ($member->translate('bio') !== '')
        <p class="mt-2 text-sm text-ink-600">{{ $member->translate('bio') }}</p>
    @endif
    @if ($member->phone)
        <p class="mt-2 text-sm font-semibold">
            <a href="tel:{{ str_replace(' ', '', $member->phone) }}" class="text-brand-700 hover:underline">{{ $member->phone }}</a>
        </p>
    @endif
    <p class="mt-3 text-xs text-ink-500">{{ $d['about']['termLabel'] }} {{ $member->term_from }}–{{ $member->term_to ?? $d['about']['present'] }}</p>
</article>
