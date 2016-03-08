<div class="row option">
    <div class="col-md-2">
        <label class="sr-only" for="from_module_{{$i}}">Модуль</label>
        <input type="text" class="form-control" name="from_module[]"
               id="from_module_{{$i}}"
               placeholder="Модуль" value="{{$handler?$handler->from_module:''}}">
    </div>
    <div class="col-md-3">
        <label class="sr-only" for="event_{{$i}}">Событие</label>
        <input type="text" class="form-control" name="event[]"
               id="event_{{$i}}"
               placeholder="Событие" value="{{$handler?$handler->event:''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="class_{{$i}}">Класс для обработчика</label>
        <input type="text" class="form-control" name="class[]"
               id="class_{{$i}}"
               placeholder="Класс для обработчика" value="{{$handler?$handler->class:''}}">
    </div>
    <div class="col-md-2">
        <label class="sr-only" for="method_{{$i}}">Метод для обработчика</label>
        <input type="text" class="form-control" name="method[]"
               id="method_{{$i}}"
               placeholder="Метод для обработчика" value="{{$handler?$handler->method:''}}">
    </div>
    <div class="col-md-2">
        <a href="#" class="btn btn-default" data-toggle="modal"
           data-target="#php_code_window_{{$i}}">Редактировать</a>
        <div class="modal fade" tabindex="-1" role="dialog" id="php_code_window_{{$i}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Код для обработчика</h4>
                    </div>
                    <div class="modal-body">
                        <label class="sr-only" for="php_code_{{$i}}">Код для обработчика</label>
                        <div id="editor_{{$i}}" style="height: 500px">{{$handler?$handler->php_code:''}}</div>

                        @push('scripts')
                        <script>
                            var editor_{{$i}} = ace.edit("editor_{{$i}}");
                            editor_{{$i}}.getSession().setMode("ace/mode/php");
                            {{--editor.setValue("{!!$handler?$handler->php_code:''!!}");--}}
                            editor_{{$i}}.getSession().on('change', function(e){
                                var text = editor_{{$i}}.getSession().getValue();
                                console.log(text)
                                $("#php_code_{{$i}}").val(text);
                            });
                        </script>
                        @endpush
                        <input type="hidden" name="php_code[]" id="php_code_{{$i}}" value="{{$handler?$handler->php_code:''}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1">
        @if ($handler)
            <a href="{{ action('Modules\Bitrix\BitrixEventHandlersController@destroy', [$module->id, $handler?$handler->id:'']) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
        @endif
    </div>
</div>