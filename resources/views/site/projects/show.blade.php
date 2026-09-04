@extends('layouts.site')
@section('title', $project->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $project->translate('title'), 'subtitle' => $project->translate('summary'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['projects']['title'], 'href' => '/projects'], ['label' => $project->translate('title')]]])
<section class="section-y">
    <div class="container-page grid gap-10 lg:grid-cols-3">
        <article class="lg:col-span-2 space-y-4 leading-relaxed text-ink-700">{!! $project->translate('body') !!}</article>
        <aside class="card-surface space-y-3 p-5">
            <p>{{ $d['projects']['raised'] }}: <strong>{{ lkr($project->raised_amount) }}</strong></p>
            <p>{{ $d['projects']['target'] }}: <strong>{{ lkr($project->target_amount) }}</strong></p>
            <p>{{ $d['projects']['spent'] }}: <strong>{{ lkr($project->spent_amount) }}</strong></p>
            <p>{{ $d['projects']['beneficiaries'] }}: <strong>{{ number_format($project->beneficiaries) }}</strong></p>
            <a href="{{ locale_url('/donations') }}" class="btn btn-brand w-full">{{ $d['projects']['fundProject'] }}</a>
        </aside>
    </div>
</section>
@endsection
