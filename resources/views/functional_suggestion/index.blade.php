@extends('app')

@section('content')
    <div class="container notable-vertical-margin">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1>{{ trans('functional_suggestion.h1') }}</h1>
                @if (count($suggestions))
                    @foreach($suggestions as $suggestion)
                        @include('functional_suggestion.suggestion', ['suggestion' => $suggestion, 'user' => $user])
                    @endforeach
                @else
                    <p class="lead">{{ trans('functional_suggestion.no_suggestions') }}</p>
                @endif
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