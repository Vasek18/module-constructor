<div class="modal fade" tabindex="-1" role="dialog" id="admin_options_dop_settings_window_{{$i}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Дополнительные настройки</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" data-for_type_ids="2">
                    <label for="option_{{$i}}_height">Высота</label>
                    <input class="form-control" type="text" name="option_height[]" id="option_{{$i}}_height"
                           @if ($option) value="{{$option->height}}" @endif>
                </div>
                <div class="form-group" data-for_type_ids="1,2">
                    <label for="option_{{$i}}_width">Ширина</label>
                    <input class="form-control" type="text" name="option_width[]" id="option_{{$i}}_width"
                           @if ($option) value="{{$option->width}}" @endif>
                </div>
                <div class="form-group" data-for_type_ids="5">
                    <label for="option_{{$i}}_spec_args">Значение</label>
                    <input class="form-control" type="text" name="option_{{$i}}_spec_args[]" id="option_{{$i}}_spec_args"
                           @if ($option && $option->type_id == 5) value="{{$option->spec_vals_args}}" @endif>
                </div>

                {{--                {{dd($option->vals)}}--}}
                <div class="form-group only-one" data-for_type_ids="3,4">
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="array"
                                   @if ($option && $option->vals) checked
                                    @endif>
                            <b>Конкретные значения</b>
                        </label>
                        @if ($option && $option->vals)
                            @foreach($option->vals as $val)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_key[]"
                                               value="{{$val->key}}">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_value[]"
                                               value="{{$val->value}}">
                                    </div>
                                </div>
                            @endforeach
                            @for($j = count($option->vals); $j<=count($option->vals)+5;$j++)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="option_{{$i}}_vals_value[]">
                                    </div>
                                </div>
                            @endfor
                        @else
                            @for($j = 0; $j<=5;$j++)
                                <div class="row">
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" name="option_{{$j}}_vals_key[]">
                                    </div>
                                    <div class="col-md-1">=&gt;</div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="option_{{$j}}_vals_value[]">
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="iblocks_list"
                                   @if ($option && $option->spec_vals == '$iblocks()') checked
                                    @endif>
                            <b>Список инфоблоков</b>
                        </label>
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="iblock_items_list"
                                   @if ($option && $option->spec_vals == '$iblock_items()') checked
                                    @endif>
                            <b>Список элементов инфоблока</b>
                        </label>
                        <input type="text" name="option_{{$i}}_spec_args[]" class="form-control" placeholder="Инфоблок"
                               @if ($option && $option->spec_vals == '$iblock_items()') value="{{$option->spec_vals_args}}" @endif>
                    </div>
                    <div>или</div>
                    <div class="item">
                        <label>
                            <input type="radio" name="option_{{$i}}_vals_type" value="iblock_props_list"
                                   @if ($option && $option->spec_vals == '$iblock_props()') checked
                                    @endif>
                            <b>Список свойств инфоблока</b>
                        </label>
                        <input type="text" name="option_{{$i}}_spec_args[]" class="form-control" placeholder="Инфоблок"
                               @if ($option && $option->spec_vals == '$iblock_props()') value="{{$option->spec_vals_args}}" @endif>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>