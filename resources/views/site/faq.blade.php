@extends('layouts.site')
@section('title', $d['faq']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['faq']['title'], 'subtitle' => $d['faq']['subtitle']])
<section class="section-y">
    <div class="container-page space-y-10">
        @forelse ($faqs as $category => $items)
            <div>
                <h2 class="text-xl font-extrabold">{{ $category }}</h2>
                <div class="mt-4 divide-y rounded-2xl border bg-white" x-data="{ open: null }">
                    @foreach ($items as $i => $faq)
                        <div>
                            <button type="button" class="flex w-full px-5 py-4 text-left font-bold" @click="open = open === {{ $i }} ? null : {{ $i }}">{{ $faq->translate('question') }}</button>
                            <div x-show="open === {{ $i }}" x-cloak class="px-5 pb-4 text-sm text-ink-600">{{ $faq->translate('answer') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p>{{ $d['faq']['noFaqs'] }}</p>
        @endforelse
    </div>
</section>
@endsection
