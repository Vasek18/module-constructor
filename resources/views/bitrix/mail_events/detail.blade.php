@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_mail_events.mail_event') }} {{ $mail_event->name }} ({{ $mail_event->code }})
@stop

@section('page')
    <div class="col-md-4">
        <h2>{{ trans('bitrix_mail_events.main_info') }}</h2>
        <form method="post"
              action="{{ action('Modules\Bitrix\BitrixMailEventsController@update', [$module->id, $mail_event->id]) }}"
              class="readonly">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label>{{ trans('bitrix_mail_events.detail_page_code') }}</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="code">{{$mail_event->code}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('bitrix_mail_events.detail_page_name') }}</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="name">{{$mail_event->name}}</a>
                </p>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('bitrix_mail_events.detail_page_sort') }}</label>
                <p class="form-control-static">
                    <a href="#"
                       class="you-can-change ajax"
                       data-name="sort">{{$mail_event->sort}}</a>
                </p>
            </div>
            <h3>{{ trans('bitrix_mail_events.vars') }}</h3>
            @if (count($mail_event->vars))
                <div class="list-group">
                    @foreach($mail_event->vars as $var)
                        <div class="list-group-item clearfix deletion_wrapper">
                            <div class="col-md-10">{{$var->code}} - {{$var->name}}</div>
                            <div class="col-md-2">
                                <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@destroy_var', [$module->id, $mail_event->id, $var->id]) }}"
                                   class="btn btn-danger btn-sm human_ajax_deletion"
                                   id="delete-var-{{ $var->id }}">
                                    <span class="glyphicon glyphicon-trash"
                                          aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="not-exist">{{ trans('app.not-exist_pl') }}</p>
            @endif
            <a href="#"
               class="btn btn-primary"
               data-toggle="modal"
               data-target="#modal_add_var">{{ trans('bitrix_mail_events.add_var_btn') }}
            </a>
            <button type="submit"
                    class="hidden">{{ trans('app.save') }}
            </button>
        </form>
    </div>
    <div class="col-md-4 col-md-offset-1">
        <h2>{{ trans('bitrix_mail_events.templates') }}</h2>
        @if (count($mail_event->templates))
            <div class="list-group">
                @foreach($mail_event->templates as $template)
                    <div class="list-group-item clearfix deletion_wrapper">
                        <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@show_template', [$module->id, $mail_event->id, $template->id]) }}">{{$template->name}}
                        </a>
                        <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@destroy_template', [$module->id, $mail_event->id, $template->id]) }}"
                           class="btn btn-danger btn-sm pull-right human_ajax_deletion"
                           id="delete-template-{{ $template->id }}">
                            <span class="glyphicon glyphicon-trash"
                                  aria-hidden="true"></span>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="not-exist">{{ trans('app.not-exist_pl') }}</p>
        @endif
        <p>
            <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@create_template', [$module->id, $mail_event->id]) }}"
               class="btn btn-primary">{{ trans('bitrix_mail_events.add_template_btn') }}
            </a>
        </p>
    </div>
    <div class="col-md-2 col-md-offset-1">
        <br>
        <p>
            <a href="{{ action('Modules\Bitrix\BitrixMailEventsController@destroy', [$module->id, $mail_event->id]) }}"
               class="btn btn-sm btn-danger"
               id="delete-mail-event">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
                {{ trans('bitrix_mail_events.delete_event_btn') }}
            </a>
        </p>
    </div>
    <div class="modal fade"
         tabindex="-1"
         role="dialog"
         id="modal_add_var">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">{{ trans('bitrix_mail_events.add_var_title') }}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ action('Modules\Bitrix\BitrixMailEventsController@add_var', [$module->id, $mail_event->id]) }}"
                          method="POST">
                        <input type="hidden"
                               name="_token"
                               value="{{ csrf_token() }}">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input class="form-control"
                                       type="text"
                                       placeholder="{{ trans('app.field_name') }}"
                                       name="name"
                                       id="MAIL_EVENT_VARS_NAME"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control"
                                       type="text"
                                       placeholder="{{ trans('app.field_code') }}"
                                       name="code"
                                       id="MAIL_EVENT_VARS_CODE"
                                       data-translit_from="MAIL_EVENT_VARS_NAME"
                                       data-transform="uppercase"
                                       required>
                            </div>
                        </div>
                        <p>
                            <button type="submit"
                                    class="btn btn-primary"
                                    name="add_var">{{ trans('app.add') }}
                            </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
