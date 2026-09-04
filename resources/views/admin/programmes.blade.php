@extends('layouts.dash')
@section('title', $d['admin']['programmes'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['programmes'] }}</h1>
<form method="POST" action="{{ route('admin.programmes.store') }}" enctype="multipart/form-data" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="title_en" required placeholder="Title">
    <select class="field" name="category">
        <option value="WELFARE">WELFARE</option>
        <option value="EMERGENCY">EMERGENCY</option>
        <option value="MEMBER_SUPPORT">MEMBER_SUPPORT</option>
    </select>
    <textarea class="field" name="summary_en" rows="3" required placeholder="Summary"></textarea>
    <input class="field" type="number" name="benefit_amount" min="0" placeholder="Benefit amount (LKR)">
    @include('admin.partials.image-field', ['name' => 'cover_image'])
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-4">
    @foreach ($programmes as $programme)
        <form method="POST" action="{{ route('admin.programmes.update', $programme) }}" enctype="multipart/form-data" class="card-surface space-y-3 p-5">
            @csrf
            @method('PUT')
            <input class="field" name="title_en" required value="{{ old('title_en', $programme->title_en) }}">
            <select class="field" name="category">
                @foreach (['WELFARE', 'EMERGENCY', 'MEMBER_SUPPORT'] as $category)
                    <option value="{{ $category }}" @selected(old('category', $programme->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <textarea class="field" name="summary_en" rows="3" required>{{ old('summary_en', $programme->summary_en) }}</textarea>
            <input class="field" type="number" name="benefit_amount" min="0" value="{{ old('benefit_amount', $programme->benefit_amount) }}">
            @include('admin.partials.image-field', ['name' => 'cover_image', 'current' => $programme->cover_image])
            <label class="flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $programme->is_active))>
                {{ $d['admin']['showPublic'] }}
            </label>
            <div class="flex flex-wrap gap-3">
                <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
            </div>
        </form>
        <form method="POST" action="{{ route('admin.programmes.destroy', $programme) }}" class="-mt-2">
            @csrf
            @method('DELETE')
            <button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button>
        </form>
    @endforeach
</div>
@endsection
