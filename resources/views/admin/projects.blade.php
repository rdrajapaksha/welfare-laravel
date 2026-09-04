@extends('layouts.dash')
@section('title', $d['admin']['projects'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['projects'] }}</h1>
<form method="POST" action="{{ route('admin.projects.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <textarea class="field" name="summary_en" rows="3" required placeholder="Summary"></textarea>
    <input class="field" name="location" required placeholder="Location">
    <select class="field" name="status">
        <option value="PLANNED">PLANNED</option>
        <option value="ONGOING">ONGOING</option>
        <option value="COMPLETED">COMPLETED</option>
    </select>
    <input class="field" type="number" name="target_amount" min="0" required placeholder="Target (LKR)">
    <input class="field" type="number" name="raised_amount" min="0" placeholder="Raised (LKR)">
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($projects as $project)
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $project->title_en) }}">
            <textarea class="field" name="summary_en" rows="3" required>{{ old('summary_en', $project->summary_en) }}</textarea>
            <input class="field" name="location" required value="{{ old('location', $project->location) }}">
            <select class="field" name="status">
                @foreach (['PLANNED', 'ONGOING', 'COMPLETED'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <input class="field" type="number" name="target_amount" min="0" required value="{{ old('target_amount', $project->target_amount) }}">
            <input class="field" type="number" name="raised_amount" min="0" value="{{ old('raised_amount', $project->raised_amount) }}">
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
@endsection
