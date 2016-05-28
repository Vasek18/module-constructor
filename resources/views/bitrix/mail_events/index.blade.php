@extends('bitrix.internal_template')

@section('h1')
    Почтовые события
@stop

@section('page')

    <a href="{{action('Modules\Bitrix\BitrixMailEventsController@create', [$module->id])}}" class="btn btn-primary">Добавить почтовое событий</a>
    <hr>
    @if (count($mail_events))
        <h2>Почтовые события</h2>
        <div class="list-group">
            @foreach($mail_events as $mail_event)
                <div class="list-group-item clearfix component">
                    <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]) }}">
                        "{{$mail_event->name}}" ({{$mail_event->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@destroy', [$module->id, $mail_event->id]) }}"
                       class="btn btn-danger pull-right">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop