@extends('layouts.dash')
@section('title', $d['admin']['content'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['content'] }}</h1>
<form method="POST" action="{{ route('admin.content.faqs') }}" class="card-surface mt-6 max-w-xl space-y-3 p-5">
    @csrf
    <input class="field" name="category" required placeholder="MEMBERSHIP" value="GENERAL">
    <input class="field" name="question_en" required placeholder="Question">
    <textarea class="field" name="answer_en" rows="4" required placeholder="Answer"></textarea>
    <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
</form>
<div class="mt-8 space-y-3">
    @foreach ($faqs as $faq)
        <div class="card-surface flex items-start justify-between gap-4 p-4">
            <div>
                <p class="text-xs font-bold uppercase text-ink-400">{{ $faq->category }}</p>
                <p class="font-bold">{{ $faq->translate('question') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.content.faqs.destroy', $faq) }}">@csrf @method('DELETE')<button class="text-sm font-bold text-brand-700" type="submit">{{ $d['common']['delete'] }}</button></form>
        </div>
    @endforeach
</div>
@endsection
