@extends('layouts.dash')
@section('title', $d['admin']['tickets'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['tickets'] }}</h1>
<div class="mt-6 space-y-3">
    @forelse ($tickets as $ticket)
        <a href="{{ route('admin.tickets.show', $ticket) }}" class="card-surface block p-4">
            <p class="font-bold">{{ $ticket->ticket_no }} · {{ $ticket->subject }}</p>
            <p class="text-sm text-ink-500">{{ $ticket->contact_name }} · {{ $ticket->status }} · {{ $ticket->priority }}</p>
        </a>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
<div class="mt-6">{{ $tickets->links() }}</div>
@endsection
