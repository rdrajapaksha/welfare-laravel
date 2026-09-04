@extends('layouts.dash')
@section('title', $d['admin']['reports'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['reports'] }}</h1>
<form method="POST" action="{{ route('admin.reports.store') }}" enctype="multipart/form-data" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" type="number" name="year" min="2000" max="2100" required placeholder="Year">
    <input class="field" name="title_en" required placeholder="Title">
    <textarea class="field" name="summary_en" rows="3" required placeholder="Summary"></textarea>
    @include('admin.partials.document-field', ['name' => 'file', 'required' => true])
    <input class="field" type="number" name="total_income" min="0" required placeholder="Total income (LKR)">
    <input class="field" type="number" name="total_expenditure" min="0" required placeholder="Total expenditure (LKR)">
    <input class="field" type="number" name="welfare_spend" min="0" placeholder="Welfare spend (LKR)">
    <input class="field" type="number" name="admin_spend" min="0" placeholder="Admin spend (LKR)">
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($reports as $report)
        <form method="POST" action="{{ route('admin.reports.update', $report) }}" enctype="multipart/form-data" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" type="number" name="year" min="2000" max="2100" required value="{{ old('year', $report->year) }}">
            <input class="field" name="title_en" required value="{{ old('title_en', $report->title_en) }}">
            <textarea class="field" name="summary_en" rows="3" required>{{ old('summary_en', $report->summary_en) }}</textarea>
            @include('admin.partials.document-field', ['name' => 'file', 'current' => $report->file_url])
            <input class="field" type="number" name="total_income" min="0" required value="{{ old('total_income', $report->total_income) }}">
            <input class="field" type="number" name="total_expenditure" min="0" required value="{{ old('total_expenditure', $report->total_expenditure) }}">
            <input class="field" type="number" name="welfare_spend" min="0" value="{{ old('welfare_spend', $report->welfare_spend) }}">
            <input class="field" type="number" name="admin_spend" min="0" value="{{ old('admin_spend', $report->admin_spend) }}">
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $report->is_published))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
@endsection
