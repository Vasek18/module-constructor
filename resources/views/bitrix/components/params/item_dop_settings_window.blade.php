<div class="modal fade"
     tabindex="-1"
     role="dialog"
     id="component_params_dop_settings_window_{{$i}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ trans('bitrix_components.additional_settings_title') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group"
                     data-for_types="LIST CHECKBOX">
                    <label for="param_{{$i}}_refresh">{{ trans('bitrix_components.params_dop_refresh') }}</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="param_refresh[]"
                                   id="param_{{$i}}_refresh"
                                   value="1"
                                   @if ($param && $param->refresh) checked @endif>
                            {{ trans('app.yes') }}
                        </label>
                    </div>
                </div>
                <div class="form-group"
                     data-for_types="LIST STRING FILE">
                    <label for="param_{{$i}}_multiple">{{ trans('bitrix_components.params_dop_multiple') }}</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="param_multiple[]"
                                   id="param_{{$i}}_multiple"
                                   value="1"
                                   @if ($param && $param->multiple) checked @endif>
                            {{ trans('app.yes') }}
                        </label>
                    </div>
                </div>
                <div class="form-group"
                     data-for_types="LIST">
                    <label for="param_{{$i}}_size">{{ trans('bitrix_components.params_dop_height') }}</label>
                    <input class="form-control"
                           type="text"
                           name="param_size[]"
                           id="param_{{$i}}_size"
                           @if ($param) value="{{$param->size}}" @endif>
                </div>
                <div class="form-group"
                     data-for_types="STRING">
                    <label for="param_{{$i}}_cols">{{ trans('bitrix_components.params_dop_width') }}</label>
                    <input class="form-control"
                           type="text"
                           name="param_cols[]"
                           id="param_{{$i}}_cols"
                           @if ($param) value="{{$param->cols}}" @endif>
                </div>
                <div class="form-group"
                     data-for_types="STRING LIST">
                    <label for="param_{{$i}}_default">{{ trans('bitrix_components.params_dop_value_by_default') }}</label>
                    <input class="form-control"
                           type="text"
                           name="param_default[]"
                           id="param_{{$i}}_default"
                           @if ($param) value="{{$param->default}}" @endif>
                </div>
                <div class="form-group"
                     data-for_types="LIST">
                    <label for="param_{{$i}}_additional_values">{{ trans('bitrix_components.params_dop_show_dop_values') }}</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="param_additional_values[]"
                                   id="param_{{$i}}_additional_values"
                                   value="1"
                                   @if ($param && $param->additional_values) checked @endif>
                            {{ trans('app.yes') }}
                        </label>
                    </div>
                </div>
                <div class="form-group only-one"
                     data-for_types="LIST">
                    <div class="item">
                        <label>
                            <input type="radio"
                                   name="param_{{$i}}_vals_type"
                                   value="array"
                                   @if ($param && $param->spec_vals == 'array') checked @endif>
                            <b>{{ trans('bitrix_components.params_dop_specific_values') }}</b>
                        </label>
                        @if ($param && $param->vals)
                            @foreach($param->vals as $val)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control"
                                               type="text"
                                               name="param_{{$i}}_vals_key[]"
                                               value="{{$val->key}}">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control"
                                               type="text"
                                               name="param_{{$i}}_vals_value[]"
                                               value="{{$val->value}}">
                                    </div>
                                </div>
                            @endforeach
                            @for($j = count($param->vals); $j<=count($param->vals)+5;$j++)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control"
                                               type="text"
                                               name="param_{{$i}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control"
                                               type="text"
                                               name="param_{{$i}}_vals_value[]">
                                    </div>
                                </div>
                            @endfor
                        @else
                            @for($j = 0; $j<=5;$j++)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control"
                                               type="text"
                                               name="param_{{$j}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control"
                                               type="text"
                                               name="param_{{$j}}_vals_value[]">
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <div>{{ trans('bitrix_components.params_dop_or' ) }}</div>
                    <div class="item">
                        <label>
                            <input type="radio"
                                   name="param_{{$i}}_vals_type"
                                   value="iblocks_types_list"
                                   @if ($param && $param->spec_vals == 'iblocks_types_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_components.params_dop_iblocks_types_list') }}</b>
                        </label>
                    </div>
                    <div>{{ trans('bitrix_components.params_dop_or' ) }}</div>
                    <div class="item">
                        <label>
                            <input type="radio"
                                   name="param_{{$i}}_vals_type"
                                   value="iblocks_list"
                                   @if ($param && $param->spec_vals == 'iblocks_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_components.params_dop_iblocks_list') }}</b>
                        </label>
                        <input type="text"
                               name="param_{{$i}}_spec_args[]"
                               class="form-control"
                               placeholder="{{ trans('bitrix_components.params_dop_iblock_type' ) }}"
                               @if ($param && $param->spec_vals == 'iblocks_list') value="{{$param->spec_vals_args}}" @endif>
                    </div>
                    <div>{{ trans('bitrix_components.params_dop_or' ) }}</div>
                    <div class="item">
                        <label>
                            <input type="radio"
                                   name="param_{{$i}}_vals_type"
                                   value="iblock_items_list"
                                   @if ($param && $param->spec_vals == 'iblock_items_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_components.params_dop_iblock_elements_list') }}</b>
                        </label>
                        <input type="text"
                               name="param_{{$i}}_spec_args[]"
                               class="form-control"
                               placeholder="{{ trans('bitrix_components.params_dop_iblock' ) }}"
                               @if ($param && $param->spec_vals == 'iblock_items_list') value="{{$param->spec_vals_args}}" @endif>
                    </div>
                    <div>{{ trans('bitrix_components.params_dop_or' ) }}</div>
                    <div class="item">
                        <label>
                            <input type="radio"
                                   name="param_{{$i}}_vals_type"
                                   value="iblock_props_list"
                                   @if ($param && $param->spec_vals == 'iblock_props_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_components.params_dop_iblock_props_list') }}</b>
                        </label>
                        <input type="text"
                               name="param_{{$i}}_spec_args[]"
                               class="form-control"
                               placeholder="{{ trans('bitrix_components.params_dop_iblock' ) }}"
                               @if ($param && $param->spec_vals == 'iblock_props_list') value="{{$param->spec_vals_args}}" @endif>
                    </div>
                </div>
                <div class="form-group"
                     data-for_types="">
                    @if (isset($template))
                        <input type="hidden" name="param_template_id[]" value="{{ $template->id }}">
                    @else
                        <label for="param_{{$i}}_template_id">{{ trans('bitrix_components.params_dop_template_id') }}</label>
                        <select name="param_template_id[]"
                                id="param_{{$i}}_template_id"
                                class="form-control">
                            <option value="">{{ trans('bitrix_components.for_all_templates') }}</option>
                            @foreach($component->templates as $c_template)
                                <option value="{{ $c_template->id }}">{{ $c_template->code }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>