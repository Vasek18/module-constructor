<div class="modal fade" tabindex="-1" role="dialog" id="admin_options_dop_settings_window_{{$i}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('bitrix_admin_options.additional_settings_title') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" data-for_type_ids="textarea">
                    <label for="option_{{$i}}_height">{{ trans('bitrix_admin_options.height') }}</label>
                    <input class="form-control" type="text" name="option_height[]" id="option_{{$i}}_height"
                           @if ($option) value="{{$option->height}}" @endif>
                </div>
                <div class="form-group" data-for_type_ids="text textarea">
                    <label for="option_{{$i}}_width">{{ trans('bitrix_admin_options.width') }}</label>
                    <input class="form-control" type="text" name="option_width[]" id="option_{{$i}}_width"
                           @if ($option) value="{{$option->width}}" @endif>
                </div>
                {{--                {{dd($option->vals)}}--}}
                <div class="form-group only-one" data-for_type_ids="selectbox multiselectbox">
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="array"
                                   @if ($option && $option->vals) checked
                                    @endif>
                            <b>{{ trans('bitrix_admin_options.specific_values') }}</b>
                        </label>
                        @if ($option && $option->vals)
                            @foreach($option->vals as $val)
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_key[]"
                                               value="{{$val->key}}">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_value[]"
                                               value="{{$val->value}}">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                                <small>{{ trans('bitrix_admin_options.option_option_default') }}</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @for($j = count($option->vals); $j<=count($option->vals)+5;$j++)
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_value[]">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                                <small>{{ trans('bitrix_admin_options.option_option_default') }}</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @else
                            @for($j = 0; $j<=5;$j++)
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="option_{{$j}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="option_{{$j}}_vals_value[]">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox">
                                                <small>{{ trans('bitrix_admin_options.option_option_default') }}</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <div>{{ trans('bitrix_admin_options.or') }}</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="iblocks_list"
                                   @if ($option && $option->spec_vals == 'iblocks_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_admin_options.iblocks_list') }}</b>
                        </label>
                    </div>
                    <div></div>
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="iblock_items_list"
                                   @if ($option && $option->spec_vals == 'iblock_items_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_admin_options.iblock_elements_list') }}</b>
                        </label>
                        <input type="text" name="option_{{$i}}_spec_args[]" class="form-control" placeholder="{{ trans('bitrix_admin_options.iblock') }}"
                               @if ($option && $option->spec_vals == 'iblock_items_list') value="{{$option->spec_vals_args}}" @endif>
                    </div>
                    <div>{{ trans('bitrix_admin_options.or') }}</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="iblock_props_list"
                                   @if ($option && $option->spec_vals == 'iblock_props_list') checked
                                    @endif>
                            <b>{{ trans('bitrix_admin_options.iblock_props_list') }}</b>
                        </label>
                        <input type="text" name="option_{{$i}}_spec_args[]" class="form-control" placeholder="{{ trans('bitrix_admin_options.iblock') }}"
                               @if ($option && $option->spec_vals == 'iblock_props_list') value="{{$option->spec_vals_args}}" @endif>
                    </div>
                </div>
                <div class="form-group" data-for_type_ids="text textarea selectbox multiselectbox">
                    <label for="option_{{$i}}_default_value">{{ trans('bitrix_admin_options.value_by_default') }}</label>
                    <input class="form-control" type="text" name="default_value[]" id="option_{{$i}}_default_value"
                           @if ($option) value="{{$option->default_value}}" @endif>
                </div>
            </div>
        </div>
    </div>
</div>