<table>
    <tbody>
    <tr>
        <td>ID</td>
        <td>Название</td>
        <td>Тип</td>
        <td>Акт.</td>
        <td>Множ.</td>
        <td>Обяз.</td>
        <td>Сорт.</td>
        <td>Код</td>
        <td>Изм.</td>
        <td>Удал.</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="text" size="25" maxlength="255" name="IB_PROPERTY_n0_NAME" id="IB_PROPERTY_n0_NAME" value="">
            <input type="hidden" name="IB_PROPERTY_n0_PROPINFO" id="IB_PROPERTY_n0_PROPINFO"
                   value="YToyMDp7czo5OiJJQkxPQ0tfSUQiO2k6MDtzOjk6IkZJTEVfVFlQRSI7czowOiIiO3M6OToiTElTVF9UWVBFIjtzOjE6IkwiO3M6OToiUk9XX0NPVU5UIjtzOjE6IjEiO3M6OToiQ09MX0NPVU5UIjtzOjI6IjMwIjtzOjE0OiJMSU5LX0lCTE9DS19JRCI7czoxOiIwIjtzOjEzOiJERUZBVUxUX1ZBTFVFIjtzOjA6IiI7czoxODoiVVNFUl9UWVBFX1NFVFRJTkdTIjthOjA6e31zOjE2OiJXSVRIX0RFU0NSSVBUSU9OIjtzOjA6IiI7czoxMDoiU0VBUkNIQUJMRSI7czowOiIiO3M6OToiRklMVFJBQkxFIjtzOjA6IiI7czoxMjoiTVVMVElQTEVfQ05UIjtzOjE6IjUiO3M6NDoiSElOVCI7czowOiIiO3M6NjoiWE1MX0lEIjtzOjA6IiI7czo2OiJWQUxVRVMiO2E6MDp7fXM6MTY6IlNFQ1RJT05fUFJPUEVSVFkiO3M6MToiWSI7czoxMjoiU01BUlRfRklMVEVSIjtzOjE6Ik4iO3M6MTI6IkRJU1BMQVlfVFlQRSI7czowOiIiO3M6MTY6IkRJU1BMQVlfRVhQQU5ERUQiO3M6MToiTiI7czoxMToiRklMVEVSX0hJTlQiO3M6MDoiIjt9">
        </td>
        <td>
            <select name="IB_PROPERTY_n0_PROPERTY_TYPE" id="IB_PROPERTY_n0_PROPERTY_TYPE" style="width:150px">
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
            <input type="hidden" name="IB_PROPERTY_n0_ACTIVE" id="IB_PROPERTY_n0_ACTIVE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n0_ACTIVE" id="IB_PROPERTY_n0_ACTIVE_Y" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n0_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n0_MULTIPLE" id="IB_PROPERTY_n0_MULTIPLE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n0_MULTIPLE" id="IB_PROPERTY_n0_MULTIPLE_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n0_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n0_IS_REQUIRED" id="IB_PROPERTY_n0_IS_REQUIRED_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n0_IS_REQUIRED" id="IB_PROPERTY_n0_IS_REQUIRED_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n0_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" size="3" maxlength="10" name="IB_PROPERTY_n0_SORT" id="IB_PROPERTY_n0_SORT" value="500">
        </td>
        <td>
            <input type="text" size="20" maxlength="50" name="IB_PROPERTY_n0_CODE" id="IB_PROPERTY_n0_CODE" value="">
        </td>
        <td>
            <input type="button" title="Нажмите для детального редактирования" name="IB_PROPERTY_n0_BTN"
                   id="IB_PROPERTY_n0_BTN" value="..." data-propid="n0">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="text" size="25" maxlength="255" name="IB_PROPERTY_n1_NAME" id="IB_PROPERTY_n1_NAME" value="">
            <input type="hidden" name="IB_PROPERTY_n1_PROPINFO" id="IB_PROPERTY_n1_PROPINFO"
                   value="YToyMDp7czo5OiJJQkxPQ0tfSUQiO2k6MDtzOjk6IkZJTEVfVFlQRSI7czowOiIiO3M6OToiTElTVF9UWVBFIjtzOjE6IkwiO3M6OToiUk9XX0NPVU5UIjtzOjE6IjEiO3M6OToiQ09MX0NPVU5UIjtzOjI6IjMwIjtzOjE0OiJMSU5LX0lCTE9DS19JRCI7czoxOiIwIjtzOjEzOiJERUZBVUxUX1ZBTFVFIjtzOjA6IiI7czoxODoiVVNFUl9UWVBFX1NFVFRJTkdTIjthOjA6e31zOjE2OiJXSVRIX0RFU0NSSVBUSU9OIjtzOjA6IiI7czoxMDoiU0VBUkNIQUJMRSI7czowOiIiO3M6OToiRklMVFJBQkxFIjtzOjA6IiI7czoxMjoiTVVMVElQTEVfQ05UIjtzOjE6IjUiO3M6NDoiSElOVCI7czowOiIiO3M6NjoiWE1MX0lEIjtzOjA6IiI7czo2OiJWQUxVRVMiO2E6MDp7fXM6MTY6IlNFQ1RJT05fUFJPUEVSVFkiO3M6MToiWSI7czoxMjoiU01BUlRfRklMVEVSIjtzOjE6Ik4iO3M6MTI6IkRJU1BMQVlfVFlQRSI7czowOiIiO3M6MTY6IkRJU1BMQVlfRVhQQU5ERUQiO3M6MToiTiI7czoxMToiRklMVEVSX0hJTlQiO3M6MDoiIjt9">
        </td>
        <td>
            <select name="IB_PROPERTY_n1_PROPERTY_TYPE" id="IB_PROPERTY_n1_PROPERTY_TYPE" style="width:150px">
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
            <input type="hidden" name="IB_PROPERTY_n1_ACTIVE" id="IB_PROPERTY_n1_ACTIVE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n1_ACTIVE" id="IB_PROPERTY_n1_ACTIVE_Y" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n1_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n1_MULTIPLE" id="IB_PROPERTY_n1_MULTIPLE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n1_MULTIPLE" id="IB_PROPERTY_n1_MULTIPLE_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n1_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n1_IS_REQUIRED" id="IB_PROPERTY_n1_IS_REQUIRED_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n1_IS_REQUIRED" id="IB_PROPERTY_n1_IS_REQUIRED_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n1_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" size="3" maxlength="10" name="IB_PROPERTY_n1_SORT" id="IB_PROPERTY_n1_SORT" value="500">
        </td>
        <td>
            <input type="text" size="20" maxlength="50" name="IB_PROPERTY_n1_CODE" id="IB_PROPERTY_n1_CODE" value="">
        </td>
        <td>
            <input type="button" title="Нажмите для детального редактирования" name="IB_PROPERTY_n1_BTN"
                   id="IB_PROPERTY_n1_BTN" value="..." data-propid="n1">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="text" size="25" maxlength="255" name="IB_PROPERTY_n2_NAME" id="IB_PROPERTY_n2_NAME" value="">
            <input type="hidden" name="IB_PROPERTY_n2_PROPINFO" id="IB_PROPERTY_n2_PROPINFO"
                   value="YToyMDp7czo5OiJJQkxPQ0tfSUQiO2k6MDtzOjk6IkZJTEVfVFlQRSI7czowOiIiO3M6OToiTElTVF9UWVBFIjtzOjE6IkwiO3M6OToiUk9XX0NPVU5UIjtzOjE6IjEiO3M6OToiQ09MX0NPVU5UIjtzOjI6IjMwIjtzOjE0OiJMSU5LX0lCTE9DS19JRCI7czoxOiIwIjtzOjEzOiJERUZBVUxUX1ZBTFVFIjtzOjA6IiI7czoxODoiVVNFUl9UWVBFX1NFVFRJTkdTIjthOjA6e31zOjE2OiJXSVRIX0RFU0NSSVBUSU9OIjtzOjA6IiI7czoxMDoiU0VBUkNIQUJMRSI7czowOiIiO3M6OToiRklMVFJBQkxFIjtzOjA6IiI7czoxMjoiTVVMVElQTEVfQ05UIjtzOjE6IjUiO3M6NDoiSElOVCI7czowOiIiO3M6NjoiWE1MX0lEIjtzOjA6IiI7czo2OiJWQUxVRVMiO2E6MDp7fXM6MTY6IlNFQ1RJT05fUFJPUEVSVFkiO3M6MToiWSI7czoxMjoiU01BUlRfRklMVEVSIjtzOjE6Ik4iO3M6MTI6IkRJU1BMQVlfVFlQRSI7czowOiIiO3M6MTY6IkRJU1BMQVlfRVhQQU5ERUQiO3M6MToiTiI7czoxMToiRklMVEVSX0hJTlQiO3M6MDoiIjt9">
        </td>
        <td>
            <select name="IB_PROPERTY_n2_PROPERTY_TYPE" id="IB_PROPERTY_n2_PROPERTY_TYPE" style="width:150px">
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
            <input type="hidden" name="IB_PROPERTY_n2_ACTIVE" id="IB_PROPERTY_n2_ACTIVE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n2_ACTIVE" id="IB_PROPERTY_n2_ACTIVE_Y" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n2_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n2_MULTIPLE" id="IB_PROPERTY_n2_MULTIPLE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n2_MULTIPLE" id="IB_PROPERTY_n2_MULTIPLE_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n2_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n2_IS_REQUIRED" id="IB_PROPERTY_n2_IS_REQUIRED_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n2_IS_REQUIRED" id="IB_PROPERTY_n2_IS_REQUIRED_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n2_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" size="3" maxlength="10" name="IB_PROPERTY_n2_SORT" id="IB_PROPERTY_n2_SORT" value="500">
        </td>
        <td>
            <input type="text" size="20" maxlength="50" name="IB_PROPERTY_n2_CODE" id="IB_PROPERTY_n2_CODE" value="">
        </td>
        <td>
            <input type="button" title="Нажмите для детального редактирования" name="IB_PROPERTY_n2_BTN"
                   id="IB_PROPERTY_n2_BTN" value="..." data-propid="n2">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="text" size="25" maxlength="255" name="IB_PROPERTY_n3_NAME" id="IB_PROPERTY_n3_NAME" value="">
            <input type="hidden" name="IB_PROPERTY_n3_PROPINFO" id="IB_PROPERTY_n3_PROPINFO"
                   value="YToyMDp7czo5OiJJQkxPQ0tfSUQiO2k6MDtzOjk6IkZJTEVfVFlQRSI7czowOiIiO3M6OToiTElTVF9UWVBFIjtzOjE6IkwiO3M6OToiUk9XX0NPVU5UIjtzOjE6IjEiO3M6OToiQ09MX0NPVU5UIjtzOjI6IjMwIjtzOjE0OiJMSU5LX0lCTE9DS19JRCI7czoxOiIwIjtzOjEzOiJERUZBVUxUX1ZBTFVFIjtzOjA6IiI7czoxODoiVVNFUl9UWVBFX1NFVFRJTkdTIjthOjA6e31zOjE2OiJXSVRIX0RFU0NSSVBUSU9OIjtzOjA6IiI7czoxMDoiU0VBUkNIQUJMRSI7czowOiIiO3M6OToiRklMVFJBQkxFIjtzOjA6IiI7czoxMjoiTVVMVElQTEVfQ05UIjtzOjE6IjUiO3M6NDoiSElOVCI7czowOiIiO3M6NjoiWE1MX0lEIjtzOjA6IiI7czo2OiJWQUxVRVMiO2E6MDp7fXM6MTY6IlNFQ1RJT05fUFJPUEVSVFkiO3M6MToiWSI7czoxMjoiU01BUlRfRklMVEVSIjtzOjE6Ik4iO3M6MTI6IkRJU1BMQVlfVFlQRSI7czowOiIiO3M6MTY6IkRJU1BMQVlfRVhQQU5ERUQiO3M6MToiTiI7czoxMToiRklMVEVSX0hJTlQiO3M6MDoiIjt9">
        </td>
        <td>
            <select name="IB_PROPERTY_n3_PROPERTY_TYPE" id="IB_PROPERTY_n3_PROPERTY_TYPE" style="width:150px">
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
            <input type="hidden" name="IB_PROPERTY_n3_ACTIVE" id="IB_PROPERTY_n3_ACTIVE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n3_ACTIVE" id="IB_PROPERTY_n3_ACTIVE_Y" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n3_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n3_MULTIPLE" id="IB_PROPERTY_n3_MULTIPLE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n3_MULTIPLE" id="IB_PROPERTY_n3_MULTIPLE_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n3_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n3_IS_REQUIRED" id="IB_PROPERTY_n3_IS_REQUIRED_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n3_IS_REQUIRED" id="IB_PROPERTY_n3_IS_REQUIRED_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n3_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" size="3" maxlength="10" name="IB_PROPERTY_n3_SORT" id="IB_PROPERTY_n3_SORT" value="500">
        </td>
        <td>
            <input type="text" size="20" maxlength="50" name="IB_PROPERTY_n3_CODE" id="IB_PROPERTY_n3_CODE" value="">
        </td>
        <td>
            <input type="button" title="Нажмите для детального редактирования" name="IB_PROPERTY_n3_BTN"
                   id="IB_PROPERTY_n3_BTN" value="..." data-propid="n3">
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="text" size="25" maxlength="255" name="IB_PROPERTY_n4_NAME" id="IB_PROPERTY_n4_NAME" value="">
            <input type="hidden" name="IB_PROPERTY_n4_PROPINFO" id="IB_PROPERTY_n4_PROPINFO"
                   value="YToyMDp7czo5OiJJQkxPQ0tfSUQiO2k6MDtzOjk6IkZJTEVfVFlQRSI7czowOiIiO3M6OToiTElTVF9UWVBFIjtzOjE6IkwiO3M6OToiUk9XX0NPVU5UIjtzOjE6IjEiO3M6OToiQ09MX0NPVU5UIjtzOjI6IjMwIjtzOjE0OiJMSU5LX0lCTE9DS19JRCI7czoxOiIwIjtzOjEzOiJERUZBVUxUX1ZBTFVFIjtzOjA6IiI7czoxODoiVVNFUl9UWVBFX1NFVFRJTkdTIjthOjA6e31zOjE2OiJXSVRIX0RFU0NSSVBUSU9OIjtzOjA6IiI7czoxMDoiU0VBUkNIQUJMRSI7czowOiIiO3M6OToiRklMVFJBQkxFIjtzOjA6IiI7czoxMjoiTVVMVElQTEVfQ05UIjtzOjE6IjUiO3M6NDoiSElOVCI7czowOiIiO3M6NjoiWE1MX0lEIjtzOjA6IiI7czo2OiJWQUxVRVMiO2E6MDp7fXM6MTY6IlNFQ1RJT05fUFJPUEVSVFkiO3M6MToiWSI7czoxMjoiU01BUlRfRklMVEVSIjtzOjE6Ik4iO3M6MTI6IkRJU1BMQVlfVFlQRSI7czowOiIiO3M6MTY6IkRJU1BMQVlfRVhQQU5ERUQiO3M6MToiTiI7czoxMToiRklMVEVSX0hJTlQiO3M6MDoiIjt9">
        </td>
        <td>
            <select name="IB_PROPERTY_n4_PROPERTY_TYPE" id="IB_PROPERTY_n4_PROPERTY_TYPE" style="width:150px">
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
            <input type="hidden" name="IB_PROPERTY_n4_ACTIVE" id="IB_PROPERTY_n4_ACTIVE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n4_ACTIVE" id="IB_PROPERTY_n4_ACTIVE_Y" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n4_ACTIVE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n4_MULTIPLE" id="IB_PROPERTY_n4_MULTIPLE_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n4_MULTIPLE" id="IB_PROPERTY_n4_MULTIPLE_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n4_MULTIPLE_Y" title=""></label>
        </td>
        <td>
            <input type="hidden" name="IB_PROPERTY_n4_IS_REQUIRED" id="IB_PROPERTY_n4_IS_REQUIRED_N" value="N">
            <input type="checkbox" name="IB_PROPERTY_n4_IS_REQUIRED" id="IB_PROPERTY_n4_IS_REQUIRED_Y" value="Y"
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="IB_PROPERTY_n4_IS_REQUIRED_Y" title=""></label>
        </td>
        <td>
            <input type="text" size="3" maxlength="10" name="IB_PROPERTY_n4_SORT" id="IB_PROPERTY_n4_SORT" value="500">
        </td>
        <td>
            <input type="text" size="20" maxlength="50" name="IB_PROPERTY_n4_CODE" id="IB_PROPERTY_n4_CODE" value="">
        </td>
        <td>
            <input type="button" title="Нажмите для детального редактирования" name="IB_PROPERTY_n4_BTN"
                   id="IB_PROPERTY_n4_BTN" value="..." data-propid="n4">
        </td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>