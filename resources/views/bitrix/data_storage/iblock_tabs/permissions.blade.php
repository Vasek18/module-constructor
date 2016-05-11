<table class="table">
    <tr>
        <th colspan="2" class="text-center">Доступ по умолчанию</th>
    </tr>
    <tr>
        <th>Для всех пользователей [2]: {{--это походу всегда вторая группа--}}</th>
        </td>
        <td>
            <select class="form-control" name="GROUP" id="group_2">
                <option value="Array('2' => 'D')" {{$iblock && $iblock->params->GROUP == "Array('2' => 'D')" ? 'selected' : ''}}>Нет доступа</option>
                <option value="Array('2' => 'R')" {{$iblock && $iblock->params->GROUP == "Array('2' => 'R')" ? 'selected' : ''}}>Чтение</option>
                <option value="Array('2' => 'S')" {{$iblock && $iblock->params->GROUP == "Array('2' => 'S')" ? 'selected' : ''}}>Просмотр в панели</option>
                <option value="Array('2' => 'T')" {{$iblock && $iblock->params->GROUP == "Array('2' => 'T')" ? 'selected' : ''}}>Добавление в панели</option>
                <option value="Array('2' => 'W')" {{$iblock && $iblock->params->GROUP == "Array('2' => 'W')" ? 'selected' : ''}}>Изменение</option>
                <option value="Array('2' => 'X')" {{$iblock && $iblock->params->GROUP == "Array('2' => 'X')" ? 'selected' : ''}}>Полный доступ (изменение прав доступа)</option>
            </select>
        </td>
    </tr>
</table>