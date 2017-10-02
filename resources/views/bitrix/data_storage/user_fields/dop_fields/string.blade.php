<tr data-for_types="string">
    <td>Значение по умолчанию:</td>
    <td>
        <input type="text"
               class="form-control"
               name="settings[DEFAULT_VALUE]"
               value="{{ isset($userField) && isset($userField->settings['DEFAULT_VALUE']) ? $userField->settings['DEFAULT_VALUE'] : '' }}"
        >
    </td>
</tr>
<tr data-for_types="string">
    <td>Размер поля ввода для отображения:</td>
    <td>
        <input type="text"
               class="form-control"
               name="settings[SIZE]"
               value="{{ isset($userField) && isset($userField->settings['SIZE']) ? $userField->settings['SIZE'] : '20' }}"
        >
    </td>
</tr>
<tr data-for_types="string">
    <td>Количество строчек поля ввода:</td>
    <td>
        <input type="text"
               class="form-control"
               name="settings[ROWS]"
               value="{{ isset($userField) && isset($userField->settings['ROWS']) ? $userField->settings['ROWS'] : '1' }}"
        >
    </td>
</tr>
<tr data-for_types="string">
    <td>Минимальная длина строки (0 - не проверять):</td>
    <td>
        <input type="text"
               class="form-control"
               name="settings[MIN_LENGTH]"
               value="{{ isset($userField) && isset($userField->settings['MIN_LENGTH']) ? $userField->settings['MIN_LENGTH'] : '0' }}"
        >
    </td>
</tr>
<tr data-for_types="string">
    <td>Максимальная длина строки (0 - не проверять):</td>
    <td>
        <input type="text"
               class="form-control"
               name="settings[MAX_LENGTH]"
               value="{{ isset($userField) && isset($userField->settings['MAX_LENGTH']) ? $userField->settings['MAX_LENGTH'] : '0' }}"
        >
    </td>
</tr>
<tr data-for_types="string">
    <td>Регулярное выражение для проверки:</td>
    <td>
        <input type="text"
               class="form-control"
               name="settings[REGEXP]"
               value="{{ isset($userField) && isset($userField->settings['REGEXP']) ? $userField->settings['REGEXP'] : '' }}"
        >
    </td>
</tr>