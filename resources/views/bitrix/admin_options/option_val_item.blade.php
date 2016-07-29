<div class="row">
    <div class="col-md-4">
        <input class="form-control" type="text" name="option_{{$i}}_vals_key[]"
               value="{{$val ? $val->key: ''}}" pattern="[a-z0-9]*">
    </div>
    <div class="col-md-1">=&gt;</div>
    <div class="col-md-5">
        <input class="form-control" type="text" name="option_{{$i}}_vals_value[]"
               value="{{$val ? $val->value: ''}}">
    </div>
    <div class="col-md-2">
        <div class="checkbox">
            <label>
                <input type="radio" name="option_{{$i}}_vals_default" value="{{$j}}" {{$val && $val->is_default ? 'checked="checked"' : ''}}>
                <small>{{ trans('bitrix_admin_options.option_option_default') }}</small>
            </label>
        </div>
    </div>
</div>