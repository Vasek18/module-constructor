@extends('bitrix.internal_template')

@section('h1')
    Component.php | {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    <div id="editor" style="height: 500px">{{$component->component_php}}</div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
    <script>
        var editor   = ace.edit("editor");
        editor.getSession().setMode("ace/mode/php");
        editor.getSession().on('change', function(e){
            var text = editor.getSession().getValue();
            console.log(text);
            $("#component_php").val(text);
        });
    </script>
    @endpush
    <form action="{{action('Modules\Bitrix\BitrixComponentsController@store_component_php', [$module->id, $component->id])}}" method="post">
        {{ csrf_field() }}
    <input type="hidden" name="component_php" id="component_php"
           value="{{$component->component_php}}">
        <button class="btn btn-primary" name="save">{{ trans('app.save') }}</button>
    </form>

@stop