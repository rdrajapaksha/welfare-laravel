@extends('layouts.dash')
@section('title', $d['admin']['applications'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['applications'] }}</h1>
<p class="mt-2 text-ink-600">{{ $d['admin']['applicationsHint'] }}</p>
<div class="mt-6 space-y-4">
    @forelse ($applications as $application)
        <div class="card-surface p-5">
            <p class="font-extrabold">{{ $application->full_name }} <span class="text-sm font-semibold text-ink-400">{{ $application->application_no }}</span></p>
            <p class="mt-1 text-sm text-ink-600">{{ $application->nic }} · {{ $application->email }} · {{ $application->city }} · {{ $application->status }}</p>
            @if ($application->status === 'PENDING' || $application->status === 'UNDER_REVIEW')
                <div class="mt-4 flex gap-2">
                    <form method="POST" action="{{ route('admin.applications.admit', $application) }}">@csrf<button class="btn btn-brand" type="submit">{{ $d['admin']['admitMember'] }}</button></form>
                    <form method="POST" action="{{ route('admin.applications.reject', $application) }}">@csrf<button class="btn btn-outline" type="submit">{{ $d['admin']['reject'] }}</button></form>
                </div>
            @endif
        </div>
    @empty
        <p class="text-sm text-ink-500">{{ $d['admin']['noRecords'] }}</p>
    @endforelse
</div>
<div class="mt-6">{{ $applications->links() }}</div>
@endsection
