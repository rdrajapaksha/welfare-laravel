@php
    $path = $path ?? null;
    $label = $label ?? $d['common']['download'];
@endphp
@if ($path)
    <a href="{{ media_url($path) }}" class="btn btn-outline {{ $class ?? '' }}" target="_blank" rel="noopener">{{ $label }}</a>
@endif
