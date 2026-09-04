@extends('layouts.dash')
@section('title', $d['dashboard']['ticketsTitle'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['dashboard']['ticketsTitle'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['dashboard']['ticketsSubtitle'] }}</p>
<form method="POST" action="{{ route('member.tickets.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <h2 class="font-extrabold">{{ $d['dashboard']['newTicket'] }}</h2>
    <select class="field" name="category" required>
        <option value="WELFARE_CLAIM">{{ $d['dashboard']['ticketCategoryWelfare'] }}</option>
        <option value="PAYMENT">{{ $d['dashboard']['ticketCategoryPayment'] }}</option>
        <option value="PROFILE">{{ $d['dashboard']['ticketCategoryProfile'] }}</option>
        <option value="GRIEVANCE">{{ $d['dashboard']['ticketCategoryGrievance'] }}</option>
        <option value="EVENT">{{ $d['dashboard']['ticketCategoryEvent'] }}</option>
        <option value="TECHNICAL">{{ $d['dashboard']['ticketCategoryTechnical'] }}</option>
        <option value="OTHER">{{ $d['dashboard']['ticketCategoryOther'] }}</option>
    </select>
    <select class="field" name="priority" required>
        <option value="LOW">{{ $d['dashboard']['priorityLow'] }}</option>
        <option value="MEDIUM" selected>{{ $d['dashboard']['priorityMedium'] }}</option>
        <option value="HIGH">{{ $d['dashboard']['priorityHigh'] }}</option>
        <option value="URGENT">{{ $d['dashboard']['priorityUrgent'] }}</option>
    </select>
    <input class="field" name="subject" required placeholder="{{ $d['dashboard']['ticketSubject'] }}">
    <textarea class="field" name="description" rows="4" required placeholder="{{ $d['dashboard']['ticketDescription'] }}"></textarea>
    <button class="btn btn-brand" type="submit">{{ $d['common']['submit'] }}</button>
</form>
<div class="mt-8 space-y-3">
    @forelse ($tickets as $ticket)
        <a href="{{ route('member.tickets.show', $ticket) }}" class="card-surface block p-4">
            <p class="font-bold">{{ $ticket->ticket_no }} · {{ $ticket->subject }}</p>
            <p class="text-sm text-ink-500">{{ $ticket->status }} · {{ $ticket->priority }}</p>
        </a>
    @empty
        <p class="text-sm text-ink-500">{{ $d['dashboard']['noTickets'] }}</p>
    @endforelse
</div>
@endsection
