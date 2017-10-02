<tr data-for_types="video">
    <td colspan="2"><h2>Общие настройки</h2></td>
</tr>
<tr data-for_types="video">
    <td>Размер буфера в секундах:</td>
    <td>
        <input class="form-control"
               type="text"
               name="SETTINGS[BUFFER_LENGTH]"
               size="10"
               value="10">
    </td>
</tr>
<tr data-for_types="video">
    <td>Расположение панели управления:</td>
    <td>
        <select class="form-control"
                name="SETTINGS[CONTROLBAR]">
            <option value="bottom"
                    selected="">Внизу
            </option>
            <option value="none">Не показывать</option>
        </select>
    </td>
</tr>
<tr data-for_types="video">
    <td>Автоматически начать проигрывать:</td>
    <td>
        <label>
            <input value="Y"
                   type="checkbox"
                   name="SETTINGS[AUTOSTART]"
            >
        </label>
    </td>
</tr>
<tr data-for_types="video">
    <td>Уровень громкости в процентах от максимального:</td>
    <td>
        <input class="form-control"
               type="text"
               name="SETTINGS[VOLUME]"
               size="10"
               value="90">
    </td>
</tr>
<tr data-for_types="video">
    <td>Размеры (Ш х В, px)</td>
    <td>
        <div class="row">
            <div class="col-md-5">
                <input class="form-control"
                       type="text"
                       name="SETTINGS[WIDTH]"
                       size="10"
                       value="400">
            </div>
            <div class="col-md-1">
                x
            </div>
            <div class="col-md-6">
                <input class="form-control"
                       type="text"
                       name="SETTINGS[HEIGHT]"
                       size="10"
                       value="300">
            </div>
        </div>
    </td>