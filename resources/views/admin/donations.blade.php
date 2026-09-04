@extends('layouts.dash')
@section('title', $d['admin']['donations'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['donations'] }}</h1>
<div class="mt-6 overflow-x-auto">
    <table class="min-w-full text-left text-sm">
        <thead class="text-xs uppercase text-ink-400"><tr><th class="py-2">Ref</th><th>Donor</th><th>Amount</th><th>{{ $d['donations']['purposeLabel'] }}</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @foreach ($donations as $donation)
                <tr class="border-t border-ink-100">
                    <td class="py-3">{{ $donation->reference }}</td>
                    <td>{{ $donation->is_anonymous ? '—' : $donation->donor_name }}</td>
                    <td>{{ lkr($donation->amount) }}</td>
                    <td>{{ $donation->destinationLabel() }}</td>
                    <td>{{ $donation->status }}</td>
                    <td>
                        @if ($donation->status !== 'CONFIRMED')
                            <form method="POST" action="{{ route('admin.donations.confirm', $donation) }}">@csrf<button class="font-bold text-brand-700" type="submit">{{ $d['admin']['markConfirmed'] }}</button></form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $donations->links() }}</div>
@endsection
