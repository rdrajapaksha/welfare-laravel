@extends('layouts.dash')
@section('title', $d['admin']['volunteers'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['volunteers'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['admin']['volunteersHint'] }}</p>
<div class="mt-6 space-y-4">
    @forelse ($volunteers as $volunteer)
        <div class="card-surface p-5">
            <p class="font-extrabold">{{ $volunteer->full_name }} <span class="text-sm font-semibold text-ink-400">{{ $volunteer->reference }}</span></p>
            <p class="mt-1 text-sm text-ink-600">{{ $volunteer->city }} · {{ $volunteer->interests }} · {{ $volunteer->availability }}</p>
            <p class="mt-1 text-sm">{{ $volunteer->motivation }}</p>
            <form method="POST" action="{{ route('admin.volunteers.update', $volunteer) }}" class="mt-3 flex gap-2">
                @csrf
                @method('PUT')
                <select class="field mt-0" name="status">
                    @foreach (['NEW','CONTACTED','ACTIVE','INACTIVE','DECLINED'] as $status)
                        <option value="{{ $status }}" @selected($volunteer->status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline" type="submit">{{ $d['common']['save'] }}</button>
            </form>
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
<div class="mt-6">{{ $volunteers->links() }}</div>
@endsection
