<tr>
    <td>
        <input type="text"
               class="form-control"
               size="25"
               maxlength="255"
               name="properties[NAME][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_NAME"
               value="{{$property?$property->name:''}}">
    </td>
    <td>
        <select class="form-control"
                name="properties[TYPE][{{$i}}]"
                id="IB_PROPERTY_n{{$i}}_PROPERTY_TYPE">
            @foreach($properties_types as $properties_type_group)
                <optgroup label="{{$properties_type_group['label']}}">
                    @foreach($properties_type_group['props'] as $properties_type)
                        <option value="{{$properties_type['code']}}" {{$property && $property->type == $properties_type['code'] ? 'selected' : ''}}>{{$properties_type['name']}}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </td>
    <td>
        <input type="checkbox"
               name="properties[MULTIPLE][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_MULTIPLE_Y"
               value="Y"
                {{$property&&$property->multiple==true?'checked':''}} >
        <label for="IB_PROPERTY_n{{$i}}_MULTIPLE_Y"
               title=""></label>
    </td>
    <td>
        <input type="checkbox"
               name="properties[IS_REQUIRED][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_IS_REQUIRED_Y"
               value="Y"
                {{$property&&$property->is_required==true?'checked':''}} >
        <label for="IB_PROPERTY_n{{$i}}_IS_REQUIRED_Y"
               title=""></label>
    </td>
    <td>
        <input type="text"
               class="form-control"
               size="3"
               maxlength="10"
               name="properties[SORT][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_SORT"
               value="{{$property?$property->sort:'500'}}">
    </td>
    <td>
        <input type="text"
               class="form-control"
               data-translit_from="IB_PROPERTY_n{{$i}}_NAME"
               data-transform="uppercase"
               name="properties[CODE][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_CODE"
               value="{{$property?$property->code:''}}">
    </td>
    <td>
        <a href="#"
           class="btn btn-default"
           data-toggle="modal"
           data-target="#infoblok_prop_dop_settings_window_{{$i}}">...
        </a>
    </td>
    <td>
        @if($property)
            <a href="{{ action('Modules\Bitrix\BitrixDataStorageController@delete_prop', [$module->id, $property]) }}"
               class="btn btn-danger">
                <span class="glyphicon glyphicon-trash"
                      aria-hidden="true"></span>
            </a>
        @endif
    </td>
</tr>@include('bitrix.data_storage.iblock_tabs.properties_item_dop_settings_window', ['property' => $property, 'i' => $i])
