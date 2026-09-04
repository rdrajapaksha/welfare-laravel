@extends('layouts.dash')
@section('title', $d['admin']['content'])
@section('content')
<h1 class="text-3xl font-extrabold">{{ $d['admin']['content'] }}</h1>
<p class="mt-2 max-w-2xl text-ink-600">{{ $d['admin']['contentHint'] }}</p>

<section class="mt-8">
    <h2 class="text-2xl font-extrabold">{{ $d['admin']['pagesHub'] }}</h2>
    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ([
            ['label' => $d['admin']['homeContent'], 'href' => '#home-copy'],
            ['label' => $d['admin']['aboutContent'], 'href' => '#about-copy'],
            ['label' => $d['admin']['identity'], 'href' => '#identity'],
            ['label' => $d['admin']['committeePage'], 'href' => route('admin.committee.index')],
            ['label' => $d['nav']['faq'], 'href' => '#faqs'],
            ['label' => $d['admin']['legal'], 'href' => '#legal'],
            ['label' => $d['admin']['news'], 'href' => route('admin.news.index')],
            ['label' => $d['admin']['events'], 'href' => route('admin.events.index')],
            ['label' => $d['admin']['gallery'], 'href' => route('admin.gallery.index')],
            ['label' => $d['admin']['programmes'], 'href' => route('admin.programmes.index')],
            ['label' => $d['admin']['projects'], 'href' => route('admin.projects.index')],
            ['label' => $d['admin']['partnersPage'], 'href' => route('admin.partners.index')],
            ['label' => $d['admin']['documents'], 'href' => route('admin.documents.index')],
            ['label' => $d['admin']['reports'], 'href' => route('admin.reports.index')],
        ] as $page)
            <a href="{{ $page['href'] }}" class="card-surface card-interactive px-4 py-3 text-sm font-bold text-brand-800">{{ $page['label'] }}</a>
        @endforeach
    </div>
</section>

<section id="home-copy" class="mt-12">
    <h2 class="text-2xl font-extrabold">{{ $d['admin']['homeContent'] }}</h2>
    <p class="mt-2 max-w-2xl text-sm text-ink-600">{{ $d['admin']['homeHint'] }}</p>
    <form method="POST" action="{{ route('admin.content.home') }}" class="card-surface mt-4 space-y-5 p-6">
        @csrf
        @method('PUT')
        @foreach ([
            ['hero_eyebrow', $d['admin']['heroEyebrow'], 2],
            ['hero_title', $d['admin']['heroTitle'], 2],
            ['hero_accent', $d['admin']['heroAccent'], 2],
            ['hero_subtitle', $d['admin']['heroSubtitle'], 4],
            ['cta_title', $d['admin']['ctaTitle'], 2],
            ['cta_text', $d['admin']['ctaText'], 4],
            ['footer_about', $d['admin']['footerAbout'], 4],
        ] as [$field, $label, $rows])
            <div class="grid gap-4 lg:grid-cols-3">
                @foreach (['en' => 'EN', 'si' => 'සි', 'ta' => 'த'] as $code => $tag)
                    <div>
                        <label class="label">{{ $label }} ({{ $tag }})</label>
                        <textarea class="field" name="{{ $field }}_{{ $code }}" rows="{{ $rows }}" required>{{ old($field.'_'.$code, $homeCopy[$field.'_'.$code]) }}</textarea>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
    </form>
</section>

<section id="about-copy" class="mt-12">
    <h2 class="text-2xl font-extrabold">{{ $d['admin']['aboutContent'] }}</h2>
    <form method="POST" action="{{ route('admin.content.about') }}" class="card-surface mt-4 space-y-5 p-6">
        @csrf
        @method('PUT')
        <div class="grid gap-4 lg:grid-cols-3">
            <div>
                <label class="label">{{ $d['about']['visionTitle'] }} (EN)</label>
                <textarea class="field" name="vision_en" rows="4" required>{{ old('vision_en', $about['vision_en']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['visionTitle'] }} (සි)</label>
                <textarea class="field" name="vision_si" rows="4" required>{{ old('vision_si', $about['vision_si']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['visionTitle'] }} (த)</label>
                <textarea class="field" name="vision_ta" rows="4" required>{{ old('vision_ta', $about['vision_ta']) }}</textarea>
            </div>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            <div>
                <label class="label">{{ $d['about']['missionTitle'] }} (EN)</label>
                <textarea class="field" name="mission_en" rows="5" required>{{ old('mission_en', $about['mission_en']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['missionTitle'] }} (සි)</label>
                <textarea class="field" name="mission_si" rows="5" required>{{ old('mission_si', $about['mission_si']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['missionTitle'] }} (த)</label>
                <textarea class="field" name="mission_ta" rows="5" required>{{ old('mission_ta', $about['mission_ta']) }}</textarea>
            </div>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            <div>
                <label class="label">{{ $d['about']['introTitle'] }} (EN)</label>
                <textarea class="field" name="intro_en" rows="6" required>{{ old('intro_en', $about['intro_en']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['introTitle'] }} (සි)</label>
                <textarea class="field" name="intro_si" rows="6" required>{{ old('intro_si', $about['intro_si']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['introTitle'] }} (த)</label>
                <textarea class="field" name="intro_ta" rows="6" required>{{ old('intro_ta', $about['intro_ta']) }}</textarea>
            </div>
        </div>
        <div class="grid gap-4 lg:grid-cols-3">
            <div>
                <label class="label">{{ $d['about']['objectivesTitle'] }} (EN)</label>
                <textarea class="field" name="objectives_en" rows="10" required>{{ old('objectives_en', $about['objectives_en']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['objectivesTitle'] }} (සි)</label>
                <textarea class="field" name="objectives_si" rows="10" required>{{ old('objectives_si', $about['objectives_si']) }}</textarea>
            </div>
            <div>
                <label class="label">{{ $d['about']['objectivesTitle'] }} (த)</label>
                <textarea class="field" name="objectives_ta" rows="10" required>{{ old('objectives_ta', $about['objectives_ta']) }}</textarea>
            </div>
        </div>
        <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
    </form>
</section>

<section id="identity" class="mt-12">
    <h2 class="text-2xl font-extrabold">{{ $d['admin']['identity'] }}</h2>
    <form method="POST" action="{{ route('admin.content.identity') }}" class="card-surface mt-4 grid max-w-4xl gap-3 p-6 sm:grid-cols-2">
        @csrf
        @method('PUT')
        <div class="sm:col-span-2">
            <label class="label">{{ $d['brand']['full'] }}</label>
            <input class="field" name="name" required value="{{ old('name', $identity['name']) }}">
        </div>
        <div>
            <label class="label">{{ $d['brand']['name'] }}</label>
            <input class="field" name="short_name" required value="{{ old('short_name', $identity['short_name']) }}">
        </div>
        <div>
            <label class="label">{{ $d['brand']['regNo'] }}</label>
            <input class="field" name="registration_no" required value="{{ old('registration_no', $identity['registration_no']) }}">
        </div>
        <div class="sm:col-span-2">
            <label class="label">{{ $d['contact']['address'] }}</label>
            <input class="field" name="street" required value="{{ old('street', $identity['contact']['street']) }}">
        </div>
        <input class="field" name="locality" required value="{{ old('locality', $identity['contact']['locality']) }}" placeholder="{{ $d['forms']['city'] }}">
        <input class="field" name="region" required value="{{ old('region', $identity['contact']['region']) }}">
        <input class="field" name="postal_code" required value="{{ old('postal_code', $identity['contact']['postal_code']) }}">
        <input class="field" name="email" type="email" required value="{{ old('email', $identity['contact']['email']) }}">
        <input class="field" name="phone_display" required value="{{ old('phone_display', $identity['contact']['phone_display']) }}" placeholder="{{ $d['contact']['telephone'] }}">
        <input class="field" name="hotline_display" required value="{{ old('hotline_display', $identity['contact']['hotline_display']) }}" placeholder="{{ $d['contact']['hotline'] }}">
        <p class="sm:col-span-2 mt-2 text-sm font-extrabold">{{ $d['admin']['bankDetails'] }}</p>
        <div>
            <label class="label">{{ $d['donations']['bankName'] }}</label>
            <input class="field" name="bank_name" required value="{{ old('bank_name', $identity['bank']['bank_name']) }}">
        </div>
        <div>
            <label class="label">{{ $d['donations']['bankBranch'] }}</label>
            <input class="field" name="branch" required value="{{ old('branch', $identity['bank']['branch']) }}">
        </div>
        <div class="sm:col-span-2">
            <label class="label">{{ $d['donations']['bankAccountName'] }}</label>
            <input class="field" name="account_name" required value="{{ old('account_name', $identity['bank']['account_name']) }}">
        </div>
        <div>
            <label class="label">{{ $d['donations']['bankAccountNo'] }}</label>
            <input class="field" name="account_no" required value="{{ old('account_no', $identity['bank']['account_no']) }}">
        </div>
        <div>
            <label class="label">{{ $d['donations']['bankSwift'] }}</label>
            <input class="field" name="swift" value="{{ old('swift', $identity['bank']['swift']) }}">
        </div>
        <div class="sm:col-span-2">
            <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
        </div>
    </form>
</section>

<section class="mt-12">
    <div class="card-surface flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-extrabold">{{ $d['admin']['committeePage'] }}</h2>
            <p class="mt-2 max-w-2xl text-sm text-ink-600">{{ $d['admin']['committeeHint'] }}</p>
        </div>
        <a href="{{ route('admin.committee.index') }}" class="btn btn-brand">{{ $d['admin']['manageOfficers'] }}</a>
    </div>
</section>

<section id="legal" class="mt-12">
    <h2 class="text-2xl font-extrabold">{{ $d['admin']['legal'] }}</h2>
    <form method="POST" action="{{ route('admin.content.legal') }}" class="card-surface mt-4 space-y-5 p-6">
        @csrf
        @method('PUT')
        @foreach ([
            ['privacy', $d['admin']['privacyPage']],
            ['terms', $d['admin']['termsPage']],
        ] as [$field, $label])
            <div class="grid gap-4 lg:grid-cols-3">
                @foreach (['en' => 'EN', 'si' => 'සි', 'ta' => 'த'] as $code => $tag)
                    <div>
                        <label class="label">{{ $label }} ({{ $tag }})</label>
                        <textarea class="field" name="{{ $field }}_{{ $code }}" rows="8" required>{{ old($field.'_'.$code, $legal[$field.'_'.$code]) }}</textarea>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button class="btn btn-brand" type="submit">{{ $d['common']['save'] }}</button>
    </form>
</section>

<section id="faqs" class="mt-12">
    <h2 class="text-2xl font-extrabold">{{ $d['nav']['faq'] }}</h2>
    <form method="POST" action="{{ route('admin.content.faqs') }}" class="card-surface mt-4 max-w-xl space-y-3 p-5">
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
</section>
@endsection
