@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_mail_events.h1') }}
@stop

@section('page')
    <a href="{{action('Modules\Bitrix\BitrixMailEventsController@create', [$module->id])}}"
       class="btn btn-primary">{{ trans('bitrix_mail_events.button_add') }}</a>
    <hr>
    @if (count($mail_events))
        <h2>{{ trans('bitrix_mail_events.mail_events') }}</h2>
        <div class="list-group">
            @foreach($mail_events as $mail_event)
                <div class="list-group-item clearfix mail_event deletion_wrapper">
                    <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]) }}">
                        "{{$mail_event->name}}" ({{$mail_event->code}})
                    </a>
                    <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@destroy', [$module->id, $mail_event->id]) }}"
                       class="btn btn-danger pull-right human_ajax_deletion"
                       id="delete_mail_event_{{$mail_event->id}}">
                    <span class="glyphicon glyphicon-trash"
                          aria-hidden="true"></span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@stop