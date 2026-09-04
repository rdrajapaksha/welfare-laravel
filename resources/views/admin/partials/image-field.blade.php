@php
    $name = $name ?? 'cover_image';
    $current = $current ?? null;
    $required = $required ?? false;
    $label = $label ?? ($current ? $d['admin']['replacePhoto'] : $d['forms']['photo']);
@endphp
<div>
    <label class="label">{{ $label }}</label>
    @if ($current)
        <img src="{{ media_url($current) }}" alt="" class="mb-2 h-24 w-full max-w-xs rounded-xl object-cover">
    @endif
    <input class="field" type="file" name="{{ $name }}" accept="image/jpeg,image/png,image/webp" @required($required && ! $current)>
    @error($name)
        <p class="text-sm text-brand-700">{{ $message }}</p>
    @enderror
</div>
