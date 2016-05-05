<table class="table">
    <tr>
        <th>Значения свойств
            хранятся:
        </th>
        <td>
            <label>
                <input type="radio" name="VERSION" value="1" checked="">
                в общей таблице (по
                умолчанию)
            </label>
            <br>
            <label>
                <input type="radio" name="VERSION" value="2">
                в отдельной таблице для данного
                информационного блока
            </label>
        </td>
    </tr>
    <tr>
        <th>
            <label for="ACTIVE">Информационный блок активен:</label>
        </th>
        <td>
            <input type="checkbox" id="ACTIVE" name="ACTIVE" value="Y" checked="">
            <label for="ACTIVE" title=""></label>
        </td>
    </tr>
    <tr>
        <th>Символьный код:</th>
        <td>
            <input type="text" class="form-control" name="CODE" size="50" maxlength="50"
                   value="{{isset($iblock)?$iblock->params->CODE:''}}" required>
        </td>
    </tr>
    <tr>
        <th>Сайты:</th>
        <td>
            <input type="text" class="form-control" name="LID" value="{{isset($iblock)?$iblock->params->LID:'s1'}}">
        </td>
    </tr>
    <tr>
        <th>Название:</th>
        <td>
            <input type="text" class="form-control" name="NAME" size="55" maxlength="255"
                   value="{{isset($iblock)?$iblock->params->NAME:''}}" required>
        </td>
    </tr>
    <tr>
        <th>Сортировка:</th>
        <td>
            <input type="text" class="form-control" name="SORT" size="10" maxlength="10" value="500">
        </td>
    </tr>
    <tr>
        <th>URL страницы информационного блока:</th>
        <td>
            <input type="text" class="form-control" name="LIST_PAGE_URL" id="LIST_PAGE_URL" size="55" maxlength="255"
                   value="#SITE_DIR#/vregions/index.php?ID=#IBLOCK_ID#">
        </td>
    </tr>
    <tr>
        <th>URL страницы раздела:</th>
        <td>
            <input type="text" class="form-control" name="SECTION_PAGE_URL" id="SECTION_PAGE_URL" size="55"
                   maxlength="255"
                   value="#SITE_DIR#/vregions/list.php?SECTION_ID=#SECTION_ID#">
        </td>
    </tr>
    <tr>
        <th>URL страницы детального просмотра:</th>
        <td>
            <input type="text" class="form-control" name="DETAIL_PAGE_URL" id="DETAIL_PAGE_URL" size="55"
                   maxlength="255"
                   value="#SITE_DIR#/vregions/detail.php?ID=#ELEMENT_ID#">
        </td>
    </tr>
    <tr>
        <th>Канонический URL элемента:<br>(необходимо указать
            протокол, адрес сервера и путь на сайте)
        </th>
        <td>
            <input type="text" class="form-control" name="CANONICAL_PAGE_URL" id="CANONICAL_PAGE_URL" size="55"
                   maxlength="255" value="">
        </td>
    </tr>
    <tr>
        <th>
            <label for="INDEX_SECTION">Индексировать разделы для
                модуля поиска:
            </label>
        </th>
        <td>
            <input type="checkbox" id="INDEX_SECTION" name="INDEX_SECTION" value="Y" checked=""
                    >
            <label
                    for="INDEX_SECTION" title=""></label>
        </td>
    </tr>
    <tr>
        <th>
            <label for="INDEX_ELEMENT">Индексировать элементы для
                модуля поиска:
            </label>
        </th>
        <td>
            <input type="checkbox" id="INDEX_ELEMENT" name="INDEX_ELEMENT" value="Y" checked=""
                    >
            <label
                    for="INDEX_ELEMENT" title=""></label>
        </td>
    </tr>
    <tr>
        <th>Участвует в документообороте или бизнес процессах</th>
        <td>
            <select class="form-control" name="WF_TYPE">
                <option value="N" selected="">нет</option>
                <option value="WF">документооборот</option>
                <option value="BP">бизнес процессы</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Интерфейс привязки элемента к разделам:</th>
        <td>
            <select class="form-control" name="SECTION_CHOOSER">
                <option value="L" selected="">Список множественного выбора</option>
                <option value="D">Выпадающие списки</option>
                <option value="P">Окно поиска</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Режим просмотра разделов и элементов:</th>
        <td>
            <select class="form-control" name="LIST_MODE">
                <option value="">из настроек модуля</option>
                <option value="S">раздельный</option>
                <option value="C">совместный</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>Изображение:</th>
        <td>
            <a href="#" class="btn btn-primary">Добавить файл</a>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label for="bxed_DESCRIPTION_text">
                <input checked="checked" type="radio"
                       name="DESCRIPTION_TYPE"
                       id="bxed_DESCRIPTION_text"
                       value="text">
                Текст
            </label>
            <label for="bxed_DESCRIPTION_html">
                <input type="radio" name="DESCRIPTION_TYPE"
                       id="bxed_DESCRIPTION_html"
                       value="html">
                HTML
            </label>
            <textarea class="form-control" style="height:450px;" name="DESCRIPTION"
                      id="bxed_DESCRIPTION" wrap="virtual"></textarea>
        </td>
    </tr>
</table>