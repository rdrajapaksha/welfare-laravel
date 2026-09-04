@php
    $name = $name ?? 'document';
    $current = $current ?? null;
    $required = $required ?? false;
    $label = $label ?? ($current ? $d['admin']['replacePdf'] : $d['admin']['uploadPdf']);
@endphp
<div>
    <label class="label">{{ $label }}</label>
    @if ($current)
        <p class="mb-2 text-sm text-ink-600">
            <a href="{{ media_url($current) }}" class="font-semibold text-brand-700" target="_blank" rel="noopener">{{ $d['admin']['currentDocument'] }}</a>
        </p>
    @endif
    <input class="field" type="file" name="{{ $name }}" accept="application/pdf" @required($required && ! $current)>
    <p class="mt-1 text-xs text-ink-500">{{ $d['admin']['pdfHint'] }}</p>
    @error($name)
        <p class="text-sm text-brand-700">{{ $message }}</p>
    @enderror
</div>
