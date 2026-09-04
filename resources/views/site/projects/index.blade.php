@extends('layouts.site')
@section('title', $d['projects']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['projects']['title'], 'subtitle' => $d['projects']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['projects']['title']]]])
<section class="section-y">
    <div class="container-page grid gap-5 lg:grid-cols-3">
        @foreach ($projects as $project)
            <a href="{{ route('projects.show', $project) }}" class="card-surface card-interactive overflow-hidden">
                <img src="{{ media_url($project->cover_image, '/media/community-hall.svg') }}" alt="" class="h-48 w-full object-cover">
                <div class="p-6">
                    <p class="text-xs font-bold uppercase text-teal-700">{{ $project->status }}</p>
                    <h2 class="mt-2 font-extrabold">{{ $project->translate('title') }}</h2>
                    <p class="mt-2 text-sm text-ink-600">{{ $project->translate('summary') }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
