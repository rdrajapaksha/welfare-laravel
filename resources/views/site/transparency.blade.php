@extends('layouts.site')
@section('title', $d['transparency']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['transparency']['title'], 'subtitle' => $d['transparency']['subtitle']])
<section class="section-y">
    <div class="container-page space-y-6">
        @foreach ($reports as $report)
            <article class="card-surface p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-extrabold">{{ $report->translate('title') }}</h2>
                        <p class="mt-2 text-sm text-ink-600">{{ $report->translate('summary') }}</p>
                    </div>
                    <a href="{{ media_url($report->file_url) }}" class="btn btn-outline" target="_blank" rel="noopener">{{ $d['transparency']['downloadReport'] }}</a>
                </div>
                <dl class="mt-4 grid gap-3 sm:grid-cols-3 text-sm">
                    <div>{{ $d['transparency']['income'] }}<br><strong>{{ lkr($report->total_income) }}</strong></div>
                    <div>{{ $d['transparency']['welfareSpend'] }}<br><strong>{{ lkr($report->welfare_spend) }}</strong></div>
                    <div>{{ $d['transparency']['adminSpend'] }}<br><strong>{{ lkr($report->admin_spend) }}</strong></div>
                </dl>
            </article>
        @endforeach
    </div>
</section>
@endsection
