@extends('bitrix.internal_template')

@section('h1')
    Component.php | {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
<script src="/js/bitrix_component_logic_wizard.js"></script>@endpush

@section('page')

    @include('bitrix.components.progress_way_menu')

    @include('bitrix.components.component_php.wizard', [])

    <form action="{{action('Modules\Bitrix\BitrixComponentsController@store_component_php', [$module->id, $component->id])}}"
          method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-default btn-block"
                   role="button"
                   data-toggle="collapse"
                   href="#component_php_wrap"
                   aria-expanded="false"
                   aria-controls="component_php_wrap">
                    Component.php
                </a>
            </div>
            <div class="col-md-12">
                <div class="collapse"
                     id="component_php_wrap">
                    <h2>Component.php</h2>
                    @push('scripts')
                    <script>
                        var editor_component = window.editor_component = ace.edit("component_php_editor");
                        editor_component.getSession().setMode("ace/mode/php");
                        editor_component.getSession().on('change', function(e){
                            var text = editor_component.getSession().getValue();
                            console.log(text);
                            $("#component_php").val(text);
                        });
                    </script>
                    @endpush
                    <div id="component_php_editor"
                         style="height: 500px">{{$component->component_php}}</div>
                    <input type="hidden"
                           name="component_php"
                           id="component_php"
                           value="{{$component->component_php}}">
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-default btn-block"
                   role="button"
                   data-toggle="collapse"
                   href="#class_php_wrap"
                   aria-expanded="false"
                   aria-controls="class_php_wrap">
                    Class.php
                </a>
            </div>
            <div class="col-md-12">
                <div class="collapse"
                     id="class_php_wrap">
                    <h2>Class.php</h2>
                    @if ($user->canSeePaidFiles())
                        @push('scripts')
                        <script>
                            var editor_class = window.editor_class = ace.edit("class_php_editor");
                            editor_class.getSession().setMode("ace/mode/php");
                            editor_class.getSession().on('change', function(e){
                                var text = editor_class.getSession().getValue();
                                console.log(text);
                                $("#class_php").val(text);
                            });
                        </script>
                        @endpush
                        <div id="class_php_editor"
                             style="height: 500px">{{$component->class_php}}</div>
                        <input type="hidden"
                               name="class_php"
                               id="class_php"
                               value="{{$component->class_php}}">
                    @else
                        {{ trans('app.this_is_paid_functionality') }}
                    @endif
                </div>
            </div>
        </div>
        <br>
        <button class="btn btn-primary"
                name="save">{{ trans('app.save') }}</button>
    </form>

@stop