@extends('app')

@if ($article->seo_title)
    @section('title', $article->seo_title)
@endif

@if ($article->seo_keywords)
    @section('keywords', $article->seo_keywords)
@endif

@if ($article->seo_description)
    @section('description', $article->seo_description)
@endif

@section('content')
    <section class="container">
        <h1>{{ $article->name }}</h1>
        <div class="detail-text">
            {!! $article->detail_text !!}
        </div>
    </section>
@stop