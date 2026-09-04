@extends('layouts.site')
@section('title', $d['donations']['thankYouTitle'])
@section('content')
@include('partials.page-hero', ['title' => $d['donations']['thankYouTitle'], 'subtitle' => $d['donations']['thankYouText']])
<section class="section-y">
    <div class="container-page max-w-xl card-surface p-8">
        <p class="text-sm text-ink-500">{{ $d['donations']['yourReference'] }}</p>
        <p class="mt-2 text-2xl font-extrabold">{{ $donation->reference }}</p>
        <p class="mt-4">{{ lkr($donation->amount) }}</p>
        <p class="mt-2 text-sm text-ink-600">{{ $d['donations']['purposeLabel'] }}: {{ $donation->destinationLabel() }}</p>
        @include('partials.donation-whatsapp-slip', ['reference' => $donation->reference, 'amount' => $donation->amount])
        <a href="{{ locale_url('/') }}" class="btn btn-ink mt-6">{{ $d['errors']['notFoundCta'] }}</a>
    </div>
</section>
@endsection
