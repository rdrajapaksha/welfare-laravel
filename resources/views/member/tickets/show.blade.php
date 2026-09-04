@extends('layouts.dash')
@section('title', $ticket->ticket_no)
@section('content')
<p class="text-sm"><a class="font-semibold text-brand-700" href="{{ route('member.tickets') }}">{{ $d['common']['back'] }}</a></p>
<h1 class="mt-2 text-3xl font-extrabold">{{ $ticket->subject }}</h1>
<p class="mt-1 text-sm text-ink-500">{{ $ticket->ticket_no }} · {{ $ticket->status }}</p>
<p class="mt-4 whitespace-pre-line text-ink-700">{{ $ticket->description }}</p>
<div class="mt-8 space-y-3">
    <h2 class="font-extrabold">{{ $d['dashboard']['conversation'] }}</h2>
    @foreach ($ticket->messages as $message)
        <div class="card-surface p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-ink-400">{{ $message->author_name }} · {{ $message->author_role }}</p>
            <p class="mt-2 whitespace-pre-line">{{ $message->body }}</p>
        </div>
    @endforeach
</div>
@if (! in_array($ticket->status, ['RESOLVED', 'CLOSED'], true))
    <form method="POST" action="{{ route('member.tickets.reply', $ticket) }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
        @csrf
        <textarea class="field" name="body" rows="4" required placeholder="{{ $d['dashboard']['replyPlaceholder'] }}"></textarea>
        <button class="btn btn-brand" type="submit">{{ $d['dashboard']['sendReply'] }}</button>
    </form>
@else
    <p class="mt-6 text-sm text-ink-500">{{ $d['dashboard']['ticketResolvedNote'] }}</p>
@endif
@endsection
