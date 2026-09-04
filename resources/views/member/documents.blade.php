@extends('layouts.dash')
@section('title', $d['dashboard']['documents'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['documents'] }}</h1>
<div class="mt-6 space-y-3">
    @forelse ($documents as $document)
        <a href="{{ media_url($document->file_url) }}" class="card-surface flex justify-between gap-4 p-4" target="_blank" rel="noopener">
            <span>
                <span class="block font-bold">{{ $document->translate('title') }}</span>
                <span class="text-sm text-ink-500">{{ $document->category }} · v{{ $document->version }}</span>
            </span>
            <span class="text-sm font-semibold text-brand-700">{{ $d['common']['download'] }}</span>
        </a>
    @empty
        <p class="text-sm text-ink-500">{{ $d['common']['noResults'] }}</p>
    @endforelse
</div>
@endsection
