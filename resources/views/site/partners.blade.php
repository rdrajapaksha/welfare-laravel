@extends('layouts.site')
@section('title', $d['partners']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['partners']['title'], 'subtitle' => $d['partners']['subtitle']])
<section class="section-y">
    <div class="container-page space-y-10">
        @foreach ($partners as $tier => $items)
            <div>
                <h2 class="text-xl font-extrabold">{{ $tier }}</h2>
                <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($items as $partner)
                        <article class="card-surface px-6 py-7 text-center">
                            <img src="{{ media_url($partner->logo_url) }}" alt="{{ $partner->name }}" class="mx-auto h-20 w-auto max-w-[11rem] object-contain">
                            <h3 class="mt-4 font-bold">{{ $partner->name }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
