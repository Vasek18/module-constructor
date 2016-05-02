<table class="table">
    <tr>
        <td>Значения свойств
            хранятся:
        </td>
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
        <td>
            <label for="ACTIVE">Информационный блок активен:</label>
        </td>
        <td>
            <input type="hidden" name="ACTIVE" value="N">
            <input type="checkbox" id="ACTIVE" name="ACTIVE" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="ACTIVE"
                   title=""></label>
                            <span style="display:none;"><input type="submit" name="save" value="Y"
                                                               style="width:0px;height:0px"></span>
        </td>
    </tr>
    <tr>
        <td>Символьный код:</td>
        <td>
            <input type="text" name="CODE" size="50" maxlength="50" value="">
        </td>
    </tr>
    <tr>
        <td>Сайты:</td>
        <td>
            <div class="adm-list">
                <div class="adm-list-item">
                    <div class="adm-list-control">
                        <input type="checkbox" name="LID[]" value="s1" id="s1"
                               class="typecheckbox adm-designed-checkbox">
                        <label
                                class="adm-designed-checkbox-label typecheckbox" for="s1"
                                title=""></label>
                    </div>
                    <div class="adm-list-label">
                        <label for="s1">[s1]&nbsp;Промо регионов</label>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>Название:</td>
        <td>
            <input type="text" name="NAME" size="55" maxlength="255" value="">
        </td>
    </tr>
    <tr>
        <td>Сортировка:</td>
        <td>
            <input type="text" name="SORT" size="10" maxlength="10" value="500">
        </td>
    </tr>
    <tr>
        <td>URL страницы информационного блока:</td>
        <td>
            <input type="text" name="LIST_PAGE_URL" id="LIST_PAGE_URL" size="55" maxlength="255"
                   value="#SITE_DIR#/vregions/index.php?ID=#IBLOCK_ID#">
            <input type="button" id="mnu_LIST_PAGE_URL" value="...">
        </td>
    </tr>
    <tr>
        <td>URL страницы раздела:</td>
        <td>
            <input type="text" name="SECTION_PAGE_URL" id="SECTION_PAGE_URL" size="55" maxlength="255"
                   value="#SITE_DIR#/vregions/list.php?SECTION_ID=#SECTION_ID#">
            <input type="button" id="mnu_SECTION_PAGE_URL" value="...">
        </td>
    </tr>
    <tr>
        <td>URL страницы детального просмотра:</td>
        <td>
            <input type="text" name="DETAIL_PAGE_URL" id="DETAIL_PAGE_URL" size="55" maxlength="255"
                   value="#SITE_DIR#/vregions/detail.php?ID=#ELEMENT_ID#">
            <input type="button" id="mnu_DETAIL_PAGE_URL" value="...">
        </td>
    </tr>
    <tr>
        <td>Канонический URL элемента:<br>(необходимо указать
            протокол, адрес сервера и путь на сайте)
        </td>
        <td>
            <input type="text" name="CANONICAL_PAGE_URL" id="CANONICAL_PAGE_URL" size="55"
                   maxlength="255" value="">
            <input type="button" id="mnu_CANONICAL_PAGE_URL" value="...">
        </td>
    </tr>
    <tr>
        <td>
            <label for="INDEX_SECTION">Индексировать разделы для
                модуля поиска:
            </label>
        </td>
        <td>
            <input type="hidden" name="INDEX_SECTION" value="N">
            <input type="checkbox" id="INDEX_SECTION" name="INDEX_SECTION" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label"
                   for="INDEX_SECTION" title=""></label>
        </td>
    </tr>
    <tr>
        <td>
            <label for="INDEX_ELEMENT">Индексировать элементы для
                модуля поиска:
            </label>
        </td>
        <td>
            <input type="hidden" name="INDEX_ELEMENT" value="N">
            <input type="checkbox" id="INDEX_ELEMENT" name="INDEX_ELEMENT" value="Y" checked=""
                   class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label"
                   for="INDEX_ELEMENT" title=""></label>
        </td>
    </tr>
    <tr>
        <td>Участвует в документообороте или бизнес процессах</td>
        <td>
            <select name="WF_TYPE">
                <option value="N" selected="">нет</option>
                <option value="WF">документооборот</option>
                <option value="BP">бизнес процессы</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Интерфейс привязки элемента к разделам:</td>
        <td>
            <select name="SECTION_CHOOSER">
                <option value="L" selected="">Список множественного выбора</option>
                <option value="D">Выпадающие списки</option>
                <option value="P">Окно поиска</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Режим просмотра разделов и элементов:</td>
        <td>
            <select name="LIST_MODE">
                <option value="">из настроек модуля</option>
                <option value="S">раздельный</option>
                <option value="C">совместный</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>

            Файл для редактирования элемента, позволяющий модифицировать поля перед сохранением:
        </td>
        <td>
            <input type="text" name="EDIT_FILE_BEFORE" size="55"
                   maxlength="255" value="">
            &nbsp;
            <input type="button"
                   name="browse"
                   value="..."
                   onclick="BtnClick()">
        </td>
    </tr>
    <tr>
        <td>

            Файл с формой редактирования элемента:
        </td>
        <td>
            <input type="text" name="EDIT_FILE_AFTER" size="55"
                   maxlength="255" value="">
            &nbsp;
            <input type="button"
                   name="browse"
                   value="..."
                   onclick="BtnClick2()">
        </td>
    </tr>
    <tr>
        <td>Описание:</td>
    </tr>
    <tr>
        <td>Изображение:</td>
        <td>
            <div class="adm-input-file-control adm-input-file-top-shift" id="bx_file_picture_cont">
                <div class="adm-input-file-new"><span
                            class="adm-input-file"><span>Добавить файл</span><input type="file"
                                                                                    class="adm-designed-file"></span>
                    <input type="text" class="adm-input" size="50" id="bx_file_picture_text_input"
                           style="display: none;"><span class="adm-btn add-file-popup-btn"
                                                        data-bx-meta="new"></span><span
                            class="adm-input-file-desc" style="display: none;"><span
                                class="adm-input-file-desc-link">Добавить описание</span><input
                                type="text" class="adm-input" size="50"
                                placeholder="описание..."></span>
                    <input type="file" name="PICTURE"
                           class="adm-designed-file adm-input-file-none"
                           id="bx_file_picture_file_hidden_value_0">
                </div>
            </div>
            <div id="bx_file_picture_ie_bogus_container">
                <input type="hidden" value="">
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="bx-ed-type-selector">
                                <span class="bx-ed-type-selector-item"><input checked="checked" type="radio"
                                                                              name="DESCRIPTION_TYPE"
                                                                              id="bxed_DESCRIPTION_text"
                                                                              value="text"><label
                                            for="bxed_DESCRIPTION_text">Текст
                                    </label></span>

                                <span class="bx-ed-type-selector-item"><input type="radio" name="DESCRIPTION_TYPE"
                                                                              id="bxed_DESCRIPTION_html"
                                                                              value="html"><label
                                            for="bxed_DESCRIPTION_html">HTML
                                    </label></span>

                                <span class="bx-ed-type-selector-item"><input type="radio" name="DESCRIPTION_TYPE"
                                                                              id="bxed_DESCRIPTION_editor" value="html"><label
                                            for="bxed_DESCRIPTION_editor">Визуальный редактор
                                    </label></span>
            </div>


                            <textarea class="typearea" style="width:100%;height:450px;" name="DESCRIPTION"
                                      id="bxed_DESCRIPTION" wrap="virtual"></textarea>


            <div class="bx-html-editor" id="bx-html-editor-DESCRIPTION"
                 style="width:100%; height:450px; display: none;">
                <div class="bxhtmled-toolbar-cnt" id="bx-html-editor-tlbr-cnt-DESCRIPTION">
                    <div class="bxhtmled-toolbar" id="bx-html-editor-tlbr-DESCRIPTION"></div>
                </div>
                <div class="bxhtmled-search-cnt" id="bx-html-editor-search-cnt-DESCRIPTION"
                     style="display: none;"></div>
                <div class="bxhtmled-area-cnt" id="bx-html-editor-area-cnt-DESCRIPTION">
                    <div class="bxhtmled-iframe-cnt" id="bx-html-editor-iframe-cnt-DESCRIPTION"></div>
                    <div class="bxhtmled-textarea-cnt" id="bx-html-editor-ta-cnt-DESCRIPTION"></div>
                    <div class="bxhtmled-resizer-overlay"
                         id="bx-html-editor-res-over-DESCRIPTION"></div>
                    <div id="bx-html-editor-split-resizer-DESCRIPTION"></div>
                </div>
                <div class="bxhtmled-nav-cnt" id="bx-html-editor-nav-cnt-DESCRIPTION"
                     style="display: none;"></div>
                <div class="bxhtmled-taskbar-cnt bxhtmled-taskbar-hidden"
                     id="bx-html-editor-tskbr-cnt-DESCRIPTION">
                    <div class="bxhtmled-taskbar-top-cnt"
                         id="bx-html-editor-tskbr-top-DESCRIPTION"></div>
                    <div class="bxhtmled-taskbar-resizer" id="bx-html-editor-tskbr-res-DESCRIPTION">
                        <div class="bxhtmled-right-side-split-border">
                            <div data-bx-tsk-split-but="Y" class="bxhtmled-right-side-split-btn"></div>
                        </div>
                    </div>
                    <div class="bxhtmled-taskbar-search-nothing"
                         id="bxhed-tskbr-search-nothing-DESCRIPTION">Ничего не найдено
                    </div>
                    <div class="bxhtmled-taskbar-search-cont" id="bxhed-tskbr-search-cnt-DESCRIPTION"
                         data-bx-type="taskbar_search">
                        <div class="bxhtmled-search-alignment" id="bxhed-tskbr-search-ali-DESCRIPTION">
                            <input type="text" class="bxhtmled-search-inp"
                                   id="bxhed-tskbr-search-inp-DESCRIPTION" placeholder="Поиск...">
                        </div>
                        <div class="bxhtmled-search-cancel" data-bx-type="taskbar_search_cancel"
                             title="Отменить фильтрацию"></div>
                    </div>
                </div>
                <div id="bx-html-editor-file-dialogs-DESCRIPTION" style="display: none;"></div>
            </div>
        </td>
    </tr>
</table>