@extends('bitrix.internal_template')

@section('h1')
    @if (isset($user_field))
        {{ trans('bitrix_user_fields_form.edit_h1') }}
    @else
        {{ trans('bitrix_user_fields_form.add_h1') }}
    @endif
@stop

@section('page')
    <form action="{{ action('Modules\Bitrix\BitrixUserFieldsController@store', [$module->id]) }}"
          method="post">
        {{ csrf_field() }}
        <table class="table">
            <tr>
                <td>Тип данных (можно задать только для нового поля):</td>
                <td>
                    <select class="form-control"
                            name="user_type_id"
                            required>
                        <option value="string">Строка</option>
                        <option value="video">Видео</option>
                        <option value="hlblock">Привязка к элементам highload-блоков</option>
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
                    </select>
                </td>
            </tr>
            <tr>
                <td>Объект:</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="entity_id"
                           value=""
                           required>
                </td>
            </tr>
            <tr>
                <td>Код поля (можно задать только для нового поля):</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="field_name"
                           value="UF_"
                           required>
                </td>
            </tr>
            <tr>
                <td>XML_ID:</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="xml_id"
                           value="">
                </td>
            </tr>
            <tr>
                <td>Сортировка:</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="sort"
                           value="100">
                </td>
            </tr>
            <tr>
                <td>Множественное (можно задать только для нового поля):</td>
                <td>
                    <input type="checkbox"
                           name="multiple"
                           value="Y">
                    <label title=""></label>
                </td>
            </tr>
            <tr>
                <td>Обязательное:</td>
                <td>
                    <input type="checkbox"
                           name="mandatory"
                           value="Y">
                    <label title=""></label>
                </td>
            </tr>
            <tr>
                <td>Показывать в фильтре списка:</td>
                <td>
                    <select class="form-control"
                            name="show_filter">
                        <option select
                                class="form-control"
                                value="N"> не показывать
                        </option>
                        <option value="I">точное совпадение</option>
                        <option value="E">поиск по маске</option>
                        <option value="S">поиск по подстроке</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Не показывать в списке:</td>
                <td>
                    <input type="checkbox"
                           name="show_in_list"
                           value="N">
                    <label title=""></label>
                </td>
            </tr>
            <tr>
                <td>Не разрешать редактирование пользователем:</td>
                <td>
                    <input type="checkbox"
                           name="edit_in_list"
                           value="N">
                    <label title=""></label>
                </td>
            </tr>
            <tr>
                <td>Значения поля участвуют в поиске:</td>
                <td>
                    <input type="checkbox"
                           name="is_searchable"
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
                           name="settings[DEFAULT_VALUE]"
                           value="">
                </td>
            </tr>
            <tr>
                <td>Размер поля ввода для отображения:</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="settings[SIZE]"
                           value="20">
                </td>
            </tr>
            <tr>
                <td>Количество строчек поля ввода:</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="settings[ROWS]"
                           value="1">
                </td>
            </tr>
            <tr>
                <td>Минимальная длина строки (0 - не проверять):</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="settings[MIN_LENGTH]"
                           value="0">
                </td>
            </tr>
            <tr>
                <td>Максимальная длина строки (0 - не проверять):</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="settings[MAX_LENGTH]"
                           value="0">
                </td>
            </tr>
            <tr>
                <td>Регулярное выражение для проверки:</td>
                <td>
                    <input type="text"
                           class="form-control"
                           name="settings[REGEXP]"
                           value="">
                </td>
            </tr>
            <tr>
                <td colspan="2"><h2>Языковые настройки</h2></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table">
                        <tr>
                            <td>Язык</td>
                            <td>Подпись в форме редактирования</td>
                            <td>Заголовок в списке</td>
                            <td>Подпись фильтра в списке</td>
                            <td>Сообщение об ошибке (не обязательное)</td>
                            <td>Помощь</td>
                        </tr>
                        <tr>
                            <td>Russian:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="edit_form_label[ru]"
                                       value=""
                                       required>
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="list_column_label[ru]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="list_filter_label[ru]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="error_message[ru]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="help_message[ru]"
                                       value="">
                            </td>
                        </tr>
                        <tr>
                            <td>English:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="edit_form_label[en]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="list_column_label[en]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="list_filter_label[en]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="error_message[en]"
                                       value="">
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="help_message[en]"
                                       value="">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <button class="btn btn-primary"
                name="save">{{ trans('app.save') }}</button>
    </form>
@stop