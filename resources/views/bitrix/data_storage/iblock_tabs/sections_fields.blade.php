<table class="table">
    <tr>
        <th>Поле раздела</th>
        <td>Обяз.</td>
        <td>Значение по умолчанию</td>
    </tr>
    <tr>
        <th>Название</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_NAME][IS_REQUIRED]" checked="" disabled=""
                   id="designed_checkbox_0.6718456406111109">
            <label for="designed_checkbox_0.6718456406111109" title=""></label>
        </td>
        <td>
            <input name="FIELDS[SECTION_NAME][DEFAULT_VALUE]" type="text" value="" size="60">
        </td>
    </tr>
    <tr>
        <th>Картинка для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_PICTURE][IS_REQUIRED]"
                   id="designed_checkbox_0.748316363610642">
            <label for="designed_checkbox_0.748316363610642" title=""></label>
        </td>
        <td>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">
            <label
                    for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]" title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">Создавать картинку анонса из
                детальной (если не задана).
            </label>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                    >
            <label
                    for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]" title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">Удалять картинку анонса,
                если удаляется детальная.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                    >
            <label
                    for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]" title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">Создавать картинку
                анонса из детальной даже если задана.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]">
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]"
                   title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.</label>
            Максимальная ширина:&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value="" size="7">
            Максимальная высота:&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value="" size="7">
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                    >
            <label
                    for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать ошибки
                масштабирования.
            </label>
            <input type="checkbox" value="resample" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                    >
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]"
                   title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                масштабировании (требует больше ресурсов на сервере)
            </label>
            Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                    >
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">
            <label
                    for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]" title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить авторский знак
                в виде изображения.
            </label>
            Путь к изображению с авторским знаком:&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                   id="FIELDS_SECTION_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value="" size="35">
            &nbsp;
            <input type="button" value="...">
            Прозрачность авторского знака (%):&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text" value=""
                   size="3">
            Размещение авторского знака:&nbsp;
            <select class="form-control" name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"
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
            <input type="checkbox" value="Y" id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                   name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">
            <label
                    for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]" title=""></label>
            <label for="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить авторский знак
                в виде текста.
            </label>
            Содержание надписи:&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text" value="" size="35">
            Путь к файлу шрифта:&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                   id="FIELDS_SECTION_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text" value=""
                   size="35">
            &nbsp;
            <input type="button" value="...">
            Цвет надписи (без #, например, FF00EE):&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                   id="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text" value=""
                   size="7">
            Размер (% от размера картинки):&nbsp;
            <input name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text" value=""
                   size="3">
            Размещение авторского знака:&nbsp;
            <select class="form-control" name="FIELDS[SECTION_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"
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
        </td>
    </tr>
    <tr>
        <th>Тип описания</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_DESCRIPTION_TYPE][IS_REQUIRED]" checked="" disabled=""
                   id="designed_checkbox_0.8363249068064615">
            <label for="designed_checkbox_0.8363249068064615" title=""></label>
        </td>
        <td>
            <select class="form-control" name="FIELDS[SECTION_DESCRIPTION_TYPE][DEFAULT_VALUE]" height="1">
                <option value="text">text</option>
                <option value="html">html</option>
            </select>
            <input type="checkbox" value="Y"
                   id="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked=""
                    >
            <label
                    for="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" title=""></label>
            <label for="FIELDS[SECTION_DESCRIPTION_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                переключаться между text и html.
            </label>
        </td>
    </tr>
    <tr>
        <th>Описание</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_DESCRIPTION][IS_REQUIRED]"
                   id="designed_checkbox_0.7500535682424345">
            <label for="designed_checkbox_0.7500535682424345" title=""></label>
        </td>
        <td>
            <textarea class="form-control" name="FIELDS[SECTION_DESCRIPTION][DEFAULT_VALUE]" rows="5"
                      cols="47"></textarea>
        </td>
    </tr>
    <tr>
        <th>Детальная картинка</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_DETAIL_PICTURE][IS_REQUIRED]"
                   id="designed_checkbox_0.09113542663517515">
            <label for="designed_checkbox_0.09113542663517515" title=""></label>
        </td>
        <td>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                   name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">
            <label
                    for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]" title=""></label>
            <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
            </label>
            Максимальная ширина:&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value="" size="7">
            Максимальная высота:&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value="" size="7">
            <input type="checkbox" value="Y"
                   id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                   name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                    >
            <label
                    for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
            <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать ошибки
                масштабирования.
            </label>
            <input type="checkbox" value="resample"
                   id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                   name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                    >
            <label
                    for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" title=""></label>
            <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                масштабировании (требует больше ресурсов на сервере)
            </label>
            Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                    >
            <input type="checkbox" value="Y"
                   id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                   name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">
            <label
                    for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                    title=""></label>
            <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                авторский знак в виде изображения.
            </label>
            Путь к изображению с авторским знаком:&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                   id="FIELDS_SECTION_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value=""
                   size="35">
            &nbsp;
            <input type="button" value="...">
            Прозрачность авторского знака (%):&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                   value="" size="3">
            Размещение авторского знака:&nbsp;
            <select class="form-control"
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
            <input type="checkbox" value="Y"
                   id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                   name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">
            <label
                    for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                    title=""></label>
            <label for="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                авторский знак в виде текста.
            </label>
            Содержание надписи:&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text" value=""
                   size="35">
            Путь к файлу шрифта:&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                   id="FIELDS_SECTION_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text" value=""
                   size="35">
            &nbsp;
            <input type="button" value="...">
            Цвет надписи (без #, например, FF00EE):&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                   id="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text" value=""
                   size="7">
            Размер (% от размера картинки):&nbsp;
            <input name="FIELDS[SECTION_DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                   value="" size="3">
            Размещение авторского знака:&nbsp;
            <select class="form-control"
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
        </td>
    </tr>
    <tr>
        <th>Внешний код</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_XML_ID][IS_REQUIRED]"
                   id="designed_checkbox_0.7988412621350995">
            <label for="designed_checkbox_0.7988412621350995" title=""></label>
        </td>
        <td>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th>Символьный код</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SECTION_CODE][IS_REQUIRED]"
                   id="designed_checkbox_0.2502620220108924">
            <label for="designed_checkbox_0.2502620220108924" title=""></label>
        </td>
        <td>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]"
                   name="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]">
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]"
                   title=""></label>
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][UNIQUE]">Если код задан, то проверять на
                уникальность.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]"
                   name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]">
            <label
                    for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]" title=""></label>
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANSLITERATION]">Транслитерировать из названия
                при добавлении раздела.
            </label>
            Максимальная длина результата транслитерации::&nbsp;
            <input name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_LEN]" type="text" value="100" size="3">
            Приведение к регистру:&nbsp;
            <select class="form-control" name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_CASE]">
                <option value="">сохранить</option>
                <option value="L" selected="">
                    к нижнему
                </option>
                <option value="U">
                    к верхнему
                </option>
            </select>
            Замена для символа пробела:&nbsp;
            <input name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_SPACE]" type="text" value="-" size="2">
            Замена для прочих символов:&nbsp;
            <input name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_OTHER]" type="text" value="-" size="2">
            <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]"
                   name="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]" checked=""
                    >
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]"
                   title=""></label>
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][TRANS_EAT]">Удалять лишние символы замены.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]"
                   name="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]">
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]"
                   title=""></label>
            <label for="FIELDS[SECTION_CODE][DEFAULT_VALUE][USE_GOOGLE]">Использовать внешний сервис для
                перевода.
            </label>
        </td>
    </tr>
</table>