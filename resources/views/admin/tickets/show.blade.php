@extends('layouts.dash')
@section('title', $ticket->ticket_no)
@section('content')
<p class="text-sm"><a class="font-semibold text-brand-700" href="{{ route('admin.tickets.index') }}">{{ $d['common']['back'] }}</a></p>
<h1 class="mt-2 text-3xl font-extrabold">{{ $ticket->subject }}</h1>
<p class="text-sm text-ink-500">{{ $ticket->ticket_no }} · {{ $ticket->contact_name }} · {{ $ticket->email }}</p>
<p class="mt-4 whitespace-pre-line">{{ $ticket->description }}</p>
<div class="mt-8 space-y-3">
    @foreach ($ticket->messages as $message)
        <div class="card-surface p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-ink-400">{{ $message->author_name }} · {{ $message->author_role }}</p>
            <p class="mt-2 whitespace-pre-line">{{ $message->body }}</p>
        </div>
    @endforeach
</div>
<form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <select class="field" name="status">
        @foreach (['OPEN','IN_PROGRESS','AWAITING_MEMBER','RESOLVED','CLOSED'] as $status)
            <option value="{{ $status }}" @selected($ticket->status === $status)>{{ $status }}</option>
        @endforeach
    </select>
    <textarea class="field" name="body" rows="4" required></textarea>
    <button class="btn btn-brand" type="submit">{{ $d['admin']['reply'] }}</button>
</form>
@endsection
