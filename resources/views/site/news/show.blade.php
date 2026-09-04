@extends('layouts.site')
@section('title', $post->translate('title'))
@section('content')
@include('partials.page-hero', ['title' => $post->translate('title'), 'subtitle' => $post->translate('excerpt'), 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $d['news']['title'], 'href' => '/news'], ['label' => $post->translate('title')]]])
<section class="section-y">
    <div class="container-page max-w-3xl space-y-4 leading-relaxed text-ink-700">{!! $post->translate('body') !!}</div>
</section>
@endsection
