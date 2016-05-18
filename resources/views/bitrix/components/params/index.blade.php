@extends('bitrix.internal_template')

@section('h1')
    Параметры подключения | Компонент {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @push('scripts')
    <script src="/js/bitrix_module_components_params.js"></script>
    @endpush

    @include('bitrix.components.progress_way_menu')
    <button class="btn btn-primary" data-toggle="modal"
            data-target="#upload_prepared_files">Загрузить готовые файлы
    </button>
    <div class="modal fade" tabindex="-1" role="dialog" id="upload_prepared_files">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Загрузка файлов параметров компонента</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ action('Modules\Bitrix\BitrixComponentsParamsController@upload_params_files', [$module->id, $component->id]) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="params_file">Файл</label>
                            <input class="form-control" type="file" name="params_file" id="params_file" required
                                   accept=".php">
                        </div>
                        <div class="form-group">
                            <label for="params_lang_file">Языковой файл</label>
                            <input class="form-control" type="file" name="params_lang_file" id="params_lang_file"
                                   required accept=".php">
                        </div>
                        <button class="btn btn-primary">Загрузить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <p>или</p>

    <form role="form" method="POST"
          action="{{ action('Modules\Bitrix\BitrixComponentsParamsController@store', [$module->id, $component->id]) }}">
        {{ csrf_field() }}
        <div class="row option-headers">
            <div class="col-md-3">
                <label>Название свойства</label>
            </div>
            <div class="col-md-2">
                <label>Код свойства</label>
            </div>
            <div class="col-md-2">
                <label>Тип свойства</label>
            </div>
            <div class="col-md-2">
                <label>Группа свойства</label>
            </div>
            <div class="col-md-2">
            </div>
            <div class="col-md-1">
                <label>Удалить</label>
            </div>
        </div>
        <div class="draggable-container">
            {{--todo вынести row--}}
            {{--@each('bitrix.admin_options.item', $params, 'option')--}}
            @foreach($params as $i => $param)
                {{--{{dd($param)}}--}}
                @include('bitrix.components.params.item', ['param' => $param, 'i' => $i, 'module' => $module, 'component' => $component])
            @endforeach
        </div>
        {{-- Дополнительно показываем ещё несколько пустых строк --}}
        @for ($j = count($params); $j < count($params)+5; $j++)
            @include('bitrix.components.params.item', ['param' => null, 'i' => $j, 'module' => $module, 'component' => $component])
        @endfor
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block">Сохранить</button>
            </div>
        </div>
    </form>

@stop
