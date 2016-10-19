<div class="row option deletion_wrapper">
    <div class="col-md-2">
        <label class="sr-only"
               for="from_module_{{$i}}">{{ trans('bitrix_event_handlers.module') }}</label>
        <input type="text"
               class="form-control"
               name="from_module[]"
               id="from_module_{{$i}}"
               placeholder="{{ trans('bitrix_event_handlers.module') }}"
               value="{{$handler?$handler->from_module:''}}"
               list="core_modules_list">
    </div>
    <div class="col-md-3">
        <label class="sr-only"
               for="event_{{$i}}">{{ trans('bitrix_event_handlers.event') }}</label>
        <input type="text"
               class="form-control"
               name="event[]"
               id="event_{{$i}}"
               placeholder="{{ trans('bitrix_event_handlers.event') }}"
               value="{{$handler?$handler->event:''}}"
               list="core_events_list">
    </div>
    <div class="col-md-2">
        <label class="sr-only"
               for="class_{{$i}}">{{ trans('bitrix_event_handlers.class') }}</label>
        <input type="text"
               class="form-control"
               name="class[]"
               id="class_{{$i}}"
               placeholder="{{ trans('bitrix_event_handlers.class') }}"
               value="{{$handler?$handler->class:''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only"
               for="method_{{$i}}">{{ trans('bitrix_event_handlers.method') }}</label>
        <input type="text"
               class="form-control"
               name="method[]"
               id="method_{{$i}}"
               placeholder="{{ trans('bitrix_event_handlers.method') }}"
               value="{{$handler?$handler->method:''}}">
    </div>
    <div class="col-md-2">
        <input type="text"
               class="form-control"
               name="params[]"
               id="params_{{$i}}"
               placeholder="{{ trans('bitrix_event_handlers.params') }}"
               value="{{$handler?$handler->params:''}}">
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