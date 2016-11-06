@extends('app')

@section('content')
    <section class="container">
        <h1>{{ $section->name }}</h1>
        @if ($section->articles()->count())
            <div class="list-group">
                @foreach($section->articles as $article)
                    <a href="{{ $article->link }}"
                       class="list-group-item">{{ $article->name }}</a>
                @endforeach
            </div>
        @endif
    </section>
@stop