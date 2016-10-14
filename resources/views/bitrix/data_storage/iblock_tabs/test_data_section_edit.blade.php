@extends('bitrix.internal_template')

@section('h1')
    @if (isset($section))
        {{ trans('bitrix_iblocks_form.edit_section_page_title') }}
    @else
        {{ trans('bitrix_iblocks_form.add_section_page_title') }}
    @endif
@stop

@section('page')
    <p>
        <a class="btn btn-primary"
           href="{{ action('Modules\Bitrix\BitrixDataStorageController@detail_ib', [$module->id, $iblock->id]) }}">
            {{ trans('bitrix_iblocks_form.back_to_iblock') }}
        </a>
    </p>
    <ul class="nav nav-tabs"
        role="tablist">
        <li role="presentation"
            class="active">
            <a href="#section"
               aria-controls="section"
               role="tab"
               data-toggle="tab">{{ trans('bitrix_iblocks_form.test_section_section_tab_title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel"
             class="tab-pane active"
             id="section">
            @if (isset($section))
                <form action="{{ action('Modules\Bitrix\BitrixDataStorageController@save_section', [$module->id, $iblock->id, $section->id]) }}"
                      method="post">
                    @else
                        <form action="{{ action('Modules\Bitrix\BitrixDataStorageController@store_section', [$module->id, $iblock->id]) }}"
                              method="post">
                            @endif

                            {{ csrf_field() }}
                            <div class="col-md-offset-2 col-md-8">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="ACTIVE"
                                                   value="Y"
                                                    {{!isset($section) || $section->active ? 'checked' : ''}}
                                            >
                                            {{ trans('bitrix_iblocks_form.test_data_tab_active') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="NAME">{{ trans('bitrix_iblocks_form.test_data_tab_name') }}
                                    </label>
                                    <input type="text"
                                           id="NAME"
                                           name="NAME"
                                           class="form-control"
                                           value="{{isset($section) ? $section->name : ''}}"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="CODE">{{ trans('bitrix_iblocks_form.test_data_tab_code') }}
                                    </label>
                                    <input type="text"
                                           id="CODE"
                                           name="CODE"
                                           class="form-control"
                                           data-translit_from="NAME"
                                           value="{{isset($section) ? $section->code : ''}}"
                                            {{isset($iblock->params->FIELDS->CODE->IS_REQUIRED) && $iblock->params->FIELDS->CODE->IS_REQUIRED == 'Y'?'required':''}}
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="SORT">{{ trans('bitrix_iblocks_form.test_data_tab_sort') }}
                                    </label>
                                    <input type="text"
                                           id="SORT"
                                           name="SORT"
                                           class="form-control"
                                           value="{{isset($section) ? $section->sort : '500'}}"
                                            {{isset($iblock->params->FIELDS->SORT->IS_REQUIRED) && $iblock->params->FIELDS->SORT->IS_REQUIRED == 'Y'?'required':''}}
                                    >
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary"
                                            name="save">{{ trans('bitrix_iblocks_form.button_save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
        </div>
    </div>
@stop