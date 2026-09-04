@extends('layouts.dash')
@section('title', $d['admin']['messages'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['messages'] }}</h1>
<div class="mt-6 space-y-4">
    @forelse ($messages as $message)
        <div class="card-surface p-5">
            <p class="font-extrabold">{{ $message->name }} · {{ $message->subject }}</p>
            <p class="text-sm text-ink-500">{{ $message->email }} · {{ $message->topic }} · {{ $message->status }}</p>
            <p class="mt-2 whitespace-pre-line text-sm">{{ $message->message }}</p>
            <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="mt-3 flex gap-2">
                @csrf
                @method('PUT')
                <select class="field mt-0" name="status">
                    @foreach (['NEW','READ','REPLIED','ARCHIVED'] as $status)
                        <option value="{{ $status }}" @selected($message->status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
            </form>
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
<div class="mt-6">{{ $messages->links() }}</div>
@endsection
