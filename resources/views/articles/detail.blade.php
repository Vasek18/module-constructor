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
@push('styles')
<link href='/css/articles.css'
      rel='stylesheet'/>
@endpush
@push('scripts')
<script src="/js/articles.js"></script>
@endpush

@section('content')
    <section class="article-detail container">
        <h1>{{ $article->name }}</h1>
        <div class="detail-text">
            {!! $article->detail_text !!}
        </div>
    </section>
@stop