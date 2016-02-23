<div class="modal fade" tabindex="-1" role="dialog" id="admin_options_dop_settings_window_{{$i}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Дополнительные настройки</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="option_number">
                <div class="form-group" data-for_type_ids="2">
                    <label for="option_{{$i}}_height">Высота</label>
                    <input class="form-control" type="text" name="option_height[]" id="option_{{$i}}_height"
                           value="{{$option && $option->height}}">
                </div>
                <div class="form-group" data-for_type_ids="1,2">
                    <label for="option_{{$i}}_width">Ширина</label>
                    <input class="form-control" type="text" name="option_width[]" id="option_{{$i}}_width"
                           value="{{$option && $option->width}}">
                </div>

{{--                {{dd($option->vals)}}--}}
                <div class="form-group" data-for_type_ids="3,4,5">
                    <label for="option_vals">Значения</label>
                    @if ($option && $option->vals)
                        @foreach($option->vals as $val)
                            <div class="row">
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="option_{{$i}}_vals_key[]"
                                           value="{{$val->key}}">
                                </div>
                                <div class="col-md-1">=&gt;</div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="option_{{$i}}_vals_name[]"
                                           value="{{$val->name}}">
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
                                    <input class="form-control" type="text" name="option_{{$i}}_vals_name[]">
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
                                    <input class="form-control" type="text" name="option_{{$j}}_vals_name[]">
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>
                <div class="form-group" data-for_type_ids="3,4,5">
                    <label for="">Функция генерации</label>
                    <div class="special-vals-list">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>