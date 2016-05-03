<table class="table">
    <tr>
        <th>Название</th>
        <th>Тип</th>
        <th>Акт.</th>
        <th>Множ.</th>
        <th>Обяз.</th>
        <th>Сорт.</th>
        <th>Код</th>
        <th>Изм.</th>
        <th>Удал.</th>
    </tr>
    <tr>
        <th>
            <input type="text" class="form-control" size="25" maxlength="255" name="IB_PROPERTY_n0_NAME"
                   id="IB_PROPERTY_n0_NAME" value="">
        </td>
        <td>
            <select class="form-control" name="IB_PROPERTY_n0_PROPERTY_TYPE" id="IB_PROPERTY_n0_PROPERTY_TYPE">
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
            <input type="checkbox" name="IB_PROPERTY_n0_ACTIVE" id="IB_PROPERTY_n0_ACTIVE_Y" value="Y" checked=""
                    >
            <label for="IB_PROPERTY_n0_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n0_MULTIPLE" id="IB_PROPERTY_n0_MULTIPLE_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n0_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n0_IS_REQUIRED" id="IB_PROPERTY_n0_IS_REQUIRED_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n0_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" class="form-control" size="3" maxlength="10" name="IB_PROPERTY_n0_SORT"
                   id="IB_PROPERTY_n0_SORT" value="500">
        </td>
        <td>
            <input type="text" class="form-control" size="20" maxlength="50" name="IB_PROPERTY_n0_CODE"
                   id="IB_PROPERTY_n0_CODE" value="">
        </td>
        <td>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>
            <input type="text" class="form-control" size="25" maxlength="255" name="IB_PROPERTY_n1_NAME"
                   id="IB_PROPERTY_n1_NAME" value="">
        </td>
        <td>
            <select class="form-control" name="IB_PROPERTY_n1_PROPERTY_TYPE" id="IB_PROPERTY_n1_PROPERTY_TYPE">
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
            <input type="checkbox" name="IB_PROPERTY_n1_ACTIVE" id="IB_PROPERTY_n1_ACTIVE_Y" value="Y" checked=""
                    >
            <label for="IB_PROPERTY_n1_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n1_MULTIPLE" id="IB_PROPERTY_n1_MULTIPLE_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n1_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n1_IS_REQUIRED" id="IB_PROPERTY_n1_IS_REQUIRED_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n1_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" class="form-control" size="3" maxlength="10" name="IB_PROPERTY_n1_SORT"
                   id="IB_PROPERTY_n1_SORT" value="500">
        </td>
        <td>
            <input type="text" class="form-control" size="20" maxlength="50" name="IB_PROPERTY_n1_CODE"
                   id="IB_PROPERTY_n1_CODE" value="">
        </td>
        <td>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>
            <input type="text" class="form-control" size="25" maxlength="255" name="IB_PROPERTY_n2_NAME"
                   id="IB_PROPERTY_n2_NAME" value="">
        </td>
        <td>
            <select class="form-control" name="IB_PROPERTY_n2_PROPERTY_TYPE" id="IB_PROPERTY_n2_PROPERTY_TYPE">
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
            <input type="checkbox" name="IB_PROPERTY_n2_ACTIVE" id="IB_PROPERTY_n2_ACTIVE_Y" value="Y" checked=""
                    >
            <label for="IB_PROPERTY_n2_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n2_MULTIPLE" id="IB_PROPERTY_n2_MULTIPLE_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n2_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n2_IS_REQUIRED" id="IB_PROPERTY_n2_IS_REQUIRED_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n2_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" class="form-control" size="3" maxlength="10" name="IB_PROPERTY_n2_SORT"
                   id="IB_PROPERTY_n2_SORT" value="500">
        </td>
        <td>
            <input type="text" class="form-control" size="20" maxlength="50" name="IB_PROPERTY_n2_CODE"
                   id="IB_PROPERTY_n2_CODE" value="">
        </td>
        <td>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>
            <input type="text" class="form-control" size="25" maxlength="255" name="IB_PROPERTY_n3_NAME"
                   id="IB_PROPERTY_n3_NAME" value="">
        </td>
        <td>
            <select class="form-control" name="IB_PROPERTY_n3_PROPERTY_TYPE" id="IB_PROPERTY_n3_PROPERTY_TYPE">
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
            <input type="checkbox" name="IB_PROPERTY_n3_ACTIVE" id="IB_PROPERTY_n3_ACTIVE_Y" value="Y" checked=""
                    >
            <label for="IB_PROPERTY_n3_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n3_MULTIPLE" id="IB_PROPERTY_n3_MULTIPLE_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n3_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n3_IS_REQUIRED" id="IB_PROPERTY_n3_IS_REQUIRED_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n3_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" class="form-control" size="3" maxlength="10" name="IB_PROPERTY_n3_SORT"
                   id="IB_PROPERTY_n3_SORT" value="500">
        </td>
        <td>
            <input type="text" class="form-control" size="20" maxlength="50" name="IB_PROPERTY_n3_CODE"
                   id="IB_PROPERTY_n3_CODE" value="">
        </td>
        <td>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th>
            <input type="text" class="form-control" size="25" maxlength="255" name="IB_PROPERTY_n4_NAME"
                   id="IB_PROPERTY_n4_NAME" value="">
        </td>
        <td>
            <select class="form-control" name="IB_PROPERTY_n4_PROPERTY_TYPE" id="IB_PROPERTY_n4_PROPERTY_TYPE">
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
            <input type="checkbox" name="IB_PROPERTY_n4_ACTIVE" id="IB_PROPERTY_n4_ACTIVE_Y" value="Y" checked=""
                    >
            <label for="IB_PROPERTY_n4_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n4_MULTIPLE" id="IB_PROPERTY_n4_MULTIPLE_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n4_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="checkbox" name="IB_PROPERTY_n4_IS_REQUIRED" id="IB_PROPERTY_n4_IS_REQUIRED_Y" value="Y"
                    >
            <label for="IB_PROPERTY_n4_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" class="form-control" size="3" maxlength="10" name="IB_PROPERTY_n4_SORT"
                   id="IB_PROPERTY_n4_SORT" value="500">
        </td>
        <td>
            <input type="text" class="form-control" size="20" maxlength="50" name="IB_PROPERTY_n4_CODE"
                   id="IB_PROPERTY_n4_CODE" value="">
        </td>
        <td>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>