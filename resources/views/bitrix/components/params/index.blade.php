@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.params_h1') }} | {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @push('scripts')
    <script src="/js/bitrix_module_components_params.js"></script>
    @endpush

    @include('bitrix.components.progress_way_menu')
    <button class="btn btn-primary"
            data-toggle="modal"
            data-target="#upload_prepared_files">{{ trans('bitrix_components.params_button_upload') }}
    </button>
    @include('bitrix.button_n_modal_for_file_copy', ['path' => '\install\components\\'.$component->namespace.'\\'.$component->code.'\.parameters.php', 'show' => $user->canSeePaidFiles(), 'is_lang' => false])
    @include('bitrix.button_n_modal_for_file_copy', ['path' => '\install\components\\'.$component->namespace.'\\'.$component->code.'\lang\ru\.parameters.php', 'show' => $user->canSeePaidFiles(), 'is_lang' => true, 'add_id' => '_lang'])
    @include('bitrix.components.params.hint_vars_for_input', ['name' => 'params_variables_list'])
    <div class="modal fade"
         tabindex="-1"
         role="dialog"
         id="upload_prepared_files">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">{{ trans('bitrix_components.params_upload_window_title') }}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ action('Modules\Bitrix\BitrixComponentsParamsController@upload_params_files', [$module->id, $component->id]) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="params_file">{{ trans('bitrix_components.params_upload_window_field_params_file') }}</label>
                            <input class="form-control"
                                   type="file"
                                   name="params_file"
                                   id="params_file"
                                   required
                                   accept=".php">
                        </div>
                        <div class="form-group">
                            <label for="params_lang_file">{{ trans('bitrix_components.params_upload_window_field_params_lang_file') }}</label>
                            <input class="form-control"
                                   type="file"
                                   name="params_lang_file"
                                   id="params_lang_file"
                                   required
                                   accept=".php">
                        </div>
                        <button class="btn btn-primary">{{ trans('app.upload') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <p>{{ trans('bitrix_components.params_dop_or' ) }}</p>

    <form role="form"
          method="POST"
          action="{{ action('Modules\Bitrix\BitrixComponentsParamsController@store', [$module->id, $component->id]) }}">
        {{ csrf_field() }}
        <div class="row option-headers">
            <div class="col-md-3">
                <label>{{ trans('bitrix_components.params_name_column') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_components.params_code_column') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_components.params_type_column') }}</label>
            </div>
            <div class="col-md-2">
                <label>{{ trans('bitrix_components.params_group_column') }}</label>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-1">
                <label>{{ trans('app.delete') }}</label>
            </div>
        </div>
        <div class="draggable-container">
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
                <button class="btn btn-primary btn-block"
                        name="save">{{ trans('app.save') }}</button>
            </div>
        </div>
    </form>
    <hr>
    <p class="description">{!! trans('bitrix_components.params_step_description') !!}</p>
    <hr>
    <p>{!! trans('bitrix_components.params_hints') !!}</p>
@stop
