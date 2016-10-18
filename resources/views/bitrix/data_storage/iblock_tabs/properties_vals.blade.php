<div class="clearfix">
    <div class="col-md-4">
        <input class="form-control"
               type="text"
               name="properties[VALUES][{{$i}}][XML_ID][]"
               value="{{$val ? $val->xml_id: ''}}"
               disabled>
    </div>
    <div class="col-md-4">
        <input class="form-control"
               type="text"
               name="properties[VALUES][{{$i}}][VALUE][]"
               value="{{$val ? $val->value: ''}}">
    </div>
    <div class="col-md-2">
        <input class="form-control"
               type="text"
               name="properties[VALUES][{{$i}}][SORT][]"
               value="{{$val && $val->sort ? $val->sort: '500'}}">
    </div>
    <div class="col-md-2">
        <div class="checkbox">
            <label>
                <input type="radio"
                       name="properties[VALUES][{{$i}}][DEFAULT]"
                       value="{{$j}}" {{$val && $val->default ? 'checked="checked"' : ''}}>
                <small>{{ trans('bitrix_admin_options.option_option_default') }}</small>
            </label>
        </div>
    </div>
</div>