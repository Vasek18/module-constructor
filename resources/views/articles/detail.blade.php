@extends('app')

@section('content')
    <section class="container">
        <h1>{{ $article->name }}</h1>
        <div class="detail-text">
            {{ $article->detail_text }}
        </div>
    </section>
@stop