<div class="modal fade" tabindex="-1" role="dialog" id="component_params_dop_settings_window_{{$i}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Дополнительные настройки</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="param_{{$i}}_refresh">Обновляет ли остальные настройки?</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="param_refresh[]" id="param_{{$i}}_refresh"
                                   value="1" @if ($param && $param->refresh) checked @endif> Да
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="param_{{$i}}_multiple">Множественное?</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="param_multiple[]" id="param_{{$i}}_multiple"
                                   value="1" @if ($param && $param->multiple) checked @endif> Да
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="param_{{$i}}_size">Высота</label>
                    <input class="form-control" type="text" name="param_size[]" id="param_{{$i}}_size"
                           @if ($param) value="{{$param->size}}" @endif>
                </div>
                <div class="form-group">
                    <label for="param_{{$i}}_cols">Ширина</label>
                    <input class="form-control" type="text" name="param_cols[]" id="param_{{$i}}_cols"
                           @if ($param) value="{{$param->cols}}" @endif>
                </div>
                <div class="form-group">
                    <label for="param_{{$i}}_default">Значение по умолчанию</label>
                    <input class="form-control" type="text" name="param_default[]" id="param_{{$i}}_default"
                           @if ($param) value="{{$param->default}}" @endif>
                </div>
                <div class="form-group">
                    <label for="param_{{$i}}_additional_values">Показывать дополнительные значения?</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="param_additional_values[]" id="param_{{$i}}_additional_values"
                                   value="1" @if ($param && $param->additional_values) checked @endif> Да
                        </label>
                    </div>
                </div>
                <div class="form-group only-one" data-for_type_ids="3,4">
                    <div class="item">
                        <label>
                            <input type="radio" name="param_{{$i}}_vals_type" value="array"
                                   @if ($param && $param->spec_vals == 'array') checked @endif>
                            <b>Конкретные значения</b>
                        </label>
                        @if ($param && $param->vals)
                            @foreach($param->vals as $val)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="param_{{$i}}_vals_key[]"
                                               value="{{$val->key}}">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="param_{{$i}}_vals_value[]"
                                               value="{{$val->value}}">
                                    </div>
                                </div>
                            @endforeach
                            @for($j = count($param->vals); $j<=count($param->vals)+5;$j++)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="param_{{$i}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="param_{{$i}}_vals_value[]">
                                    </div>
                                </div>
                            @endfor
                        @else
                            @for($j = 0; $j<=5;$j++)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="param_{{$j}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="param_{{$j}}_vals_value[]">
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="param_{{$i}}_vals_type" value="iblocks_types_list"
                                   @if ($param && $param->spec_vals == 'iblocks_types_list') checked
                                    @endif>
                            <b>Список типов инфоблоков</b>
                        </label>
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="param_{{$i}}_vals_type" value="iblocks_list"
                                   @if ($param && $param->spec_vals == 'iblocks_list') checked
                                    @endif>
                            <b>Список инфоблоков</b>
                        </label>
                        <input type="text" name="param_{{$i}}_spec_args[]" class="form-control" placeholder="Тип инфоблоков"
                               @if ($param && $param->spec_vals == 'iblocks_list') value="{{$param->spec_vals_args}}" @endif>
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="param_{{$i}}_vals_type" value="iblock_items_list"
                                   @if ($param && $param->spec_vals == 'iblock_items_list') checked
                                    @endif>
                            <b>Список элементов инфоблока</b>
                        </label>
                        <input type="text" name="param_{{$i}}_spec_args[]" class="form-control" placeholder="Инфоблок"
                               @if ($param && $param->spec_vals == 'iblock_items_list') value="{{$param->spec_vals_args}}" @endif>
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="param_{{$i}}_vals_type" value="iblock_props_list"
                                   @if ($param && $param->spec_vals == 'iblock_props_list') checked
                                    @endif>
                            <b>Список свойств инфоблока</b>
                        </label>
                        <input type="text" name="param_{{$i}}_spec_args[]" class="form-control" placeholder="Инфоблок"
                               @if ($param && $param->spec_vals == 'iblock_props_list') value="{{$param->spec_vals_args}}" @endif>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>