@extends('layouts.site')
@section('title', $d['partners']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['partners']['title'], 'subtitle' => $d['partners']['subtitle']])
<section class="section-y">
    <div class="container-page space-y-10">
        @foreach ($partners as $tier => $items)
            <div>
                <h2 class="text-xl font-extrabold">{{ $tier }}</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($items as $partner)
                        <article class="card-surface p-4 text-center">
                            <img src="{{ asset(ltrim($partner->logo_url, '/')) }}" alt="{{ $partner->name }}" class="mx-auto h-16 object-contain">
                            <h3 class="mt-3 font-bold">{{ $partner->name }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
