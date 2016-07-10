@extends('bitrix.internal_template')

@section('h1')
    {{ trans('bitrix_components.visual_path_h1') }} | {{ trans('bitrix_components.component') }} {{ $component->name }} ({{ $component->code }})
@stop

@section('page')

    @include('bitrix.components.progress_way_menu')

    <div id="path_items">
        <div class="path">
            <form action="{{action('Modules\Bitrix\BitrixComponentsController@store_visual_path', [$module->id, $component->id])}}"
                  method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="item col-md-3">
                        <h3>{{ trans('bitrix_components.level') }} 1</h3>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_id_1"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_id') }}"
                                   value="{{isset($path_items[0]) ? $path_items[0]->code : ''}}"
                                   required>
                        </div>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_name_1"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_name') }}"
                                   value="{{isset($path_items[0]) ? $path_items[0]->name : ''}}"
                                   required>
                        </div>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_sort_1"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_sort') }}"
                                   value="{{isset($path_items[0]) ? $path_items[0]->sort : ''}}"
                                   required>
                        </div>
                    </div>
                    <div class="item col-md-3">
                        <h3>{{ trans('bitrix_components.level') }} 2</h3>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_id_2"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_id') }}"
                                   value="{{isset($path_items[1]) ? $path_items[1]->code : ''}}">
                        </div>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_name_2"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_name') }}"
                                   value="{{isset($path_items[1]) ? $path_items[1]->name : ''}}">
                        </div>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_sort_2"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_sort') }}"
                                   value="{{isset($path_items[1]) ? $path_items[1]->sort : ''}}">
                        </div>
                    </div>
                    <div class="item col-md-3">
                        <h3>{{ trans('bitrix_components.level') }} 3</h3>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_id_3"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_id') }}"
                                   value="{{isset($path_items[2]) ? $path_items[2]->code : ''}}">
                        </div>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_name_3"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_name') }}"
                                   value="{{isset($path_items[2]) ? $path_items[2]->name : ''}}">
                        </div>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   name="path_sort_3"
                                   placeholder="{{ trans('bitrix_components.visual_path_field_sort') }}"
                                   value="{{isset($path_items[2]) ? $path_items[2]->sort : ''}}">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary"
                        name="store_path">{{ trans('bitrix_components.visual_path_button_save') }}
                </button>
            </form>
        </div>
    </div>

@stop
