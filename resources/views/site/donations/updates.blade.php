@extends('layouts.site')
@section('title', $d['donations']['updatesTitle'])
@section('content')
@include('partials.page-hero', ['title' => $d['donations']['updatesTitle'], 'subtitle' => $d['donations']['updatesSubtitle']])
<section class="section-y">
    <div class="container-page space-y-4">
        @foreach ($donations as $donation)
            <div class="card-surface flex items-center justify-between p-4">
                <div>
                    <p class="font-bold">{{ $donation->is_anonymous ? $d['donations']['anonymousDonor'] : $donation->donor_name }}</p>
                    <p class="text-xs text-ink-500">{{ $donation->purpose }} · {{ optional($donation->confirmed_at)->format('d M Y') }}</p>
                </div>
                <p class="font-extrabold">{{ lkr($donation->amount) }}</p>
            </div>
        @endforeach
        {{ $donations->links() }}
    </div>
</section>
@endsection
