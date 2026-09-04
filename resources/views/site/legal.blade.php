@extends('layouts.site')
@section('title', $title)
@section('content')
@include('partials.page-hero', ['title' => $title, 'crumbs' => [['label' => $d['nav']['home'], 'href' => '/'], ['label' => $title]]])
<section class="section-y">
    <div class="container-page prose-hla max-w-3xl text-ink-700">
        <p>{{ $body }}</p>
    </div>
</section>
@endsection
