@extends('layouts.dash')
@section('title', $d['admin']['analytics'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['analytics'] }}</h1>
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['chartDonationTrend'] }}</h2>
        @foreach ($stats as $stat)
            <p class="mt-2 text-sm">{{ $stat->year }}-{{ str_pad((string) $stat->month, 2, '0', STR_PAD_LEFT) }} · {{ lkr($stat->donation_total) }} · {{ $stat->donation_count }}</p>
        @endforeach
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['chartMembersByDistrict'] }}</h2>
        @foreach ($membersByDistrict as $row)
            <p class="mt-2 text-sm">{{ $row->district }} · {{ $row->total }}</p>
        @endforeach
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['chartDonationPurpose'] }}</h2>
        @foreach ($donationPurpose as $row)
            <p class="mt-2 text-sm">{{ $row->purpose }} · {{ lkr((int) $row->total) }}</p>
        @endforeach
    </div>
    <div class="card-surface p-5">
        <h2 class="font-extrabold">{{ $d['admin']['chartTicketStatus'] }}</h2>
        @foreach ($ticketStatus as $row)
            <p class="mt-2 text-sm">{{ $row->status }} · {{ $row->total }}</p>
        @endforeach
    </div>
</div>
@endsection
