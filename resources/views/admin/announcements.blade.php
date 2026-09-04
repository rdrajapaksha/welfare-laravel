@extends('layouts.dash')
@section('title', $d['admin']['announcements'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['announcements'] }}</h1>
<form method="POST" action="{{ route('admin.announcements.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <textarea class="field" name="body_en" rows="4" required></textarea>
    <select class="field" name="audience">
        <option value="ALL">{{ $d['admin']['audienceAll'] }}</option>
        <option value="MEMBERS">{{ $d['admin']['audienceMembers'] }}</option>
        <option value="COMMITTEE">{{ $d['admin']['audienceCommittee'] }}</option>
    </select>
    <select class="field" name="priority">
        <option value="NORMAL">NORMAL</option>
        <option value="IMPORTANT">IMPORTANT</option>
        <option value="URGENT">URGENT</option>
    </select>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_pinned" value="1"> {{ $d['admin']['pinAnnouncement'] }}</label>
    <button class="btn btn-brand" type="submit">{{ $d['admin']['publishAnnouncement'] }}</button>
</form>
<div class="mt-8 space-y-3">
    @foreach ($announcements as $announcement)
        <div class="card-surface flex items-start justify-between gap-4 p-4">
            <div>
                <p class="font-bold">{{ $announcement->translate('title') }}</p>
                <p class="text-sm text-ink-500">{{ $announcement->audience }} · {{ $announcement->priority }}</p>
            </div>
            <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}">@csrf @method('DELETE')<button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button></form>
        </div>
    @endforeach
</div>
<div class="mt-6">{{ $announcements->links() }}</div>
@endsection
