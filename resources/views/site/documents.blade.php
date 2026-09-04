@extends('layouts.site')
@section('title', $d['documents']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['documents']['title'], 'subtitle' => $d['documents']['subtitle']])
<section class="section-y">
    <div class="container-page space-y-8">
        @foreach ($documents as $category => $items)
            <div>
                <h2 class="text-xl font-extrabold">{{ $category }}</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($items as $document)
                        <div class="card-surface flex items-center justify-between p-4">
                            <div>
                                <p class="font-bold">{{ $document->translate('title') }}</p>
                                <p class="text-sm text-ink-600">{{ $document->translate('description') }}</p>
                            </div>
                            @if ($document->members_only && ! auth()->check())
                                <span class="text-xs font-bold">{{ $d['documents']['membersOnly'] }}</span>
                            @else
                                <a href="{{ asset(ltrim($document->file_url, '/')) }}" class="btn btn-outline">{{ $d['common']['download'] }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
