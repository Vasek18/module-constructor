@extends('bitrix.internal_template')

@section('h1')
    @if (isset($user_field))
        {{ trans('bitrix_user_fields_form.edit_h1') }}
    @else
        {{ trans('bitrix_user_fields_form.add_h1') }}
    @endif
@stop

@section('page')

    @push('scripts')
    <script src="/js/bitrix_user_fields.js"></script>
    @endpush

    @if (isset($userField))
        <form action="{{ action('Modules\Bitrix\BitrixUserFieldsController@update', [$module->id, $userField]) }}"
              method="post">
            @else
                <form action="{{ action('Modules\Bitrix\BitrixUserFieldsController@store', [$module->id]) }}"
                      method="post">
                    @endif
                    {{ csrf_field() }}
                    <table class="table">
                        <tr>
                            <td>Тип данных (можно задать только для нового поля):</td>
                            <td>
                                <select class="form-control js-change-fields-visibility"
                                        name="user_type_id"
                                        required>
                                    @foreach($userFieldTypes as $type)
                                        <option value="{{ $type['code'] }}" {{ isset($userField) && $type['code']==$userField->user_type_id ? 'selected' : '' }}>{{ $type['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Объект:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="entity_id"
                                       value="{{ isset($userField) ? $userField->entity_id : '' }}"
                                       required>
                            </td>
                        </tr>
                        <tr>
                            <td>Код поля (можно задать только для нового поля):</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="field_name"
                                       value="{{ isset($userField) ? $userField->field_name : 'UF_' }}"
                                       required>
                            </td>
                        </tr>
                        <tr>
                            <td>XML_ID:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="xml_id"
                                       value="{{ isset($userField) ? $userField->xml_id : '' }}"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>Сортировка:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="sort"
                                       value="{{ isset($userField) ? $userField->sort : '100' }}"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>Множественное (можно задать только для нового поля):</td>
                            <td>
                                <input type="checkbox"
                                       name="multiple"
                                       {{ isset($userField) && $userField->multiple ? 'checked' : '' }}
                                       value="Y">
                                <label title=""></label>
                            </td>
                        </tr>
                        <tr>
                            <td>Обязательное:</td>
                            <td>
                                <input type="checkbox"
                                       name="mandatory"
                                       {{ isset($userField) && $userField->mandatory ? 'checked' : '' }}
                                       value="Y">
                                <label title=""></label>
                            </td>
                        </tr>
                        <tr>
                            <td>Показывать в фильтре списка:</td>
                            <td>
                                <select class="form-control"
                                        name="show_filter">
                                    <option value="N"
                                            {{ isset($userField) && $userField->show_filter == 'N' ? 'selected' : '' }}>
                                        не показывать
                                    </option>
                                    <option value="I"
                                            {{ isset($userField) && $userField->show_filter == 'I' ? 'selected' : '' }}>
                                        точное совпадение
                                    </option>
                                    <option value="E"
                                            {{ isset($userField) && $userField->show_filter == 'E' ? 'selected' : '' }}>
                                        поиск по маске
                                    </option>
                                    <option value="S"
                                            {{ isset($userField) && $userField->show_filter == 'S' ? 'selected' : '' }}>
                                        поиск по подстроке
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Не показывать в списке:</td>
                            <td>
                                <input type="hidden"
                                       name="show_in_list"
                                       value="Y">
                                <input type="checkbox"
                                       name="show_in_list"
                                       {{ isset($userField) && $userField->show_in_list ? '' : 'checked' }}
                                       value="N">
                                <label title=""></label>
                            </td>
                        </tr>
                        <tr>
                            <td>Не разрешать редактирование пользователем:</td>
                            <td>
                                <input type="hidden"
                                       name="edit_in_list"
                                       value="Y">
                                <input type="checkbox"
                                       name="edit_in_list"
                                       {{ isset($userField) && $userField->edit_in_list ? '' : 'checked' }}
                                       value="N">
                                <label title=""></label>
                            </td>
                        </tr>
                        <tr>
                            <td>Значения поля участвуют в поиске:</td>
                            <td>
                                <input type="checkbox"
                                       name="is_searchable"
                                       {{ isset($userField) && $userField->is_searchable ? 'checked' : '' }}
                                       value="Y">
                                <label title=""></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><h2>Дополнительные настройки поля (зависят от типа)</h2></td>
                        </tr>
                        <tr data-for_types="string">
                            <td>Значение по умолчанию:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="settings[DEFAULT_VALUE]"
                                       value="{{ isset($userField) ? $userField->settings['DEFAULT_VALUE'] : '' }}"
                                >
                            </td>
                        </tr>
                        <tr data-for_types="string">
                            <td>Размер поля ввода для отображения:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="settings[SIZE]"
                                       value="{{ isset($userField) ? $userField->settings['SIZE'] : '20' }}"
                                >
                            </td>
                        </tr>
                        <tr data-for_types="string">
                            <td>Количество строчек поля ввода:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="settings[ROWS]"
                                       value="{{ isset($userField) ? $userField->settings['ROWS'] : '1' }}"
                                >
                            </td>
                        </tr>
                        <tr data-for_types="string">
                            <td>Минимальная длина строки (0 - не проверять):</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="settings[MIN_LENGTH]"
                                       value="{{ isset($userField) ? $userField->settings['MIN_LENGTH'] : '0' }}"
                                >
                            </td>
                        </tr>
                        <tr data-for_types="string">
                            <td>Максимальная длина строки (0 - не проверять):</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="settings[MAX_LENGTH]"
                                       value="{{ isset($userField) ? $userField->settings['MAX_LENGTH'] : '0' }}"
                                >
                            </td>
                        </tr>
                        <tr data-for_types="string">
                            <td>Регулярное выражение для проверки:</td>
                            <td>
                                <input type="text"
                                       class="form-control"
                                       name="settings[REGEXP]"
                                       value="{{ isset($userField) ? $userField->settings['REGEXP'] : '' }}"
                                >
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
                                                   value="{{ isset($userField) ? $userField->edit_form_label['ru'] : '' }}"
                                                   required>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="list_column_label[ru]"
                                                   value="{{ isset($userField) ? $userField->list_column_label['ru'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="list_filter_label[ru]"
                                                   value="{{ isset($userField) ? $userField->list_filter_label['ru'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="error_message[ru]"
                                                   value="{{ isset($userField) ? $userField->error_message['ru'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="help_message[ru]"
                                                   value="{{ isset($userField) ? $userField->help_message['ru'] : '' }}"
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>English:</td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="edit_form_label[en]"
                                                   value="{{ isset($userField) ? $userField->edit_form_label['en'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="list_column_label[en]"
                                                   value="{{ isset($userField) ? $userField->list_column_label['en'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="list_filter_label[en]"
                                                   value="{{ isset($userField) ? $userField->list_filter_label['en'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="error_message[en]"
                                                   value="{{ isset($userField) ? $userField->error_message['en'] : '' }}"
                                            >
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control"
                                                   name="help_message[en]"
                                                   value="{{ isset($userField) ? $userField->help_message['en'] : '' }}"
                                            >
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