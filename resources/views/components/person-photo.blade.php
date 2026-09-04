@props([
    'src' => null,
    'name' => '',
    'size' => 'lg',
])
@php
    $url = \App\Support\PhotoStore::url($src);
    $initials = \App\Support\PhotoStore::initials((string) $name);
    $sizes = [
        'sm' => 'h-12 w-12 text-sm',
        'md' => 'h-20 w-20 text-lg',
        'lg' => 'h-28 w-28 text-2xl',
        'xl' => 'h-36 w-36 text-3xl',
        'id' => 'h-24 w-24 text-xl',
    ];
    $box = $sizes[$size] ?? $sizes['lg'];
    $ring = $size === 'xl' ? 'ring-4 ring-gold-300' : 'ring-2 ring-white';
@endphp
@if ($url)
    <img src="{{ $url }}" alt="{{ $name }}" {{ $attributes->merge(['class' => $box.' rounded-full object-cover shadow-soft '.$ring]) }}>
@else
    <span {{ $attributes->merge(['class' => $box.' inline-flex items-center justify-center rounded-full bg-gradient-to-br from-ink-900 to-brand-700 font-display font-extrabold text-white shadow-soft']) }} aria-hidden="true">{{ $initials }}</span>
@endif
