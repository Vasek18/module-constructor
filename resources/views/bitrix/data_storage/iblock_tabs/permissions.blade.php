<table class="table">
    <tr>
        <th>Режим прав доступа</th>
    </tr>
    <tr>
        <th>
            <label for="RIGHTS_MODE">Расширенное управление правами:</label>
        </td>
        <td>
            <input type="checkbox" id="RIGHTS_MODE" name="RIGHTS_MODE" value="E">
            <label for="RIGHTS_MODE" title=""></label>
        </td>
    </tr>
    <tr>
        <th>Доступ по умолчанию</th>
    </tr>
    <tr>
        <th>Для всех пользователей [<a
                    href="/bitrix/admin/group_edit.php?ID=2&amp;lang=ru">2</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[2]" id="group_2">
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
        <th>Доступ для групп пользователей</th>
    </tr>
    <tr>
        <th>Администраторы [<a
                    href="/bitrix/admin/group_edit.php?ID=1&amp;lang=ru">1</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[1]">
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
        <th>Зарегистрированные пользователи [<a
                    href="/bitrix/admin/group_edit.php?ID=5&amp;lang=ru">5</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[5]">
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
        <th>Пользователи, имеющие право голосовать за рейтинг
            [<a href="/bitrix/admin/group_edit.php?ID=3&amp;lang=ru">3</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[3]">
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
        <th>Пользователи имеющие право голосовать за авторитет [<a
                    href="/bitrix/admin/group_edit.php?ID=4&amp;lang=ru">4</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[4]">
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
        <th>Администраторы интернет-магазина [<a
                    href="/bitrix/admin/group_edit.php?ID=6&amp;lang=ru">6</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[6]">
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
        <th>Почтовые пользователи [<a
                    href="/bitrix/admin/group_edit.php?ID=8&amp;lang=ru">8</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[8]">
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
        <th>Контент-редакторы [<a
                    href="/bitrix/admin/group_edit.php?ID=7&amp;lang=ru">7</a>]:
        </td>
        <td>
            <select class="form-control" name="GROUP[7]">
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
</table>