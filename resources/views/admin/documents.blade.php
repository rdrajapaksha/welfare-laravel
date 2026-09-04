@extends('layouts.dash')
@section('title', $d['admin']['documents'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['documents'] }}</h1>
<form method="POST" action="{{ route('admin.documents.store') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <input class="field" name="category" required placeholder="CONSTITUTION" value="POLICY">
    <input class="field" name="file_url" required placeholder="/media/documents/constitution.pdf">
    <label class="flex items-center gap-2 text-sm font-semibold">
        <input type="checkbox" name="members_only" value="1">
        Members only
    </label>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($documents as $document)
        <form method="POST" action="{{ route('admin.documents.update', $document) }}" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $document->title_en) }}">
            <input class="field" name="category" required value="{{ old('category', $document->category) }}">
            <input class="field" name="file_url" required value="{{ old('file_url', $document->file_url) }}">
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="members_only" value="1" @checked(old('members_only', $document->members_only))>
                Members only
            </label>
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $document->is_published))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </form>
        <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
@endsection
