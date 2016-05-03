<table class="table">
    <tr>
        <th>Поле элемента</th>
        <th>Обяз.</th>
        <th>Значение по умолчанию</th>
    </tr>
    <tr>
        <th>Привязка к разделам</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[IBLOCK_SECTION][IS_REQUIRED]"
                   id="designed_checkbox_0.45557879228328524">
            <label for="designed_checkbox_0.45557879228328524"
                   title=""></label>
        </td>
        <td>
            <input type="checkbox" name="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"
                   id="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]" value="Y"
                    >
            <label
                    for="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]" title=""></label>
            <label for="FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]">
                Разрешить выбор основного раздела для привязки.
            </label>
        </td>
    </tr>
    <tr>
        <th>Активность</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[ACTIVE][IS_REQUIRED]" checked="" disabled=""
                   id="designed_checkbox_0.7348353701186734">
            <label for="designed_checkbox_0.7348353701186734"
                   title=""></label>
        </td>
        <td>
            <select class="form-control" name="FIELDS[ACTIVE][DEFAULT_VALUE]" height="1">
                <option value="Y">да</option>
                <option value="N">нет</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Начало активности</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[ACTIVE_FROM][IS_REQUIRED]"
                   id="designed_checkbox_0.1582518372963051">
            <label for="designed_checkbox_0.1582518372963051"
                   title=""></label>
        </td>
        <td>
            <select class="form-control" name="FIELDS[ACTIVE_FROM][DEFAULT_VALUE]" height="1">
                <option value="">Не задано</option>
                <option value="=now">Текущие дата и время</option>
                <option value="=today">Текущая дата</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Окончание активности</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[ACTIVE_TO][IS_REQUIRED]"
                   id="designed_checkbox_0.38986472993139154">
            <label for="designed_checkbox_0.38986472993139154"
                   title=""></label>
        </td>
        <td>
            <label for="FIELDS[ACTIVE_TO][DEFAULT_VALUE]">Продолжительность активности элемента (дней):
            </label>
            <input name="FIELDS[ACTIVE_TO][DEFAULT_VALUE]" type="text" value="" size="5">
        </td>
    </tr>
    <tr>
        <th>Сортировка</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[SORT][IS_REQUIRED]"
                   id="designed_checkbox_0.3665720954477776">
            <label for="designed_checkbox_0.3665720954477776"
                   title=""></label>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <th>Название</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[NAME][IS_REQUIRED]" checked="" disabled=""
                   id="designed_checkbox_0.303135673414207">
            <label for="designed_checkbox_0.303135673414207"
                   title=""></label>
        </td>
        <td>
            <input name="FIELDS[NAME][DEFAULT_VALUE]" type="text" value="" size="60">
        </td>
    </tr>
    <tr>
        <th>Картинка для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[PREVIEW_PICTURE][IS_REQUIRED]"
                   id="designed_checkbox_0.061358043493824566">
            <label for="designed_checkbox_0.061358043493824566"
                   title=""></label>
        </td>
        <td>
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"
                    >
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]" title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]">Создавать картинку
                анонса из детальной (если не задана).
            </label>
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                    >
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"
                    title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]">Удалять
                картинку анонса, если удаляется детальная.
            </label>
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                    >
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"
                    title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]">Создавать
                картинку анонса из детальной даже если задана.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]">
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]" title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
            </label>
            Максимальная ширина:&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value=""
                   size="7">
            Максимальная высота:&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value=""
                   size="7">
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                    >
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                    title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать
                ошибки масштабирования.
            </label>
            <input type="checkbox" value="resample"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                    >
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]" title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                масштабировании (требует больше ресурсов на сервере)
            </label>
            Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                    >
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                    title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                авторский знак в виде изображения.
            </label>
            Путь к изображению с авторским знаком:&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                   id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value=""
                   size="35">
            &nbsp;
            Прозрачность авторского знака (%):&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                   value="" size="3">
            Размещение авторского знака:&nbsp;
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
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                   name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">
            <label
                    for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                    title=""></label>
            <label for="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                авторский знак в виде текста.
            </label>
            Содержание надписи:&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text"
                   value="" size="35">
            Путь к файлу шрифта:&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                   id="FIELDS_PREVIEW_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text"
                   value="" size="35">
            &nbsp;
            Цвет надписи (без #, например, FF00EE):&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                   id="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text"
                   value="" size="7">
            Размер (% от размера картинки):&nbsp;
            <input name="FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                   value="" size="3">
            Размещение авторского знака:&nbsp;
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
        </td>
    </tr>
    <tr>
        <th>Тип описания для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]" checked=""
                   disabled="" id="designed_checkbox_0.027747465301816154">
            <label for="designed_checkbox_0.027747465301816154"
                   title=""></label>
        </td>
        <td>
            <select class="form-control" name="FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]" height="1">
                <option value="text">text</option>
                <option value="html">html</option>
            </select>
            <input type="checkbox" value="Y"
                   id="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked=""
                    >
            <label
                    for="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                    title=""></label>
            <label for="FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                переключаться между text и html.
            </label>
        </td>
    </tr>
    <tr>
        <th>Описание для анонса</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[PREVIEW_TEXT][IS_REQUIRED]"
                   id="designed_checkbox_0.5353263693991939">
            <label for="designed_checkbox_0.5353263693991939"
                   title=""></label>
        </td>
        <td>
            <textarea class="form-control" name="FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]" rows="5" cols="47"></textarea>
        </td>
    </tr>
    <tr>
        <th>Детальная картинка</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[DETAIL_PICTURE][IS_REQUIRED]"
                   id="designed_checkbox_0.14278487664014983">
            <label for="designed_checkbox_0.14278487664014983"
                   title=""></label>
        </td>
        <td>
            <input type="checkbox" value="Y" id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"
                   name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">
            <label
                    for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]" title=""></label>
            <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]">Уменьшать если большая.
            </label>
            Максимальная ширина:&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]" type="text" value=""
                   size="7">
            Максимальная высота:&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]" type="text" value=""
                   size="7">
            <input type="checkbox" value="Y"
                   id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                   name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"
                    >
            <label
                    for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]" title=""></label>
            <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]">Игнорировать
                ошибки масштабирования.
            </label>
            <input type="checkbox" value="resample"
                   id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"
                   name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" checked=""
                    >
            <label
                    for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]" title=""></label>
            <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]">Сохранять качество при
                масштабировании (требует больше ресурсов на сервере)
            </label>
            Качество (только для JPEG, 1-100, по умолчанию около 75):&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]" type="text" value="95"
                    >
            <input type="checkbox" value="Y"
                   id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                   name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">
            <label
                    for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"
                    title=""></label>
            <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]">Наносить
                авторский знак в виде изображения.
            </label>
            Путь к изображению с авторским знаком:&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"
                   id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_FILE_" type="text" value=""
                   size="35">
            &nbsp;
            Прозрачность авторского знака (%):&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]" type="text"
                   value="" size="3">
            Размещение авторского знака:&nbsp;
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
            <input type="checkbox" value="Y"
                   id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                   name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">
            <label
                    for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"
                    title=""></label>
            <label for="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]">Наносить
                авторский знак в виде текста.
            </label>
            Содержание надписи:&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]" type="text" value=""
                   size="35">
            Путь к файлу шрифта:&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"
                   id="FIELDS_DETAIL_PICTURE__DEFAULT_VALUE__WATERMARK_TEXT_FONT_" type="text"
                   value="" size="35">
            &nbsp;
            Цвет надписи (без #, например, FF00EE):&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"
                   id="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]" type="text"
                   value="" size="7">
            Размер (% от размера картинки):&nbsp;
            <input name="FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]" type="text"
                   value="" size="3">
            Размещение авторского знака:&nbsp;
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
        </td>
    </tr>
    <tr>
        <th>Тип детального описания</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]" checked=""
                   disabled="" id="designed_checkbox_0.5221106695295175">
            <label for="designed_checkbox_0.5221106695295175"
                   title=""></label>
        </td>
        <td>
            <select class="form-control" name="FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]" height="1">
                <option value="text">text</option>
                <option value="html">html</option>
            </select>
            <input type="checkbox" value="Y"
                   id="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"
                   name="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" checked=""
                    >
            <label
                    for="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]" title=""></label>
            <label for="FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]">Разрешить
                переключаться между text и html.
            </label>
        </td>
    </tr>
    <tr>
        <th>Детальное описание</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[DETAIL_TEXT][IS_REQUIRED]"
                   id="designed_checkbox_0.08954430783910827">
            <label for="designed_checkbox_0.08954430783910827"
                   title=""></label>
        </td>
        <td>
            <textarea class="form-control" name="FIELDS[DETAIL_TEXT][DEFAULT_VALUE]" rows="5" cols="47"></textarea>
        </td>
    </tr>
    <tr>
        <th>Внешний код</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[XML_ID][IS_REQUIRED]"
                   id="designed_checkbox_0.7896526411710969">
            <label for="designed_checkbox_0.7896526411710969"
                   title=""></label>
        </td>
        <td>
            &nbsp;
        </td>
    </tr>
    <tr>
        <th>Символьный код</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[CODE][IS_REQUIRED]"
                   id="designed_checkbox_0.649197026766049">
            <label for="designed_checkbox_0.649197026766049"
                   title=""></label>
        </td>
        <td>
            <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                   name="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]">
            <label for="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"
                   title=""></label>
            <label for="FIELDS[CODE][DEFAULT_VALUE][UNIQUE]">Если код задан, то проверять на
                уникальность.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"
                   name="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]">
            <label
                    for="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]" title=""></label>
            <label for="FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]">Транслитерировать из
                названия при добавлении элемента.
            </label>
            Максимальная длина результата транслитерации::&nbsp;
            <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]" type="text" value="100" size="3">
            Приведение к регистру:&nbsp;
            <select class="form-control" name="FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]">
                <option value="">сохранить</option>
                <option value="L" selected="">
                    к нижнему
                </option>
                <option value="U">
                    к верхнему
                </option>
            </select>
            Замена для символа пробела:&nbsp;
            <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]" type="text" value="-" size="2">
            Замена для прочих символов:&nbsp;
            <input name="FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]" type="text" value="-" size="2">
            <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"
                   name="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]" checked=""
                    >
            <label
                    for="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]" title=""></label>
            <label for="FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]">Удалять лишние символы замены.
            </label>
            <input type="checkbox" value="Y" id="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"
                   name="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]">
            <label
                    for="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]" title=""></label>
            <label for="FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]">Использовать внешний сервис для
                перевода.
            </label>
        </td>
    </tr>
    <tr>
        <th>Теги</th>
        <td>
            <input type="checkbox" value="Y" name="FIELDS[TAGS][IS_REQUIRED]"
                   id="designed_checkbox_0.1941895748884055">
            <label for="designed_checkbox_0.1941895748884055"
                   title=""></label>
        </td>
        <td>
            &nbsp;
        </td>
    </tr>
</table>