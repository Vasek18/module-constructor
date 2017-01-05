<div class="row option deletion_wrapper">
    <div class="col-md-2">
        @if ($handler && count($handler->events))
            @foreach($handler->events as $event)
                <input type="text"
                       class="form-control"
                       name="from_module_{{$i}}[]"
                       placeholder="{{ trans('bitrix_event_handlers.module') }}"
                       value="{{$event->from_module}}"
                       list="core_modules_list">
                <br>
            @endforeach
        @endif
        @for($j = 1; $j <= 3; $j++)
            <input type="text"
                   class="form-control"
                   name="from_module_{{$i}}[]"
                   placeholder="{{ trans('bitrix_event_handlers.module') }}"
                   list="core_modules_list">
            <br>
        @endfor
    </div>
    <div class="col-md-3">
        @if ($handler && count($handler->events))
            @foreach($handler->events as $event)
                <div class="row">
                    <div class="col-md-10">
                        <input type="text"
                               class="form-control"
                               name="event_{{$i}}[]"
                               placeholder="{{ trans('bitrix_event_handlers.event') }}"
                               value="{{$event->event}}"
                               list="core_events_list">
                    </div>
                    <div class="col-md-2">
                        <a data-toggle="popover"
                           tabindex="0"
                           role="button"
                           data-trigger="focus"
                           title="{{ trans('bitrix_event_handlers.description') }}"
                           data-content="{{$event->description}}">
                             <span class="glyphicon glyphicon-info-sign"
                                   aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <br>
            @endforeach
        @endif
        @for($j = 1; $j <= 3; $j++)
            <div class="row">
                <div class="col-md-10">
                    <input type="text"
                           class="form-control"
                           name="event_{{$i}}[]"
                           placeholder="{{ trans('bitrix_event_handlers.event') }}"
                           list="core_events_list">
                </div>
            </div>
            <br>
        @endfor
    </div>
    <div class="col-md-2">
        <input type="text"
               class="form-control"
               name="params[]"
               id="params_{{$i}}"
               placeholder="{{ trans('bitrix_event_handlers.params') }}"
               value="{{$handler?$handler->params:''}}">
    </div>
    <div class="col-md-4">
        @if ($handler)
            {{ $handler->php_code }}
        @endif
    </div>
    <div class="col-md-1">
        @if ($handler)
            <a href="#"
               class="btn btn-sm btn-default"
               data-toggle="modal"
               data-target="#php_code_window_{{$i}}">
            <span class="glyphicon glyphicon-console"
                  aria-hidden="true"></span>
            </a>
        @endif
        @if ($handler)
            <a href="{{ action('Modules\Bitrix\BitrixEventHandlersController@destroy', [$module, $handler]) }}"
               class="btn btn-sm btn-danger human_ajax_deletion"
               id="delete_handler_{{$handler->id}}">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>
<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="php_code_window_{{$i}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_event_handlers.code') }} {{ $handler ? '('.$handler->from_module.' -> '.$handler->event.')' : '' }}
                    <br>{{ trans('bitrix_event_handlers.params') }} - ({{ $handler ? $handler->params : '' }})</h4>
            </div>
            <div class="modal-body">
                <label class="sr-only"
                       for="php_code_{{$i}}">{{ trans('bitrix_event_handlers.code') }}</label>
                <div id="editor_{{$i}}"
                     style="height: 500px">{{ $handler ? $handler->php_code : '' }}</div>
                @push('scripts')
                <script>
                    var editor_{{$i}}   = ace.edit("editor_{{$i}}");
                    editor_{{$i}}.getSession().setMode("ace/mode/php");
                    {{--editor.setValue("{!!$handler?$handler->php_code:''!!}");--}}
                    editor_{{$i}}.getSession().on('change', function(e){
                        var text = editor_{{$i}}.getSession().getValue();
                        $("#php_code_{{$i}}").val(text);
                    });
                </script>
                @endpush
                <input type="hidden"
                       name="php_code[]"
                       id="php_code_{{$i}}"
                       value="{{$handler?$handler->php_code:''}}">
            </div>
        </div>
    </div>
</div>