<datalist id="params_variables_list">
    @foreach($params as $i => $param)
        <option value='$arCurrentValues["{{ $param->code }}"]'>{{ $param->name }}</option>
    @endforeach
    @if ($admin_options)
        @foreach($admin_options as $i => $option)
            <option value='{{ $option->bitrix_receive_code }}'>{{ $option->name }}</option>
        @endforeach
    @endif
</datalist>