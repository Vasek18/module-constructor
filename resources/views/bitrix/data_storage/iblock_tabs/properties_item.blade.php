<tr>
    <td>
        <input type="text" class="form-control" size="25" maxlength="255" name="properties[NAME][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_NAME" value="{{$property?$property->name:''}}">
    </td>
    <td>
        <select class="form-control" name="properties[TYPE][{{$i}}]" id="IB_PROPERTY_n{{$i}}_PROPERTY_TYPE">
            <optgroup label="Базовые типы">
                <option value="S" selected="">Строка</option>
                <option value="N">Число</option>
                <option value="L">Список</option>
                <option value="F">Файл</option>
                <option value="G">Привязка к разделам</option>
                <option value="E">Привязка к элементам</option>
            </optgroup>
            <optgroup label="Пользовательские типы">
                <option value="S:HTML">HTML/текст</option>
                <option value="S:video">Видео</option>
                <option value="S:Date">Дата</option>
                <option value="S:DateTime">Дата/Время</option>
                <option value="S:map_yandex">Привязка к Яндекс.Карте</option>
                <option value="S:map_google">Привязка к карте Google Maps</option>
                <option value="S:UserID">Привязка к пользователю</option>
                <option value="G:SectionAuto">Привязка к разделам с автозаполнением</option>
                <option value="S:TopicID">Привязка к теме форума</option>
                <option value="E:SKU">Привязка к товарам (SKU)</option>
                <option value="S:FileMan">Привязка к файлу (на сервере)</option>
                <option value="E:EList">Привязка к элементам в виде списка</option>
                <option value="S:ElementXmlID">Привязка к элементам по XML_ID</option>
                <option value="E:EAutocomplete">Привязка к элементам с автозаполнением</option>
                <option value="S:directory">Справочник</option>
                <option value="N:Sequence">Счетчик</option>
            </optgroup>
        </select>
    </td>
    <td>
        <input type="checkbox" name="properties[MULTIPLE][{{$i}}]" id="IB_PROPERTY_n{{$i}}_MULTIPLE_Y" value="Y"
                {{$property&&$property->multiple==true?'checked':''}} >
        <label for="IB_PROPERTY_n{{$i}}_MULTIPLE_Y" title=""></label>
    </td>
    <td>
        <input type="checkbox" name="properties[IS_REQUIRED][{{$i}}]" id="IB_PROPERTY_n{{$i}}_IS_REQUIRED_Y" value="Y"
                {{$property&&$property->is_required==true?'checked':''}} >
        <label for="IB_PROPERTY_n{{$i}}_IS_REQUIRED_Y" title=""></label>
    </td>
    <td>
        <input type="text" class="form-control" size="3" maxlength="10" name="properties[SORT][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_SORT" value="{{$property?$property->sort:'500'}}">
    </td>
    <td>
        <input type="text" class="form-control" size="20" maxlength="50" name="properties[CODE][{{$i}}]"
               id="IB_PROPERTY_n{{$i}}_CODE" value="{{$property?$property->code:''}}">
    </td>
    <td>
    </td>
    <td>&nbsp;</td>
</tr>