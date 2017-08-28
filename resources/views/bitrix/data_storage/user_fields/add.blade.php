@extends('bitrix.internal_template')

@section('h1')
    @if (isset($user_field))
        {{ trans('bitrix_user_fields_form.edit_h1') }}
    @else
        {{ trans('bitrix_user_fields_form.add_h1') }}
    @endif
@stop

@section('page')
    <table class="table">
        <tbody>
        <tr>
            <td>Тип данных (можно задать только для нового поля):</td>
            <td>
                <select class="form-control"
                        name="USER_TYPE_ID">
                    <option value="video">Видео</option>
                    <option value="hlblock">Привязка к элементам highload-блоков</option>
                    <option value="string"> Строка
                    </option>
                    <option value="integer">Целое число</option>
                    <option value="double">Число</option>
                    <option value="datetime">Дата со временем</option>
                    <option value="date">Дата</option>
                    <option value="boolean">Да/Нет</option>
                    <option value="file">Файл</option>
                    <option value="enumeration">Список</option>
                    <option value="iblock_section">Привязка к разделам инф. блоков</option>
                    <option value="iblock_element">Привязка к элементам инф. блоков</option>
                    <option value="string_formatted">Шаблон</option>
                    <option value="vote">Опрос</option>
                    <option value="url_preview">Содержимое ссылки</option>
                </select class="form-control">
            </td>
        </tr>
        <tr>
            <td>Объект:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="ENTITY_ID"
                       value="">
            </td>
        </tr>
        <tr>
            <td>Код поля (можно задать только для нового поля):</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="FIELD_NAME"
                       value="UF_">
            </td>
        </tr>
        <tr>
            <td>XML_ID:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="XML_ID"
                       value="">
            </td>
        </tr>
        <tr>
            <td>Сортировка:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SORT"
                       value="100">
            </td>
        </tr>
        <tr>
            <td>Множественное (можно задать только для нового поля):</td>
            <td>
                <input type="checkbox"
                       name="MULTIPLE"
                       value="Y">
                <label title=""></label>
            </td>
        </tr>
        <tr>
            <td>Обязательное:</td>
            <td>
                <input type="checkbox"
                       name="MANDATORY"
                       value="Y">
                <label title=""></label>
            </td>
        </tr>
        <tr>
            <td>Показывать в фильтре списка:</td>
            <td>
                <select class="form-control"
                        name="SHOW_FILTER">
                    <option select
                            class="form-control"
                            ed=""
                            value="N"> не показывать
                    </option>
                    <option value="I">точное совпадение</option>
                    <option value="E">поиск по маске</option>
                    <option value="S">поиск по подстроке</option>
                </select class="form-control">
            </td>
        </tr>
        <tr>
            <td>Не показывать в списке:</td>
            <td>
                <input type="checkbox"
                       name="SHOW_IN_LIST"
                       value="N">
                <label title=""></label>
            </td>
        </tr>
        <tr>
            <td>Не разрешать редактирование пользователем:</td>
            <td>
                <input type="checkbox"
                       name="EDIT_IN_LIST"
                       value="N">
                <label title=""></label>
            </td>
        </tr>
        <tr>
            <td>Значения поля участвуют в поиске:</td>
            <td>
                <input type="checkbox"
                       name="IS_SEARCHABLE"
                       value="Y">
                <label title=""></label>
            </td>
        </tr>
        <tr>
            <td colspan="2">Дополнительные настройки поля (зависят от типа)</td>
        </tr>
        <tr>
            <td>Значение по умолчанию:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SETTINGS[DEFAULT_VALUE]"
                       value="">
            </td>
        </tr>
        <tr>
            <td>Размер поля ввода для отображения:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SETTINGS[SIZE]"
                       value="20">
            </td>
        </tr>
        <tr>
            <td>Количество строчек поля ввода:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SETTINGS[ROWS]"
                       value="1">
            </td>
        </tr>
        <tr>
            <td>Минимальная длина строки (0 - не проверять):</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SETTINGS[MIN_LENGTH]"
                       value="0">
            </td>
        </tr>
        <tr>
            <td>Максимальная длина строки (0 - не проверять):</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SETTINGS[MAX_LENGTH]"
                       value="0">
            </td>
        </tr>
        <tr>
            <td>Регулярное выражение для проверки:</td>
            <td>
                <input type="text"
                       class="form-control"
                       name="SETTINGS[REGEXP]"
                       value="">
            </td>
        </tr>
        <tr>
            <td colspan="2"><h2>Языковые настройки</h2></td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Язык</td>
                        <td> Подпись в форме редактирования</td>
                        <td> Заголовок в списке</td>
                        <td> Подпись фильтра в списке</td>
                        <td> Сообщение об ошибке (не обязательное)</td>
                        <td> Помощь</td>
                    </tr>
                    <tr>
                        <td>Russian:</td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="EDIT_FORM_LABEL[ru]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="LIST_COLUMN_LABEL[ru]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="LIST_FILTER_LABEL[ru]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="ERROR_MESSAGE[ru]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="HELP_MESSAGE[ru]"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>English:</td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="EDIT_FORM_LABEL[en]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="LIST_COLUMN_LABEL[en]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="LIST_FILTER_LABEL[en]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="ERROR_MESSAGE[en]"
                                   value="">
                        </td>
                        <td>
                            <input type="text"
                                   class="form-control"
                                   name="HELP_MESSAGE[en]"
                                   value="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@stop