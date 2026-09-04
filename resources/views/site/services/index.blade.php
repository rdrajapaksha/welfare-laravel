@extends('layouts.site')
@section('title', $d['services']['title'])
@section('content')
@include('partials.page-hero', ['title' => $d['services']['title'], 'subtitle' => $d['services']['subtitle'], 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['services']['title']]]])
<section class="section-y">
    <div class="container-page">
        <div class="mb-8 flex flex-wrap gap-2">
            @foreach (['' => $d['common']['all'], 'WELFARE' => $d['services']['categoryWelfare'], 'EMERGENCY' => $d['services']['categoryEmergency'], 'MEMBER_SUPPORT' => $d['services']['categoryMemberSupport']] as $key => $label)
                <a href="{{ locale_url('/services', $key ? ['category' => $key] : []) }}" class="rounded-full px-3 py-1 text-sm font-bold {{ $category === $key ? 'bg-brand-600 text-white' : 'border border-ink-200' }}">{{ $label }}</a>
            @endforeach
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            @forelse ($programmes as $programme)
                <a href="{{ route('services.show', $programme) }}" class="card-surface card-interactive p-6">
                    <p class="text-xs font-bold uppercase text-brand-700">{{ $programme->category }}</p>
                    <h2 class="mt-2 text-xl font-extrabold">{{ $programme->translate('title') }}</h2>
                    <p class="mt-2 text-sm text-ink-600">{{ $programme->translate('summary') }}</p>
                </a>
            @empty
                <p>{{ $d['services']['noProgrammes'] }}</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
