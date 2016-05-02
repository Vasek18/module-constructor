<table>
    <tbody>
    <tr>
        <td>Поле раздела</td>
        <td>Обяз.</td>
        <td>Значение по умолчанию</td>
    </tr>
    <tr>
        <td>Название</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_NAME][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_NAME][IS_REQUIRED]" checked="" disabled=""
                   id="designed_checkbox_0.6718456406111109" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.6718456406111109" title=""></label>
        </td>
        <td>
            <input name="FIELDS[SECTION_NAME][DEFAULT_VALUE]" type="text" value="" size="60">
        </td>
    </tr>
    <tr>
        <td>Картинка для анонса</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_PICTURE][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_PICTURE][IS_REQUIRED]"
                   id="designed_checkbox_0.748316363610642" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.748316363610642" title=""></label>
        </td>
        <td>
            <div class="adm-list">
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">Создавать картинку анонса из
                            детальной (если не задана).
                        </label>
                    </div>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">Удалять картинку анонса,
                            если удаляется детальная.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">Создавать картинку
                            анонса из детальной даже если задана.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]" onclick="
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WIDTH]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][HEIGHT]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][METHOD_DIV]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][COMPRESSION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]"
                               title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.</label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WIDTH]"
                     style="padding-left:16px;display:none">
                    Максимальная ширина:&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value="" size="7">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][HEIGHT]"
                     style="padding-left:16px;display:none">
                    Максимальная высота:&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value="" size="7">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]"
                     style="padding-left:16px;display:none">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать ошибки
                            масштабирования.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][METHOD_DIV]"
                     style="padding-left:16px;display:none">
                    <div class="adm-list-control">
                        <input type="checkbox" value="resample" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]"
                               title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                            масштабировании (требует больше ресурсов на сервере)
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][COMPRESSION]"
                     style="padding-left:16px;display:none">
                    Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                           style="width: 30px">
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" onclick="
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить авторский знак
                            в виде изображения.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                     style="padding-left:16px;display:none">

                    Путь к изображению с авторским знаком:&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                           id="FIELDS_SECTION_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value="" size="35">
                    &nbsp;
                    <input type="button" value="..." onclick="BtnClickSECTION_PICTURE()">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"
                     style="padding-left:16px;display:none">
                    Прозрачность авторского знака (%):&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text" value=""
                           size="3">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                     style="padding-left:16px;display:none">
                    Размещение авторского знака:&nbsp;
                    <select class="typeselect" name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                            id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]">
                        <option value="tl">Сверху слева</option>
                        <option value="tc">Сверху по центру</option>
                        <option value="tr">Сверху справа</option>
                        <option value="ml">Слева</option>
                        <option value="mc">По центру</option>
                        <option value="mr">Справа</option>
                        <option value="bl">Снизу слева</option>
                        <option value="bc">Снизу по центру</option>
                        <option value="br">Снизу справа</option>
                    </select>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                               name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" onclick="
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]').style.display =
								BX('SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить авторский знак
                            в виде текста.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                     style="padding-left:16px;display:none">
                    Содержание надписи:&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text" value="" size="35">

                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                     style="padding-left:16px;display:none">
                    Путь к файлу шрифта:&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                           id="FIELDS_SECTION_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text" value=""
                           size="35">
                    &nbsp;
                    <input type="button" value="..." onclick="BtnClickFontSECTION_PICTURE()">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                     style="padding-left:16px;display:none">
                    Цвет надписи (без #, например, FF00EE):&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text" value=""
                           size="7">
                    &nbsp;
                    <input type="button" value="..."
                           onclick="BX.findChildren(this.parentNode, {'tag': 'IMG'}, true)[0].onclick();"><span
                            style="float:left;width:1px;height:1px;visibility:hidden;position:absolute;">
<span id="bx_colorpicker_TfqxLXgJd1"><div class="bx-colpic-button-cont">
        <img src="/bitrix/images/1.gif" title="TfqxLXgJd1" class="bx-colpic-button bx-colpic-button-normal"
             id="bx_btn_tfqxlxgjd1">
    </div></span>
<style>#bx_btn_TfqxLXgJd1{
        background-position : -280px -21px;
    }</style>

</span>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"
                     style="padding-left:16px;display:none">
                    Размер (% от размера картинки):&nbsp;
                    <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text" value=""
                           size="3">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                     style="padding-left:16px;display:none">
                    Размещение авторского знака:&nbsp;
                    <select class="typeselect" name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                            id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]">
                        <option value="tl">Сверху слева</option>
                        <option value="tc">Сверху по центру</option>
                        <option value="tr">Сверху справа</option>
                        <option value="ml">Слева</option>
                        <option value="mc">По центру</option>
                        <option value="mr">Справа</option>
                        <option value="bl">Снизу слева</option>
                        <option value="bc">Снизу по центру</option>
                        <option value="br">Снизу справа</option>
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>Тип описания</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_DESCRIPTION_TYPE][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_DESCRIPTION_TYPE][IS_REQUIRED]" checked="" disabled=""
                   id="designed_checkbox_0.8363249068064615" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.8363249068064615" title=""></label>
        </td>
        <td>
            <div class="adm-list">
                <div class="adm-list-item">
                    <select name="FIELDS[SECTION_DESCRIPTION_TYPE][DEFAULT_VALUE]" height="1">
                        <option value="text">text</option>
                        <option value="html">html</option>
                    </select>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="hidden" value="N"
                               name="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">
                        <input type="checkbox" value="Y"
                               id="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                               name="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked=""
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                            переключаться между text и html.
                        </label>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>Описание</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_DESCRIPTION][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_DESCRIPTION][IS_REQUIRED]"
                   id="designed_checkbox_0.7500535682424345" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.7500535682424345" title=""></label>
        </td>
        <td>
            <textarea name="FIELDS[SECTION_DESCRIPTION][DEFAULT_VALUE]" rows="5" cols="47"></textarea>
        </td>
    </tr>
    <tr>
        <td>Детальная картинка</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_DETAIL_PICTURE][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_DETAIL_PICTURE][IS_REQUIRED]"
                   id="designed_checkbox_0.09113542663517515" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.09113542663517515" title=""></label>
        </td>
        <td>
            <div class="adm-list">
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                               name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]" onclick="
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD_DIV]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]"
                     style="padding-left:16px;display:none">
                    Максимальная ширина:&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value="" size="7">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]"
                     style="padding-left:16px;display:none">
                    Максимальная высота:&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value="" size="7">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]"
                     style="padding-left:16px;display:none">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y"
                               id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                               name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать ошибки
                            масштабирования.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD_DIV]"
                     style="padding-left:16px;display:none">
                    <div class="adm-list-control">
                        <input type="checkbox" value="resample"
                               id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                               name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                            масштабировании (требует больше ресурсов на сервере)
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]"
                     style="padding-left:16px;display:none">
                    Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                           style="width: 30px">
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y"
                               id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                               name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" onclick="
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                            авторский знак в виде изображения.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                     style="padding-left:16px;display:none">

                    Путь к изображению с авторским знаком:&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                           id="FIELDS_SECTION_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value=""
                           size="35">
                    &nbsp;
                    <input type="button" value="..." onclick="BtnClickSECTION_DETAIL_PICTURE()">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"
                     style="padding-left:16px;display:none">
                    Прозрачность авторского знака (%):&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                           value="" size="3">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                     style="padding-left:16px;display:none">
                    Размещение авторского знака:&nbsp;
                    <select class="typeselect"
                            name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                            id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]">
                        <option value="tl">Сверху слева</option>
                        <option value="tc">Сверху по центру</option>
                        <option value="tr">Сверху справа</option>
                        <option value="ml">Слева</option>
                        <option value="mc">По центру</option>
                        <option value="mr">Справа</option>
                        <option value="bl">Снизу слева</option>
                        <option value="bc">Снизу по центру</option>
                        <option value="br">Снизу справа</option>
                    </select>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y"
                               id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                               name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" onclick="
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]').style.display =
								BX('SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                            авторский знак в виде текста.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                     style="padding-left:16px;display:none">
                    Содержание надписи:&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text" value=""
                           size="35">

                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                     style="padding-left:16px;display:none">
                    Путь к файлу шрифта:&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                           id="FIELDS_SECTION_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text" value=""
                           size="35">
                    &nbsp;
                    <input type="button" value="..." onclick="BtnClickFontSECTION_DETAIL_PICTURE()">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                     style="padding-left:16px;display:none">
                    Цвет надписи (без #, например, FF00EE):&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text" value=""
                           size="7">
                    &nbsp;
                    <input type="button" value="..."
                           onclick="BX.findChildren(this.parentNode, {'tag': 'IMG'}, true)[0].onclick();"><span
                            style="float:left;width:1px;height:1px;visibility:hidden;position:absolute;">
<span id="bx_colorpicker_NdwuRgfY9A"><div class="bx-colpic-button-cont">
        <img src="/bitrix/images/1.gif" title="NdwuRgfY9A" class="bx-colpic-button bx-colpic-button-normal"
             id="bx_btn_ndwurgfy9a">
    </div></span>
<style>#bx_btn_NdwuRgfY9A{
        background-position : -280px -21px;
    }</style>

</span>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"
                     style="padding-left:16px;display:none">
                    Размер (% от размера картинки):&nbsp;
                    <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                           value="" size="3">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                     style="padding-left:16px;display:none">
                    Размещение авторского знака:&nbsp;
                    <select class="typeselect"
                            name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                            id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]">
                        <option value="tl">Сверху слева</option>
                        <option value="tc">Сверху по центру</option>
                        <option value="tr">Сверху справа</option>
                        <option value="ml">Слева</option>
                        <option value="mc">По центру</option>
                        <option value="mr">Справа</option>
                        <option value="bl">Снизу слева</option>
                        <option value="bc">Снизу по центру</option>
                        <option value="br">Снизу справа</option>
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>Внешний код</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_XML_ID][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_XML_ID][IS_REQUIRED]"
                   id="designed_checkbox_0.7988412621350995" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.7988412621350995" title=""></label>
        </td>
        <td>
            <input type="hidden" value="" name="FIELDS[SECTION_XML_ID][DEFAULT_VALUE]">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>Символьный код</td>
        <td>
            <input type="hidden" value="N" name="FIELDS[SECTION_CODE][IS_REQUIRED]">
            <input type="checkbox" value="Y" name="FIELDS[SECTION_CODE][IS_REQUIRED]"
                   id="designed_checkbox_0.2502620220108924" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="designed_checkbox_0.2502620220108924" title=""></label>
        </td>
        <td>
            <div class="adm-list">
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]"
                               name="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]"
                               title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]">Если код задан, то проверять на
                            уникальность.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]"
                               name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]" onclick="
								BX('SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_LEN]').style.display =
								BX('SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_CASE]').style.display =
								BX('SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_SPACE]').style.display =
								BX('SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_OTHER]').style.display =
								BX('SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]').style.display =
								BX('SETTINGS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]" title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]">Транслитерировать из названия
                            при добавлении раздела.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_LEN]"
                     style="padding-left:16px;display:none">
                    Максимальная длина результата транслитерации::&nbsp;
                    <input name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_LEN]" type="text" value="100" size="3">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_CASE]"
                     style="padding-left:16px;display:none">
                    Приведение к регистру:&nbsp;
                    <select name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_CASE]">
                        <option value="">сохранить</option>
                        <option value="L" selected="">
                            к нижнему
                        </option>
                        <option value="U">
                            к верхнему
                        </option>
                    </select>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_SPACE]"
                     style="padding-left:16px;display:none">
                    Замена для символа пробела:&nbsp;
                    <input name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_SPACE]" type="text" value="-" size="2">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_OTHER]"
                     style="padding-left:16px;display:none">
                    Замена для прочих символов:&nbsp;
                    <input name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_OTHER]" type="text" value="-" size="2">
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]"
                     style="padding-left:16px;display:none">
                    <div class="adm-list-control">
                        <input type="hidden" value="N" name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]"
                               name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]" checked=""
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]"
                               title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]">Удалять лишние символы замены.
                        </label>
                    </div>
                </div>
                <div class="adm-list-item" id="SETTINGS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]"
                     style="padding-left:16px;display:none">
                    <div class="adm-list-control">
                        <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]"
                               name="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]"
                               title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]">Использовать внешний сервис для
                            перевода.
                        </label>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>