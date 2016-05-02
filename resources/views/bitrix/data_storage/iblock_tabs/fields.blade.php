<table>
    <tbody>
    <tr>
        <td>
            <table border="0" cellspacing="0" cellpadding="0" class="internal" style="width:690px; margin: 0 auto;">
                <tbody>
                <tr>
                    <td>Поле элемента</td>
                    <td>Обяз.</td>
                    <td>Значение по умолчанию</td>
                </tr>
                <tr>
                    <td>Привязка к разделам</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[IBLOCK_SECTION][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[IBLOCK_SECTION][IS_REQUIRED]"
                               id="designed_checkbox_0.45557879228328524" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.45557879228328524"
                               title=""></label>
                    </td>
                    <td>
                        <input type="hidden" name="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"
                               value="N">
                        <input type="checkbox" name="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"
                               id="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]" value="Y"
                               class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label"
                               for="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]" title=""></label>
                        <label for="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]">
                            Разрешить выбор основного раздела для привязки.
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Активность</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[ACTIVE][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[ACTIVE][IS_REQUIRED]" checked="" disabled=""
                               id="designed_checkbox_0.7348353701186734" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.7348353701186734"
                               title=""></label>
                    </td>
                    <td>
                        <select name="FIELDS[ACTIVE][DEFAULT_VALUE]" height="1">
                            <option value="Y">да</option>
                            <option value="N">нет</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Начало активности</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[ACTIVE_FROM][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[ACTIVE_FROM][IS_REQUIRED]"
                               id="designed_checkbox_0.1582518372963051" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.1582518372963051"
                               title=""></label>
                    </td>
                    <td>
                        <select name="FIELDS[ACTIVE_FROM][DEFAULT_VALUE]" height="1">
                            <option value="">Не задано</option>
                            <option value="=now">Текущие дата и время</option>
                            <option value="=today">Текущая дата</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Окончание активности</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[ACTIVE_TO][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[ACTIVE_TO][IS_REQUIRED]"
                               id="designed_checkbox_0.38986472993139154" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.38986472993139154"
                               title=""></label>
                    </td>
                    <td>
                        <label for="FIELDS[ACTIVE_TO][DEFAULT_VALUE]">Продолжительность активности элемента (дней):
                        </label>
                        <input name="FIELDS[ACTIVE_TO][DEFAULT_VALUE]" type="text" value="" size="5">
                    </td>
                </tr>
                <tr>
                    <td>Сортировка</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[SORT][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[SORT][IS_REQUIRED]"
                               id="designed_checkbox_0.3665720954477776" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.3665720954477776"
                               title=""></label>
                    </td>
                    <td>
                        <input name="FIELDS[SORT][DEFAULT_VALUE]" type="hidden" value="">
                    </td>
                </tr>
                <tr>
                    <td>Название</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[NAME][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[NAME][IS_REQUIRED]" checked="" disabled=""
                               id="designed_checkbox_0.303135673414207" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.303135673414207"
                               title=""></label>
                    </td>
                    <td>
                        <input name="FIELDS[NAME][DEFAULT_VALUE]" type="text" value="" size="60">
                    </td>
                </tr>
                <tr>
                    <td>Картинка для анонса</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[PREVIEW_PICTURE][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[PREVIEW_PICTURE][IS_REQUIRED]"
                               id="designed_checkbox_0.061358043493824566" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.061358043493824566"
                               title=""></label>
                    </td>
                    <td>
                        <div class="adm-list">
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">Создавать картинку
                                        анонса из детальной (если не задана).
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">Удалять
                                        картинку анонса, если удаляется детальная.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">Создавать
                                        картинку анонса из детальной даже если задана.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y" id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]" onclick="
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD_DIV]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]"
                                 style="padding-left:16px;display:none">
                                Максимальная ширина:&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value=""
                                       size="7">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]"
                                 style="padding-left:16px;display:none">
                                Максимальная высота:&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value=""
                                       size="7">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]"
                                 style="padding-left:16px;display:none">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать
                                        ошибки масштабирования.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD_DIV]"
                                 style="padding-left:16px;display:none">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="resample"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                                        масштабировании (требует больше ресурсов на сервере)
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]"
                                 style="padding-left:16px;display:none">
                                Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                                       style="width: 30px">
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" onclick="
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                                        авторский знак в виде изображения.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                                 style="padding-left:16px;display:none">

                                Путь к изображению с авторским знаком:&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                                       id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value=""
                                       size="35">
                                &nbsp;
                                <input type="button" value="..." onclick="BtnClickPREVIEW_PICTURE()">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"
                                 style="padding-left:16px;display:none">
                                Прозрачность авторского знака (%):&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                                       value="" size="3">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                                 style="padding-left:16px;display:none">
                                Размещение авторского знака:&nbsp;<select class="typeselect"
                                                                          name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                                                                          id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]">
                                    <option value="tl">Сверху слева</option>
                                    <option value="tc">Сверху по центру</option>
                                    <option value="tr">Сверху справа</option>
                                    <option value="ml">Слева</option>
                                    <option value="mc">По центру</option>
                                    <option value="mr">Справа</option>
                                    <option value="bl">Снизу слева</option>
                                    <option value="bc">Снизу по центру</option>
                                    <option value="br">Снизу справа</option>
                                </select></div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" onclick="
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]').style.display =
								BX('SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                                        авторский знак в виде текста.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                                 style="padding-left:16px;display:none">
                                Содержание надписи:&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text"
                                       value="" size="35">

                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                                 style="padding-left:16px;display:none">
                                Путь к файлу шрифта:&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                                       id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text"
                                       value="" size="35">
                                &nbsp;
                                <input type="button" value="..." onclick="BtnClickFontPREVIEW_PICTURE()">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                                 style="padding-left:16px;display:none">
                                Цвет надписи (без #, например, FF00EE):&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text"
                                       value="" size="7">
                                &nbsp;
                                <input type="button" value="..."
                                       onclick="BX.findChildren(this.parentNode, {'tag': 'IMG'}, true)[0].onclick();"><span
                                        style="float:left;width:1px;height:1px;visibility:hidden;position:absolute;">
<span id="bx_colorpicker_LElA2Q9p46"><div class="bx-colpic-button-cont">
        <img src="/bitrix/images/1.gif" title="LElA2Q9p46" class="bx-colpic-button bx-colpic-button-normal"
             id="bx_btn_lela2q9p46">
    </div></span>
<style>#bx_btn_LElA2Q9p46{
        background-position : -280px -21px;
    }</style>

</span>
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"
                                 style="padding-left:16px;display:none">
                                Размер (% от размера картинки):&nbsp;
                                <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                                       value="" size="3">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                                 style="padding-left:16px;display:none">
                                Размещение авторского знака:&nbsp;<select class="typeselect"
                                                                          name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                                                                          id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]">
                                    <option value="tl">Сверху слева</option>
                                    <option value="tc">Сверху по центру</option>
                                    <option value="tr">Сверху справа</option>
                                    <option value="ml">Слева</option>
                                    <option value="mc">По центру</option>
                                    <option value="mr">Справа</option>
                                    <option value="bl">Снизу слева</option>
                                    <option value="bc">Снизу по центру</option>
                                    <option value="br">Снизу справа</option>
                                </select></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Тип описания для анонса</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]" checked=""
                               disabled="" id="designed_checkbox_0.027747465301816154" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.027747465301816154"
                               title=""></label>
                    </td>
                    <td>
                        <div class="adm-list">
                            <div class="adm-list-item">
                                <select name="FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]" height="1">
                                    <option value="text">text</option>
                                    <option value="html">html</option>
                                </select>
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="hidden" value="N"
                                           name="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                                           name="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked=""
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                                        переключаться между text и html.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Описание для анонса</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[PREVIEW_TEXT][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[PREVIEW_TEXT][IS_REQUIRED]"
                               id="designed_checkbox_0.5353263693991939" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.5353263693991939"
                               title=""></label>
                    </td>
                    <td>
                        <textarea name="FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]" rows="5" cols="47"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Детальная картинка</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[DETAIL_PICTURE][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[DETAIL_PICTURE][IS_REQUIRED]"
                               id="designed_checkbox_0.14278487664014983" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.14278487664014983"
                               title=""></label>
                    </td>
                    <td>
                        <div class="adm-list">
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y" id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]" onclick="
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD_DIV]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]"
                                 style="padding-left:16px;display:none">
                                Максимальная ширина:&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value=""
                                       size="7">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]"
                                 style="padding-left:16px;display:none">
                                Максимальная высота:&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value=""
                                       size="7">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS_DIV]"
                                 style="padding-left:16px;display:none">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать
                                        ошибки масштабирования.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD_DIV]"
                                 style="padding-left:16px;display:none">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="resample"
                                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                                        масштабировании (требует больше ресурсов на сервере)
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]"
                                 style="padding-left:16px;display:none">
                                Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                                       style="width: 30px">
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" onclick="
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                                        авторский знак в виде изображения.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                                 style="padding-left:16px;display:none">

                                Путь к изображению с авторским знаком:&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                                       id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value=""
                                       size="35">
                                &nbsp;
                                <input type="button" value="..." onclick="BtnClickDETAIL_PICTURE()">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"
                                 style="padding-left:16px;display:none">
                                Прозрачность авторского знака (%):&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                                       value="" size="3">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                                 style="padding-left:16px;display:none">
                                Размещение авторского знака:&nbsp;<select class="typeselect"
                                                                          name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
                                                                          id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]">
                                    <option value="tl">Сверху слева</option>
                                    <option value="tc">Сверху по центру</option>
                                    <option value="tr">Сверху справа</option>
                                    <option value="ml">Слева</option>
                                    <option value="mc">По центру</option>
                                    <option value="mr">Справа</option>
                                    <option value="bl">Снизу слева</option>
                                    <option value="bc">Снизу по центру</option>
                                    <option value="br">Снизу справа</option>
                                </select></div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" onclick="
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]').style.display =
								BX('SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                                        авторский знак в виде текста.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                                 style="padding-left:16px;display:none">
                                Содержание надписи:&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text" value=""
                                       size="35">

                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                                 style="padding-left:16px;display:none">
                                Путь к файлу шрифта:&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                                       id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text"
                                       value="" size="35">
                                &nbsp;
                                <input type="button" value="..." onclick="BtnClickFontDETAIL_PICTURE()">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                                 style="padding-left:16px;display:none">
                                Цвет надписи (без #, например, FF00EE):&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                                       id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text"
                                       value="" size="7">
                                &nbsp;
                                <input type="button" value="..."
                                       onclick="BX.findChildren(this.parentNode, {'tag': 'IMG'}, true)[0].onclick();"><span
                                        style="float:left;width:1px;height:1px;visibility:hidden;position:absolute;">
<span id="bx_colorpicker_bxO2x5zUHS"><div class="bx-colpic-button-cont">
        <img src="/bitrix/images/1.gif" title="bxO2x5zUHS" class="bx-colpic-button bx-colpic-button-normal"
             id="bx_btn_bxo2x5zuhs">
    </div></span>
<style>#bx_btn_bxO2x5zUHS{
        background-position : -280px -21px;
    }</style>

</span>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"
                                 style="padding-left:16px;display:none">
                                Размер (% от размера картинки):&nbsp;
                                <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                                       value="" size="3">
                            </div>
                            <div class="adm-list-item"
                                 id="SETTINGS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                                 style="padding-left:16px;display:none">
                                Размещение авторского знака:&nbsp;<select class="typeselect"
                                                                          name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
                                                                          id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]">
                                    <option value="tl">Сверху слева</option>
                                    <option value="tc">Сверху по центру</option>
                                    <option value="tr">Сверху справа</option>
                                    <option value="ml">Слева</option>
                                    <option value="mc">По центру</option>
                                    <option value="mr">Справа</option>
                                    <option value="bl">Снизу слева</option>
                                    <option value="bc">Снизу по центру</option>
                                    <option value="br">Снизу справа</option>
                                </select></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Тип детального описания</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]" checked=""
                               disabled="" id="designed_checkbox_0.5221106695295175" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.5221106695295175"
                               title=""></label>
                    </td>
                    <td>
                        <div class="adm-list">
                            <div class="adm-list-item">
                                <select name="FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]" height="1">
                                    <option value="text">text</option>
                                    <option value="html">html</option>
                                </select>
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="hidden" value="N"
                                           name="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">
                                    <input type="checkbox" value="Y"
                                           id="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                                           name="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked=""
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                                        переключаться между text и html.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Детальное описание</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[DETAIL_TEXT][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[DETAIL_TEXT][IS_REQUIRED]"
                               id="designed_checkbox_0.08954430783910827" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.08954430783910827"
                               title=""></label>
                    </td>
                    <td>
                        <textarea name="FIELDS[DETAIL_TEXT][DEFAULT_VALUE]" rows="5" cols="47"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Внешний код</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[XML_ID][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[XML_ID][IS_REQUIRED]"
                               id="designed_checkbox_0.7896526411710969" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.7896526411710969"
                               title=""></label>
                    </td>
                    <td>
                        <input type="hidden" value="" name="FIELDS[XML_ID][DEFAULT_VALUE]">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>Символьный код</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[CODE][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[CODE][IS_REQUIRED]"
                               id="designed_checkbox_0.649197026766049" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.649197026766049"
                               title=""></label>
                    </td>
                    <td>
                        <div class="adm-list">
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                                           name="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label" for="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                                           title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]">Если код задан, то проверять на
                                        уникальность.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"
                                           name="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]" onclick="
								BX('SETTINGS[CODE][DEFAULT_VALUE][TRANS_LEN]').style.display =
								BX('SETTINGS[CODE][DEFAULT_VALUE][TRANS_CASE]').style.display =
								BX('SETTINGS[CODE][DEFAULT_VALUE][TRANS_SPACE]').style.display =
								BX('SETTINGS[CODE][DEFAULT_VALUE][TRANS_OTHER]').style.display =
								BX('SETTINGS[CODE][DEFAULT_VALUE][TRANS_EAT]').style.display =
								BX('SETTINGS[CODE][DEFAULT_VALUE][USE_GOOGLE]').style.display =
								this.checked? 'block': 'none';
							" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]">Транслитерировать из
                                        названия при добавлении элемента.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[CODE][DEFAULT_VALUE][TRANS_LEN]"
                                 style="padding-left:16px;display:none">
                                Максимальная длина результата транслитерации::&nbsp;
                                <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]" type="text" value="100" size="3">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[CODE][DEFAULT_VALUE][TRANS_CASE]"
                                 style="padding-left:16px;display:none">
                                Приведение к регистру:&nbsp;<select name="FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]">
                                    <option value="">сохранить</option>
                                    <option value="L" selected="">
                                        к нижнему
                                    </option>
                                    <option value="U">
                                        к верхнему
                                    </option>
                                </select>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[CODE][DEFAULT_VALUE][TRANS_SPACE]"
                                 style="padding-left:16px;display:none">
                                Замена для символа пробела:&nbsp;
                                <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]" type="text" value="-" size="2">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[CODE][DEFAULT_VALUE][TRANS_OTHER]"
                                 style="padding-left:16px;display:none">
                                Замена для прочих символов:&nbsp;
                                <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]" type="text" value="-" size="2">
                            </div>
                            <div class="adm-list-item" id="SETTINGS[CODE][DEFAULT_VALUE][TRANS_EAT]"
                                 style="padding-left:16px;display:none">
                                <div class="adm-list-control">
                                    <input type="hidden" value="N" name="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]">
                                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"
                                           name="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]" checked=""
                                           class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]">Удалять лишние символы замены.
                                    </label>
                                </div>
                            </div>
                            <div class="adm-list-item" id="SETTINGS[CODE][DEFAULT_VALUE][USE_GOOGLE]"
                                 style="padding-left:16px;display:none">
                                <div class="adm-list-control">
                                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"
                                           name="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]" class="adm-designed-checkbox">
                                    <label class="adm-designed-checkbox-label"
                                           for="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]" title=""></label>
                                </div>
                                <div class="adm-list-label">
                                    <label for="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]">Использовать внешний сервис для
                                        перевода.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Теги</td>
                    <td>
                        <input type="hidden" value="N" name="FIELDS[TAGS][IS_REQUIRED]">
                        <input type="checkbox" value="Y" name="FIELDS[TAGS][IS_REQUIRED]"
                               id="designed_checkbox_0.1941895748884055" class="adm-designed-checkbox">
                        <label class="adm-designed-checkbox-label" for="designed_checkbox_0.1941895748884055"
                               title=""></label>
                    </td>
                    <td>
                        <input type="hidden" value="" name="FIELDS[TAGS][DEFAULT_VALUE]">
                        &nbsp;
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    </tbody>
</table>