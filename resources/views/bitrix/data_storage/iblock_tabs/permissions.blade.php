<table>
    <tbody>
    <tr>
        <td>Режим прав доступа</td>
    </tr>
    <tr>
        <td>
            <label for="RIGHTS_MODE">Расширенное управление правами:</label>
        </td>
        <td>
            <input type="hidden" name="RIGHTS_MODE" value="S">
            <input type="checkbox" id="RIGHTS_MODE" name="RIGHTS_MODE" value="E" class="adm-designed-checkbox">
            <label class="adm-designed-checkbox-label" for="RIGHTS_MODE" title=""></label>
            <div class="adm-info-message-wrap">
                <div class="adm-info-message">
                    После того как вы отметите этот чекбокс, необходимо нажать кнопку "Применить". При этом текущие
                    настройки будут сконвертированы в расширенные.
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>Доступ по умолчанию</td>
    </tr>
    <tr>
        <td>Для всех пользователей [<a class="tablebodylink"
                                       href="/bitrix/admin/group_edit.php?ID=2&amp;lang=ru">2</a>]:
        </td>
        <td>

            <select name="GROUP[2]" id="group_2">
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Доступ для групп пользователей</td>
    </tr>
    <tr>
        <td>Администраторы [<a class="tablebodylink"
                               href="/bitrix/admin/group_edit.php?ID=1&amp;lang=ru">1</a>]:
        </td>
        <td>

            <select name="GROUP[1]" onchange="OnGroupChange(this, 'spn_group_1');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X" selected="">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_1"></span>
        </td>
    </tr>
    <tr>
        <td>Зарегистрированные пользователи [<a
                    class="tablebodylink" href="/bitrix/admin/group_edit.php?ID=5&amp;lang=ru">5</a>]:
        </td>
        <td>

            <select name="GROUP[5]" onchange="OnGroupChange(this, 'spn_group_5');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_5"></span>
        </td>
    </tr>
    <tr>
        <td>Пользователи, имеющие право голосовать за рейтинг
            [<a class="tablebodylink" href="/bitrix/admin/group_edit.php?ID=3&amp;lang=ru">3</a>]:
        </td>
        <td>

            <select name="GROUP[3]" onchange="OnGroupChange(this, 'spn_group_3');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_3"></span>
        </td>
    </tr>
    <tr>
        <td>Пользователи имеющие право голосовать за авторитет [<a
                    class="tablebodylink" href="/bitrix/admin/group_edit.php?ID=4&amp;lang=ru">4</a>]:
        </td>
        <td>

            <select name="GROUP[4]" onchange="OnGroupChange(this, 'spn_group_4');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_4"></span>
        </td>
    </tr>
    <tr>
        <td>Администраторы интернет-магазина [<a
                    class="tablebodylink" href="/bitrix/admin/group_edit.php?ID=6&amp;lang=ru">6</a>]:
        </td>
        <td>

            <select name="GROUP[6]" onchange="OnGroupChange(this, 'spn_group_6');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_6"></span>
        </td>
    </tr>
    <tr>
        <td>Почтовые пользователи [<a class="tablebodylink"
                                      href="/bitrix/admin/group_edit.php?ID=8&amp;lang=ru">8</a>]:
        </td>
        <td>

            <select name="GROUP[8]" onchange="OnGroupChange(this, 'spn_group_8');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_8"></span>
        </td>
    </tr>
    <tr>
        <td>Контент-редакторы [<a class="tablebodylink"
                                  href="/bitrix/admin/group_edit.php?ID=7&amp;lang=ru">7</a>]:
        </td>
        <td>

            <select name="GROUP[7]" onchange="OnGroupChange(this, 'spn_group_7');">
                <option value="">По умолчанию</option>
                <option value="D">Нет доступа</option>
                <option value="R">Чтение</option>
                <option value="S">Просмотр в панели</option>
                <option value="T">Добавление в панели</option>
                <option value="W">Изменение</option>
                <option value="X">Полный доступ (изменение прав доступа)</option>
            </select>
            <span id="spn_group_7"></span>
        </td>
    </tr>

    </tbody>
</table>