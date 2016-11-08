@extends('app')

@if ($section->seo_title)
    @section('title', $section->seo_title)
@endif

@if ($section->seo_keywords)
    @section('keywords', $section->seo_keywords)
@endif

@if ($section->seo_description)
    @section('description', $section->seo_description)
@endif

@section('content')
    <section class="container">
        <h1>{{ $section->name }}</h1>
        <p class="lead">{!! $section->detail_text !!}</p>
        @if ($section->articles()->count())
            <div class="list-group">
                @foreach($section->articles()->active()->orderBy('sort')->get() as $article)
                    <div class="list-group-item">
                        <a class="h3"
                           href="{{ $article->link }}">{{ $article->name }}</a>
                        <p>{{ $article->preview_text }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@stop