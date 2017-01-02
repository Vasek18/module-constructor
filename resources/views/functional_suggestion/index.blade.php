@extends('app')

@section('content')
    <div class="container notable-vertical-margin">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1>Предложения функционала</h1>
                @foreach($suggestions as $suggestion)
                    <div class="panel panel-primary">
                        <div class="panel-heading">{{ $suggestion->name }}</div>
                        <div class="panel-body">
                            <p>{{ $suggestion->description }}</p>
                        </div>
                        <div class="panel-footer">
                            <a href="#"
                               class="upvote btn btn-success">Да, это нужно
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @include('functional_suggestion.add_form')
            </div>
        </div>
    </div>
@stop