<table class="table">
    <tr>
        <td>Основные настройки</td>
    </tr>
    <tr>
        <td>
            <label for="IS_CATALOG_Y">Является торговым каталогом</label>
        </td>
        <td>
            <input type="checkbox" name="IS_CATALOG" id="IS_CATALOG_Y" value="Y"
                    >
            <label for="IS_CATALOG_Y" title=""></label>
        </td>
    </tr>
    <tr>
        <td>
            <label for="IS_CONTENT_Y">Продажа контента</label>
        </td>
        <td>
            <input type="checkbox" id="IS_CONTENT_Y" name="SUBSCRIPTION" value="Y"
                    >
            <label for="IS_CONTENT_Y" title=""></label>
        </td>
    </tr>
    <tr>
        <td>
            <label for="YANDEX_EXPORT_Y">Экспортировать в Яндекс.Товары</label>
        </td>
        <td>
            <input type="checkbox" id="YANDEX_EXPORT_Y" name="YANDEX_EXPORT" value="Y" disabled="disabled"
                    >
            <label for="YANDEX_EXPORT_Y" title=""></label>
        </td>
    </tr>
    <tr>
        <td>
            <label for="VAT_ID">НДС</label>
        </td>
        <td>
            <select class="form-control" disabled="disabled" name="VAT_ID" id="VAT_ID">
                <option value="">--- не выбрано ---</option>
                <option value="1">Без НДС</option>
                <option value="2">НДС 18%</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Торговые предложения</td>
    </tr>
    <tr>
        <td>
            <label for="USED_SKU_Y">Инфоблок имеет торговые предложения</label>
        </td>
        <td>
            <input type="checkbox" id="USED_SKU_Y" name="USED_SKU" value="Y"
                    >
            <label for="USED_SKU_Y" title=""></label>
        </td>
    </tr>
    <tr>
        <td>
            <div  id="SKU-SETTINGS">
                <table >
                    <tr>
                        <td>Инфоблок торговых предложений</td>
                        <td>
                            <select class="form-control" id="OF_IBLOCK_ID" name="OF_IBLOCK_ID">
                                <option value="0" selected="">не выбрано</option>
                                <option value="-1">новый инфоблок</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div id="offers_add_info" >
                    <table >
                        <tr>
                            <td>Название:</td>
                            <td>
                                <input type="text" class="form-control" name="OF_IBLOCK_NAME" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" value="N" id="OF_CREATE_IBLOCK_TYPE_ID_N"
                                       name="OF_CREATE_IBLOCK_TYPE_ID" checked="checked"
                                        >
                                <label for="CREATE_OFFERS_TYPE_N">Использовать существующий тип инфоблока</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Тип:</td>
                            <td>
                                <select class="form-control" name="OF_IBLOCK_TYPE_ID" id="OF_IBLOCK_TYPE_ID">
                                    <option value="catalog">[catalog] Каталоги</option>
                                    <option value="news">[news] Новости</option>
                                    <option value="offers">[offers] Торговые предложения</option>
                                    <option value="services">[services] Сервисы</option>
                                    <option value="references">[references] Справочники</option>
                                    <option value="av_promo">[av_promo] Для самого промо</option>
                                    <option value="vregions">[vregions] Регионы продаж</option>
                                    <option value="vtenders">[vtenders] Тендерная площадка</option>
                                    <option value="bitrix_processes">[bitrix_processes] Processes</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" value="Y" id="OF_CREATE_IBLOCK_TYPE_ID_Y"
                                       name="OF_CREATE_IBLOCK_TYPE_ID">
                                <label for="CREATE_OFFERS_TYPE_Y">Создать новый тип инфоблока</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Идентификатор (ID):</td>
                            <td>
                                <input type="text" class="form-control" name="OF_NEW_IBLOCK_TYPE_ID" id="OF_NEW_IBLOCK_TYPE_ID" value=""
                                        disabled="disabled">
                            </td>
                        </tr>
                    </table>
                    <div><b>Свойства инфоблока торговых предложений</b></div>
                    <table  id="of_prop_list">
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
                                <input type="text" class="form-control" size="25" maxlength="255" name="OF_PROPERTY_n0_NAME"
                                       id="OF_PROPERTY_n0_NAME" value="">
                            </td>
                            <td>
                                <select class="form-control" name="OF_PROPERTY_n0_PROPERTY_TYPE" id="OF_PROPERTY_n0_PROPERTY_TYPE"
                                        >
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
                                <input type="checkbox" name="OF_PROPERTY_n0_ACTIVE" id="OF_PROPERTY_n0_ACTIVE_Y"
                                       value="Y" checked="">
                                <label for="OF_PROPERTY_n0_ACTIVE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n0_MULTIPLE" id="OF_PROPERTY_n0_MULTIPLE_Y"
                                       value="Y">
                                <label for="OF_PROPERTY_n0_MULTIPLE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n0_IS_REQUIRED"
                                       id="OF_PROPERTY_n0_IS_REQUIRED_Y" value="Y">
                                <label for="OF_PROPERTY_n0_IS_REQUIRED_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="text" class="form-control" size="3" maxlength="10" name="OF_PROPERTY_n0_SORT"
                                       id="OF_PROPERTY_n0_SORT" value="500">
                            </td>
                            <td>
                                <input type="text" class="form-control" size="20" maxlength="50" name="OF_PROPERTY_n0_CODE"
                                       id="OF_PROPERTY_n0_CODE" value="">
                            </td>
                            <td>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" size="25" maxlength="255" name="OF_PROPERTY_n1_NAME"
                                       id="OF_PROPERTY_n1_NAME" value="">
                            </td>
                            <td>
                                <select class="form-control" name="OF_PROPERTY_n1_PROPERTY_TYPE" id="OF_PROPERTY_n1_PROPERTY_TYPE"
                                        >
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
                                <input type="checkbox" name="OF_PROPERTY_n1_ACTIVE" id="OF_PROPERTY_n1_ACTIVE_Y"
                                       value="Y" checked="">
                                <label for="OF_PROPERTY_n1_ACTIVE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n1_MULTIPLE" id="OF_PROPERTY_n1_MULTIPLE_Y"
                                       value="Y">
                                <label for="OF_PROPERTY_n1_MULTIPLE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n1_IS_REQUIRED"
                                       id="OF_PROPERTY_n1_IS_REQUIRED_Y" value="Y">
                                <label for="OF_PROPERTY_n1_IS_REQUIRED_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="text" class="form-control" size="3" maxlength="10" name="OF_PROPERTY_n1_SORT"
                                       id="OF_PROPERTY_n1_SORT" value="500">
                            </td>
                            <td>
                                <input type="text" class="form-control" size="20" maxlength="50" name="OF_PROPERTY_n1_CODE"
                                       id="OF_PROPERTY_n1_CODE" value="">
                            </td>
                            <td>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" size="25" maxlength="255" name="OF_PROPERTY_n2_NAME"
                                       id="OF_PROPERTY_n2_NAME" value="">
                            </td>
                            <td>
                                <select class="form-control" name="OF_PROPERTY_n2_PROPERTY_TYPE" id="OF_PROPERTY_n2_PROPERTY_TYPE"
                                        >
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
                                <input type="checkbox" name="OF_PROPERTY_n2_ACTIVE" id="OF_PROPERTY_n2_ACTIVE_Y"
                                       value="Y" checked="">
                                <label for="OF_PROPERTY_n2_ACTIVE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n2_MULTIPLE" id="OF_PROPERTY_n2_MULTIPLE_Y"
                                       value="Y">
                                <label for="OF_PROPERTY_n2_MULTIPLE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n2_IS_REQUIRED"
                                       id="OF_PROPERTY_n2_IS_REQUIRED_Y" value="Y">
                                <label for="OF_PROPERTY_n2_IS_REQUIRED_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="text" class="form-control" size="3" maxlength="10" name="OF_PROPERTY_n2_SORT"
                                       id="OF_PROPERTY_n2_SORT" value="500">
                            </td>
                            <td>
                                <input type="text" class="form-control" size="20" maxlength="50" name="OF_PROPERTY_n2_CODE"
                                       id="OF_PROPERTY_n2_CODE" value="">
                            </td>
                            <td>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" size="25" maxlength="255" name="OF_PROPERTY_n3_NAME"
                                       id="OF_PROPERTY_n3_NAME" value="">
                            </td>
                            <td>
                                <select class="form-control" name="OF_PROPERTY_n3_PROPERTY_TYPE" id="OF_PROPERTY_n3_PROPERTY_TYPE"
                                        >
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
                                <input type="checkbox" name="OF_PROPERTY_n3_ACTIVE" id="OF_PROPERTY_n3_ACTIVE_Y"
                                       value="Y" checked="">
                                <label for="OF_PROPERTY_n3_ACTIVE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n3_MULTIPLE" id="OF_PROPERTY_n3_MULTIPLE_Y"
                                       value="Y">
                                <label for="OF_PROPERTY_n3_MULTIPLE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n3_IS_REQUIRED"
                                       id="OF_PROPERTY_n3_IS_REQUIRED_Y" value="Y">
                                <label for="OF_PROPERTY_n3_IS_REQUIRED_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="text" class="form-control" size="3" maxlength="10" name="OF_PROPERTY_n3_SORT"
                                       id="OF_PROPERTY_n3_SORT" value="500">
                            </td>
                            <td>
                                <input type="text" class="form-control" size="20" maxlength="50" name="OF_PROPERTY_n3_CODE"
                                       id="OF_PROPERTY_n3_CODE" value="">
                            </td>
                            <td>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" size="25" maxlength="255" name="OF_PROPERTY_n4_NAME"
                                       id="OF_PROPERTY_n4_NAME" value="">
                            </td>
                            <td>
                                <select class="form-control" name="OF_PROPERTY_n4_PROPERTY_TYPE" id="OF_PROPERTY_n4_PROPERTY_TYPE"
                                        >
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
                                <input type="checkbox" name="OF_PROPERTY_n4_ACTIVE" id="OF_PROPERTY_n4_ACTIVE_Y"
                                       value="Y" checked="">
                                <label for="OF_PROPERTY_n4_ACTIVE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n4_MULTIPLE" id="OF_PROPERTY_n4_MULTIPLE_Y"
                                       value="Y">
                                <label for="OF_PROPERTY_n4_MULTIPLE_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="checkbox" name="OF_PROPERTY_n4_IS_REQUIRED"
                                       id="OF_PROPERTY_n4_IS_REQUIRED_Y" value="Y">
                                <label for="OF_PROPERTY_n4_IS_REQUIRED_Y"
                                       title=""></label>
                            </td>
                            <td>
                                <input type="text" class="form-control" size="3" maxlength="10" name="OF_PROPERTY_n4_SORT"
                                       id="OF_PROPERTY_n4_SORT" value="500">
                            </td>
                            <td>
                                <input type="text" class="form-control" size="20" maxlength="50" name="OF_PROPERTY_n4_CODE"
                                       id="OF_PROPERTY_n4_CODE" value="">
                            </td>
                            <td>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                    <div >
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <script type="text/javascript">
        var is_cat = BX('IS_CATALOG_Y'),
                is_cont = BX('IS_CONTENT_Y'),
                is_yand = BX('YANDEX_EXPORT_Y'),
                vat_id = BX('VAT_ID'),
                cat_type = BX('CATALOG_TYPE'),
                use_sku = BX('USED_SKU_Y'),
                ob_sku_settings = BX('SKU-SETTINGS'),
                ob_offers_add = BX('offers_add_info'),
                ob_of_iblock_type_id = BX('OF_IBLOCK_TYPE_ID'),
                ob_of_new_iblock_type_id = BX('OF_NEW_IBLOCK_TYPE_ID');

        //var ob_sku_rights = BX('offers_rights');

        function ib_checkFldActivity(flag, catalog){
            catalog = (catalog == 'Y' ? 'Y' : 'N');
            if (0 == flag){
                if (undefined != cat_type){
                    if ('O' == cat_type.value)
                        is_cat.checked = true;
                }
                if (catalog == 'Y' && !is_cat.checked){
                    is_cat.checked = !confirm(BX.message('IB_E_CAT_CONFIRM'));
                }
                if (!is_cat.checked){
                    if (!!is_cont)
                        is_cont.checked = false;
                    is_yand.checked = false;
                }
            }
            if (1 == flag){
                if (!!is_cont && is_cont.checked)
                    is_cat.checked = true;
            }

            var bActive      = is_cat.checked;
            is_yand.disabled = !bActive;
            vat_id.disabled  = !bActive;
        }
        function ib_skumaster(obj){
            if (undefined != ob_sku_settings){
                var bActive                   = obj.checked;
                ob_sku_settings.style.display = (true == bActive ? 'block' : 'none');
            }
        }

        function show_add_offers(obj){
            var value = obj.options[obj.selectedIndex].value;
            if (undefined !== ob_offers_add){
                if (-1 == value){
                    ob_offers_add.style.display = 'block';
                }
                else{
                    ob_offers_add.style.display = 'none';
                }
            }
            /*		if (undefined !== ob_sku_rights)
             {
             ob_sku_rights.style.display = (0 < ParseInt(value) ? 'block' : 'none');
             } */
        }
        function change_offers_ibtype(obj){
            var value = obj.value;
            if ('Y' == value){
                ob_of_iblock_type_id.disabled     = true;
                ob_of_new_iblock_type_id.disabled = false;
            }
            else if ('N' == value){
                ob_of_iblock_type_id.disabled     = false;
                ob_of_new_iblock_type_id.disabled = true;
            }
        }
    </script>
</table>