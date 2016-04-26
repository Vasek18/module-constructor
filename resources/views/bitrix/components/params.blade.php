@extends('bitrix.internal_template')

@section('h1')
    Параметры подключения | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')
    <form role="form" method="POST"
          action="{{ action('Modules\Bitrix\BitrixComponentsController@store_params', [$module->id, $component->id]) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row option-headers">
            <div class="col-md-1">
                <label>Сортировка</label>
            </div>
            <div class="col-md-2">
                <label>Код свойства</label>
            </div>
            <div class="col-md-3">
                <label>Название свойства</label>
            </div>
            <div class="col-md-2">
                <label>Тип свойства</label>
            </div>
            <div class="col-md-2">
                <label>Удалить</label>
            </div>
        </div>
        {{--todo вынести row--}}
        {{--@each('bitrix.admin_options.item', $params, 'option')--}}
        @foreach($params as $i => $param)
            {{--{{dd($param)}}--}}
            @include('bitrix.components.params_item', ['param' => $param, 'i' => $i, 'module' => $module, 'component' => $component])
        @endforeach
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($params); $j < count($params)+5; $j++)
            @include('bitrix.components.params_item', ['param' => null, 'i' => $j, 'module' => $module, 'component' => $component])
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">Сохранить</button>
            </div>
        </div>
    </form>

@stop
