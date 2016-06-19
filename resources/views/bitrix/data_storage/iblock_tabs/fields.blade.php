<table class="table">
    <tr>
        <th>Поле элемента</th>
        <th>Обяз.</th>
        <th>Значение по умолчанию</th>
    </tr>
    <tr>
        <th>Привязка к разделам</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[IBLOCK_SECTION][IS_REQUIRED]">
        </td>
        <td>
            <input type="checkbox" name="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"
                   id="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]" value="Y">
            <label for="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]">
                Разрешить выбор основного раздела для привязки.
            </label>
        </td>
    </tr>
    <tr>
        <th>Активность</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[ACTIVE][IS_REQUIRED]" checked disabled>
        </td>
        <td>
            <select class="form-control" name="FIELDS[ACTIVE][DEFAULT_VALUE]">
                <option value="Y">да</option>
                <option value="N">нет</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Начало активности</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[ACTIVE_FROM][IS_REQUIRED]">
        </td>
        <td>
            <select class="form-control" name="FIELDS[ACTIVE_FROM][DEFAULT_VALUE]">
                <option>Не задано</option>
                <option value="=now">Текущие дата и время</option>
                <option value="=today">Текущая дата</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Окончание активности</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[ACTIVE_TO][IS_REQUIRED]">
        </td>
        <td>
            <label for="FIELDS[ACTIVE_TO][DEFAULT_VALUE]">Продолжительность активности элемента
                (дней):
            </label>
            <input class="form-control" name="FIELDS[ACTIVE_TO][DEFAULT_VALUE]" type="text">
        </td>
    </tr>
    <tr>
        <th>Сортировка</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SORT][IS_REQUIRED]">
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <th>Название</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[NAME][IS_REQUIRED]" checked disabled>
        </td>
        <td>
            <input class="form-control" name="FIELDS[NAME][DEFAULT_VALUE]" type="text">
        </td>
    </tr>
    <tr>
        <th>Картинка для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[PREVIEW_PICTURE][IS_REQUIRED]">
        </td>
        <td>
            <div>
                <input type="checkbox" value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">Создавать картинку
                    анонса из детальной (если не задана).
                </label>
            </div>
            <div>
                <input type="checkbox" value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">Удалять
                    картинку анонса, если удаляется детальная.
                </label>
            </div>
            <div>
                <input type="checkbox" value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">Создавать
                    картинку анонса из детальной даже если задана.
                </label>
            </div>
            <div>
                <input type="checkbox" value="Y" id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]">
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
                </label>
                <div>
                    Максимальная ширина:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" class="form-control">
                </div>
                <div>
                    Максимальная высота:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" class="form-control">
                </div>
                <div>
                    <input type="checkbox" value="Y"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">
                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать
                        ошибки масштабирования.
                    </label>
                </div>
                <div>
                    <input type="checkbox" value="resample"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"
                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]" checked>
                    <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                        масштабировании (требует больше ресурсов на сервере)
                    </label>
                </div>
                <div>
                    Качество (только для JPEG, 1-100, по умолчанию около 75):
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                           class="form-control">
                    <input type="checkbox" value="Y"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                           name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">
                </div>
            </div>
            <div>
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                    авторский знак в виде изображения.
                </label>
                <div>
                    Путь к изображению с авторским знаком:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                           id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" class="form-control">
                </div>
                <div>
                    Прозрачность авторского знака (%):
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                           class="form-control">
                </div>
                <div>
                    Размещение авторского знака:
                    <select class="form-control"
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
                    </select>
                </div>
            </div>
            <div>
                <input type="checkbox" value="Y"
                       id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                       name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">
                <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                    авторский знак в виде текста.
                </label>
                <div>Содержание надписи:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text"
                           class="form-control">
                </div>
                <div>
                    Путь к файлу шрифта:
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                           id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text"
                           class="form-control">
                </div>
                <div>
                    Цвет надписи (без #, например, FF00EE):
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text"
                           class="form-control">
                </div>
                <div>
                    Размер (% от размера картинки):
                    <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                           class="form-control">
                </div>
                <div>
                    Размещение авторского знака:
                    <select class="form-control"
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
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>Тип описания для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]" checked
                   disabled>
        </td>
        <td>
            <select class="form-control" name="FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]">
                <option value="text">text</option>
                <option value="html">html</option>
            </select>
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked>
            <label for="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                переключаться между text и html.
            </label>
        </td>
    </tr>
    <tr>
        <th>Описание для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[PREVIEW_TEXT][IS_REQUIRED]">
        </td>
        <td>
            <textarea class="form-control" name="FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]"></textarea>
        </td>
    </tr>
    <tr>
        <th>Детальная картинка</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[DETAIL_PICTURE][IS_REQUIRED]">
        </td>
        <td>
            <div>
                <input type="checkbox" value="Y" id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                       name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">
                <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
                </label>
                <div>
                    Максимальная ширина:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" class="form-control">
                </div>
                <div>
                    Максимальная высота:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" class="form-control">
                </div>
                <div>
                    <input type="checkbox" value="Y"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">
                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать
                        ошибки масштабирования.
                    </label>
                </div>
                <div>
                    <input type="checkbox" value="resample"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" checked>
                    <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                        масштабировании (требует больше ресурсов на сервере)
                    </label>
                </div>
                <div>
                    Качество (только для JPEG, 1-100, по умолчанию около 75):
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                           class="form-control">
                    <input type="checkbox" value="Y"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                           name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">
                </div>
            </div>
            <div>
                <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                    авторский знак в виде изображения.
                </label>
                <div>
                    Путь к изображению с авторским знаком:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                           id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" class="form-control">
                </div>
                <div>
                    Прозрачность авторского знака (%):
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                           class="form-control">
                </div>
                <div>
                    Размещение авторского знака:
                    <select class="form-control"
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
                    </select>
                </div>
            </div>
            <div>
                <input type="checkbox" value="Y"
                       id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                       name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">
                <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                    авторский знак в виде текста.
                </label>
                <div>Содержание надписи:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text"
                           class="form-control">
                </div>
                <div>
                    Путь к файлу шрифта:
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                           id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text"
                           class="form-control">
                </div>
                <div>
                    Цвет надписи (без #, например, FF00EE):
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                           id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text"
                           class="form-control">
                </div>
                <div>
                    Размер (% от размера картинки):
                    <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                           class="form-control">
                </div>
                <div>
                    Размещение авторского знака:
                    <select class="form-control"
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
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>Тип детального описания</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]" checked
                   disabled>
        </td>
        <td>
            <select class="form-control" name="FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]">
                <option value="text">text</option>
                <option value="html">html</option>
            </select>
            <input type="checkbox" value="Y"
                   id="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked>
            <label for="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                переключаться между text и html.
            </label>
        </td>
    </tr>
    <tr>
        <th>Детальное описание</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[DETAIL_TEXT][IS_REQUIRED]">
        </td>
        <td>
            <textarea class="form-control" name="FIELDS[DETAIL_TEXT][DEFAULT_VALUE]"></textarea>
        </td>
    </tr>
    <tr>
        <th>Внешний код</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[XML_ID][IS_REQUIRED]">
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <th>Символьный код</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[CODE][IS_REQUIRED]">
        </td>
        <td>
            <div>
                <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                       name="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]">
                <label for="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]">Если код задан, то проверять на
                    уникальность.
                </label>
            </div>
            <div>
                <div>
                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"
                           name="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]">
                    <label for="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]">Транслитерировать из
                        названия при добавлении элемента.
                    </label>
                </div>
                <div>
                    Максимальная длина результата транслитерации::
                    <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]" type="text" value="100" class="form-control">
                </div>
                <div>
                    Приведение к регистру:
                    <select class="form-control" name="FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]">
                        <option>сохранить</option>
                        <option value="L" selected="">
                            к нижнему
                        </option>
                        <option value="U">
                            к верхнему
                        </option>
                    </select>
                </div>
                <div>
                    Замена для символа пробела:
                    <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]" type="text" value="-" class="form-control">
                </div>
                <div> Замена для прочих символов:
                    <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]" type="text" value="-" class="form-control">
                </div>
                <div>
                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"
                           name="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]" checked>
                    <label for="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]">Удалять лишние символы замены.
                    </label>
                </div>
                <div>
                    <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"
                           name="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]">
                    <label for="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]">Использовать внешний сервис для
                        перевода.
                    </label>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <th>Теги</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[TAGS][IS_REQUIRED]">
        </td>
        <td>
        </td>
    </tr>
</table>