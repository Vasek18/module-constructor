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
                    <label for="param_{{$i}}_refresh">Обновляемо?</label>
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
            </div>
        </div>
    </div>
</div>